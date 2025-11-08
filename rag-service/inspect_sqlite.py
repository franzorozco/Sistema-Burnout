import sqlite3

db_path = "./vectordb/chroma.sqlite3"

conn     = sqlite3.connect(db_path)
cursor = conn.cursor()

print("📋 Tablas disponibles:")
cursor.execute("SELECT name FROM sqlite_master WHERE type='table';")
tables = cursor.fetchall()
for t in tables:
    print("-", t[0])

print("\n🔢 Conteo de filas en tablas principales:")
for t in ["embeddings", "collections", "documents"]:
    try:
        cursor.execute(f"SELECT COUNT(*) FROM {t};")
        count = cursor.fetchone()[0]
        print(f"{t}: {count}")
    except Exception as e:
        print(f"{t}: (no existe)")

conn.close()
