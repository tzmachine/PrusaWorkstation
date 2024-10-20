from flask import Flask, render_template, jsonify
import RPi.GPIO as GPIO

server = Flask(__name__)

# Konfiguriere die GPIO-Pins
GPIO.setmode(GPIO.BCM)  # Nutze die BCM-Pin-Nummerierung
gpio_pins = [6, 5, 12, 0]  # Beispiel-Pins für GPIO 1, 2, 3, 4
for pin in gpio_pins:
    GPIO.setup(pin, GPIO.OUT)  # Setze alle Pins als Ausgang

@server.route('/')
def index():
 return render_template('index.html')

@server.route('/toggle_gpio/<int:pin_number>', methods=['POST'])
def toggle_gpio(pin_number):
# Überprüfe, ob die pin_number in der Liste gpio_pins ist
    if pin_number not in gpio_pins:
        return jsonify({'error': 'Ungültige Pin-Nummer'}), 400

    # Wenn die Pin-Nummer gültig ist, finde den Index und toggle den Pin
    pin_index = gpio_pins.index(pin_number)  # Finde den Index der Pin-Nummer
    GPIO.output(pin_number, not GPIO.input(pin_number))  # Toggle den Status des Pins

    return jsonify({'status': 'success', 'pin': pin_number})

if __name__ == '__main__':

 try:
    # Deine Hauptlogik hier
     server.run(debug=False, host='0.0.0.0')
 except KeyboardInterrupt:
     pass
 finally:
     GPIO.cleanup()  # GPIO aufräumen, auch wenn das Skript abbricht
