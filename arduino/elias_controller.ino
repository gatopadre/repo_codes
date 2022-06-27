#include <DHT.h>


/* contants */
#define baudrate              9600 // resfresh rate of arduino

/* pin sets */
#define dht_pin               5           // pin for temperature and humidity
#define led_builtin_pin       LED_BUILTIN // led builtin pin
#define rele_pin              4           // pin for relay
#define time_delay            2000        // time in miliseconds
#define min_temp              23          // minimum temperature to turn on the relay
#define max_temp              26          // maximum temperature to turn off the relay


/* OBJECTS */
#define dhttype               DHT11 // type module for temperature and humidity
DHT dht(dht_pin, dhttype);          // instance for dht11 module

float temperature = -1; // temperature var
float humidity = -1;    // humidity var

/* configurations */
void setup() {
    pinMode(led_builtin_pin, OUTPUT); 
    pinMode(dht_pin, INPUT);
    pinMode(rele_pin, OUTPUT);
    dht.begin();    //sensor start
}

/* work */
void loop() {  
  temperature = dht.readTemperature();
  if (temperature <= min_temp && digitalRead(rele_pin) == LOW) {
    digitalWrite(rele_pin, HIGH);
  }
  if (temperature > max_temp && digitalRead(rele_pin) == HIGH) {
    digitalWrite(rele_pin, LOW);
  } 
  digitalWrite(led_builtin_pin, HIGH);
  delay(time_delay/2);
  digitalWrite(led_builtin_pin, LOW);
  delay(time_delay/2);
  temperature = -1;
}