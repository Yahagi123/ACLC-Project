#include <Arduino.h>
#include <ArduinoJson.h> 
#include <Adafruit_Fingerprint.h>
#include <WiFi.h>
#include <HTTPClient.h>
#include <WebServer.h>

HardwareSerial serialPort(2); // use UART2

Adafruit_Fingerprint finger = Adafruit_Fingerprint(&serialPort);

int counter;
int OwnerOne;
uint16_t inputFingerprintId;

uint8_t id;
uint8_t conditionswitch;
uint8_t option;
uint8_t getFingerprintEnroll();
uint8_t deleteFingerprint();

char doorlockstatus;
String DigitalSerialNumber = "";
// Yui2: 192.168.0.222
// ran: 172.20.10.6
// mphen : 192.168.158.202

const char *apiUrl = "http://192.168.0.222/cloudfingerprintproject/api.php";  
const char *ap_ssid = "ESP32-Config", *ap_password = "123456789";
WebServer server(80);
String savedSSID = "", savedPassword = "";
// interval to read the fingerprint sensor
unsigned long previousMillis = 0;
const long readInterval = 1000;

// interval when to close the door lock
bool isOpen = false;
const long closeInterval = 5000;
unsigned long previousOpenMillis = 0;

//InsideButton
const int buttonUnlocked = 12;

// Relay Pin
const int RELAY_PIN = 23;

// Buzzer
const int buzzerPin = 22;

const char *htmlForm = R"(
  <!DOCTYPE html>
