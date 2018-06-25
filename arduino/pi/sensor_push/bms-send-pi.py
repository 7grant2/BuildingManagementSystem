#!/user/bin/python
#!/bin/envpython
import serial
import requests
import RPi.GPIO as GPIO
from datetime import datetime
import time
from time import sleep
import string
import os

# O = OCCUPANY
# S = SMOKE
# R = RFID
# M = MOTION
# T = METAL

emodepin = 40
us='username'
ps='password'
port=''
url = 'url-to-site'
loop = True

# Boot E-mode Settings
GPIO.setmode(GPIO.BOARD)
GPIO.setwarnings(False)
GPIO.setup(emodepin, GPIO.OUT)
GPIO.output(emodepin, 0)

# Returns if network is active
def check_network():
    hostname = "http://google.com"
    r = requests.get('https://google.com')
    if r.status_code == 200:
        return
    else:
        #pingstatus = "Network Error"
        sleep(5)
        check_ping()

def pushSensor(sensorarr):
    d = datetime.now().strftime('%Y/%m/%d')
    t = datetime.now().strftime('%H:%M:%S')
    # For each sensor in sensor array, push info to server
    for arr in sensorarr:
        #print arr[0]
        #print arr[1]
        info = {
            'sensorname' : arr[0],
            'date' : d,
            'time' : t,
            'metric' : arr[1],
            'username' : us,
            'password' : ps
        }
        try:
            r = requests.post(url, data=info)
            # If connection isn't successful
            if(r.status_code != 200):
                # If error is not a bad sensor
                if(r.status_code != 401):
                    check_network()
                    return
                else:
                    print arr
                #print r.status_code
                #print r.text
        except:
            # Unkown error - check network
            check_network()
            sleep(1)
            break;
        
# Strips the input from Serial to proper ascii values
def stripper(x):
    try:
        x = x.strip()
        x = x.decode("utf-8", "ignore").encode("ascii", "ignore")
        if (x == ''):
            x = '0'
        return x
    except:
        if (x == ''):
            x = '0'
        return x
        
def readSerial(s1):
    #store all sensors with their information in this array
    sensorarr = []
    #check if value has been repeated
    check = ''    
    while True:
        begin = s1.readline()
        begin = stripper(begin)
        if (begin.strip() == "end"):
            break
    while True:
        sensorinfo = []
        sensorid = s1.readline()
        sensorid = stripper(sensorid)
        if (sensorid.strip()=="end"):
            break
        sensorinfo.append(sensorid)
        metric = s1.readline()
        metric = stripper(metric)
        sensorinfo.append(metric)
        type = s1.readline()
        type = stripper(type)
        sensorinfo.append(type)
        #append current info to array
        print sensorinfo
        sleep(.01)
        sensorarr.append(sensorinfo)
    return sensorarr

# Write GPIO pin to ON
def eMode():
    print "emode"
    GPIO.output(emodepin, 1)
    time.sleep(1)
    GPIO.output(emodepin, 0)

#loop through info and check if smoke or metal is true
def checkSmoke(sensorarr):
    for arr in sensorarr:
        if((arr[2] == str(ord('s'))) or (arr[2] == str(ord('S')))):
            #print arr[1]
            if (int(arr[1]) > 0):
                return True
    return False

def checkMetal(sensorarr):
    for arr in sensorarr:
        print arr[2]
        if(arr[2] == str(ord('T'))):
            if (arr[1] > 0):
                return True
    return False

def serinit():
    loop = True
    while(loop):
        try:
            t = serial.Serial('/dev/ttyACM0', 9600)
            t.close()
            port = ('/dev/ttyACM0')
            loop = False
        except:
            try:
                t = serial.Serial('/dev/ttyACM1',9600)
                t.close()
                port = ('/dev/ttyACM1')
                loop = False
            except:
                loop = True
                sleep(5)
    ser = serial.Serial(port, 9600)
    ser.baudrate = 9600
    ser.bytesize=serial.SEVENBITS
    ser.parity=serial.PARITY_NONE
    ser.stopbits=serial.STOPBITS_ONE
    ser.xonxoff=1
    ser.rtscts=0
    return ser

def main():
    print "Booting bms-send-pi..."
    sleep(1)
    check_network()
    sensorarr = []
    start = time.time()
    ser = serinit() 
    while True:
        #test = time.time()
        #get sensor values
        try:
            ser.reset_input_buffer()
            sensorarr = readSerial(ser)
        except:
            ser = serinit()
        if(checkSmoke(sensorarr)):
            pushSensor(sensorarr)
            eMode()
        if ((time.time() - start) > 5):
            pushSensor(sensorarr)
            start = time.time()
        del sensorarr[:]
        sleep(.01)
main()
