<?php
session_start();
include 'conexion.php';
include 'crudProductos.php';

$productos = obtenerTodosLosProductos($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos Gourmet</title>
    <link rel="stylesheet" href="style_gourmet.css">
</head>
<body>
    <h1>Catálogo de Productos Gourmet</h1>
    <a href="bienvenido.php">Volver al menú</a>

    <ul>
        <?php while ($producto = $productos->fetch_assoc()) : ?>
            <li>
                <strong><?php echo $producto['nombre']; ?></strong><br>
                Categoría: <?php echo $producto['categoria']; ?><br>
                Precio: $<?php echo $producto['precio']; ?><br>
                Cantidad Disponible: <?php echo $producto['cantidad_disponible']; ?><br>
                <form action="procesar_agregar_producto.php" method="post">
                        <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
                        <label for="cantidad">Cantidad:</label>
                        <select name="cantidad" id="cantidad">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
        <!-- Agrega más opciones según sea necesario -->
                    </select>
                    <button type="submit">Agregar al Carrito</button>
                </form>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>