<html>
<head>
  <title>Connect to Wi-Fi</title>
  <style>
    body { font-family: Arial; margin: 0; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #393453; }
    .container{ font-size: 40px; background-color: #6a4191; padding: 20px; border-radius: 50px; color: white; }
    .center-this{ display: flex; justify-content: center; }
    input[type=text], input[type=password] { padding: 10px; margin: 5px; width: 300px; font-size:40px; background-color: #d7abff; border: none; border-radius: 20px; }
    input[type=submit] { padding: 10px 20px; background-color: #4CAF50; color: white; border: none; font-size: 40px; }
  </style>
</head>
<body>
  <form action="/connect" method="POST" class="container">
    <h1>Enter Wi-Fi Credentials</h1>
    SSID: <input type="text" name="ssid" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <div class="center-this"><input type="submit" value="Connect"></div>
  </form>
</body>
</html>
)";

const char *serialNumberForm = R"(
  <!DOCTYPE html>
  <html>
  <head>
    <title>Enter Serial Number</title>
    <style>
      body { font-family: Arial; margin: 0; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #393453; }
      .container{ font-size: 40px; background-color: #6a4191; padding: 20px; border-radius: 50px; color: white; }
      .center-this{ display: flex; justify-content: center; }
      input[type=text] { padding: 10px; margin: 5px; width: 300px; font-size:40px; background-color: #d7abff; border: none; border-radius: 20px; }
      input[type=submit] { padding: 10px 20px; background-color: #4CAF50; color: white; border: none; font-size: 40px; border-radius: 20px; }
    </style>
  </head>
  <body>
    <form action="/saveSerial" method="POST" class="container">
    <h1>Enter Your Serial Number</h1>
    Serial Number: <input type="text" name="serial" required><br><br>
    <div class="center-this"><input type="submit" value="Save Serial Number"></div>
    </form>
  </body>
  </html>
)";

void fetchDigitalSerialNumber() {
  HTTPClient http;

  // Specify the request type (GET or POST depending on your API)
  http.begin(apiUrl);
  http.addHeader("Content-Type", "application/json");  // Set the content type to JSON
  
  // Send the request to the PHP API
  String requestData = "{\"action\":\"get_serial_number\"}";  // Modify action as needed
  int httpResponseCode = http.POST(requestData);  // Use GET if your API accepts GET requests
  
  if (httpResponseCode == 200) {
    // Get the response from the server
    String payload = http.getString();
    Serial.println("Received Response: " + payload);

    // Check the response for the DigitalSerialNumber
    // The response should be in the format of a JSON object
    DynamicJsonDocument doc(1024);
    deserializeJson(doc, payload);

    if (doc["success"].as<bool>() == true && doc.containsKey("serial_number")) {
      DigitalSerialNumber = doc["serial_number"].as<String>();  // Save the serial number if exists
      Serial.println("DigitalSerialNumber: " + DigitalSerialNumber);
    } else {
      Serial.println("No serial number found or failed to fetch.");
    }
  } else {
    Serial.println("Error fetching serial number: " + String(httpResponseCode));
  }

  http.end();  // Close the HTTP request
}

void sendStatusToAPI(String statusMessage) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin("http://192.168.0.222/cloudfingerprintproject/send_status.php"); // Replace with your PHP API URL
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    String postData = "status=" + statusMessage + "&serialNumber=" + DigitalSerialNumber;
    
    int httpResponseCode = http.POST(postData);
    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println("Status Response: " + response);
    } else {
      Serial.println("Error sending status: " + String(httpResponseCode));
    }
    http.end();
  } else {
    Serial.println("WiFi not connected");
  }
}

void handleFormSubmit() {
  String ssid = server.arg("ssid"), password = server.arg("password");
  savedSSID = ssid;
  savedPassword = password;

  WiFi.begin(ssid.c_str(), password.c_str());
  for (int i = 0; i < 10 && WiFi.status() != WL_CONNECTED; i++) delay(1000);

  if (WiFi.status() == WL_CONNECTED) {
    // server.send(200, "text/html", "<h1>Connected to Wi-Fi!</h1>");
    server.sendHeader("Location", "/serialNumber", true);
    server.send(302, "text/html", "");
  } else {
    server.send(200, "text/html", "<h1>Failed to connect! Go back and input your wifi-network</h1>");
  }
}

void sendDigitalSerialNumber() {
  if (WiFi.status() == WL_CONNECTED) { // Check Wi-Fi connection
    HTTPClient http;
    const String url = "http://192.168.0.222/cloudfingerprintproject/insert_serial.php"; // Replace with your PHP API URL
    const String postData = "DigitalSerialNumber=" + DigitalSerialNumber;
    const int maxRetries = 3; // Maximum number of retries
    int attempt = 0;
    int httpResponseCode = -1; // Default to an error state

    http.begin(url);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Retry logic
    while (attempt < maxRetries) {
      attempt++;
      Serial.printf("Attempt %d: Sending POST request...\n", attempt);

      httpResponseCode = http.POST(postData);

      if (httpResponseCode > 0) {
        // Successful request
        String response = http.getString();
        Serial.println("Response: " + response);
        http.end(); // Close connection
        return; // Exit the function as the request was successful
      } else {
        // Log the error
        Serial.printf("Error on attempt %d: %s\n", attempt, http.errorToString(httpResponseCode).c_str());
        delay(1000); // Wait 1 second before retrying
      }
    }

    // If we reach here, all attempts failed
    Serial.println("All attempts to send POST request failed. Error: " + String(httpResponseCode));
    http.end(); // Close connection
  } else {
    Serial.println("WiFi not connected");
  }
}


void insertToSuspiciousLogsLogs(String typeee) {
  if (WiFi.status() == WL_CONNECTED) { // Check Wi-Fi connection
    HTTPClient http;
    http.begin("http://192.168.0.222/cloudfingerprintproject/SUSPICIOUSinsert_accessLogs.php"); // Replace with your PHP API URL
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Prepare the POST data
    String postData = "ESP32SerialNumber=" + DigitalSerialNumber + "&typeee=" + typeee;

    // Send POST request
    int httpResponseCode = http.POST(postData);

    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println("Deletion Status Response: " + response);
    } else {
      Serial.println("Error on sending POST: " + String(httpResponseCode));
    }
    http.end(); // Close connection
  } else {
    Serial.println("WiFi not connected");
  }
}

void insertToLogs(String id) {
  if (WiFi.status() == WL_CONNECTED) { // Check Wi-Fi connection
    HTTPClient http;
    http.begin("http://192.168.0.222/cloudfingerprintproject/insert_accessLogs.php"); // Replace with your PHP API URL
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Prepare the POST data
    String postData = "ESP32SerialNumber=" + DigitalSerialNumber + "&index=" + String(id) ;

    // Send POST request
    int httpResponseCode = http.POST(postData);

    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println("Deletion Status Response: " + response);
    } else {
      Serial.println("Error on sending POST: " + String(httpResponseCode));
    }
    http.end(); // Close connection
  } else {
    Serial.println("WiFi not connected");
  }
}

void deleteUserToDatabase() {
  if (WiFi.status() == WL_CONNECTED) { // Check Wi-Fi connection
    HTTPClient http;
    http.begin("http://192.168.0.222/cloudfingerprintproject/deleteOneUser.php"); // Replace with your PHP API URL
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Prepare the POST data
    String postData = "ESP32SerialNumber=" + DigitalSerialNumber + "&index=" + String(id) ;

    // Send POST request
    int httpResponseCode = http.POST(postData);

    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println("Deletion Status Response: " + response);
    } else {
      Serial.println("Error on sending POST: " + String(httpResponseCode));
    }
    http.end(); // Close connection
  } else {
    Serial.println("WiFi not connected");
  }
}


