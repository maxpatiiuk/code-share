int analogPin = 3;
int ledPin = 5;
int Pin1 = 10;
int quest;
void setup()
{
  pinMode(ledPin, OUTPUT);
  pinMode(Pin1, INPUT);
  Serial.begin(9600);
}

void loop()
{
  quest = analogRead(1);
  Serial.println(quest);
  digitalWrite(ledPin, HIGH);
  delay(quest);
  digitalWrite(ledPin, LOW);
  delay(quest);
}