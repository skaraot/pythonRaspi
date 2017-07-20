from flask import Flask
import RPi.GPIO as GPIO
import time


app = Flask(__name__)

@app.route('/')
def home():
        return "GPIO Test With Flask"

@app.route('/ledyak/<port>/<durum>')
def ledyak ( port, durum):
        GPIO.setmode(GPIO.BOARD)
        GPIO.setwarnings(False)
        GPIO.setup(7, GPIO.OUT)
        GPIO.setup(35,GPIO.OUT)
        GPIO.setup(37,GPIO.OUT)
        GPIO.output(37,GPIO.LOW)
		# int() fonksiyonu ile url den gelen degeri integer a cevirdik
        if (int(durum)==1):
                GPIO.output(int(port), GPIO.HIGH)
                return  "%s port aktif" % port
        else:
                GPIO.output(int(port), GPIO.LOW)
                GPIO.cleanup()
                return "%s port pasif" % port



if __name__ == '__main__':
        app.run(debug=True, host='0.0.0.0')