void sendEnrollmentStatus(bool success, String message) {
  if (WiFi.status() == WL_CONNECTED) { // Check Wi-Fi connection
    HTTPClient http;
    http.begin("http://192.168.0.222/cloudfingerprintproject/enrollment_status.php"); // Replace with your PHP API URL
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Prepare the POST data
    String postData = "status=" + String(success ? "success" : "failure") + "&message=" + message + "&serialnumber=" + DigitalSerialNumber + "&indexFingerprint=" + id ;

    // Send POST request
    int httpResponseCode = http.POST(postData);

    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println("Enrollment Status Response: " + response);
    } else {
      Serial.println("Error on sending POST: " + String(httpResponseCode));
    }
    http.end(); // Close connection
  } else {
    Serial.println("WiFi not connected");
  }
}



void handleSaveSerialNumber() {
  DigitalSerialNumber = server.arg("serial");
  server.send(200, "text/html", "<h1>Serial Number Saved!</h1><p>" + DigitalSerialNumber + "</p>");

  // Send the DigitalSerialNumber to the database
  sendDigitalSerialNumber();
  WiFi.softAPdisconnect(true);
  conditionswitch = 1;


}

void setup()
{
  Serial.begin(9600);
  conditionswitch = 0;
  if (savedSSID != "" && savedPassword != "") {
    WiFi.begin(savedSSID.c_str(), savedPassword.c_str());
    for (int i = 0; i < 10 && WiFi.status() != WL_CONNECTED; i++) delay(1000);
    if (WiFi.status() == WL_CONNECTED) {
      conditionswitch = 1;
      return;
    }
  }

  WiFi.softAP(ap_ssid, ap_password);
  server.on("/", HTTP_GET, []() { server.send(200, "text/html", htmlForm); });
  server.on("/connect", HTTP_POST, handleFormSubmit);
  server.on("/serialNumber", HTTP_GET, []() { server.send(200, "text/html", serialNumberForm); });
  server.on("/saveSerial", HTTP_POST, handleSaveSerialNumber);
  server.begin();
  while (!Serial)
    ; // For Yun/Leo/Micro/Zero/...
  delay(100);
  Serial.println("\n\nAdafruit Fingerprint sensor enrollment");

  // set the data rate for the sensor serial port
  finger.begin(57600);

  if (finger.verifyPassword())
  {
    Serial.println("Found fingerprint sensor!");
  }
  else
  {
    Serial.println("Did not find fingerprint sensor :(");
    while (1)
    {
      delay(1);
    }
  }

  Serial.println(F("Reading sensor parameters"));
  finger.getParameters();
  Serial.print(F("Status: 0x"));
  Serial.println(finger.status_reg, HEX);
  Serial.print(F("Sys ID: 0x"));
  Serial.println(finger.system_id, HEX);
  Serial.print(F("Capacity: "));
  Serial.println(finger.capacity);
  Serial.print(F("Security level: "));
  Serial.println(finger.security_level);
  Serial.print(F("Device address: "));
  Serial.println(finger.device_addr, HEX);
  Serial.print(F("Packet len: "));
  Serial.println(finger.packet_len);
  Serial.print(F("Baud rate: "));
  Serial.println(finger.baud_rate);

  // initialize Relay digital pin as an output.
  pinMode(RELAY_PIN, OUTPUT);
  digitalWrite(RELAY_PIN, LOW);

  pinMode(buttonUnlocked, INPUT_PULLUP);

  // configure buzzer and led pin
  pinMode(buzzerPin, OUTPUT);
}

