import datetime
import random
import string
import uuid

import psycopg2
from psycopg2 import Error

# ID para la fecha inicial (1 de enero de 2021)
fecha_inicial = datetime.datetime(2024, 5, 1)

# IDs predefinidos para id_centro
id_centros = [
    "ef48298f-cedf-4718-aa67-b097c80ef23b",
    "e1420c15-5f78-4815-8f27-c4df1793bc21",
    "e9003437-c828-465a-b0ec-b50f7395a2b2",
    "ed587387-5f05-4b86-8bdc-db81d95d5acf",
    "bc5d1e12-acf0-4771-8d91-8e0fe7d3cf71",
    "833397ec-c152-40e0-8a3b-536455dd1982",
    "2dbf73c0-17f0-44c3-bf3e-6cffe40264d1",
    "42a9c5de-2fa9-47cb-9707-a6bade35fdc5",
    "e3eb2897-7999-4418-bd04-d0a33e3a84f6",
    "caba5421-1581-49db-a4c2-2a8c3b39d238",
    "054c93ab-fc9c-435f-bf6b-0dabcf4cce5e",
    "525c8421-6961-47fd-a630-1819594c9ecc",
    "1fb38bb6-59bc-4272-8e08-0dcbf43516dc",
    "c9ffaf46-4ba8-4515-aac7-58bdc923f197",
    "141ef0a0-4102-4f44-99bd-59e52d314e8c",
    "664f5ba3-84e3-40f9-afc3-2fc1a152f88b"
]

# Funciones para generar valores aleatorios
def generar_string(n):
    return ''.join(random.choices(string.ascii_uppercase + string.digits, k=n))

def generar_entero_limite(limite):
    return random.randint(1, limite)

# Datos de conexión a la base de datos
try:
    connection = psycopg2.connect(user="postgres",
                                  password="cmg.2024",
                                  host="10.121.6.205",
                                  port="5432",
                                  database="SIS")

    cursor = connection.cursor()

    # Establecer la misma fecha inicial para todos los registros
    fecha_actual = fecha_inicial

    for id_centro in id_centros:
        # Generar valores aleatorios
        id_registro = str(uuid.uuid4())
        conve_stra = generar_entero_limite(10)
        comp_insti = generar_entero_limite(10)
        opera_cam = generar_entero_limite(20)
        ausentimo = generar_entero_limite(20)
        mobile_locator = generar_entero_limite(10)
        dispoci = generar_entero_limite(20)
        com_estra = generar_entero_limite(10)
        created_at = fecha_actual
        obv_conve_stra = generar_string(10)
        obv_comp_insti = generar_string(10)
        obv_opera_cam = generar_string(10)
        obv_ausentimo = generar_string(10)
        obv_mobile_locator = generar_string(10)
        obv_dispoci = generar_string(10)
        obv_com_estra = generar_string(10)

        # Query de inserción
        postgres_insert_query = """ INSERT INTO public.registros (id_registro, id_centro, conve_stra, comp_insti, opera_cam, ausentimo, mobile_locator, dispoci, com_estra, created_at, obv_conve_stra, obv_comp_insti, obv_opera_cam, obv_ausentimo, obv_mobile_locator, obv_dispoci, obv_com_estra) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"""
        record_to_insert = (id_registro, id_centro, conve_stra, comp_insti, opera_cam, ausentimo, mobile_locator, dispoci, com_estra, created_at, obv_conve_stra, obv_comp_insti, obv_opera_cam, obv_ausentimo, obv_mobile_locator, obv_dispoci, obv_com_estra)

        cursor.execute(postgres_insert_query, record_to_insert)
        connection.commit()

        # Imprimir id_centro y fecha insertada para cada registro
        print(f"Centro: {id_centro}, Fecha: {fecha_actual.strftime('%Y-%m-%d')}")

    print("Datos insertados correctamente")

except (Exception, Error) as error:
    print("Error al insertar datos:", error)

finally:
    if (connection):
        cursor.close()
        connection.close()
        print("Conexión cerrada")
