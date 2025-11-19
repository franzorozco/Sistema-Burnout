import os
import logging
from dotenv import load_dotenv
from fastapi import FastAPI, UploadFile, File, HTTPException
from pydantic import BaseModel
from pathlib import Path

# LangChain / Ollama
from langchain_ollama import OllamaLLM, OllamaEmbeddings
from langchain_text_splitters import CharacterTextSplitter
from langchain_core.documents import Document
from langchain_chroma import Chroma
from langchain_core.prompts import PromptTemplate
from langchain_core.output_parsers import StrOutputParser

# FastAPI
from fastapi.responses import JSONResponse

# OCR / PDF
import fitz
import pytesseract
from PIL import Image
import io

# DB
import mysql.connector
from mysql.connector import Error

# Util
import traceback
import time

# ======================================================
# LOGGING
# ======================================================
logger = logging.getLogger("uvicorn")

# ======================================================
# TESSERACT
# ======================================================
pytesseract.pytesseract.tesseract_cmd = r"C:\Program Files\Tesseract-OCR\tesseract.exe"
os.environ["TESSDATA_PREFIX"] = r"C:\Program Files\Tesseract-OCR\tessdata"

# ======================================================
# ENV
# ======================================================
load_dotenv()
LLM_URL = os.getenv("LLM_URL", "http://host.docker.internal:11434")
LLM_MODEL = os.getenv("LLM_MODEL", "llama3.2")
EMBED_MODEL = os.getenv("EMBED_MODEL", "nomic-embed-text")

PERSIST_DIR = Path("vectordb")
PERSIST_DIR.mkdir(exist_ok=True)

app = FastAPI(title="RAG Service (Ollama + LangChain + Chroma)")

# ======================================================
# MODELOS
# ======================================================
llm = OllamaLLM(model=LLM_MODEL, base_url=LLM_URL)
embeddings = OllamaEmbeddings(model=EMBED_MODEL, base_url=LLM_URL)

# ======================================================
# PROMPT PRINCIPAL
# ======================================================
prompt = PromptTemplate(
    input_variables=["context", "question"],
    template="""
Eres un asistente virtual llamado Laiso, especializado en medicina preventiva y psicología, enfocado en la **prevención del burnout**.

🧠 **Contexto recuperado del documento y chat:**
{context}

❓ **Pregunta del usuario:**
{question}

💬 **Responde como Laiso con recomendaciones claras, prácticas y fáciles de aplicar:**
"""
)

# QA CHAIN
qa_chain = prompt | llm | StrOutputParser()

# ======================================================
# MYSQL
# ======================================================
def connect_db():
    try:
        return mysql.connector.connect(
            host=os.getenv("DB_HOST", "127.0.0.1"),
            user=os.getenv("DB_USER", "root"),
            password=os.getenv("DB_PASSWORD", ""),
            database=os.getenv("DB_NAME", "burnout_borrador"),
            connection_timeout=10
        )
    except Error as e:
        logger.error(f"MySQL error: {e}")
        return None

db_conn = connect_db()

def ensure_db_connection():
    global db_conn
    if not db_conn or not db_conn.is_connected():
        db_conn = connect_db()

# ======================================================
# HISTORIAL DE CHAT
# ======================================================
def get_chat_history(session_id: str, limit: int = 20):
    if not session_id:
        return ""
    ensure_db_connection()
    cursor = db_conn.cursor(dictionary=True)
    cursor.execute("""
        SELECT input_text, response_text 
        FROM chatbot_interactions
        WHERE session_id = %s
        ORDER BY created_at ASC
        LIMIT %s
    """, (session_id, limit))
    rows = cursor.fetchall()
    cursor.close()
    history = [f"Usuario: {row['input_text']}\nBot: {row['response_text']}" for row in rows]
    return "\n".join(history)