uint8_t readnumber(void)
{
  uint8_t num = 0;

  while (num == 0)
  {
    while (!Serial.available())
      ;
    num = Serial.parseInt();
  }
  return num;
}

//send message.
void sendToFrontend(String message) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin("http://192.168.0.222/cloudfingerprintproject/send_log.php"); // Replace with your logging endpoint
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    String postData = "message=" + message;
    int httpCode = http.POST(postData);

    if (httpCode > 0) {
      Serial.println("Message sent to frontend: " + message);
    } else {
      Serial.println("Failed to send message to frontend: " + http.errorToString(httpCode));
    }
    http.end();
  }
}

//send status to database.
void sendToFrontendStatus(String message) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin("http://192.168.0.222/cloudfingerprintproject/send_log.php"); // Replace with your logging endpoint
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    String postData = "status=" + message;
    int httpCode = http.POST(postData);

    if (httpCode > 0) {
      Serial.println("Message sent to frontend: " + message);
    } else {
      Serial.println("Failed to send message to frontend: " + http.errorToString(httpCode));
    }
    http.end();
  }
}

int fetchFingerprintID() {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin("http://192.168.0.222/cloudfingerprintproject/get_fingerprint_id.php"); // Replace with your server endpoint
    int httpCode = http.GET();

    if (httpCode == 200) { // Successful response
      String payload = http.getString();
      Serial.println("Received response: " + payload);
      sendToFrontend("Received response: " + payload);

      // Parse the ID from the JSON response
      DynamicJsonDocument doc(1024);
      DeserializationError error = deserializeJson(doc, payload);

      if (error) {
        Serial.println("JSON Parsing Error: " + String(error.c_str()));
        sendToFrontend("JSON Parsing Error: " + String(error.c_str()));
        return -1; // Return an invalid ID
      }

      int fingerprintID = doc["fingerprintID"];
      http.end();
      return fingerprintID;
    } else {
      Serial.println("Error fetching fingerprint ID: " + String(httpCode));
      sendToFrontend("Error fetching fingerprint ID: " + String(httpCode));
      http.end();
      return -1; // Return an invalid ID
    }
  } else {
    Serial.println("WiFi not connected. Cannot fetch fingerprint ID.");
    sendToFrontend("WiFi not connected. Cannot fetch fingerprint ID.");
    return -1; // Return an invalid ID
  }
}

void deletionFingerprint(){
  Serial.println("Ready to Delete a fingerprint!");
  Serial.println("Please type in the ID # (from 1 to 127) you want to delete this finger as...");
  id = fetchFingerprintID();
  if (id == 0)
  { // ID #0 not allowed, try again!
    return;
  }
  Serial.print("Enrolling ID #");
  Serial.println(id);

  while (!deleteFingerprint())
    ;
  delay(10000);
}

void enrollmentFingerprint(){
  Serial.println("Ready to enroll a fingerprint!");
  sendToFrontend("Ready to enroll a fingerprint!");
  Serial.println("Fetching the ID from the web...");
  sendToFrontend("Fetching the ID from the web...");
  
  id = fetchFingerprintID();
  if (id <= 0) {
    Serial.println("Invalid ID received. Enrollment aborted.");
    sendToFrontend("Invalid ID received. Enrollment aborted.");
    return;
  }

  Serial.print("Enrolling ID #");
  Serial.println(id);
  sendToFrontend("Enrolling ID #" + String(id));

  while (!getFingerprintEnroll()) {
    sendToFrontend("Waiting for fingerprint enrollment...");
    sendToFrontendStatus("waiting");
    delay(100); // Give a small delay for enrollment process
  }
}

