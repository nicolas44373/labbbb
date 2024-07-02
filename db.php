<?php
$servername = "localhost";
$username = "root";
$password = "";  // Cambia esto por tu contraseña de MySQL
$dbname = "mi_proyecto";
$port = 3307;  // Puerto actualizado, cámbialo si es necesario

$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verifica la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
