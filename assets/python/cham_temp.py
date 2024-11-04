import os
import time

# Ersetze die Adresse durch die deines Sensors
sensor_address = "28-3c01b5569c64"

def read_temp_raw():
    sensor_file = f"/sys/bus/w1/devices/{sensor_address}/w1_slave"
    try:
        with open(sensor_file, "r") as file:
            lines = file.readlines()
        return lines
    except FileNotFoundError:
        print(f"Sensor not found at {sensor_file}")
        return None

def read_temp():
    lines = read_temp_raw()
    while lines and lines[0].strip()[-3:] != "YES":
        time.sleep(0.2)
        lines = read_temp_raw()

    if lines:
        equals_pos = lines[1].find("t=")
        if equals_pos != -1:
            temp_string = lines[1][equals_pos+2:]
            temperature_celsius = float(temp_string) / 1000.0
            return temperature_celsius
    return None

if __name__ == "__main__":
    temperature = read_temp()
    if temperature is not None:
        print(f"{temperature:.2f} °C")
    else:
        print("Failed to read temperature.")