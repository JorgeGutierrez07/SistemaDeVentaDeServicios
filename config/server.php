<?php
const DB_SERVER = "localhost";
const DB_NAME = "ventaservicios";
const DB_USER = "root";
const DB_PASS = '';

try {
    $conn = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Si la conexión es exitosa, envía un mensaje al navegador para que ejecute console.log()
    echo "<script>console.log('Conexión a la base de datos exitosa.');</script>";
} catch (PDOException $e) {
    // Si la conexión falla, envía un mensaje al navegador para que ejecute console.error()
    echo "<script>console.error('Error en la conexión: " . $e->getMessage() . "');</script>";
}
?>