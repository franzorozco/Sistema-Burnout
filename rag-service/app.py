import os
from dotenv import load_dotenv
from fastapi import FastAPI, UploadFile, File, HTTPException
from pydantic import BaseModel
from pathlib import Path
from langchain_ollama import OllamaLLM, OllamaEmbeddings
from langchain.text_splitter import CharacterTextSplitter
from langchain.schema import Document
from langchain_community.vectorstores import Chroma
from langchain.chains import RetrievalQA
import fitz  # PyMuPDF
import traceback
import pytesseract
from PIL import Image
import io

pytesseract.pytesseract.tesseract_cmd = r"C:\Program Files\Tesseract-OCR\tesseract.exe"

os.environ["TESSDATA_PREFIX"] = r"C:\Program Files\ Tesseract-OCR"

load_dotenv()

LLM_MODEL = os.getenv("LLM_MODEL", "nomic-embed-text")
LLM_URL = os.getenv("LLM_URL", "http://host.docker.internal:11434")  

PERSIST_DIR = Path("vectordb")
PERSIST_DIR.mkdir(exist_ok=True)

app = FastAPI(title="RAG Service (LangChain + Ollama + Chroma)")

def get_embeddings():
    return OllamaEmbeddings(model=LLM_MODEL, base_url=LLM_URL)

def get_llm():
    return OllamaLLM(model=LLM_MODEL, base_url=LLM_URL)

class Query(BaseModel):
    query: str

@app.post("/ingest")
async def ingest(file: UploadFile = File(...)):
    """Sube archivo TXT/PDF y lo indexa en Chroma (con OCR automático si es necesario)."""
    try:
        content = await file.read()

        if file.filename.lower().endswith(".txt"):
            text = content.decode("utf-8").strip()
            docs = [Document(page_content=text)]

        elif file.filename.lower().endswith(".pdf"):
            pdf_doc = fitz.open(stream=content, filetype="pdf")
            print(f"Total de páginas: {len(pdf_doc)}")
            docs = []

            for i, page in enumerate(pdf_doc):
                page_text = page.get_text().strip()

                if not page_text:
                    print(f"Página {i+1}: sin texto, aplicando OCR...")
                    zoom = 3.0  # alta resolución para mejor OCR
                    mat = fitz.Matrix(zoom, zoom)
                    pix = page.get_pixmap(matrix=mat)
                    img = Image.open(io.BytesIO(pix.tobytes("png"))).convert("RGB")
                    page_text = pytesseract.image_to_string(img, lang="spa").strip()

                print(f"  Página {i+1}: {len(page_text)} caracteres extraídos")
                if len(page_text) < 20:
                    print(f"Página {i+1} parece vacía tras OCR")

                if page_text:
                    docs.append(Document(page_content=page_text))

        else:
            raise HTTPException(status_code=400, detail="Solo se aceptan archivos TXT o PDF.")

        if not docs:
            raise HTTPException(status_code=400, detail="El archivo está vacío o no se pudo extraer texto.")

        splitter = CharacterTextSplitter(chunk_size=500, chunk_overlap=50)
        chunks = splitter.split_documents(docs)
        print(f"Total de chunks generados: {len(chunks)}")

        embeddings = get_embeddings()
        db = Chroma.from_documents(
            chunks,
            embedding=embeddings,
            persist_directory=str(PERSIST_DIR)
        )
        db.persist()

        print(f"Indexación completada. Total de chunks guardados: {len(chunks)}")
        return {"status": "ok", "chunks_indexed": len(chunks)}

    except Exception as e:
        traceback.print_exc()
        raise HTTPException(status_code=500, detail=f"Error al procesar el archivo: {str(e)}")

@app.post("/ask")
async def ask(q: Query):
    try:
        if not PERSIST_DIR.exists() or not any(PERSIST_DIR.iterdir()):
            raise HTTPException(status_code=400, detail="No hay base de vectores. Usa /ingest primero.")

        embeddings = get_embeddings()
        db = Chroma(
            persist_directory=str(PERSIST_DIR),
            embedding_function=embeddings
        )

        retriever = db.as_retriever(search_kwargs={"k": 3})
        llm = get_llm()
        qa = RetrievalQA.from_chain_type(llm=llm, retriever=retriever)

        print("Pregunta recibida:", q.query)
        answer = qa.run(q.query)
        print("Respuesta generada:", answer)

        if not answer:
            answer = "No se pudo generar respuesta. Revisa si hay documentos indexados."

        return {"answer": answer}

    except Exception as e:
        traceback.print_exc()
        raise HTTPException(status_code=500, detail=f"Error al generar respuesta: {str(e)}")
