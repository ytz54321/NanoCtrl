#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <OneWire.h>
#include <DallasTemperature.h>
#include "DHT.h"
#include "ArduinoJson.h"
//////////////////////////////////////
const char* ssid     = "Mcbodi-ser01";
const char* password = "000111000";
const char* host1 = "59.127.204.180";
const char* host2 = "api.thingspeak.com";
const char* host3 = "59.127.204.180";
const char* writeAPIKey = "AJ23JR75N6CSABVVAJ2";
const long interval = 1000 * 1000;
const int httpPort = 80;
//////////////////////////////////////
#define ONE_WIRE_BUS D3
#define DHTPIN D2
#define DHTTYPE DHT22
/////////////////////////////////////
WiFiClient client;
HTTPClient http;
DHT dht(DHTPIN, DHTTYPE);//定義DHT腳位
OneWire oneWire(ONE_WIRE_BUS);//定義DS18B溫感腳位
DallasTemperature sensors(&oneWire);
/////////////////////////////////////
float h_air = 0;//空氣濕度
float t_air = 0;//空氣溫度
float hic_air = 0;//空氣體感溫度
float t_water = 0; //水中溫度
int cont = 0;
int relay1;int relay2;int relay3;//定義relay狀態
int relay4;int relay5;int relay6;//定義relay狀態
////////////////////////////////////

void setup() {
  //定義腳位功能
  pinMode(D0,OUTPUT);
  pinMode(D1,OUTPUT);	
  pinMode(D4,OUTPUT);
  pinMode(D5,OUTPUT);
  pinMode(D6,OUTPUT);
  pinMode(D7,OUTPUT);
  
  Serial.begin(115200);
  sensors.begin();
  dht.begin();
  delay(10);
  //連接WIFI
  Serial.print("connect to:");
  Serial.println(ssid);
  WiFi.begin(ssid, password);
  /*****等待連接*****/
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("Wifi Connected");
  Serial.println("IP:");
  Serial.println(WiFi.localIP());  
  }
  /*******************/
  
////////////////////////////////////

void loop() {
  THR();
  TRNAS();
  RelayOUT();
  delay(5000);
}


void THR(){
  sensors.requestTemperatures();
  //溫溼度
  h_air = dht.readHumidity();//空氣濕度
  t_air = dht.readTemperature();//空氣溫度
  hic_air = dht.computeHeatIndex(t_air, h_air, false);//空氣體感溫度
  t_water = sensors.getTempCByIndex(0); //水中溫度
  Serial.print("Air_Hr:");
  Serial.print(h_air);
  Serial.print("%");
  Serial.print("  Air_Temp:");
  Serial.print(t_air);
  Serial.print("*C");
  Serial.print("  Heat_Temp:");
  Serial.print(hic_air);
  Serial.print("*C");
  Serial.print("  Water_Temp:");
  Serial.print(t_water);
  Serial.println("*C");
}
 void TRNAS(){
  Serial.print("TRNAS:");
  Serial.println(host3);
  if (!client.connect(host3, httpPort)) {
    Serial.println("connect Fail");
    return;
  }

  String url = "http://59.127.204.180/THRR/GetData.php?upload=1";
  url += "&h_air=";
  url += h_air;
  url += "&t_air=";
  url += t_air;
  url += "&heat_air=";
  url += hic_air;
  url += "&t_water=";
  url += t_water;

  http.begin(url);
  if(http.GET() == 200){//如果網頁回應200代表正常
    DynamicJsonBuffer jsonBuffer(69);//設定json的緩衝區
    JsonObject& root = jsonBuffer.parseObject(http.getString());//設定緩衝區資料來源
    Serial.print("GET:");
    relay1=root["relay1"]; //變數relay1=讀取json的relay1值
    relay2=root["relay2"];
    relay3=root["relay3"];
    relay4=root["relay4"];
    relay5=root["relay5"];
    relay6=root["relay6"];
    Serial.print("relay1_state=");Serial.println(relay1);
    Serial.print("relay2_state=");Serial.println(relay2);
    Serial.print("relay3_state=");Serial.println(relay3);
    Serial.print("relay4_state=");Serial.println(relay4);
    Serial.print("relay5_state=");Serial.println(relay5);
    Serial.print("relay6_state=");Serial.println(relay6);
  }else{
    Serial.println("GetError");
  }
  http.end();
}
 
 void RelayOUT(){
	 digitalWrite(D0,relay1);
	 digitalWrite(D1,relay2);
	 digitalWrite(D4,relay3);
	 digitalWrite(D5,relay4);
	 digitalWrite(D6,relay5);
	 digitalWrite(D7,relay6);
 }