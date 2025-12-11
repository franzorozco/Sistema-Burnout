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
LLM_URL = os.getenv("LLM_URL", "http://localhost:11434")  # Ollama local
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
# CORS para poder llamar desde Laravel remoto
# ======================================================
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],  # en producción poner solo la URL de Laravel
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
# PROMPT PRINCIPAL
# ======================================================
prompt = PromptTemplate(
    input_variables=["context", "question"],
    template="""
Eres **Laiso**, un asistente psicológico especializado en prevención del burnout. 
Tu estilo es cálido, empático, breve y natural. Hablas como en un chat real, 
NO como una clase, NO repites saludos, NO das definiciones largas, 
NO repites información que ya está en el historial.

### REGLAS DE COMUNICACIÓN:
- No saludes si el usuario ya saludó antes.
- No te despidas si el usuario no se despide.
- Responde siempre de forma breve (3–20 líneas máximo).
- No respondas con nombres que estén en el documento, solo usa el nombre que el usuario te da.
- Mantén coherencia emocional con lo dicho anteriormente.
- Prioriza escuchar, validar emociones y avanzar la conversación.
- Haz preguntas cortas que ayuden a comprender mejor al usuario.
- No repitas información del contexto, solo úsala para entenderlo.
- Usa un tono humano, empático y sencillo.

### CONTEXTO DEL CHAT (para que entiendas el estado emocional, no lo repitas):
{context}

### MENSAJE DEL USUARIO:
{question}

### RESPUESTA DE LAISO (concisa, empática y natural):
"""
)
qa_chain = prompt | llm | StrOutputParser()

# ======================================================
# DETECCIÓN DE SÍNTOMAS Y EMOCIONES
# ======================================================
RISK_KEYWORDS = ["no puedo más", "no doy más", "agotado", "agotamiento",
                 "estresado", "estres", "cansado", "fatigado",
                 "ansioso", "ansiedad", "desesperado"]

SYMPTOMS_MAP = {
    "estres": ["estres", "estresado", "estresante"],
    "agotamiento": ["agotado", "cansado", "fatigado"],
    "ansiedad": ["ansioso", "ansiedad"],
    "tristeza": ["triste", "bajoneado"],
    "frustracion": ["frustrado", "molesto"],
    "problemas_sueno": ["insomnio", "no puedo dormir", "duermo mal"],
    "dolor_cabeza": ["dolor de cabeza", "migraña"],
    "desmotivacion": ["desmotivado", "sin ganas", "pérdida de interés"]
}


def detect_symptoms_and_emotion(text: str):
    text_lower = text.lower()
    detected_symptoms = []
    risk_flag = False

    for symptom, keywords in SYMPTOMS_MAP.items():
        if any(kw in text_lower for kw in keywords):
            detected_symptoms.append(symptom)

    if any(kw in text_lower for kw in RISK_KEYWORDS):
        risk_flag = True

    emotion = "neutral"
    if any(x in text_lower for x in ["triste", "solo", "mal"]):
        emotion = "tristeza"
    if any(x in text_lower for x in ["estres", "presion"]):
        emotion = "estres"
    if any(x in text_lower for x in ["ansioso"]):
        emotion = "ansiedad"

    sentiment = "neutral"
    if any(x in text_lower for x in ["bien", "contento", "tranquilo"]):
        sentiment = "positivo"
    elif any(x in text_lower for x in ["mal", "triste", "estres", "agotado"]):
        sentiment = "negativo"

    return {"emotion": emotion, "sentiment": sentiment, "symptoms": detected_symptoms, "risk": risk_flag}

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
    last_line = f"Última interacción del usuario:\nU: {last_row['input_text']}\nA: {last_row['response_text'][:200]}"
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
        logger.info(f"Nueva pregunta: {payload.query}")

        # Recuperar contexto RAG
        docs = retriever.invoke(payload.query)
        context_text = "\n".join([d.page_content for d in docs])

        # Obtener historial
        chat_context = get_chat_history(session_id)
        full_context = ""
        if chat_context:
            full_context += f"--- HISTORIAL DEL CHAT ---\n{chat_context}\n\n"
        if context_text:
            full_context += f"--- CONTEXTO DEL DOCUMENTO ---\n{context_text}"

        logger.info("Contexto enviado al LLM (resumido):")
        logger.info(full_context[:500])

        # Generar respuesta
        start = time.time()
        answer = qa_chain.invoke({"context": full_context, "question": payload.query})
        end = time.time()

        clean_answer = answer.strip()
        logger.info(f"Respuesta FINAL: {clean_answer}")

        # Detectar síntomas
        analysis = detect_symptoms_and_emotion(payload.query)

        # Guardar en BD
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
            json.dumps({"emotion": analysis["emotion"], "sentiment": analysis["sentiment"]}),
            analysis["risk"],
            json.dumps(analysis["symptoms"])
        ))

        interaction_id = cursor.lastrowid
        if analysis["risk"]:
            student_profile_id = None
            if payload.user_id:
                cursor.execute("SELECT id FROM student_profiles WHERE user_id = %s", (payload.user_id,))
                profile = cursor.fetchone()
                if profile:
                    student_profile_id = profile[0]
            cursor.execute("""
                INSERT INTO chatbot_alerts
                (chatbot_interaction_id, student_profile_id, alert_type, severity)
                VALUES (%s, %s, 'alto_estres', 'alto')
            """, (interaction_id, student_profile_id))

        db_conn.commit()
        cursor.close()
        return {"answer": clean_answer}

    except Exception:
        traceback.print_exc()
        raise HTTPException(500, "Error procesando la consulta.")