void fetchOption() {
    if (WiFi.status() == WL_CONNECTED) {
        HTTPClient http;
        http.begin("http://192.168.0.222/cloudfingerprintproject/get_option.php");
        int httpCode = http.GET();

        if (httpCode == 200) { // HTTP response code OK
            String payload = http.getString();
            Serial.println("Payload received: " + payload); // Debug: Log the payload

            // Parse the JSON response
            DynamicJsonDocument doc(1024); // Allocate sufficient size for the JSON document
            DeserializationError error = deserializeJson(doc, payload);

            // Check for JSON parsing errors
            if (error) {
                Serial.print("JSON Parsing Error: ");
                Serial.println(error.c_str()); // Print the error message
                return;
            }

            // Extract the value of "option" from the parsed JSON
            if (doc.containsKey("option")) {
                option = doc["option"].as<int>();
                Serial.println("Parsed Option: " + String(option)); // Debug: Log the parsed option
            } else {
                Serial.println("JSON does not contain the 'option' key."); // Debug: Log missing key
            }

        } else {
            Serial.println("HTTP GET Error: " + String(httpCode)); // Debug: Log HTTP error code
        }

        http.end(); // Free the resources used by HTTPClient
    } else {
        Serial.println("WiFi not connected"); // Debug: Log WiFi connection status
    }
}

void dashboardSendThisTo(String sendThistoPage,String infodata) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin("http://192.168.0.222/cloudfingerprintproject/loggedDashboardInformation.php"); // Replace with your logging endpoint
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    Serial.println("----------------------------");
    Serial.println(" sending to : " + sendThistoPage + " info data: " + infodata);
    Serial.println("----------------------------");
    String postData = "sendThistoPage=" + sendThistoPage + "&infodata=" + infodata + "&serialnumber=" + DigitalSerialNumber;
    int httpCode = http.POST(postData);

    if (httpCode > 0) {
      Serial.println("Message sent to frontend: " + infodata);
    } else {
      Serial.println("Failed to send message to frontend: " + http.errorToString(httpCode));
    }
    http.end();
  }
}

uint8_t getFingerprintID()
{
  uint8_t p = finger.getImage();
  switch (p)
  {
  case FINGERPRINT_OK:
    Serial.println("Image taken");
    break;
  case FINGERPRINT_NOFINGER:
    return p;
  case FINGERPRINT_PACKETRECIEVEERR:
    Serial.println("Communication error");
    return p;
  case FINGERPRINT_IMAGEFAIL:
    Serial.println("Imaging error");
    return p;
  default:
    Serial.println("Unknown error");
    return p;
  }

  // OK success!

  p = finger.image2Tz();
  switch (p)
  {
  case FINGERPRINT_OK:
    Serial.println("Image converted");
    break;
  case FINGERPRINT_IMAGEMESS:
    Serial.println("Image too messy");
    return p;
  case FINGERPRINT_PACKETRECIEVEERR:
    Serial.println("Communication error");
    return p;
  case FINGERPRINT_FEATUREFAIL:
    Serial.println("Could not find fingerprint features");
    return p;
  case FINGERPRINT_INVALIDIMAGE:
    Serial.println("Could not find fingerprint features");
    return p;
  default:
    Serial.println("Unknown error");
    return p;
  }

  // OK converted!
  p = finger.fingerSearch();
  if (p == FINGERPRINT_OK)
  {
    Serial.println("Found a print match!");
    // found a match!
    Serial.print("Found ID #");
    Serial.print(finger.fingerID);
    Serial.print(" with confidence of ");
    Serial.println(finger.confidence);

    dashboardSendThisTo("doorlock-lastperson", String(finger.fingerID));
    dashboardSendThisTo("doorlock-status", String("UNLOCKED"));
    insertToLogs(String(finger.fingerID));
    inputFingerprintId = finger.fingerID;

    return p;
  }
  else if (p == FINGERPRINT_PACKETRECIEVEERR)
  {
    Serial.println("Communication error");
    return p;
  }
  else if (p == FINGERPRINT_NOTFOUND)
  {
    Serial.println("Did not find a match");
    return p;
  }
  else
  {
    Serial.println("Unknown error");
    return p;
  }
}

