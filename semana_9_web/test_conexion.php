<?php
include 'conexion.php'; // test de conexion con la BD

if (isset($conexion) && $conexion->ping()) {
    echo "Conexión establecida correctamente con la base de datos.";
} else {
    echo "Error en la conexión: " . ($conexion ? $conexion->connect_error : "No se pudo crear la conexión.");
}
?>



