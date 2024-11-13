<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido a la Tienda Gourmet</title>
    <link rel="stylesheet" href="style_bienvenido.css">
</head>
<body>
    <header>
        <h1>Bienvenido a la Tienda Gourmet</h1>
        <p>Selecciona una opción para explorar nuestros productos exclusivos</p>
    </header>

    <div class="container">
        <div class="welcome-message">
            <h2>¡Hola, <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?>!</h2>
            <p>Has iniciado sesión correctamente.</p>
        </div>

        <div class="nav-buttons">
            <a href="catalogo_gourmet.php">Catálogo de Productos Gourmet</a>
            <a href="mis_productos.php">Mis Productos</a>
        </div>

        <div class="logout-link">
            <a href="logout.php">Cerrar sesión</a>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Tienda Gourmet. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