def save_interaction(session_id: str, user_input: str, bot_response: str):
    ensure_db_connection()
    cursor = db_conn.cursor()
    cursor.execute("""
        INSERT INTO chatbot_interactions (session_id, input_text, response_text)
        VALUES (%s, %s, %s)
    """, (session_id, user_input, bot_response))
    db_conn.commit()
    cursor.close()




# ======================================================
# CARGA CHROMA
# ======================================================
db = None
retriever = None

def load_chroma():
    global db, retriever
    db = Chroma(embedding_function=embeddings, persist_directory=str(PERSIST_DIR))
    retriever = db.as_retriever(search_type="similarity", search_kwargs={"k": 3})

# cargar si hay datos
if any(PERSIST_DIR.iterdir()):
    load_chroma()
    logger.info("VectorDB cargado correctamente.")

# ======================================================
# MODELO REQUEST
# ======================================================
class Query(BaseModel):
    query: str
    session_id: str | None = None

# ======================================================
# ENDPOINT INGEST
# ======================================================
@app.post("/ingest")
async def ingest(file: UploadFile = File(...)):
    try:
        content = await file.read()
        docs = []

        # TXT
        if file.filename.lower().endswith(".txt"):
            text = content.decode("utf-8").strip()
            if text:
                docs.append(Document(page_content=text))

        # PDF
        elif file.filename.lower().endswith(".pdf"):
            pdf = fitz.open(stream=content, filetype="pdf")
            for page in pdf:
                txt = page.get_text().strip()
                if not txt:
                    zoom = 3
                    pix = page.get_pixmap(matrix=fitz.Matrix(zoom, zoom))
                    img = Image.open(io.BytesIO(pix.tobytes("png"))).convert("RGB")
                    txt = pytesseract.image_to_string(img, lang="spa").strip()
                if txt:
                    docs.append(Document(page_content=txt))
        else:
            raise HTTPException(400, "Solo archivos TXT o PDF.")

        if not docs:
            raise HTTPException(400, "El archivo no contiene texto usable.")

        splitter = CharacterTextSplitter(chunk_size=500, chunk_overlap=50)
        chunks = splitter.split_documents(docs)

        global db, retriever
        db = Chroma.from_documents(documents=chunks, embedding_function=embeddings, persist_directory=str(PERSIST_DIR))
        db.persist()
        retriever = db.as_retriever(search_type="similarity", search_kwargs={"k": 3})

        logger.info("Retriever reconstruido correctamente.")
        return {"status": "ok", "chunks_indexed": len(chunks)}

    except Exception:
        traceback.print_exc()
        raise HTTPException(500, "Error procesando el archivo.")

# ======================================================
# ENDPOINT ASK
# ======================================================
@app.post("/ask")
async def ask(payload: Query):
    try:
        if retriever is None:
            raise HTTPException(400, "Primero usa /ingest para cargar documentos.")

        session_id = payload.session_id
        logger.info(f"🟦 Nueva pregunta: {payload.query}")

        # 🔥 FIX: usar método correcto
        docs = retriever.invoke(payload.query)

        context_text = "\n".join([d.page_content for d in docs])
        chat_context = get_chat_history(session_id)

        full_context = ""
        if chat_context:
            full_context += f"--- HISTORIAL DEL CHAT ---\n{chat_context}\n\n"
        if context_text:
            full_context += f"--- CONTEXTO DEL DOCUMENTO ---\n{context_text}"

        logger.info("Contexto enviado al LLM (recortado):")
        logger.info(full_context[:1000])

        start = time.time()
        answer = qa_chain.invoke({"context": full_context, "question": payload.query})
        end = time.time()

        logger.info(f"Tiempo respuesta LLM: {round(end - start, 2)}s")
        clean_answer = answer.strip()
        logger.info(f"🟩 Respuesta FINAL: {clean_answer}")

# Guardar en historial
        if session_id:
            save_interaction(session_id, payload.query, clean_answer)

        return {"answer": clean_answer}

    except Exception:
        traceback.print_exc()
        raise HTTPException(500, "Error procesando la consulta.")
