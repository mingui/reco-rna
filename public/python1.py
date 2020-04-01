import sys
print(sys.version)
import pymysql
import pandas as pd

from sys import argv

print(sys.version)

############### CONFIGURAR ESTO ###################
# Abre conexion con la base de datos
db = pymysql.connect(host='localhost',
                    user='root',
                    password='',
                    db='libros',
                    charset='utf8')
##################################################

# prepare a cursor object using cursor() method
cursor = db.cursor()

# Prepare SQL query to READ a record into the database.
sql = "SELECT * FROM `bibliografia`"
#WHERE id > {0}".format(0)

# Execute the SQL command
cursor.execute(sql)

libros_df = pd.read_sql(sql, db)

#print (libros_df.head(5))
