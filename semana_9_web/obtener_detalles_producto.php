<?php
include 'conexion.php';

if (isset($_GET['id_producto'])) {
    $id_producto = $_GET['id_producto'];

    // Prepara la consulta para obtener los detalles del producto
    $sql = "SELECT * FROM productos_gourmet WHERE id_producto = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $producto = $resultado->fetch_assoc();

    if ($producto) {
        echo "<h2>" . htmlspecialchars($producto['nombre']) . "</h2>";
        echo "<p><strong>Categoría:</strong> " . htmlspecialchars($producto['categoria']) . "</p>";
        echo "<p><strong>Descripción:</strong> " . htmlspecialchars($producto['descripcion']) . "</p>";
        echo "<p><strong>Fecha Agregado:</strong> " . htmlspecialchars($producto['fecha_agregado']) . "</p>";
        echo "<p><strong>Cantidad Disponible:</strong> " . htmlspecialchars($producto['cantidad_disponible']) . "</p>";
        echo "<p><strong>Precio:</strong> $" . htmlspecialchars($producto['precio']) . "</p>";
        
        
        if (!empty($producto['imagen_url'])) {
            echo "<img src='" . htmlspecialchars($producto['imagen_url']) . "' alt='" . htmlspecialchars($producto['nombre']) . "' style='width:100%; height:auto;'>";
        }
    } else {
        echo "<p>Producto no encontrado.</p>";
    }
} else {
    echo "<p>ID de producto no especificado.</p>";
}
?>

