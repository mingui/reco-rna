import tensorflow as tf
import numpy as np
import pandas as pd
import pymysql
#import os
import sys



from sys import argv

script, usuario_id = argv
#usuario_id = list(map(int,usuario_id))
usuario_id = int(usuario_id)
#usuario_id = 1
#print (usuario_id)

mysql_connection = pymysql.connect(host='localhost',
                    user='root',
                    password='',
                    db='libros',
                    charset='utf8',
                    cursorclass=pymysql.cursors.DictCursor)
                    
sql1 = "SELECT * FROM `bibliografia`"
sql2 = "SELECT * FROM `user_libros`"
libros_df = pd.read_sql(sql1, mysql_connection)
ratings_df = pd.read_sql(sql2, mysql_connection)

#print (libros_df.head(5))

#ratings_df = pd.read_csv(r'data/busquedas.csv', sep=',', header=None, engine='python')
#print (ratings_df.head(5))

libros_df.columns = ['bibliografiaID', 'Title', 'Autor1','Autor2','Volumen']
#ratings_df.columns = ['UserID', 'bibliografiaID', 'Rating', 'Timestamp']
ratings_df.columns = ['ID','UserID','bibliografiaID','busquedaID', 'Rating', 'Creado','Modificado']
#ratings_df = ratings_df[np.isfinite(ratings_df['bibliografiaID'])]
#ratings_df['bibliografiaID'] = ratings_df.bibliografiaID.astype(int)
#Dropping unecessary columns
ratings_df = ratings_df.drop(['ID','busquedaID','Creado','Modificado'], axis=1)
#print (ratings_df.head(5))


user_rating_df = ratings_df.pivot(index='UserID', columns='bibliografiaID', values='Rating')
#print (user_rating_df.head())

norm_user_rating_df = user_rating_df.fillna(0) / 5.0
trX = norm_user_rating_df.values

#print (trX[0:5])

hiddenUnits = 20
visibleUnits =  len(user_rating_df.columns)
vb = tf.placeholder("float", [visibleUnits]) #Cantidad de libros unicos
hb = tf.placeholder("float", [hiddenUnits]) #Numero de caracteristicas que va aprender
W = tf.placeholder("float", [visibleUnits, hiddenUnits])


#Fase 1: Input Processing, Forward Pass

v0 = tf.placeholder("float", [None, visibleUnits])
_h0 = tf.nn.sigmoid(tf.matmul(v0, W) + hb)
h0 = tf.nn.relu(tf.sign(_h0 - tf.random_uniform(tf.shape(_h0))))


#Fase 2: Reconstruction

_v1 = tf.nn.sigmoid(tf.matmul(h0, tf.transpose(W)) + vb) 
v1 = tf.nn.relu(tf.sign(_v1 - tf.random_uniform(tf.shape(_v1))))
h1 = tf.nn.sigmoid(tf.matmul(v1, W) + hb)

#Tasa de aprendizaje
alpha = 1.0
#Crear gradientes
w_pos_grad = tf.matmul(tf.transpose(v0), h0)
w_neg_grad = tf.matmul(tf.transpose(v1), h1)
#
#Calcula la Divergencia Contrastiva para maximizar
CD = (w_pos_grad - w_neg_grad) / tf.to_float(tf.shape(v0)[0])
#Crear métodos para actualizar los pesos y bias
update_w = W + alpha * CD
update_vb = vb + alpha * tf.reduce_mean(v0 - v1, 0)
update_hb = hb + alpha * tf.reduce_mean(h0 - h1, 0)


err = v0 - v1
err_sum = tf.reduce_mean(err * err)



#Current weight
cur_w = np.zeros([visibleUnits, hiddenUnits], np.float32)
#Current visible unit biases
cur_vb = np.zeros([visibleUnits], np.float32)
#Current hidden unit biases
cur_hb = np.zeros([hiddenUnits], np.float32)
#Previous weight
prv_w = np.zeros([visibleUnits, hiddenUnits], np.float32)
#Previous visible unit biases
prv_vb = np.zeros([visibleUnits], np.float32)
#Previous hidden unit biases
prv_hb = np.zeros([hiddenUnits], np.float32)
sess = tf.Session()
sess.run(tf.global_variables_initializer())

epochs = 15
batchsize = 100
errors = []
for i in range(epochs):
    for start, end in zip( range(0, len(trX), batchsize), range(batchsize, len(trX), batchsize)):
        batch = trX[start:end]
        cur_w = sess.run(update_w, feed_dict={v0: batch, W: prv_w, vb: prv_vb, hb: prv_hb})
        cur_vb = sess.run(update_vb, feed_dict={v0: batch, W: prv_w, vb: prv_vb, hb: prv_hb})
        cur_nb = sess.run(update_hb, feed_dict={v0: batch, W: prv_w, vb: prv_vb, hb: prv_hb})
        prv_w = cur_w
        prv_vb = cur_vb
        prv_hb = cur_hb
    errors.append(sess.run(err_sum, feed_dict={v0: trX, W: cur_w, vb: cur_vb, hb: cur_hb}))
   # print (errors[-1])


#Seleccionando el usuario de entrada
mock_user_id = usuario_id
inputUser = trX[mock_user_id-1].reshape(1, -1)
#print (inputUser[0:5])

#Alimentar el usuario de entrada y reconstruir la entrada
hh0 = tf.nn.sigmoid(tf.matmul(v0, W) + hb)
vv1 = tf.nn.sigmoid(tf.matmul(hh0, tf.transpose(W)) + vb)
feed = sess.run(hh0, feed_dict={ v0: inputUser, W: prv_w, hb: prv_hb})
rec = sess.run(vv1, feed_dict={ hh0: feed, W: prv_w, vb: prv_vb})
#print(rec)


#Se recomiendan 20 libros a nuestro usuario de prueba clasificándolos por sus puntajes proporcionados por nuestro modelo.
scored_libros_df_mock = libros_df[libros_df['bibliografiaID'].isin(user_rating_df.columns)]
scored_libros_df_mock = scored_libros_df_mock.assign(RecommendationScore = rec[0])
#print (scored_libros_df_mock.sort_values(["RecommendationScore"], ascending=False).head(20))

libros_df_mock = ratings_df[ratings_df['UserID'] == mock_user_id]

#combinar libros_df con ratings_df por bibliografiaID
merged_df_mock = scored_libros_df_mock.merge(libros_df_mock, on='bibliografiaID', how='outer')

#borrar columnas innecesarias
merged_df_mock = merged_df_mock.drop('Title', axis=1).drop(['UserID','Autor1','Autor2','Volumen',], axis=1)


rec = merged_df_mock[merged_df_mock["Rating"].isnull()].sort_values(["RecommendationScore"], ascending=False).head(5)
rec = rec.drop('Rating',axis=1)
print (rec)
#print (merged_df_mock.sort_values(["RecommendationScore"], ascending=False).head(20))