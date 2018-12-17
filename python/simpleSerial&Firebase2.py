import serial
import datetime
from firebase import firebase

db = firebase.FirebaseApplication('https://innovaton-86d52.firebaseio.com', None)

arduino = serial.Serial('COM4', baudrate=9600,timeout=0.5)
cont = 1
while True:
    line = arduino.readline()
    if len( line ) > 0:
        listLines = line.splitlines()
        textClean = ''.join(map(str,listLines))
        textClean = textClean.replace('b', '')
        textClean = textClean.replace('\'', '')
        listData = textClean.split('  ')
        textClean = ''.join(map(str, listData))
        textClean = textClean.replace('X:', '').replace('Y:', '').replace('Z:', '').lstrip()
        listData = textClean.split(' ')
        print(listData)
    cont = cont+1

