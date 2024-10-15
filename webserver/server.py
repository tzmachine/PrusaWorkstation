from flask import Flask, render_template
import RPi.GPIO as GPIO

server = Flask(__name__)

GPIO.setmode(GPIO.BOARD)
GPIO.setup(13, GPIO.OUT)

@server.route('/')
def index():
 return render_template('index.html')

@server.route('/print')
def print():
 return 'Rasperry Pie!'

@server.route('/toggle_pin')
def toggle_pin():
 state = GPIO.input(13)
 GPIO.output(13, not state)
 return 'GPIO Pin 27 set to HIGH'
if __name__ == '__main__':

 try:
    # Deine Hauptlogik hier
     server.run(debug=False, host='0.0.0.0')
 except KeyboardInterrupt:
     pass
 finally:
     GPIO.cleanup()  # GPIO aufräumen, auch wenn das Skript abbricht
