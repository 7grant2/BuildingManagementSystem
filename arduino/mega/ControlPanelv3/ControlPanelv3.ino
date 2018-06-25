//EGN 4952C - Engineering Design II
//Group 15
//BMS - Control Panel
//Grant

/*
 ********************************************************
 * ARDUIONO MEGA
 * :: ROOM SENSOR ROUTER ::
 *  - Gathers information from ATTINY85 and the
 *    wireless motion sensor and sends pin
 *    output to the nano and serial output
 *    to the raspberry pi
 *  - The MEGA only acts as a router and
 *    does not perform physical
 *    interactions
 *  - 4 input sensors to a room
 *  - 3 total rooms
 *  - 6 output sensors
 *  
 *   SENSOR TYPES
 *   - O = OCCUPANCY
 *   - S = SMOKE
 *   - R = RFID
 *   - M = MOTINO
 *   - T = METAL 
 ********************************************************
 */

#define wait 1
#define time 100

// ???
uint8_t freq = 0;

// Number of Rooms
uint8_t rooms = 3;  

/*
 * INPUT PIN VARIABLES
 *  - Occupancy_InputOutputPin_walkIn/Out
 */
// Input pins for occupancy walk in
static uint8_t occ_i_win1 = 22;
static uint8_t occ_i_win2 = 28;
static uint8_t occ_i_win3 = 34;

// Input pins for occupancy walk out
static uint8_t occ_i_wout1 = 23;
static uint8_t occ_i_wout2 = 29;
static uint8_t occ_i_wout3 = 35;

// Input pins for smoke detection
static uint8_t smoke_i1 = 24;
static uint8_t smoke_i2 = 30;
static uint8_t smoke_i3 = 36;

// Input pins for rfid
static uint8_t rfid_i1 = 25;
static uint8_t rfid_i2 = 31;
static uint8_t rfid_i3 = 37;

static uint8_t mot_i1 = 26;
static uint8_t mot_i2 = 32;
static uint8_t mot_i3 = 38// e-mode button input
static uint8_t relay_button = 42;

/*
 * Motion Sensor pins should be updated in
 * VirtualWire.cpp
// The digital IO pin number of the receiver data
static uint8_t vw_rx_pin = 11;

// The digital IO pin number of the transmitter data
static uint8_t vw_tx_pin = 12;
*/

/*
 * OUTPUT PIN VARIABLES
 */
 
 
// output pins for occupancy walk in
static uint8_t occ_o_win1 = A0;
static uint8_t occ_o_win2 = 60;
static uint8_t occ_o_win3 = 66;

// output pins for occupancy walk in
static uint8_t occ_o_wout1 = A1;
static uint8_t occ_o_wout2 = 61;
static uint8_t occ_o_wout3 = 67;

// output pins for if someone is in the room
static uint8_t occ_stat1 = A2;
static uint8_t occ_stat2 = 62;
static uint8_t occ_stat3 = 68;

// output pins for motion
static uint8_t mot_o1 = A3;
static uint8_t mot_o2 = 63;
static uint8_t mot_o3 = 69;

// output pins for smoke
static uint8_t smoke_o1 = A4;
static uint8_t smoke_o2 = 64;
static uint8_t smoke_o3 = 52;

// output pin for rfid
static uint8_t rfid_o1 = A5;
static uint8_t rfid_o2 = 65;
static uint8_t rfid_o3 = 53;

// output for smoke.
static uint8_t relay_emode = 48;
static uint8_t relay_main = 49;


/*
 * SERIAL VARIABLES
 */
//occupancy count for a given room
uint8_t os1 = 0;
uint8_t os2 = 0;
uint8_t os3 = 0;

//smoke detection for a given room
uint8_t sm1 = 0;
uint8_t sm2 = 0;
uint8_t sm3 = 0;

//motion detection for a given room
uint8_t mot1 = 0;
uint8_t mot2 = 0;
uint8_t mot3 = 0;

//rfid for a given room
uint8_t rfid1 = 0;
uint8_t rfid2 = 0;
uint8_t rfid3 = 0;

//Test
uint8_t occ_flag1 = 0;
uint8_t occ_flag2 = 0;
uint8_t occ_flag3 = 0;

//For e-mode 
uint8_t emode_flag = 0;
uint64_t emode_timer = 0;

//sensorID Names
static uint8_t occ_id1 = 101;
static uint8_t occ_id2 = 104;
static uint8_t occ_id3 = 107;

static uint8_t mot_id1 = 102;
static uint8_t mot_id2 = 105;
static uint8_t mot_id3 = 108;

static uint8_t sm_id1 = 103;
static uint8_t sm_id2 = 106;
static uint8_t sm_id3 = 109;

