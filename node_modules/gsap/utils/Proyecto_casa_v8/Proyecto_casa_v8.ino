#include <WiFi.h>
#include <WebServer.h>
#include <ESP32Servo.h>

const char* ssid = "Sistemas_WiFi";
const char* password = "$.56841312.%";

WebServer server(80);

// Pines para cada luz y componente
const int puerta = 5;
const int ledCocina = 18;
const int ledRecamara = 19;
const int ledSanitario = 21;
const int ledCochera = 22;
const int ledTerraza = 23;
const int ledExtractor = 25;
const int pinservogaraje = 13;

Servo servogaraje;  

unsigned long tiempoLuzCochera = 0;
bool luzCocheraEncendida = false;


void setup() {
  Serial.begin(115200);
  pinMode(puerta, OUTPUT);
  pinMode(ledCocina, OUTPUT);
  pinMode(ledRecamara, OUTPUT);
  pinMode(ledSanitario, OUTPUT);
  pinMode(ledCochera, OUTPUT);
  pinMode(ledTerraza, OUTPUT);
  pinMode(ledExtractor, OUTPUT);
  

  servogaraje.attach(pinservogaraje);  // Inicia el servo
  servogaraje.write(0);                // Servo en posición inicial

  // Apagar todo al inicio
  digitalWrite(puerta, HIGH);
  digitalWrite(ledCocina, HIGH);
  digitalWrite(ledRecamara, HIGH);
  digitalWrite(ledSanitario, HIGH);
  digitalWrite(ledCochera, HIGH);
  digitalWrite(ledTerraza, HIGH);
  digitalWrite(ledExtractor, HIGH);

  Serial.println("Configurando WiFi en modo estación");
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("\nWiFi conectado!!!");
  Serial.print("Dirección IP: ");
  Serial.println(WiFi.localIP());

  server.on("/", HTTP_GET, handleRoot);

  server.on("/encender_todo", HTTP_GET, [](){
    digitalWrite(ledCocina, LOW);
    digitalWrite(ledRecamara, LOW);
    digitalWrite(ledSanitario, LOW);
    digitalWrite(ledCochera, LOW);
    digitalWrite(ledTerraza, LOW);
    server.send(200, "text/plain", "Todas las luces encendidas");
  });

  server.on("/apagar_todo", HTTP_GET, [](){
    digitalWrite(ledCocina, HIGH);
    digitalWrite(ledRecamara, HIGH);
    digitalWrite(ledSanitario, HIGH);
    digitalWrite(ledCochera, HIGH);
    digitalWrite(ledTerraza, HIGH);
    server.send(200, "text/plain", "Todas las luces apagadas");
  });

  server.on("/abrir_garaje", HTTP_GET, []() {
  servogaraje.write(90);                         // Abre el garaje
  digitalWrite(ledCochera, HIGH);                // Apaga la luz de cochera
  tiempoLuzCochera = millis();                   // Inicia el conteo
  luzCocheraEncendida = true;                    // Indicador de cuenta regresiva
  server.send(200, "text/plain", "Garaje Abierto y luz cochera apagada");
});


  server.on("/cerrar_garaje", HTTP_GET, [](){
    servogaraje.write(0);
    server.send(200, "text/plain", "Garaje Cerrado");
  });

  server.on("/abrir_puerta", HTTP_GET, [](){ digitalWrite(puerta, LOW); server.send(200, "text/plain", "Puerta Abierta"); });
  server.on("/cerrar_puerta", HTTP_GET, [](){ digitalWrite(puerta, HIGH); server.send(200, "text/plain", "Puerta Cerrada"); });

  server.on("/encender_cocina", HTTP_GET, [](){ digitalWrite(ledCocina, LOW); server.send(200, "text/plain", "Luz Cocina Encendida"); });
  server.on("/apagar_cocina", HTTP_GET, [](){ digitalWrite(ledCocina, HIGH); server.send(200, "text/plain", "Luz Cocina Apagada"); });

  server.on("/encender_recamara", HTTP_GET, [](){ digitalWrite(ledRecamara, LOW); server.send(200, "text/plain", "Luz Recamara Encendida"); });
  server.on("/apagar_recamara", HTTP_GET, [](){ digitalWrite(ledRecamara, HIGH); server.send(200, "text/plain", "Luz Recamara Apagada"); });

  server.on("/encender_sanitario", HTTP_GET, [](){ digitalWrite(ledSanitario, LOW); server.send(200, "text/plain", "Luz Sanitario Encendida"); });
  server.on("/apagar_sanitario", HTTP_GET, [](){ digitalWrite(ledSanitario, HIGH); server.send(200, "text/plain", "Luz Sanitario Apagada"); });

  server.on("/encender_cochera", HTTP_GET, [](){ digitalWrite(ledCochera, LOW); server.send(200, "text/plain", "Luz Cochera Encendida"); });
  server.on("/apagar_cochera", HTTP_GET, [](){ digitalWrite(ledCochera, HIGH); server.send(200, "text/plain", "Luz Cochera Apagada"); });

  server.on("/encender_terraza", HTTP_GET, [](){ digitalWrite(ledTerraza, LOW); server.send(200, "text/plain", "Luz Terraza Encendida"); });
  server.on("/apagar_terraza", HTTP_GET, [](){ digitalWrite(ledTerraza, HIGH); server.send(200, "text/plain", "Luz Terraza Apagada"); });

  server.on("/iniciar_extractor", HTTP_GET, [](){ digitalWrite(ledExtractor, LOW); server.send(200, "text/plain", "Extractor Encendido"); });
  server.on("/detener_extractor", HTTP_GET, [](){ digitalWrite(ledExtractor, HIGH); server.send(200, "text/plain", "Extractor Apagado"); });

  server.onNotFound(handleNotFound);
  server.begin();
  Serial.println("Servidor HTTP iniciado");
}

