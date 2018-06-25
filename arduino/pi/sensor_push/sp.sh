#!/bin/sh
# sp.sh

cd /
cd /home/pi/Desktop/sensor_push
(python /home/pi/Desktop/sensor_push/bms-send-pi.py > /home/pi/Desktop/sensor_push/logs/test) &
cd /
