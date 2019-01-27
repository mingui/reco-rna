#Tensorflow library. Used to implement machine learning models
import tensorflow as tf
#Numpy contains helpful functions for efficient mathematical calculations
import numpy as np
#Dataframe manipulation library
import pandas as pd
import os

libros_df = pd.read_csv('data/bibliografia2.csv', sep=',', header=None)
#print (libros_df.head(5))

ratings_df = pd.read_csv('data/ratings.dat', sep='::', header=None)
#print (ratings_df.head(5))

libros_df.columns = ['bibliografiaID', 'Title', 'Autor1','Autor2','Volumen']
ratings_df.columns = ['UserID', 'bibliografiaID', 'Rating', 'Timestamp']

#print (len(libros_df))

libros_df['List Index'] = libros_df.index

#unir tablas
merged_df = libros_df.merge(ratings_df, on='bibliografiaID')
#Dropping unecessary columns
merged_df = merged_df.drop('Timestamp', axis=1)

#Agrupar por UserID
userGroup = merged_df.groupby('UserID')
#print (userGroup.first().head()) 

#cantidad de usuarios para entrenar red
amountOfUsedUsers = 1000
#creando lista de entrenamiento
trX = []
#por cada usuario en el grupo
for userID, curUser in userGroup:
    #crear un temp que guarda cada valoracion de libro
    temp = [0]*len(libros_df)
    #por cada libro en la lista de libros curUser's
    for num, libros in curUser.iterrows():
        #Dividir la valoracion por 5 y guardarla
        temp[libros['List Index']] = libros['Rating']/5.0
    # Agregar la lista de valoracion en la lista de entrenamiento
    trX.append(temp)
    # revisar para ver si se termino de agregar la cantidad de usuarios para entrenar
    if amountOfUsedUsers == 0:
        break
    amountOfUsedUsers -= 1


hiddenUnits = 20
visibleUnits = len(libros_df)
vb = tf.placeholder("float", [visibleUnits]) #Number of unique movies
hb = tf.placeholder("float", [hiddenUnits]) #Number of features we're going to learn
W = tf.placeholder("float", [visibleUnits, hiddenUnits])

#Phase 1: Input Processing
v0 = tf.placeholder("float", [None, visibleUnits])
_h0= tf.nn.sigmoid(tf.matmul(v0, W) + hb)
h0 = tf.nn.relu(tf.sign(_h0 - tf.random_uniform(tf.shape(_h0))))
#Phase 2: Reconstruction
_v1 = tf.nn.sigmoid(tf.matmul(h0, tf.transpose(W)) + vb) 
v1 = tf.nn.relu(tf.sign(_v1 - tf.random_uniform(tf.shape(_v1))))
h1 = tf.nn.sigmoid(tf.matmul(v1, W) + hb)

#Learning rate
alpha = 1.0
#Create the gradients
w_pos_grad = tf.matmul(tf.transpose(v0), h0)
w_neg_grad = tf.matmul(tf.transpose(v1), h1)
#Calculate the Contrastive Divergence to maximize
CD = (w_pos_grad - w_neg_grad) / tf.to_float(tf.shape(v0)[0])
#Create methods to update the weights and biases
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
        prv_hb = cur_nb
    errors.append(sess.run(err_sum, feed_dict={v0: trX, W: cur_w, vb: cur_vb, hb: cur_nb}))
    #print (errors[-1])


    #Seleccionando el usuario de entrada
inputUser = [trX[75]]
#Alimentar el usuario de entrada y reconstruir la entrada
hh0 = tf.nn.sigmoid(tf.matmul(v0, W) + hb)
vv1 = tf.nn.sigmoid(tf.matmul(hh0, tf.transpose(W)) + vb)
feed = sess.run(hh0, feed_dict={ v0: inputUser, W: prv_w, hb: prv_hb})
rec = sess.run(vv1, feed_dict={ hh0: feed, W: prv_w, vb: prv_vb})

#Se recomiendan 20 libros a nuestro usuario de prueba clasificándolos por sus puntajes proporcionados por nuestro modelo.
scored_libros_df_75 = libros_df
scored_libros_df_75["Recommendation Score"] = rec[0]
#print (scored_libros_df_75.sort_values(["Recommendation Score"], ascending=False).head(20))


#Para recomendar libros que el usuario no ha leido:
#Se encuentra el id del usuario de prueba
merged_df.iloc[75]

#encontrar los libros que el usuario leyó
libros_df_75 = merged_df[merged_df['UserID']==1]
#libros_df_75.head()

#combinar libros_df con ratings_df por bibliografiaID
merged_df_75 = scored_libros_df_75.merge(libros_df_75, on='bibliografiaID', how='outer')
#borrar columnas innecesarias
merged_df_75 = merged_df_75.drop('List Index_y', axis=1).drop('UserID', axis=1).drop('Title_y', axis=1).drop('Autor1_y', axis=1).drop('Autor2_y', axis=1).drop('Volumen_y', axis=1)


print (merged_df_75.sort_values(["Recommendation Score"], ascending=False).head(20))