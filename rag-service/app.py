import os
import logging
from dotenv import load_dotenv
from fastapi import FastAPI, UploadFile, File, HTTPException
from fastapi.middleware.cors import CORSMiddleware
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
import json
import traceback
import time

# DB
import mysql.connector
from mysql.connector import Error

# ======================================================
# LOGGING
# ======================================================
logging.basicConfig(level=logging.INFO)
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
LLM_URL = os.getenv("LLM_URL", "http://localhost:11434")
LLM_MODEL = os.getenv("LLM_MODEL", "llama3.2")
EMBED_MODEL = os.getenv("EMBED_MODEL", "nomic-embed-text")
DB_HOST = os.getenv("DB_HOST", "127.0.0.1")
DB_USER = os.getenv("DB_USER", "root")
DB_PASSWORD = os.getenv("DB_PASSWORD", "")
DB_NAME = os.getenv("DB_NAME", "burnout_borrador")

PERSIST_DIR = Path("vectordb")
PERSIST_DIR.mkdir(exist_ok=True)

app = FastAPI(title="RAG Service (Ollama + LangChain + Chroma)")

# ======================================================
# CORS
# ======================================================
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# ======================================================
# MODELOS
# ======================================================
llm = OllamaLLM(model=LLM_MODEL, base_url=LLM_URL)
embeddings = OllamaEmbeddings(model=EMBED_MODEL, base_url=LLM_URL)

# ======================================================
# PROMPT PRINCIPAL (RESPUESTA DEL CHAT)
# ======================================================
prompt = PromptTemplate(
    input_variables=["context", "question"],
    template="""
Eres **Laiso**, un asistente psicológico especializado en prevención del burnout.
Tu estilo es cálido, empático y breve. Hablas natural, como un chat humano.

### REGLAS:
- No saludes si ya hubo saludo.
- No te despidas si no se despiden.
- No repitas el historial ni el contexto.
- Responde entre 3 y 20 líneas.
- Mantén tono empático, simple y humano.

### CONTEXTO PARA ENTENDER (NO LO REPITAS):
{context}

### MENSAJE:
{question}

### RESPUESTA DE LAISO:
"""
)
qa_chain = prompt | llm | StrOutputParser()

# ======================================================
# PROMPT DE ANÁLISIS EMOCIONAL Y DE RIESGO
# ======================================================
analysis_prompt = PromptTemplate(
    input_variables=["text"],
    template="""
Eres un analizador clínico automático. Recibirás un mensaje de un usuario y debes clasificarlo.
Responde SOLO en JSON válido.

Analiza el mensaje:
"{text}"

Devuelve un JSON con:

- "emotion": ["neutral", "tristeza", "ansiedad", "estres", "frustracion", "ira", "miedo", "desesperacion"]
- "sentiment": ["positivo", "neutral", "negativo"]
- "symptoms": lista de síntomas detectados (texto libre)
- "risk_level": ["sin_riesgo", "riesgo_leve", "riesgo_moderado", "riesgo_alto", "riesgo_extremo"]
- "should_alert": true o false
- "summary": explicación breve del estado emocional

REGLAS:
- Mencionar suicidio, autolesiones, "me quiero matar", "no quiero vivir", implica riesgo_alto o riesgo_extremo.
- Ansiedad fuerte, pánico, colapso → riesgo_moderado.
- SOLO JSON. Sin texto adicional.
"""
)
analysis_chain = analysis_prompt | llm | StrOutputParser()

def analyze_with_model(text: str):
    raw = analysis_chain.invoke({"text": text})
    try:
        return json.loads(raw)
    except:
        return {
            "emotion": "neutral",
            "sentiment": "neutral",
            "symptoms": [],
            "risk_level": "sin_riesgo",
            "should_alert": False,
            "summary": "No se pudo analizar correctamente"
        }

