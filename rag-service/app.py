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

load_dotenv()

LLM_MODEL = os.getenv("LLM_MODEL", "llama3.2")
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
    """Sube archivo TXT/PDF y lo indexa en Chroma"""
    try:
        content = await file.read()
        text = ""

        if file.filename.lower().endswith(".txt"):
            text = content.decode("utf-8").strip()
        elif file.filename.lower().endswith(".pdf"):
            pdf_doc = fitz.open(stream=content, filetype="pdf")
            for page in pdf_doc:
                text += page.get_text()
            text = text.strip()
        else:
            raise HTTPException(status_code=400, detail="Solo se aceptan archivos TXT o PDF.")

        if not text:
            raise HTTPException(status_code=400, detail="El archivo está vacío o no se pudo extraer texto.")

        docs = [Document(page_content=text)]
        splitter = CharacterTextSplitter(chunk_size=800, chunk_overlap=100)
        chunks = splitter.split_documents(docs)

        if not chunks:
            raise HTTPException(status_code=400, detail="No se pudieron generar chunks del archivo.")

        embeddings = get_embeddings()
        db = Chroma.from_documents(
            chunks,
            embedding_function=embeddings,
            persist_directory=str(PERSIST_DIR)
        )
        db.persist()

        return {"status": "ok", "chunks_indexed": len(chunks)}

    except Exception as e:
        traceback.print_exc()
        raise HTTPException(status_code=500, detail=f"Error al procesar el archivo: {str(e)}")


@app.post("/ask")
async def ask(q: Query):
    """Consulta el índice y responde usando RAG + Ollama"""
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
