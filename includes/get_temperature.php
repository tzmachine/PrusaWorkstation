<?php
// Ausführen des Python-Skripts und Speichern der Ausgabe in einer Variablen
$output = shell_exec("python3 /var/www/html/PrusaWorkstation/assets/python/cham_temp.py"); // Ersetze den Pfad mit dem tatsächlichen Pfad zu deinem Skript

// Entfernen von Leerzeichen und Zeilenumbrüchen
$temperature = trim($output);
echo $temperature; // Gibt nur die Temperatur aus
?>