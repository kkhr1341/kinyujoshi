const int keyPin = 12;
const int ledPin = 9;


void setup() {
  // put your setup code here, to run once:
  //pinMode(keyPin, INPUT);
  pinMode(ledPin, OUTPUT);
}

void loop() {
  // put your main code here, to run repeatedly:

  for(int a = 0; a <= 255; a++) {
    analogWrite(ledPin, a);
    delay(2);
  }

  for(int a = 255; a >= 0; a--) {
    analogWrite(ledPin, a);
    delay(2);
  }

  delay(500);
  /*
  if (digitalRead(keyPin) == HIGH) {
    digitalWrite(ledPin, HIGH);
  }
  else {
    digitalWrite(ledPin, LOW);
  }
  */
}
