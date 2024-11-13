<?php
session_start();
include 'conexion.php'; // Conexión a la base de datos

// Procesar el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Consulta SQL 
    $sql = "SELECT ID, nombre, contraseña FROM usuarios WHERE email = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $usuario['contraseña'])) {
            // Iniciar la sesión del usuario con 'ID'
            $_SESSION['id_usuario'] = $usuario['ID'];
            $_SESSION['nombre_usuario'] = $usuario['nombre'];
            
            // Redirigir a la página de bienvenida
            header("Location: bienvenido.php");
            exit();
        } else {
            $error_login = "Contraseña incorrecta.";
        }
    } else {
        $error_login = "El usuario no existe.";
    }
}

// Procesar el formulario de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, email, contraseña) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sss", $nombre, $email, $password_hashed);
    if ($stmt->execute()) {
        $success_register = "Registro exitoso. Inicia sesión para continuar.";
    } else {
        $error_register = "Error al registrarse.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda Gourmet - Bienvenido</title>
    <link rel="stylesheet" href="style_gourmet.css">
</head>
<body>
    <header>
        <h1>Tienda Gourmet de Alimentos</h1>
        <p>Bienvenido a nuestra selección de productos gourmet exclusivos.</p>
    </header>

    <main>
        <div class="intro">
            <button onclick="mostrarLogin()">Iniciar Sesión</button>
            <button onclick="mostrarRegistro()">Registrarse</button>
        </div>

        <?php if (isset($error_login)) echo "<p class='error'>$error_login</p>"; ?>
        <?php if (isset($success_register)) echo "<p class='success'>$success_register</p>"; ?>
        <?php if (isset($error_register)) echo "<p class='error'>$error_register</p>"; ?>

        <!-- Formulario de inicio de sesión -->
        <div id="loginModal" class="modal">
            <div class="modal-content">
                <span onclick="cerrarModal('loginModal')" class="close">&times;</span>
                <h2>Iniciar Sesión</h2>
                <form action="index.php" method="post">
                    <input type="hidden" name="login">
                    <label for="email">Correo electrónico:</label>
                    <input type="email" name="email" required>
                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" required>
                    <button type="submit">Iniciar Sesión</button>
                </form>
            </div>
        </div>

        <!-- Formulario de registro -->
        <div id="registerModal" class="modal">
            <div class="modal-content">
                <span onclick="cerrarModal('registerModal')" class="close">&times;</span>
                <h2>Registrarse</h2>
                <form action="index.php" method="post">
                    <input type="hidden" name="register">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" required>
                    <label for="email">Correo electrónico:</label>
                    <input type="email" name="email" required>
                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" required>
                    <button type="submit">Registrarse</button>
                </form>
            </div>
        </div>
    </main>

    <script>
        function mostrarLogin() {
            document.getElementById('loginModal').style.display = 'block';
        }

        function mostrarRegistro() {
            document.getElementById('registerModal').style.display = 'block';
        }

        function cerrarModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        



        document.getElementById("password").addEventListener("input", function () {
    const password = this.value;
    const mensaje = document.getElementById("passwordMessage");
    if (password.length >= 8) {
        mensaje.textContent = "Contraseña segura.";
        mensaje.style.color = "green";
    } else {
        mensaje.textContent = "La contraseña debe tener al menos 8 caracteres.";
        mensaje.style.color = "red";
    }
});
    </script>
</body>
</html>