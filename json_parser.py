#!/usr/bin/env python

import json
import urllib2
import serial
import time
import struct
import io
import webbrowser
import datetime
import serial.tools.list_ports
import os

connected_port = '/dev/ttyACM0'
ports = list(serial.tools.list_ports.comports())
for p in ports:
    if 'ttyACM' in p[0]:
        connected_port = p[0]

arduino = serial.Serial(connected_port, 9600, timeout = 1)
dataio = io.TextIOWrapper(io.BufferedRWPair(arduino, arduino))

url = 'http://localhost/dpf/'
# webbrowser.open(url)
done = 0

# dataio.flush()
i=1
while True:
    filename = "/var/www/html/dpf/pillSettings.json"
    # print filename
    if os.path.isfile(filename):
        with open(filename) as settingsFile:
            data = json.load(settingsFile)
        now = datetime.datetime.now()
        today = now.strftime("%A")
        slots = ('morning','day','evening')
        sleepTime = 2
        # print now
        if (data[today]["bool"]):
            for slot in slots:
                now = datetime.datetime.now()
                minute = int(data[today][slot]) % 100
                hour = int(data[today][slot]) / 100;
                tempTime = now.replace(hour = hour, minute = minute,second = 0)
                offsetTime = 0
                alarmTime = 3000
                day = tempTime.weekday()-2
                # print "Dispensing today at:"
                print tempTime
                if (tempTime - now).days >= 0:
                    print "if1"
                    if (tempTime - now).seconds > offsetTime:
                        pillTime = tempTime
                        sleepTime = (tempTime - now).seconds
                        print "Dispensing medicines in:"
                        print sleepTime
                    time.sleep(sleepTime)
                    now = datetime.datetime.now()
                    if (now - tempTime).seconds < alarmTime:
                        stg = arduino.readline()
                        print stg

                        if slot == 'morning':
                            gate = 1
                        elif slot == 'day':
                            gate = 2
                        elif slot == 'evening':
                            gate = 3
                        inputString = str(day) + ' ' + str(gate)
                        print inputString
                        arduino.write(inputString.encode('utf-8'))
                        stg = dataio.readline()
                        print stg
                else:
                    time.sleep(60)
        else:
            now = datetime.datetime.now()
            print "No medicines to be given today! Will check again in 10 minutes"
            time.sleep(600)



t = now
now = datetime.datetime.now()
if(t.day != now.day):
   done = 0

response = urllib2.urlopen('').read()
json_data = json.loads(response)

if(json_data[now.strftime("%A")][bool]):
   if(json_data[now.strftime()]['morning'] == (now.hour) and done != 1):
      stg = dataio.readline()
      print stg
      data.write(("1 1".encode('utf-8')))
      done = 1;
   if(json_data[now.strftime("%A")]['afternon'] == (now.hour) and done != 2):
      stg = dataio.readline()
      print stg
      data.write(("1 2".encode('utf-8')))
      done = 2;
   if(json_data[now.strftime("%A")]['evening'] == (now.hour) and done != 3):
      stg = dataio.readline()
      print stg
      data.write(("1 3".encode('utf-8')))
      done = 3;



time.sleep(1)
stg = data.readline()

# print stg
#Do something with the parsed json data after reading