void loop() {
  server.handleClient();
  
if (luzCocheraEncendida && millis() - tiempoLuzCochera >= 60000) {
  digitalWrite(ledCochera, LOW);               // Apaga la luz
  luzCocheraEncendida = false;                  // Reinicia el estado
  Serial.println("Luz de cochera apagada automáticamente");
}
}

void handleRoot() {
  String html = "<h1>Control de Casa Domótica</h1>";
  html += "<p><a href='/encender_todo'>Encender Todo</a> | <a href='/apagar_todo'>Apagar Todo</a></p>";
  html += "<p><a href='/abrir_puerta'>Abrir Puerta</a> | <a href='/cerrar_puerta'>Cerrar Puerta</a></p>";
  html += "<p><a href='/encender_cocina'>Encender Cocina</a> | <a href='/apagar_cocina'>Apagar Cocina</a></p>";
  html += "<p><a href='/encender_recamara'>Encender Recamara</a> | <a href='/apagar_recamara'>Apagar Recamara</a></p>";
  html += "<p><a href='/encender_sanitario'>Encender Sanitario</a> | <a href='/apagar_sanitario'>Apagar Sanitario</a></p>";
  html += "<p><a href='/encender_cochera'>Encender Cochera</a> | <a href='/apagar_cochera'>Apagar Cochera</a></p>";
  html += "<p><a href='/encender_terraza'>Encender Terraza</a> | <a href='/apagar_terraza'>Apagar Terraza</a></p>";
  html += "<p><a href='/iniciar_extractor'>Iniciar Extractor</a> | <a href='/detener_extractor'>Detener Extractor</a></p>";
  html += "<p><a href='/abrir_garaje'>Abrir Garaje</a> | <a href='/cerrar_garaje'>Cerrar Garaje</a></p>";
  server.send(200, "text/html", html);
}

void handleNotFound() {
  server.send(404, "text/plain", "Comando no reconocido");
}
