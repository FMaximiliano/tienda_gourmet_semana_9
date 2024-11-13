<?php
session_start();
include 'conexion.php';
include 'crudProductos.php';

$id_usuario = $_SESSION['id_usuario'];
$productos = obtenerProductosPorUsuario($conexion, $id_usuario);

if (isset($_POST['eliminar'])) {
    $id_producto = $_POST['id_producto'];
    eliminarProducto($conexion, $id_producto);
    header("Location: gestion_productos.php");
    exit();
}

if (isset($_POST['actualizar'])) {
    $id_producto = $_POST['id_producto'];
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $descripcion = $_POST['descripcion'];
    $fecha_agregado = $_POST['fecha_agregado'];
    $cantidad_disponible = $_POST['cantidad_disponible'];
    $precio = $_POST['precio'];
    actualizarProducto($conexion, $id_producto, $nombre, $categoria, $descripcion, $fecha_agregado, $cantidad_disponible, $precio, $imagen_url);
    header("Location: gestion_productos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos Gourmet</title>
    <link rel="stylesheet" href="style_gourmet.css">
</head>
<body>
    <h1>Mis Productos Gourmet</h1>
    <ul>
        <?php while ($producto = $productos->fetch_assoc()) : ?>
            <li>
                <form method="POST" action="">
                    <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
                    <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>">
                    <input type="text" name="categoria" value="<?php echo htmlspecialchars($producto['categoria']); ?>">
                    <textarea name="descripcion"><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
                    <input type="date" name="fecha_agregado" value="<?php echo $producto['fecha_agregado']; ?>">
                    <input type="number" name="cantidad_disponible" value="<?php echo $producto['cantidad_disponible']; ?>">
                    <input type="number" step="0.01" name="precio" value="<?php echo $producto['precio']; ?>">
                    <button type="submit" name="actualizar">Actualizar</button>
                    <button type="submit" name="eliminar">Eliminar</button>
                </form>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
