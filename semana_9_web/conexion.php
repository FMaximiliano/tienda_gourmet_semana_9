<?php
$servidor = "localhost";  
$usuario = "root";        
$contraseña = "";         
$bd = "GOURMET"; // Nombre de la BD

$conexion = new mysqli($servidor, $usuario, $contraseña, $bd);

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}
?>
