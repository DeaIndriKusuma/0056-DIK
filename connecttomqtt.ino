//#deklarasi header.
#include <EEPROM.h>
#include <ESP8266WiFi.h>
#include <PubSubClient.h>
#include <Wire.h>
#include <stdlib.h>

// Deklarasi ssid, password, mqtt
const char* ssid = "UTM";
const char* password = "calonsarjana23";
const char* mqtt_server = "riset.revolusi-it.com";
const char* topik = "iot/kendali";

// deklarasi variabel class WiFiClient
WiFiClient espClient;
PubSubClient client(espClient);
String messages;
String messages2;

void reconnect() {
// Ulang terus sampai terkoneksi
while (!client.connected()) {
Serial.print("Menghubungkan diri ke MQTT Server : "+(String)mqtt_server);
// Attempt to connect
if (client.connect("G.211.19.0056")) { // gunakan NIM anda sebagai identitas client
Serial.println("connected");
// .subscribe ke topic
client.subscribe(topik);
} else {
Serial.print("failed, rc=");
Serial.print(client.state());
Serial.println(" coba lagi dalam 5 detik...");
// Wait 5 seconds before retrying
delay(5000);
}
}
}

// sambungkan ke wifi
void konek_wifi()
{
WiFi.begin(ssid, password);
while (WiFi.status() != WL_CONNECTED) {
delay(500);
Serial.print(".");
}
Serial.println("");
Serial.println("WiFi connected"); // cetak wifi terkoneksi
}

// ------------------------------- begin program utama --------------------------------------- //
void setup()


{
  // initialize digital pin LED_BUILTIN as an output.
pinMode(D1, OUTPUT);
pinMode(D2, OUTPUT);
pinMode(D3, OUTPUT);
Serial.begin(9600); // mulai komunikasi serial
client.setServer(mqtt_server, 1883); // sambungkan client ke mqtt
client.setCallback(callback); // interaksi callback

}
void loop()
{

if(WiFi.status() != WL_CONNECTED) { konek_wifi(); } // jika tidak konek wifi maka di reconnect
if (!client.connected()) { reconnect(); } // reconnect apabila belum konek
client.loop(); // lakukan client.loop()
}

void callback(char* topic, byte* payload, unsigned int length) {
Serial.print("Pesan dari MQTT [");
Serial.print(topic);
Serial.print("] ");
messages="";
for (int i=0;i<length;i++) { // susun jadi string saja...
char receivedChar = (char)payload[i];
messages=messages+(char)payload[i]; // ambil pesannya masukkan dalam string
}
Serial.println(messages);
if (messages=="D1=1"){
  digitalWrite(D1, 1);
}
Serial.println(messages);
if (messages=="D2=1"){
  digitalWrite(D2, 1);
}
Serial.println(messages);
if (messages=="D3=1"){
  digitalWrite(D3, 1);
}
Serial.println(messages);
if (messages=="D1=0"){
  digitalWrite(D1, 0);
}
Serial.println(messages);
if (messages=="D2=0"){
  digitalWrite(D2, 0);
}
Serial.println(messages);
if (messages=="D3=0"){
  digitalWrite(D3, 0);
}
// kirim pesan ke mqtt server
messages2="G211190063";
// Serial.println(messages2);
// perhatikan cara ngirim variabel string lewat client.publish ini gak bisa langsung...
char attributes[100];
messages2.toCharArray(attributes, 100);
//client.publish(topik,attributes,true);
Serial.println("messages : "+messages2+" terkirim...");
//delay(1000);

}
// ===================================================================================
