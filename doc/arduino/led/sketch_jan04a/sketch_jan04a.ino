const int keyPin = 12;
const int ledPin = 9;


void setup() {
  // put your setup code here, to run once:
  pinMode(keyPin, INPUT);
  pinMode(ledPin, OUTPUT);
}

void loop() {
  // put your main code here, to run repeatedly:
  if (digitalRead(keyPin) == HIGH) {
    digitalWrite(ledPin, HIGH);
  }
  else {
    digitalWrite(ledPin, LOW);
  }
}
