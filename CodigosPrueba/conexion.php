<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pruebas";

// Creamos la conexion
$con = new mysqli($servername, $username, $password, $dbname);
// Validamos la conexion
if ($con->connect_error) {
    die("Error de Conexion: " . $con->connect_error);
} 

?> 