void showNotAllowed()
{
  digitalWrite(buzzerPin, HIGH);
  delay(1000);
  digitalWrite(buzzerPin, LOW);
}

void showNotAllowedSMS() //locked
{
  digitalWrite(buzzerPin, HIGH);
  delay(150);
  digitalWrite(buzzerPin, LOW);
  delay(25);
  digitalWrite(buzzerPin, HIGH);
  delay(150);
  digitalWrite(buzzerPin, LOW);
  delay(25);
  digitalWrite(buzzerPin, HIGH);
  delay(150);
  digitalWrite(buzzerPin, LOW);
  delay(250);

  digitalWrite(buzzerPin, HIGH);
  delay(350);
  digitalWrite(buzzerPin, LOW);
  delay(25);
  digitalWrite(buzzerPin, HIGH);
  delay(350);
  digitalWrite(buzzerPin, LOW);
  delay(250);
  
  digitalWrite(buzzerPin, HIGH);
  delay(150);
  digitalWrite(buzzerPin, LOW);
  delay(25);
  digitalWrite(buzzerPin, HIGH);
  delay(150);
  digitalWrite(buzzerPin, LOW);
  delay(25);
  digitalWrite(buzzerPin, HIGH);
  delay(150);
  digitalWrite(buzzerPin, LOW);
  delay(500);
}
// ----------------------------------------------------------------------------------------------------


void readmode()
{ 
  if(digitalRead(buttonUnlocked) == LOW){
      previousOpenMillis = millis();
      isOpen = true;
      digitalWrite(RELAY_PIN, HIGH);
  }
  delay(2500);
  dashboardSendThisTo("device-ssid", savedSSID);
  unsigned long currentMillis = millis();
  // Close the door lock after 5 seconds
  if (isOpen && currentMillis - previousOpenMillis >= closeInterval)
  {
    isOpen = false;
    Serial.println("Closing the door lock!");

    dashboardSendThisTo("doorlock-status", String("LOCKED"));
    digitalWrite(RELAY_PIN, LOW);
  }

  // save the last time we read the fingerprint sensor
  if (!isOpen && currentMillis - previousMillis >= readInterval)
  {
    previousMillis = currentMillis;
    uint8_t result = getFingerprintID();
    switch (result)
    {
    case FINGERPRINT_NOFINGER:
      Serial.println("Scan your fingerprint");
      break;
    case FINGERPRINT_OK:
    // if(OwnerOne = 1 ){
    //   if(inputFingerprintId != 1){
    //     Serial.println("Access Denied due to multiple attempts with no match.. contact owner!");
    //     showNotAllowedSMS();
    //     break;
    //   }
    // }
      Serial.println("Access Granted..opening door lock!");
      previousOpenMillis = millis();
      isOpen = true;
      digitalWrite(RELAY_PIN, HIGH);
      counter = 0;
      OwnerOne = 0;
      Serial.println("Owner One set = " + OwnerOne);
      break;
    case FINGERPRINT_NOTFOUND:
      Serial.println("Access Denied");
      
      // if(counter >= 3 ){
      //   insertToSuspiciousLogsLogs("MALICIOUS");
      //   dashboardSendThisTo("alert-attempt","LOCKED DUE TO MULTIPLE ATTEMPTS");
      //   showNotAllowedSMS();
      //   OwnerOne = 1; // locked mode
      //   delay(2000);
      //   break;
      // }
      // dashboardSendThisTo("alert-attempt","SUSPICIOUS");
      // insertToSuspiciousLogsLogs("SUSPICIOUS");
      // showNotAllowed();
      // delay(2000);
      break;
    case FINGERPRINT_PACKETRECIEVEERR:
    case FINGERPRINT_IMAGEFAIL:
    case FINGERPRINT_IMAGEMESS:
    case FINGERPRINT_FEATUREFAIL:
    case FINGERPRINT_INVALIDIMAGE:
      Serial.println("Error in Fingerprint Scan!");
      break;
    default:
      Serial.println("Unknown Error!");
      break;
    }
  }
  fetchOption();
}


