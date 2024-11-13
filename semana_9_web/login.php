<?php
session_start();
include 'conexion.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id_usuario, nombre, contraseña FROM usuarios WHERE email = ?";
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $usuario = $resultado->fetch_assoc();
            if (password_verify($password, $usuario['contraseña'])) {
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['nombre_usuario'] = $usuario['nombre'];
                header("Location: bienvenido.php");
                exit();
            } else {
                $error_login = "Contraseña incorrecta.";
            }
        } else {
            $error_login = "El usuario no existe.";
        }
        $stmt->close();
    } else {
        $error_login = "Error al preparar la consulta SQL.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="style_login.css">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <?php if (isset($error_login)) : ?>
            <p class="error"><?php echo $error_login; ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <input type="text" name="email" placeholder="Correo Electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Entrar</button>
        </form>
        <p>¿No tienes cuenta? <a href="index.php">Regístrate aquí</a></p>
    </div>
</body>
</html>
