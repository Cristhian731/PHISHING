<?php
// Datos de conexión
$servername = "localhost";
$username = "root";       // Idealmente usar un usuario distinto a root
$password = "admin123";   // Tu clave MySQL
$dbname = "phishguard";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Forzar UTF-8 para evitar problemas con acentos y caracteres especiales
$conn->set_charset("utf8");
?>