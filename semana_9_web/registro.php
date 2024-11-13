<?php
include 'conexion.php'; // establece la conexión a la BD

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura los datos enviados
    $nombre = $_POST['nombre'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    // Verifica que todos los campos tienen valores
    if ($nombre && $email && $password) {
        // Encripta la contraseña antes de guardarla
        $password_encriptada = password_hash($password, PASSWORD_DEFAULT);

        // Inserta en la BD el nuevo usuario
        $sql = "INSERT INTO usuarios (nombre, email, contraseña, direccion, telefono) VALUES (?, ?, ?, '', '')";
        $stmt = $conexion->prepare($sql);

        // Verificar si la preparación fue exitosa
        if ($stmt === false) {
            die("Error en la consulta SQL: " . $conexion->error);
        }

        $stmt->bind_param("sss", $nombre, $email, $password_encriptada);

        // Ejecuta la consulta y verifica el resultado
        if ($stmt->execute()) {
            echo "Registro exitoso. Ahora puedes iniciar sesión.";
            header("Location: index.php"); // Redirige a la página de inicio
            exit();
        } else {
            echo "Error al registrar el usuario: " . $stmt->error;
        }
    } else {
        echo "Por favor, completa todos los campos.";
    }
} else {
    echo "Método de solicitud no válido.";
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
</head>
<body>
    <h2>Registro</h2>
    <form method="POST" action="registro.php">
        <input type="text" name="nombre" placeholder="Nombre completo" required>
        <input type="email" name="email" placeholder="Correo Electrónico" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Registrarse</button>
    </form>
</body>
</html>
