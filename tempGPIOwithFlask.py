#!/usr/bin/env python
# coding=utf-8

from flask import Flask
import RPi.GPIO as GPIO
from connectDB import connectDB
from sicaklik import sicaklik
import time


app = Flask(__name__)

@app.route('/')
def home():
        return "GPIO Test With Flask"

@app.route('/acKapa/<port>/<durum>')
def ledyak ( port, durum):
        GPIO.setmode(GPIO.BCM)
        pin = [5,6,13,19]
        for i in pin:
            GPIO.setup(i, GPIO.OUT)
            GPIO.output(i, GPIO.HIGH)


		# int() fonksiyonu ile url den gelen degeri integer a cevirdik
        if (int(durum)==1):
                GPIO.output(int(port), GPIO.HIGH)
                return  "%s port aktif" % port
        else:
                GPIO.output(int(port), GPIO.LOW)
                #GPIO.cleanup()
                return "%s port pasif" % port
@app.route('/sicaklik')
def heatControl():
        odaSicaklik = sicaklik()
        gelenData = odaSicaklik.read_temp()
        gelenData = str(gelenData[0])
        return "%s °C" % gelenData



if __name__ == '__main__':
        app.run(debug=True, host='0.0.0.0')

