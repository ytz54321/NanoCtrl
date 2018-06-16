#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
//#include <ESP8266mDNS.h>
//#include <WiFiUdp.h>
//#include <ArduinoOTA.h>
#include <OneWire.h>
#include <DallasTemperature.h>
#include "DHT.h"
#include <Ticker.h>
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
Ticker ticker;
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
//void ICACHE_RAM_ATTR onTimerISR(){ //計時器中斷時去做的事情
//   cont = 1;
//}

void setup() {
  //設定線上OTA
  //ArduinoOTA.setHostname("Bodi02");
  //ArduinoOTA.setPassword((const char *)"0101");
  //ArduinoOTA.begin();
  //定義腳位功能
  pinMode(D1,OUTPUT);	
  pinMode(D4,OUTPUT);
  pinMode(D5,OUTPUT);
  pinMode(D6,OUTPUT);
  pinMode(D7,OUTPUT);
  pinMode(D8,OUTPUT);
  Serial.begin(115200);
  sensors.begin();
  dht.begin();
  pinMode(D4,OUTPUT);
  ////啟用計時器
  //timer1_attachInterrupt(onTimerISR);
  //timer1_enable(TIM_DIV256, TIM_EDGE, TIM_LOOP);
  //timer1_write(26843542);
  ////  
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

/*void UPNET_NAS(){
  /////////////HOST1/////////////
  Serial.print("Upload_THR:");
  Serial.println(host1);
  //連線至HOST1
  if (!client.connect(host1, httpPort)) {
    Serial.println("connect Fail");
    return;
  }
  //建立回傳的URL
  String url = "/THRR/GetData_thr.php?";
  url += "h_air=";
  url += h_air;
  url += "&t_air=";
  url += t_air;
  url += "&heat_air=";
  url += hic_air;
  url += "&t_water=";
  url += t_water;
  
  Serial.print("GET: ");
  Serial.println(url);
  //回傳URL
  client.print(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host1 + "\r\n" + 
               "Connection: close\r\n\r\n"); 
  Serial.println("close connect");
  client.stop();
  ////////////////////////////////
}
*/
/*void RelayGET(){
  Serial.print("GET_Relay:");
  Serial.println(host3);
  //連線至HOST3
  if (!client.connect(host3, httpPort)) {
    Serial.println("connect Fail");
    return;
  }

  String url = "GetData.php?";
  url += "h_air=";
  url += h_air;
  url += "&t_air=";
  url += t_air;
  url += "&heat_air=";
  url += hic_air;
  url += "&t_water=";
  url += t_water;

  http.begin("http://59.127.204.180/THRR", 80 , url);
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
}       
*/
 
 
 
 
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

}


 
 
 void RelayOUT(){
	 digitalWrite(D1,relay1);
	 digitalWrite(D4,relay2);
	 digitalWrite(D5,relay3);
	 digitalWrite(D6,relay4);
	 digitalWrite(D7,relay5);
	 digitalWrite(D8,relay6);
 }