void setup(){
    pinMode(relay_emode, OUTPUT);
    pinMode(relay_main, OUTPUT);
    digitalWrite(relay_emode, LOW);
    digitalWrite(relay_main, HIGH);

    //input pins for occupancy walk in
    pinMode(occ_i_win1, INPUT);
    pinMode(occ_i_win2, INPUT);
    pinMode(occ_i_win3, INPUT);
    
    //input pins for occupancy walk out
    pinMode(occ_i_wout1, INPUT);
    pinMode(occ_i_wout2, INPUT);
    pinMode(occ_i_wout3, INPUT);
    
    //input pins for smoke detection
    pinMode(smoke_i1, INPUT);
    pinMode(smoke_i2, INPUT);
    pinMode(smoke_i3, INPUT);

    //input pins for smoke detection
    pinMode(rfid_i1, INPUT);
    pinMode(rfid_i2, INPUT);
    pinMode(rfid_i3, INPUT);
    
    //output pins for occupancy walk out
    pinMode(occ_o_win1, OUTPUT);
    pinMode(occ_o_win2, OUTPUT);
    pinMode(occ_o_win3, OUTPUT);
    
    //output pins for occupancy walk in
    pinMode(occ_o_wout1, OUTPUT);
    pinMode(occ_o_wout2, OUTPUT);
    pinMode(occ_o_wout3, OUTPUT);
    
    //output pins for if someone is in the room
    pinMode(occ_stat1, OUTPUT);
    pinMode(occ_stat2, OUTPUT);
    pinMode(occ_stat3, OUTPUT);    
    
    //output pin for motion
    pinMode(mot_o1, OUTPUT);
    pinMode(mot_o2, OUTPUT);
    pinMode(mot_o3, OUTPUT);    
    
    //output pin for smoke
    pinMode(smoke_o1, OUTPUT);
    pinMode(smoke_o2, OUTPUT);
    pinMode(smoke_o3, OUTPUT); 

   //output pin for rfid
    pinMode(rfid_o1, OUTPUT);
    pinMode(rfid_o2, OUTPUT);
    pinMode(rfid_o3, OUTPUT);     
    
    Serial.begin(9600);
    
}

void loop() {
    
    motionSensor(mot_i1, mot_o1, &mot1);
    motionSensor(mot_i2, mot_o2, &mot2);
    motionSensor(mot_i3, mot_o3, &mot3);

    roomCounter(occ_i_win1, occ_i_wout1, occ_o_win1, occ_o_wout1, &os1, &occ_flag1);
    //roomCounter(occ_i_win2, occ_i_wout2, occ_o_win2, occ_o_wout2, &os2, &occ_flag2);
    //roomCounter(occ_i_win3, occ_i_wout3, occ_o_win3, occ_o_wout3, &os3, &occ_flag3);        

    roomOccupancy(occ_stat1, os1);
    roomOccupancy(occ_stat2, os2);
    roomOccupancy(occ_stat3, os3);

    smokeDetection(smoke_i1, smoke_o1, &sm1);
    smokeDetection(smoke_i2, smoke_o2, &sm2);
    smokeDetection(smoke_i3, smoke_o3, &sm3);

    serialOut(occ_id1, os1, 'O');
    serialOut(occ_id2, os2, 'O');
    serialOut(occ_id3, os3, 'O');
    
    serialOut(mot_id1, mot1, 'M');
    serialOut(mot_id2, mot2, 'M');
    serialOut(mot_id3, mot3, 'M');
   
    serialOut(sm_id1, sm1, 'S');
    serialOut(sm_id2, sm2, 'S');
    serialOut(sm_id3, sm3, 'S');   
      
    Serial.println("end");
    
    //delay(1000);
    eMode(sm1, sm2, sm3, &emode_flag, &emode_timer);
    
  }


//Enables and Disables Relay
void eMode(const uint8_t sm1,const uint8_t sm2,const uint8_t sm3, uint8_t *e_flag, uint64_t *timer) {

  if(*e_flag == 0) {
    //If smoke sensed, enable flag
    if (sm1 == 1 || sm2 == 1 || sm3 == 1){
       *e_flag = 1;
       *timer = millis();
        return;
    } 
    else if(digitalRead(relay_button) == 1) {
       //Serial.println("E-MODE DISABLED");  
       delay(10);
       *e_flag = 0;
        digitalWrite(relay_main, HIGH);
        digitalWrite(relay_emode, LOW);       
       return;      
    }  
  }
  
  //If flag enabled for smoke detection
  else if (*e_flag == 1) {
    //If time exceeds threshold, active e-mode
    if (millis() - *timer > 5000) {  
       //Serial.println("E-MODE ENABLED");  
       delay(10);      
      *e_flag = 0;
      digitalWrite(relay_emode, HIGH);
      digitalWrite(relay_main, LOW);
      return;
    }    
    //If smoke is disabled before threshold
    else if(sm1 == 0 && sm2 == 0 && sm3 == 0) {
       *e_flag = 0;
       return;
    }
  }
}