# ======================================================
# MYSQL
# ======================================================
def connect_db():
    try:
        return mysql.connector.connect(
            host=DB_HOST,
            user=DB_USER,
            password=DB_PASSWORD,
            database=DB_NAME,
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
def get_chat_history(session_id: str, max_chars: int = 3000):
    if not session_id:
        return ""
    ensure_db_connection()
    cursor = db_conn.cursor(dictionary=True)
    cursor.execute("""
        SELECT input_text, response_text 
        FROM chatbot_interactions
        WHERE session_id = %s
        ORDER BY created_at ASC
    """, (session_id,))
    rows = cursor.fetchall()
    cursor.close()

    if not rows:
        return ""

    history = []
    total_chars = 0

    for row in rows[:-1]:
        line = f"U: {row['input_text']}\nA: {row['response_text'][:200]}"
        total_chars += len(line)
        if total_chars > max_chars:
            break
        history.append(line)

    last_row = rows[-1]
    last_line = (
        f"Última interacción:\n"
        f"U: {last_row['input_text']}\n"
        f"A: {last_row['response_text'][:200]}"
    )
    history.append(last_line)
    return "\n".join(history)

# ======================================================
# CARGA CHROMA
# ======================================================
db = None
retriever = None

def load_chroma():
    global db, retriever
    db = Chroma(embedding_function=embeddings, persist_directory=str(PERSIST_DIR))
    retriever = db.as_retriever(search_type="similarity", search_kwargs={"k": 3})

if any(PERSIST_DIR.iterdir()):
    load_chroma()
    logger.info("VectorDB cargado correctamente.")

# ======================================================
# MODELO REQUEST
# ======================================================
class Query(BaseModel):
    query: str
    session_id: str | None = None
    user_id: int | None = None

# ======================================================
# ENDPOINT INGEST
# ======================================================
@app.post("/ingest")
async def ingest(file: UploadFile = File(...)):
    try:
        content = await file.read()
        docs = []

        if file.filename.lower().endswith(".txt"):
            text = content.decode("utf-8").strip()
            if text:
                docs.append(Document(page_content=text))

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
        db = Chroma.from_documents(
            documents=chunks,
            embedding_function=embeddings,
            persist_directory=str(PERSIST_DIR)
        )
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
        logger.info(f"Nueva pregunta: {payload.query}")

        # Recuperar contexto RAG
        docs = retriever.invoke(payload.query)
        context_text = "\n".join([d.page_content for d in docs])

        # Historial
        chat_context = get_chat_history(session_id)

        full_context = ""
        if chat_context:
            full_context += f"--- HISTORIAL DEL CHAT ---\n{chat_context}\n\n"
        if context_text:
            full_context += f"--- CONTEXTO DEL DOCUMENTO ---\n{context_text}"

        logger.info("Contexto enviado al LLM (resumido):")
        logger.info(full_context[:500])

        # Respuesta del chat
        answer = qa_chain.invoke({"context": full_context, "question": payload.query})
        clean_answer = answer.strip()

        # Análisis emocional completo con el LLM
        analysis = analyze_with_model(payload.query)

        # Guardar BD
        ensure_db_connection()
        cursor = db_conn.cursor()

        insert_sql = """
            INSERT INTO chatbot_interactions
            (user_id, session_id, input_text, input_metadata, response_text, 
            response_metadata, intent, sentiment, detected_risk, detected_keywords, created_at)
            VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, NOW())
        """

        cursor.execute(insert_sql, (
            payload.user_id,
            session_id,
            payload.query,
            json.dumps({"source": "fastapi"}),
            clean_answer,
            json.dumps({"model": LLM_MODEL}),
            None,
            json.dumps({
                "emotion": analysis["emotion"],
                "sentiment": analysis["sentiment"],
                "risk_level": analysis["risk_level"],
                "summary": analysis["summary"]
            }),
            analysis["should_alert"],
            json.dumps(analysis["symptoms"])
        ))

        interaction_id = cursor.lastrowid

        if analysis["should_alert"]:
            student_profile_id = None
            if payload.user_id:
                cursor.execute("SELECT id FROM student_profiles WHERE user_id = %s", (payload.user_id,))
                profile = cursor.fetchone()
                if profile:
                    student_profile_id = profile[0]

            cursor.execute("""
                INSERT INTO chatbot_alerts
                (chatbot_interaction_id, student_profile_id, alert_type, severity)
                VALUES (%s, %s, 'riesgo_emocional', %s)
            """, (
                interaction_id,
                student_profile_id,
                analysis["risk_level"][0] if isinstance(analysis["risk_level"], list) else analysis["risk_level"]

            ))

        db_conn.commit()
        cursor.close()

        return {"answer": clean_answer}

    except Exception:
        traceback.print_exc()
        raise HTTPException(500, "Error procesando la consulta.")
