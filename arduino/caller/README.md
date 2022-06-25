# arduino_caller
Programs ESP8266 to send GET requests to a specified URL on button press.

The code provided in the `esp8266.ino` file is designed to be executed on the LoLin NodeMCU V3 ESP8266 Board. It can be made to work on other boards with some modifications.

# How to use it
Following the instructions below requires basic knowledge of how to flash custom code on an arduino board. Please refer to the official documentation for the Arduiono project.
## Instructions:
1. Import the following [.json](http://arduino.esp8266.com/stable/package_esp8266com_index.json) file into Arduino.
2. Modify the `esp8266.ino`:
   - Replace `<your_ssid>` with the SSID of the WIFI network the board is supposed to connect to. Note, only 2.4gHz networks are supported by the board.
   - Replace `<your_password>` with the password for the network you specified in the previous step.
   - Replace `<your_url_here>` with the URL that would receive a GET request whenever the button was pressed. Both `http` and `https` is supported, but SSL certificate verification is dissabled.
3. Flash the code and wait for the process to be completed (You will see `Hard resetting via RTS pin...` in the console when everything is ready)

# Resources Used
Code by [Enrique Latorres](http://enrique.latorres.org/2017/10/17/testing-lolin-nodemcu-v3-esp8266/) was used as a base for the program.
