<?php
// Ausführen des Python-Skripts und Speichern der Ausgabe in einer Variablen
$output = shell_exec('python3 /var/www/html/PrusaWorkstation/assets/python/cham_temp.py'); // Ersetze den Pfad mit dem tatsächlichen Pfad zu deinem Skript

// Entfernen von Leerzeichen und Zeilenumbrüchen aus der Ausgabe
$temperature = trim($output);
?>


<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrusaWorkstation</title>
    <link rel="icon" href="{{ url_for('static', filename='favicon.ico') }}" type="image/x-icon">
    <style>
        body {
            font-family: Helvetica;
            background-color: #1C1E21;
            margin: 0;
            text-align: center;
            padding: 20px;
            color: white;
        }

        header {
            background-color: #2A2A2A;
            color: white;
            padding: 10px 0;
            border-radius: 10px;
        }

        section {
            margin: 20px 0;
        }

        h2 {
            text-align: center;
        }

        footer {
            text-align: center;
            padding: 10px 0;
            background-color: #2A2A2A;
            color: white;
            border-radius: 10px;
        }

        .temperature {
            color: #FA6831;
        }

        button {
            background-color: #1C1E21;
            color: white;
            border: 2px solid #FA6831;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 3px;
        }

        button:hover {
            background-color: #212529;
        }
    </style>
</head>

<body>
    <header>
        <h1>Prusa Workstation</h1>
    </header>

    <section>
        <h2>Chamber Temperature</h2>
        <div class="temperature">Current Temperature</div>
        <p>
            <?php echo $temperature; ?>
        </p>
        <input type="range" min="20" max="40" value="30" id="cham_temp"></input>
        <div>
        	<output id="temp_target"></output>
            <button id="setCTemp" onclick="setCTemp()">set</button>
        	<script>
            	var slider = document.getElementById("cham_temp");
            	var output = document.getElementById("temp_target");
            	output.innerHTML = slider.value; // Display the default slider value
            	// Update the current slider value (each time you drag the slider handle)
            	slider.oninput = function() {
                	output.innerHTML = this.value;
            	}
                
               	function setCTemp() {
                	var target_temp = document.getElementById("cham_temp");	//get slider element
                    console.log(target_temp.value);							//print slider value on button press in console
                }

                function fetchTemperature() {
                    $.ajax({
                        url: 'temperature.php', // Die URL, die die Temperatur zurückgibt
                        method: 'GET', // GET-Anfrage
                        success: function(data) {
                        // Aktualisiere die Anzeige der Temperatur
                            $('#temperature').text(data + ' °C');
                        },
                        error: function() {
                        // Fehlerbehandlung
                        $('#temperature').text('Fehler beim Abrufen der Temperatur');
                        }
                    });
                }

                // Alle 5 Sekunden die Temperatur aktualisieren
                $(document).ready(function() {
                    fetchTemperature(); // Ruft die Temperatur direkt beim Laden der Seite ab
                    setInterval(fetchTemperature, 5000); // Alle 5 Sekunden
                });
        	</script>
        </div>
    </section>

    <header>
        <h3>GPIO Control</h3>
    </header>
    <script>
        //button states
        var buttonStates = {
                6: 0, // Button 1
                12: 0, // Button 2
                5: 0, // Button 3
                0: 0  // Button 4
            };

        function togglePin(pin, buttonID) {

            //get button element and switch state based on current value
            var button = document.getElementById(buttonID);
            buttonStates[pin] = buttonStates[pin] === 0 ? 1 : 0;
            updateButtonColor(button, buttonStates[pin]);

            //create GET command based on function input anmd send it to index.php
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "index_.php?pin=" + pin + "&action=toggle", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Optional: hier kannst du die Serverantwort verwenden, um zu bestätigen, dass die Aktion erfolgreich war
                    console.log(xhr.responseText);
                }
            };
            xhr.send();
        }
    </script>
    <section>
        <button id="btn1" onclick="togglePin(6, 'btn1')">GPIO 1</button>
        <button id="btn2" onclick="togglePin(12, 'btn2')">GPIO 2</button>
        <button id="btn3" onclick="togglePin(5, 'btn3')">GPIO 3</button>
        <button id="btn4" onclick="togglePin(0, 'btn4')">GPIO 4</button>

        <script>            
            // function to switch color based on current state
            function updateButtonColor(button, state) {
                if (state === 1) {
                    button.style.backgroundColor = "#FA6831";
                } else {
                    button.style.backgroundColor = "#1C1E21";
                }
            }

            // Beim Laden der Seite die GPIO-Zustände vom Backend laden
            window.onload = function () {
                fetch('/get_gpio_states')
                    .then(response => response.json())
                    .then(data => {
                        // Zustände der GPIOs an die ButtonStates anpassen
                        buttonStates[6] = data.gpio6;
                        buttonStates[12] = data.gpio12;
                        buttonStates[5] = data.gpio5;
                        buttonStates[0] = data.gpio0;

                        // Farben der Buttons aktualisieren
                        updateButtonColor(document.getElementById('btn1'), buttonStates[6]);
                        updateButtonColor(document.getElementById('btn2'), buttonStates[12]);
                        updateButtonColor(document.getElementById('btn3'), buttonStates[5]);
                        updateButtonColor(document.getElementById('btn4'), buttonStates[0]);
                    })
                    .catch(error => {
                        console.error('Fehler beim Laden der GPIO-Zustände:', error);
                    });
            }
        </script>


    </section>

    <footer>
        <p>&copy; 2024 Deine Webseite</p>
    </footer>
</body>

</html>
