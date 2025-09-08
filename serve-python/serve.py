import mysql.connector

try:
    conn = mysql.connector.connect(
        host="192.168.180.200",
        port=3306,
        user="teste",
        password="041599",
        database="telynoc"
    )

    if conn.is_connected():
        print("✅ Conectado ao MySQL!")
        cursor = conn.cursor()
        cursor.execute("SHOW TABLES;")
        for table in cursor.fetchall():
            print(table)

except mysql.connector.Error as e:
    print(f"❌ Erro: {e}")

finally:
    if 'conn' in locals() and conn.is_connected():
        conn.close()
