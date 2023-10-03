/* This arduino code is sending data to mysql server every 30 seconds.
Created By Embedotronics Technologies*/
#include "ACS712.h"
#include "DHT.h"
#include <ESP8266WiFi.h>
#include <WiFiClient.h>
#include <ESP8266WebServer.h>
#include <ESP8266mDNS.h>
#include <SPI.h>
#include <MFRC522.h>
#include<EEPROM.h>

//#define DHTPIN 0
const int DHTPin = 5;//--> The pin used for the DHT11 sensor is Pin D1=Pin 5

const int ACS712_PIN = 4;   // Digital input pin for ACS712 sensor

#define DHTTYPE DHT11
#define Vib A0

DHT dht(DHTPin, DHTTYPE); //--> Initialize DHT sensor, DHT dht(Pin_used, Type_of_DHT_Sensor);


float humidityData;
float temperatureData;
float vibrationData;
float amperageData;


const char* ssid = "SLT_FIBRE";// 
const char* password = "D0312247124";
//WiFiClient client;
char server[] = "192.168.1.4";   //eg: 192.168.0.222


WiFiClient client;    


void setup()
{
 Serial.begin(115200);
  delay(10);
  dht.begin();
  // Connect to WiFi network
  Serial.println();
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);
 
  WiFi.begin(ssid, password);
 
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("WiFi connected");
 
  // Start the server
//  server.begin();
  Serial.println("Server started");
  Serial.print(WiFi.localIP());
  delay(1000);
  Serial.println("connecting...");
 }
void loop()
{ 
  amperageData = (analogRead(ACS712_PIN));  // Read analog value from ACS712 sensor
  vibrationData=analogRead(Vib);
  humidityData = dht.readHumidity();
  temperatureData = dht.readTemperature(); 
  Sending_To_phpmyadmindatabase(); 
  delay(30000); // interval
 }

 void Sending_To_phpmyadmindatabase()   //CONNECTING WITH MYSQL
 {
   if (client.connect(server, 80)) {
    Serial.println("connected");
    // Make a HTTP request:
    Serial.print("GET /rp/arduno_to_db/dht.php?humidity=");
    client.print("GET /rp/arduno_to_db/dht.php?humidity=");     //YOUR URL
    Serial.println(humidityData);
    client.print(humidityData);
    client.print("&temperature=");
    Serial.println("&temperature=");
    client.print(temperatureData);
    Serial.println(temperatureData);
    //
    client.print("&vibration=");
    Serial.println("&vibration=");
    client.print(vibrationData);
    Serial.println(vibrationData);
    //
    //
    client.print("&amperage=");
    Serial.println("&amperage=");
    client.print(amperageData);
    Serial.println(amperageData);
    //
    client.print(" ");      //SPACE BEFORE HTTP/1.1
    client.print("HTTP/1.1");
    client.println();
    client.println("Host: 192.168.1.4");
    client.println("Connection: close");
    client.println();
  } else {
    // if you didn't get a connection to the server:
    Serial.println("connection failed");
  }
 }
