import sys
import RPi.GPIO as GPIO

# GPIO-Pin-Nummer aus den Argumenten lesen
pin = int(sys.argv[1])

# GPIO-Modus setzen
GPIO.setmode(GPIO.BCM)  # BCM-Nummerierung verwenden

# Den Pin konfigurieren
GPIO.setup(pin, GPIO.OUT)

GPIO.output(pin, not GPIO.input(pin))

# GPIO-Bibliothek zurücksetzen
#GPIO.cleanup()