void loop() // run over and over again
{
  if(conditionswitch == 0){
    server.handleClient();
  }
  if(conditionswitch == 1){
    dashboardSendThisTo("device-ssid", savedSSID);
  fetchOption(); 
  Serial.println("Ready! option: " + option);
  if (option < 1 || option > 3)
  { // ID #0 not allowed, try again!
    return;
  }
  if(option == 1){
    enrollmentFingerprint();
  }
  if(option == 2){
    deletionFingerprint();
  }
  if(option == 3){
    while (option == 3)
    {
      readmode();
    }
    
  }
  delay(5000); // Wait for 5 seconds before checking the option again
  }
  
}



uint8_t deleteFingerprint() {
  uint8_t p = -1;

  p = finger.deleteModel(id);

  if (p == FINGERPRINT_OK) {
    Serial.println("Deleted!");
    deleteUserToDatabase();
  } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
    Serial.println("Communication error");
    return p;
  } else if (p == FINGERPRINT_BADLOCATION) {
    Serial.println("Could not delete in that location");
    return p;
  } else if (p == FINGERPRINT_FLASHERR) {
    Serial.println("Error writing to flash");
    return p;
  } else {
    Serial.print("Unknown error: 0x"); Serial.println(p, HEX);
    return p;
  }

  return true;
}


uint8_t getFingerprintEnroll() {
  int p = -1;
  Serial.print("Waiting for valid finger to enroll as #");
  Serial.println(id);
  
  // Wait for the first image
  while (p != FINGERPRINT_OK) {
    p = finger.getImage();
    switch (p) {
      case FINGERPRINT_OK:
        Serial.println("Image taken");
        sendToFrontendStatus("scanning");
        break;
      case FINGERPRINT_NOFINGER:
        Serial.println(".");
        sendToFrontendStatus("waiting");
        break;
      case FINGERPRINT_PACKETRECIEVEERR:
        Serial.println("Communication error");
        sendEnrollmentStatus(false, "Communication error during first image capture");
        return p;
      case FINGERPRINT_IMAGEFAIL:
        Serial.println("Imaging error");
        sendEnrollmentStatus(false, "Imaging error during first image capture");
        return p;
      default:
        Serial.println("Unknown error");
        sendEnrollmentStatus(false, "Unknown error during first image capture");
        return p;
    }
  }

  // Convert the first image to template
  p = finger.image2Tz(1);
  if (p == FINGERPRINT_OK) {
    Serial.println("Image converted");
    sendToFrontendStatus("Fingerprint-converted");
  } else {
    sendEnrollmentStatus(false, "Image conversion failed (first scan)");
    return p;
  }

  // Wait for the finger to be removed
  delay(2000);
  p = 0;
  while (p != FINGERPRINT_NOFINGER) {
    p = finger.getImage();
    sendToFrontendStatus("lift");
  }
  
  // Wait for the same finger to be placed again
  Serial.println("Place same finger again");
  sendToFrontendStatus("waiting2");
  while (p != FINGERPRINT_OK) {
    p = finger.getImage();
    sendToFrontendStatus("waiting2");
  }

  // Convert the second image to template
  p = finger.image2Tz(2);
  if (p == FINGERPRINT_OK) {
    Serial.println("Image converted");
  } else {
    sendToFrontendStatus("scan2failed");
    sendEnrollmentStatus(false, "Image conversion failed (second scan)");
    return p;
  }

  // Create the fingerprint model (matching)
  p = finger.createModel();
  if (p == FINGERPRINT_OK) {
    Serial.println("Prints matched!");
    
  } else {
    sendToFrontendStatus("Fingerprintmismatch");
    sendEnrollmentStatus(false, "Fingerprint mismatch");
    return p;
  }

  // Store the fingerprint model
  p = finger.storeModel(id);
  if (p == FINGERPRINT_OK) {

    Serial.println("Stored!");
    sendToFrontendStatus("success");
    sendEnrollmentStatus(true, "Fingerprint stored successfully");
  } else {
    sendEnrollmentStatus(false, "Error storing model");
  }

  return true;
}

// Deletion fingerprint logic (same as original)
