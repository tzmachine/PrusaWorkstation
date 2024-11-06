<?php
$pin = (int)$_GET['pin'];        // Pin-Nummer, z. B. 17, 18, 22, 23
$action = $_GET['action'];        // Erwartet "toggle"

echo "$pin";
echo "$action";

// Zulässige Pins festlegen
$allowed_pins = [6, 12, 5, 0];
// Validierung der Eingaben
if (in_array($pin, $allowed_pins) && $action === 'toggle') {
    $command = "sudo -u www-data python3 /var/www/html/PrusaWorkstation/assets/python/gpio_control.py $pin";
    shell_exec($command);
    echo "$command";
} else {
    echo "Ungültiger Pin oder Aktion.";
}
?>
