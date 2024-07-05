#include <WiFi.h>
#include <FirebaseESP32.h>
#include <DHT.h>
#include <NTPClient.h>
#include <WiFiUdp.h>
#include <TimeLib.h>

#define FIREBASE_HOST "https://project-ta-merang-default-rtdb.firebaseio.com/"
#define FIREBASE_AUTH "AIzaSyCg5YGHuFqkTR6OcPcZoWAet6n_HNvJsXY"

// WiFi credentials
#define WIFI_SSID "POCO F4"
#define WIFI_PASSWORD "12345678"

// Pin definitions
#define pinKipas 13
#define pinMist 23
#define pinKipMist 22
#define DHTPIN 21
#define LDR_PIN 34
#define REFERENCE_RESISTANCE 10000
#define LAMP_PIN 19

#define DHTTYPE DHT22
DHT dht(DHTPIN, DHTTYPE);

FirebaseData fbdo;
FirebaseJson json;

// NTP Client settings
WiFiUDP ntpUDP;
NTPClient timeClient(ntpUDP, "pool.ntp.org", 25200); // Setel zona waktu WIB (UTC+7)

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

  // Initialize NTP client
  timeClient.begin();
}

void loop() {
  timeClient.update();

  float temp = dht.readTemperature();
  float humidity = dht.readHumidity();
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

  // Baca status otomatis dari Firebase
  if (Firebase.RTDB.getBool(&fbdo, "Kontrol/otomatis")) {
    otomatis = fbdo.boolData();
  }

  if (otomatis) {
    set_otomatis(temp, humidity, lux); // Pass parameters
  } else {
    set_manual();
  }

  set_data_log(temp, humidity, lux);

  Serial.print("Temp: ");
  Serial.print(temp);
  Serial.print(" C ");
  Firebase.RTDB.setFloat(&fbdo, "Sensor/s_suhu", temp);

  Serial.print("Humidity: ");
  Serial.print(humidity);
  Serial.println(" % ");
  Firebase.RTDB.setFloat(&fbdo, "Sensor/s_kelembaban", humidity);

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

void set_otomatis(float temp, float humidity, float lux) {
  // Kipas control
  if (temp >= 32) {
    digitalWrite(pinKipas, HIGH);
    Serial.println("Kipas ON");
    Firebase.RTDB.setBool(&fbdo, "Kontrol/kipas", true);
  } else {
    digitalWrite(pinKipas, LOW);
    Serial.println("Kipas OFF");
    Firebase.RTDB.setBool(&fbdo, "Kontrol/kipas", false);
  }

  // Mist control
  if (humidity <= 80) {
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

void set_data_log(float temp, float humidity, float lux) {
  String path = "DataLog/";

  json.set("/d_suhu", temp);
  json.set("/d_kelembapan", humidity);
  json.set("/d_ldr", lux);

  if (Firebase.RTDB.getBool(&fbdo, "Kontrol/kipas")) {
    if (fbdo.boolData() == true) {
      json.set("/d_kipas", true);
    } else {
      json.set("/d_kipas", false);
    }
  }

  if (Firebase.RTDB.getBool(&fbdo, "Kontrol/light")) {
    if (fbdo.boolData() == true) {
      json.set("/d_light", true);
    } else {
      json.set("/d_light", false);
    }
  }

  if (Firebase.RTDB.getBool(&fbdo, "Kontrol/mistmaker")) {
    if (fbdo.boolData() == true) {
      json.set("/d_mistmaker", true);
    } else {
      json.set("/d_mistmaker", false);
    }
  }

  // Get the current time and date from NTP client
  String formattedDate = timeClient.getFormattedDate();
  json.set("/d_waktu", formattedDate);

  Firebase.RTDB.push(&fbdo, path, &json);
}
