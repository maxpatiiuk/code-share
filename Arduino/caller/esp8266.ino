#include <ESP8266WiFi.h>
#include <EasyButton.h>
#include <ESP8266HTTPClient.h>

const char *ssid = "<your_ssid>";
const char *password = "<your_password>";
int ledPin = 2;  // Arduino standard is GPIO13 but lolin nodeMCU is 2 http://www.esp8266.com/viewtopic.php?f=26&t=13410#p61332

// Arduino pin where the button is connected to.
#define BUTTON_PIN 0

// Instance of the button.
EasyButton button(BUTTON_PIN);
WiFiServer server(80);

void onPressed()
{

  BearSSL::WiFiClientSecure client;
  client.setInsecure();
  HTTPClient http;  //Declare an object of class HTTPClient

  Serial.print("Request status:");
  Serial.println(http.begin(client,"https://<your_url_here>"));
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

  http.end(); //Close connection
}

void setup()
{
  WiFi.softAPdisconnect (true);
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
    Serial.print(".");
  }

  Serial.println("");
  Serial.println("WiFi connected");
  button.begin();
  // Add the callback function to be called when the button is pressed.
  button.onPressed(onPressed);

}

void loop()
{
  button.read();
}
