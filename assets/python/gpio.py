import time
import RPi.GPIO as GPIO
from read_temp import read_temp
from pwm.py import calcDutyCycle

#set temp range
g_temp = 36
max_temp = 42

GPIO.setmode(GPIO.BCM)
GPIO.setup(14, GPIO.OUT)


def setFanSpeed(dc):
	p.ChangeDutyCycle(dc)	

p = GPIO.PWM(14, 25000)  # channel=14 frequency=25000Hz
p.start(0)
GPIO.cleanup()
