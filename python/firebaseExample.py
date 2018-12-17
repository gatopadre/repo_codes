import datetime
from firebase import firebase

firebase = firebase.FirebaseApplication('https://innovaton-86d52.firebaseio.com', None)
result = firebase.get('/coordenadas', None)

print(result)