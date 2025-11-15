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
import fitz
import traceback
import pytesseract
from PIL import Image
import io

# --- CONFIG TESSERACT ---
pytesseract.pytesseract.tesseract_cmd = r"C:\Program Files\Tesseract-OCR\tesseract.exe"
os.environ["TESSDATA_PREFIX"] = r"C:\Program Files\Tesseract-OCR\tessdata"


# --- ENV ---
load_dotenv()

LLM_URL = os.getenv("LLM_URL", "http://host.docker.internal:11434")
LLM_MODEL = os.getenv("LLM_MODEL", "llama3.2")
EMBED_MODEL = os.getenv("EMBED_MODEL", "nomic-embed-text")

PERSIST_DIR = Path("vectordb")
PERSIST_DIR.mkdir(exist_ok=True)

app = FastAPI(title="RAG Service (LangChain + Ollama + Chroma)")

# --- MODELOS (cargan solo UNA VEZ → súper rápido) ---
embeddings = OllamaEmbeddings(model=EMBED_MODEL, base_url=LLM_URL)
llm = OllamaLLM(model=LLM_MODEL, base_url=LLM_URL)

# Cargar la base si existe
if any(PERSIST_DIR.iterdir()):
    db = Chroma(persist_directory=str(PERSIST_DIR), embedding_function=embeddings)
    retriever = db.as_retriever(search_kwargs={"k": 3})
    qa = RetrievalQA.from_chain_type(llm=llm, retriever=retriever)
else:
    db = None
    retriever = None
    qa = None


class Query(BaseModel):
    query: str


@app.post("/ingest")
async def ingest(file: UploadFile = File(...)):
    """Sube archivo TXT/PDF y lo indexa en Chroma."""
    try:
        content = await file.read()

        # ----- TXT -----
        if file.filename.lower().endswith(".txt"):
            text = content.decode("utf-8").strip()
            docs = [Document(page_content=text)]

        # ----- PDF -----
        elif file.filename.lower().endswith(".pdf"):
            pdf_doc = fitz.open(stream=content, filetype="pdf")
            docs = []

            for i, page in enumerate(pdf_doc):
                page_text = page.get_text().strip()

                # Si no hay texto → OCR
                if not page_text:
                    zoom = 3.0
                    mat = fitz.Matrix(zoom, zoom)
                    pix = page.get_pixmap(matrix=mat)
                    img = Image.open(io.BytesIO(pix.tobytes("png"))).convert("RGB")
                    page_text = pytesseract.image_to_string(img, lang="spa").strip()

                if page_text:
                    docs.append(Document(page_content=page_text))
        else:
            raise HTTPException(status_code=400, detail="Solo archivos TXT o PDF.")

        if not docs:
            raise HTTPException(status_code=400, detail="El archivo no contiene texto.")

        # Dividir texto
        splitter = CharacterTextSplitter(chunk_size=500, chunk_overlap=50)
        chunks = splitter.split_documents(docs)

        # Guardar en Chroma persistente
        db = Chroma.from_documents(
            chunks,
            embedding=embeddings,
            persist_directory=str(PERSIST_DIR)
        )
        db.persist()

        # Recargar retriever global
        global retriever, qa
        retriever = db.as_retriever(search_kwargs={"k": 3})
        qa = RetrievalQA.from_chain_type(llm=llm, retriever=retriever)

        return {"status": "ok", "chunks_indexed": len(chunks)}

    except Exception as e:
        traceback.print_exc()
        raise HTTPException(status_code=500, detail=str(e))


@app.post("/ask")
async def ask(q: Query):
    try:
        if qa is None:
            raise HTTPException(status_code=400, detail="No hay vectores cargados. Usa /ingest primero.")

        print("Pregunta:", q.query)
        answer = qa.run(q.query)
        print("Respuesta:", answer)

        return {"answer": answer}

    except Exception as e:
        traceback.print_exc()
        raise HTTPException(status_code=500, detail=str(e))
