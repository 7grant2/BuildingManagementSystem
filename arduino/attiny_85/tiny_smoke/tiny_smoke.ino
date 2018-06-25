/*
 *******************************************************************
 * SMOKE SENSOR 
 *  :: ATTINY85 ::
 * *****************************************************************
 */
static uint8_t smoke_led = 0;
static uint8_t smoke_alarm = 1;
static uint8_t smoke_output = 2;
static uint8_t smoke_input = A2;
static uint8_t smoke_button = A3;

static uint16_t smoke_thresh = 8;
uint32_t smoke_val = 0;
uint8_t smoke_button_val = 0;
uint8_t i = 0;

void setup() {
  pinMode(smoke_led, OUTPUT);
  pinMode(smoke_output, OUTPUT);
  pinMode(smoke_button, INPUT);
}

void readValues(){
 static uint8_t lc = 5;
 i = smoke_val = 0;
 for(i = 0; i<lc; i++) {
    smoke_val += analogRead(smoke_input);
    delay(1);
 }
 smoke_val = smoke_val/lc;
}

void loop() {
  readValues();
  smokeSensor();
}

void smokeSensor() {
  // Checks if it has reached the threshold value
  smoke_button_val = digitalRead(smoke_button);
  //Serial.println(smoke_button_val);
  
  if (smoke_button_val == HIGH) {
    //Serial.println("Button");
    digitalWrite(smoke_led, LOW);
    digitalWrite(smoke_output, LOW);    
    noTone(smoke_alarm);
  }
  if (smoke_val > smoke_thresh) {
    //Serial.println("Smoke!");
    digitalWrite(smoke_led, HIGH);
    digitalWrite(smoke_output, HIGH);
    tone(smoke_alarm, 2000);
  }
  delay(100);
}
