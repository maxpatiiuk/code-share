//Original source code : http://enrique.latorres.org/2017/10/17/testing-lolin-nodemcu-v3-esp8266/
//Download LoLin NodeMCU V3 ESP8266 Board for Arduino IDE (json) : http://arduino.esp8266.com/stable/package_esp8266com_index.json
#include <ESP8266WiFi.h>
#include <EasyButton.h>
#include <ESP8266HTTPClient.h>

// Uncomment this if you want to ping a HTTPs URL
//#include <WiFiClientSecure.h>

const char *ssid = "<your ssid>";
const char *password = "<your wifi password>";
int ledPin = 2;  // Arduino standard is GPIO13 but lolin nodeMCU is 2 http://www.esp8266.com/viewtopic.php?f=26&t=13410#p61332

// Arduino pin where the button is connected to.
#define BUTTON_PIN 0

// Instance of the button.
EasyButton button(BUTTON_PIN);

void onPressed()
{

  // Uncomment this if you want to ping a HTTPs URL
  //BearSSL::WiFiClientSecure client;
  WiFiClient client;
  
  // Uncomment this if you want to ping a HTTPs URL
  //client.setInsecure();
  
  HTTPClient http;  //Declare an object of class HTTPClient

  Serial.print("Request status:");
  Serial.println(http.begin(client,"http://<your_url_here>"));
  int httpCode = http.GET();
  Serial.print("Request code: ");
  Serial.println(httpCode);
  if (httpCode > 0)
  {
    //Check the returning code

    String payload = http.getString();  //Get the request response payload
    Serial.println(payload);  //Print the response payload
    digitalWrite(LED_BUILTIN, LOW);
    delay(200);
    digitalWrite(LED_BUILTIN, HIGH);
    delay(200);
    digitalWrite(LED_BUILTIN, LOW);
    delay(200);
    digitalWrite(LED_BUILTIN, HIGH);

  }
  else
    Serial.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());

  http.end(); //Close connection
}

void setup()
{
  Serial.begin(115200);
  delay(10);
  pinMode(ledPin, OUTPUT);
  digitalWrite(ledPin, HIGH);
  // Connect to WiFi network
  Serial.println();
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);

  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED)
  {
    delay(500);
    Serial.println(".");
    WiFi.printDiag(Serial);
  }

  Serial.println("");
  Serial.println("WiFi connected");
  digitalWrite(LED_BUILTIN, LOW);
  delay(200);
  digitalWrite(LED_BUILTIN, HIGH);
  button.begin();
  // Add the callback function to be called when the button is pressed.
  button.onPressed(onPressed);

}

void loop()
{
  button.read();
}
