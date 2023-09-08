#include <ESP8266WiFi.h>
#include <WiFiClient.h>
#include <ESP8266WebServer.h>
#include <ESP8266mDNS.h>
#include <SPI.h>
#include <Wire.h>
#include <OneWire.h>
#include <DallasTemperature.h>


const char *ssid = "osanda";     // replace with your wifi ssid and wpa2 key
const char *password = "Osama123";
char server[] = "172.20.10.5";

#define LED_BUILTIN 16
#define SENSOR1  D2 // Digital pin for flow sensor 1 (D2)
#define SENSOR2  D3 // Digital pin for flow sensor 2 (D3)
#define TEMP D4 //Digital pin for temp sensor 3(D4)

long currentMillis = 0;
long previousMillis = 0;
int interval = 1000;
boolean ledState = LOW;
float calibrationFactor = 4.5;
volatile byte pulseCount1;
volatile byte pulseCount2;
byte pulse1Sec1 = 0;
byte pulse1Sec2 = 0;
float flowRate1;
float flowRate2;
// unsigned long flowMilliLitres1;
// unsigned long flowMilliLitres2;
// unsigned int totalMilliLitres1;
// unsigned int totalMilliLitres2;
float flowLitres1;
float flowLitres2;
// float totalLitres1;
// float totalLitres2;

OneWire oneWire(TEMP);
DallasTemperature sensors(&oneWire);

float temperature;

void IRAM_ATTR pulseCounter1()
{
  pulseCount1++;
}

void IRAM_ATTR pulseCounter2()
{
  pulseCount2++;
}

WiFiClient client;

void setup()
{
  sensors.begin();
  Serial.begin(115200);
  delay(10);

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
  // server.begin();
  Serial.println("Server started");
  Serial.print(WiFi.localIP());
  delay(1000);
  Serial.println("connecting...");

  pinMode(LED_BUILTIN, OUTPUT);
  pinMode(SENSOR1, INPUT_PULLUP);
  pinMode(SENSOR2, INPUT_PULLUP);

  pulseCount1 = 0;
  pulseCount2 = 0;
  flowRate1 = 0.0;
  flowRate2 = 0.0;
  // flowMilliLitres1 = 0;
  // flowMilliLitres2 = 0;
  // totalMilliLitres1 = 0;
  // totalMilliLitres2 = 0;
  previousMillis = 0;

  attachInterrupt(digitalPinToInterrupt(SENSOR1), pulseCounter1, FALLING);
  attachInterrupt(digitalPinToInterrupt(SENSOR2), pulseCounter2, FALLING);

}

void loop()
{
  currentMillis = millis();
  if (currentMillis - previousMillis > interval)
  {
    pulse1Sec1 = pulseCount1;
    pulse1Sec2 = pulseCount2;
    pulseCount1 = 0;
    pulseCount2 = 0;

    flowRate1 = ((1000.0 / (millis() - previousMillis)) * pulse1Sec1) / calibrationFactor;
    flowRate2 = ((1000.0 / (millis() - previousMillis)) * pulse1Sec2) / calibrationFactor;

    temperature = sensors.getTempCByIndex(0);

    previousMillis = millis();

    // flowMilliLitres1 = (flowRate1 / 60) * 1000;
    // flowMilliLitres2 = (flowRate2 / 60) * 1000;
    // flowLitres1 = (flowRate1 / 60);
    // flowLitres2 = (flowRate2 / 60);

    // totalMilliLitres1 += flowMilliLitres1;
    // totalMilliLitres2 += flowMilliLitres2;
    // totalLitres1 += flowLitres1;
    // totalLitres2 += flowLitres2;
    delay(5000);

    
  }
  Sending_To_phpmyadmindatabase();
}

void Sending_To_phpmyadmindatabase()   //CONNECTING WITH MYSQL
{
  if (client.connect(server, 80)) 
  {
    Serial.println("connected");
    // Make a HTTP request:
    Serial.print("GET /rp/arduno_to_db/flowrate.php?flow_in=");
    client.print("GET /rp/arduno_to_db/flowrate.php?flow_in=");   //YOUR URL
    client.print(flowRate1);
    Serial.print("Flow rate 1: ");
    Serial.print(float(flowRate1));
    Serial.print("L/min");
    Serial.print("\t");

    //
    client.print("&flow_out=");
    Serial.println("&flow_out=");
    client.print(flowRate2);
    Serial.print("Flow rate 2: ");
    Serial.print(float(flowRate2));
    Serial.print("L/min");
    Serial.print("\t");;

    //
    client.print("&temperature=");
    Serial.println("&temperature=");
    client.print(temperature);
    Serial.print(temperature);
    Serial.print(" °C ");
    //
    //
    client.print(" ");      //SPACE BEFORE HTTP/1.1
    client.print("HTTP/1.1");
    client.println();
    client.println("Host: 172.20.10.5");
    client.println("Connection: close");
    client.println();
   }else {
    // if you didn't get a connection to the server:
    Serial.println("connection failed");
   }
}
 