void longprint(const uint8_t pin, String str) {
  const uint8_t a = analogRead(pin);
  const uint8_t d = digitalRead(pin);
  Serial.print(str);
  Serial.print(" : ");
  Serial.print(pin);
  Serial.print(" : ");
  Serial.print(a);
  Serial.print(" : ");  
  Serial.println(d);  
}


void smokeDetection(const uint8_t smoke_i, const uint8_t smoke_o, uint8_t *sm) {
  //longprint(smoke_i, "smoke");
  uint8_t val = digitalRead(smoke_i);
  if (val == 1) {
    digitalWrite(smoke_o, HIGH);
    *sm = 1;
  }
  else {
    digitalWrite(smoke_o, LOW);
    *sm = 0;
  }
  //Serial.println(smoke_input);
}

//FOR DIRECT PIN IN, NOT MEANT FOR WIRLESS TRANSMITTER
void motionSensor(const uint8_t motion_i, const uint8_t motion_o, uint8_t *mot) {
  static uint8_t motion_val = digitalRead(motion_i); // read motion sensor  
  if (motion_val == HIGH) { // check if the input is HIGH
    digitalWrite(motion_o, HIGH); // turn LED ON
    *mot = 1;
  } else if (motion_val == LOW) { // input is LOW
    digitalWrite(motion_o, LOW); // turn LED OFF
    *mot = 0;
  }
}

/*
//reads and writes motion detection
void motionDetector(){
    //Serial.println("InMotion");
    if (vw_get_message(buf, &buflen)) {
      for (uint8_t i = 0; i < buflen; i++) {
        switch (buf[i]) {
            case 'A':
              Serial.println('A');
              digitalWrite(mot_o1, HIGH);   
              mot1=1;
              break;
            case 'a':
              Serial.println('a');            
              digitalWrite(mot_o1, LOW);
              mot1=0;
              break;
            case 'B':
              digitalWrite(mot_o2, HIGH);
              mot2=1;
              break;
            case 'b':
              digitalWrite(mot_o2, LOW);
              mot2=0;
              break;
            case 'C':
              break;
              digitalWrite(mot_o3, HIGH);              
              mot3=1;
            case 'c':
              digitalWrite(mot_o3, LOW);
              mot3=0;
              break;       
        }
     }    
  }
}
*/

//Reads input walk in/out pins of a given room
//Outputs results of walk in/out pins
//Sote room count in variable
void roomCounter(const uint8_t pin_i_win,
                 const uint8_t pin_i_wout, 
                 const uint8_t pin_o_win,
                 const uint8_t pin_o_wout, 
                 uint8_t *occupancy, 
                 uint8_t *occ_flag) {
  // Read Values from Pins
  uint8_t r_in = digitalRead(pin_i_win);
  uint8_t r_out = digitalRead(pin_i_wout);  

  /*
  Serial.print("in/out/occ/flag: ");
  Serial.print(r_in);
  Serial.print(r_out);
  Serial.print(*occupancy);
  Serial.println(*occ_flag);

*/
 
  // Leaving the room
  if (r_out == 1 && r_in == 0  && *occ_flag == 0){
    *occ_flag = 1;
    if(*occupancy == 0) {
      *occupancy = 0;
    }
    else {
      *occupancy = *occupancy - 1;
    }
    digitalWrite(pin_o_wout, HIGH);
    delay(100);
    digitalWrite(pin_o_wout, LOW);
  }
  // Entering the room
  else if (r_in == 1 && r_out == 0 && *occ_flag == 0){
    *occ_flag = 1;
    *occupancy+= 1;
    digitalWrite(pin_o_win, HIGH);
    delay(100);
    digitalWrite(pin_o_win, LOW);
  }

  // Ensure values are not doubled
  if(*occ_flag == 1) {
    if(r_in == 0 && r_out == 0){
      *occ_flag = 0;
    } 
  }


}

void roomOccupancy(const uint8_t pinout, const uint8_t *occupancy){  
  if (*occupancy > 0) {
    digitalWrite(pinout, HIGH); //Room is occupied
  } else {
    digitalWrite(pinout, LOW); //Room is empty
  }
}

// Write contets of information to output
// Write contets of information to output
void serialOut(const uint8_t sensor_id, const uint8_t sensor_val, const char sensor_type) {
  Serial.println((int)(sensor_id));
  delay(1);
  Serial.println((int)(sensor_val));
  delay(1);
  Serial.println((sensor_type));
  delay(1);  
}


