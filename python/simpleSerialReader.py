import serial

s = serial.Serial('COM4', baudrate=9600,timeout=1.0)
res = s.read(20)
print(res)