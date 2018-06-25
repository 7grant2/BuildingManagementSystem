
/******************************************************************
 * OCCUPANCY SENSOR
 *  ATTINY85
 *  - Reads inputs from occupancy and outputs if someone enters
 *    or leaves.
 *  INPUT
 *  --- 2* Laser/PhotoResistor/Transistor
 *  OUTPUT
 *  --- 2* Walk In / Walk Out
 * *****************************************************************
 */

//////////////////////////////////////////////////////
//Input
static uint8_t occ_outer = 2, occ_inner = 3;

//Output
static uint8_t occ_leave = 4, occ_enter = 5, occ_led = 7;

//Read Variables
uint8_t occ_val_o = 0;
uint8_t occ_val_i = 0;
uint8_t flag = 0, flag_o = 0, flag_i = 0;

//Room Count
uint16_t rc = 0;

/*
//Emode battery reader
uint8_t emode_input = 0;

*/
//////////////////////////////////////////////////////


void setup() {
  // put your setup code here, to run once:
  pinMode(occ_outer, INPUT); 
  pinMode(occ_inner, INPUT); 
  pinMode(occ_leave, OUTPUT); 
  pinMode(occ_enter, OUTPUT); 
  pinMode(occ_led, OUTPUT);
  Serial.begin(9600);
}

void loop() {
  roomCounter();
  occupancyStatus();
}

//Works with digital input (Laser, BJT, Photodiode)
void roomCounter(){
  occ_val_o = digitalRead(occ_outer);
  occ_val_i = digitalRead(occ_inner);

  //delay(500);
  //Determine movement in or out of door
  if(flag == 0) {
    if(occ_val_o == 0 && occ_val_i == 0){
      flag_o = flag_i = 0;
    } 
    else if(occ_val_o == 1 && occ_val_i == 0){
      flag_o = 1;
    }
    else if (occ_val_o == 0 && occ_val_i == 1){
      flag_i = 1;
    }
    else {
      if(flag_i == 0 && flag_o == 0) flag = 0;
      else flag = 1;
    }
  }

  //Determine if object has completely passed through sensors
  if (flag == 1) {
     //Serial.println("between door");
    //person leaving the room
    if (occ_val_i == 0) {
        if(flag_o == 0 && flag_i == 1) {
          
          digitalWrite(occ_leave, HIGH);
          delay(100);
          digitalWrite(occ_leave, LOW);
          if(rc == 0) rc = 0;
          else rc--;
          flag_i = 0;          
        }
        flag = 0;
    }
    
    //person entering room
    else if (occ_val_o == 0) {
        if(flag_o == 1 && flag_i == 0){
           digitalWrite(occ_enter, HIGH);
           delay(100);
           digitalWrite(occ_enter, LOW);
           rc++;
           flag_o = 0;           
        }
        flag = 0;
    }
  }  
}


void occupancyStatus() {
   Serial.println(rc);
   if (rc > 0) {
    //People are in the room
    digitalWrite(occ_led, HIGH);
  } else {
    //No one is in the room
    digitalWrite(occ_led, LOW);
  }   
}
