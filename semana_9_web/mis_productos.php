<?php
session_start();
include 'conexion.php';

$id_usuario = $_SESSION['id_usuario'];
$sql = "SELECT c.cantidad, c.monto_total, p.nombre, p.categoria, p.precio 
        FROM carrito c 
        INNER JOIN productos_gourmet p ON c.id_producto = p.id_producto 
        WHERE c.id_usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Productos</title>
    <link rel="stylesheet" href="style_bienvenido.css">
</head>
<body>
    <h1>Mis Productos</h1>
    <a href="catalogo_gourmet.php">Seguir comprando</a>
    <ul>
        <?php while ($producto = $resultado->fetch_assoc()) : ?>
            <li>
                <strong><?php echo $producto['nombre']; ?></strong><br>
                Categoría: <?php echo $producto['categoria']; ?><br>
                Precio Unitario: $<?php echo $producto['precio']; ?><br>
                Cantidad: <?php echo $producto['cantidad']; ?><br>
                Monto Total: $<?php echo $producto['monto_total']; ?><br>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>