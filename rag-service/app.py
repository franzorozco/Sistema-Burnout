import os
from dotenv import load_dotenv
from fastapi import FastAPI, UploadFile, File, HTTPException
from pydantic import BaseModel
from pathlib import Path
from langchain_ollama import OllamaLLM, OllamaEmbeddings
from langchain.text_splitter import CharacterTextSplitter
from langchain.schema import Document
from langchain.vectorstores import Chroma
from langchain.chains import RetrievalQA

load_dotenv()

LLM_MODEL = os.getenv("LLM_MODEL", "llama3.1")
LLM_URL = os.getenv("LLM_URL", "http://host.docker.internal:11434")  
# usamos host.docker.internal para que Python vea al contenedor Docker

PERSIST_DIR = Path("vectordb")
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
    content = await file.read()
    try:
        text = content.decode("utf-8")
    except Exception:
        text = ""
    docs = [Document(page_content=text)]
    splitter = CharacterTextSplitter(chunk_size=800, chunk_overlap=100)
    chunks = splitter.split_documents(docs)
    embeddings = get_embeddings()
    db = Chroma.from_documents(chunks, embedding_function=embeddings, persist_directory=str(PERSIST_DIR))
    db.persist()
    return {"status":"ok", "chunks_indexed": len(chunks)}

@app.post("/ask")
async def ask(q: Query):
    """Consulta el índice y responde usando RAG + Ollama"""
    if not PERSIST_DIR.exists():
        raise HTTPException(status_code=400, detail="No hay base de vectores. Usa /ingest primero.")
    embeddings = get_embeddings()
    db = Chroma(persist_directory=str(PERSIST_DIR), embedding_function=embeddings)
    retriever = db.as_retriever(search_kwargs={"k": 3})
    llm = get_llm()
    qa = RetrievalQA.from_chain_type(llm=llm, retriever=retriever)
    answer = qa.run(q.query)
    return {"answer": answer}
import os
from dotenv import load_dotenv
from fastapi import FastAPI, UploadFile, File, HTTPException
from pydantic import BaseModel
from pathlib import Path
from langchain_ollama import OllamaLLM, OllamaEmbeddings
from langchain.text_splitter import CharacterTextSplitter
from langchain.schema import Document
from langchain.vectorstores import Chroma
from langchain.chains import RetrievalQA

load_dotenv()

LLM_MODEL = os.getenv("LLM_MODEL", "llama3.1")
LLM_URL = os.getenv("LLM_URL", "http://host.docker.internal:11434")  
# usamos host.docker.internal para que Python vea al contenedor Docker

PERSIST_DIR = Path("vectordb")
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
    content = await file.read()
    try:
        text = content.decode("utf-8")
    except Exception:
        text = ""
    docs = [Document(page_content=text)]
    splitter = CharacterTextSplitter(chunk_size=800, chunk_overlap=100)
    chunks = splitter.split_documents(docs)
    embeddings = get_embeddings()
    db = Chroma.from_documents(chunks, embedding_function=embeddings, persist_directory=str(PERSIST_DIR))
    db.persist()
    return {"status":"ok", "chunks_indexed": len(chunks)}

@app.post("/ask")
async def ask(q: Query):
    """Consulta el índice y responde usando RAG + Ollama"""
    if not PERSIST_DIR.exists():
        raise HTTPException(status_code=400, detail="No hay base de vectores. Usa /ingest primero.")
    embeddings = get_embeddings()
    db = Chroma(persist_directory=str(PERSIST_DIR), embedding_function=embeddings)
    retriever = db.as_retriever(search_kwargs={"k": 3})
    llm = get_llm()
    qa = RetrievalQA.from_chain_type(llm=llm, retriever=retriever)
    answer = qa.run(q.query)
    return {"answer": answer}
