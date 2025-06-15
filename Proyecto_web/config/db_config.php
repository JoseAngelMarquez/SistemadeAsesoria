<?php
//Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "JAME060503";
$dbname = "AsesoriasDB";

$conexion = new mysqli($servername, $username, $password, $dbname);

if ($conexion->connect_error){
    die("Error al conectarse a la base de datos" . $conexion->connect_error);
}
?>