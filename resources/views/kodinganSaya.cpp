#include <TimeLib.h>
#include <WiFi.h>
#include <FirebaseESP32.h>
#include <DHT.h>
#include <NTPClient.h>
#include <WiFiUdp.h>


#define FIREBASE_HOST "https://project-ta-merang-default-rtdb.firebaseio.com/"
#define FIREBASE_AUTH "AIzaSyCg5YGHuFqkTR6OcPcZoWAet6n_HNvJsXY"

// WiFi credentials
#define WIFI_SSID "DoSaNaGi"
#define WIFI_PASSWORD "sury4123"

// Pin definitions
#define pinKipas 13
#define pinMist 25
#define pinKipMist 26
#define LDR_PIN 34
#define REFERENCE_RESISTANCE 10000
#define LAMP_PIN 19

#define DHTPIN 21
#define DHTTYPE DHT22
DHT dht(DHTPIN, DHTTYPE);

FirebaseData fbdo;
FirebaseJson json;

// NTP Client settings
WiFiUDP ntpUDP;
NTPClient timeClient(ntpUDP, "pool.ntp.org", 25200); // Setel zona waktu WIB (UTC+7)

// Function declarations
void set_manual();
void set_otomatis(float temp, float humidity, float lux);
void set_data_log(float temp, float humidity, float lux);

void setup() {
  Serial.begin(9600);
  pinMode(pinKipas, OUTPUT);
  pinMode(pinMist, OUTPUT);
  pinMode(pinKipMist, OUTPUT);
  pinMode(LAMP_PIN, OUTPUT);
  digitalWrite(LAMP_PIN, LOW);

  dht.begin();

  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);
  Serial.print("Menghubungkan..");
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    delay(500);
  }
  Serial.println();
  Serial.print("Terhubung IP : ");
  Serial.println(WiFi.localIP());
  Serial.println();

  Firebase.begin(FIREBASE_HOST, FIREBASE_AUTH);
  Firebase.reconnectWiFi(true);

  timeClient.begin();
  timeClient.forceUpdate();

  configTime(25200, 0, "pool.ntp.org"); // Setel zona waktu dan server NTP
}

void loop() {
  float temp = dht.readTemperature();
  float t = temp-2;
  float humidity = dht.readHumidity();
  float h = humidity-5;
  bool otomatis = false;
  bool kipasStatus = false;
  bool mistStatus = false;
  bool lampStatus = false;

  int ldrValue = analogRead(LDR_PIN);
  float voltage = (ldrValue / 4095.0) * 3.3; // Assuming 12-bit ADC resolution
  float ldrResistance = (3.3 - voltage) * REFERENCE_RESISTANCE / voltage;
  float faktor = 500;
  float lux = faktor * (ldrResistance / REFERENCE_RESISTANCE);

  lux = constrain(lux, 0, 1999);

  struct tm timeinfo;
  if (!getLocalTime(&timeinfo)) {
    Serial.println("Gagal mendapatkan waktu");
    return;
  }

  char formattedDateTime[20]; // YYYY-MM-DD HH:MM:SS
  strftime(formattedDateTime, sizeof(formattedDateTime), "%d-%m-%Y %H:%M:%S", &timeinfo); // Format tanggal dan waktu

  // Baca status otomatis dari Firebase
  if (Firebase.RTDB.getBool(&fbdo, "Kontrol/otomatis")) {
    otomatis = fbdo.boolData();
  }

  if (otomatis) {
    set_otomatis(temp, humidity, lux); // Pass parameters
  } else {
    set_manual();
  }

  set_data_log(temp, humidity, lux, formattedDateTime);

  Serial.print("Temp: ");
  Serial.print(t);
  Serial.print(" C ");
  Firebase.RTDB.setFloat(&fbdo, "Sensor/s_suhu", t);

  Serial.print("Humidity: ");
  Serial.print(h);
  Serial.println(" % ");
  Firebase.RTDB.setFloat(&fbdo, "Sensor/s_kelembaban", h);

  Serial.print(lux, 1);
  Serial.println(" lux");

  delay(2000);
}

void set_manual() {
  bool kipasStatus = false;
  bool mistStatus = false;
  bool lampStatus = false;

  if (Firebase.RTDB.getBool(&fbdo, "Kontrol/kipas")) {
    kipasStatus = fbdo.boolData();
    digitalWrite(pinKipas, kipasStatus ? HIGH : LOW);
    Serial.println(kipasStatus ? "Kipas ON" : "Kipas OFF");
  }

  if (Firebase.RTDB.getBool(&fbdo, "Kontrol/mistmaker")) {
    mistStatus = fbdo.boolData();
    digitalWrite(pinMist, mistStatus ? HIGH : LOW);
    digitalWrite(pinKipMist, mistStatus ? HIGH : LOW);
    Serial.println(mistStatus ? "Mist ON" : "Mist OFF");
  }

  if (Firebase.RTDB.getBool(&fbdo, "Kontrol/light")) {
    lampStatus = fbdo.boolData();
    digitalWrite(LAMP_PIN, lampStatus ? HIGH : LOW);
    Serial.println(lampStatus ? "Lampu ON" : "Lampu OFF");
  }
}

void set_otomatis(float t, float h, float lux) {
  // Kipas control
  if (t >= 32) {
    digitalWrite(pinKipas, HIGH);
    Serial.println("Kipas ON");
    Firebase.RTDB.setBool(&fbdo, "Kontrol/kipas", true);
  } else {
    digitalWrite(pinKipas, LOW);
    Serial.println("Kipas OFF");
    Firebase.RTDB.setBool(&fbdo, "Kontrol/kipas", false);
  }

  // Mist control
  if (h <= 80) {
    digitalWrite(pinMist, HIGH);
    digitalWrite(pinKipMist, HIGH);
    Serial.println("Mist ON");
  } else {
    digitalWrite(pinMist, LOW);
    digitalWrite(pinKipMist, LOW);
    Serial.println("Mist OFF");
  }

  // Lampu
  if (lux >= 50 && lux <= 300) {
    digitalWrite(LAMP_PIN, LOW);
  } else {
    digitalWrite(LAMP_PIN, HIGH);
  }
}

void set_data_log(float t, float h, float lux, const char* formattedDateTime) {
  String path = "DataLog/";

  json.set("/d_suhu", t);
  json.set("/d_kelembapan", h);
  json.set("/d_lux", lux);

  if (Firebase.RTDB.getBool(&fbdo, "Kontrol/kipas")) {
    json.set("/d_kipas", fbdo.boolData());
  }

  if (Firebase.RTDB.getBool(&fbdo, "Kontrol/light")) {
    json.set("/d_light", fbdo.boolData());
  }

  if (Firebase.RTDB.getBool(&fbdo, "Kontrol/mistmaker")) {
    json.set("/d_mistmaker", fbdo.boolData());
  }

  // Set the combined date and time
  json.set("/d_waktu", formattedDateTime);

  Firebase.RTDB.push(&fbdo, path, &json);
}
