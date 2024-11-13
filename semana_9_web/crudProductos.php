<?php
include 'conexion.php';

// Función para crear un producto gourmet
function crearProducto($conexion, $nombre, $categoria, $descripcion, $fecha_agregado, $cantidad_disponible, $precio, $imagen_url) {
    $sql = "INSERT INTO productos_gourmet (nombre, categoria, descripcion, fecha_agregado, cantidad_disponible, precio, imagen_url)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssidsd", $nombre, $categoria, $descripcion, $fecha_agregado, $cantidad_disponible, $precio, $imagen_url);
    
    if ($stmt->execute()) {
        echo "Producto agregado correctamente.";
    } else {
        echo "Error al agregar el producto: " . $stmt->error;
    }
}

// Función para actualizar un producto gourmet
function actualizarProducto($conexion, $id_producto, $nombre, $categoria, $descripcion, $fecha_agregado, $cantidad_disponible, $precio, $imagen_url) {
    $sql = "UPDATE productos_gourmet SET nombre = ?, categoria = ?, descripcion = ?, fecha_agregado = ?, cantidad_disponible = ?, precio = ?, imagen_url = ?
            WHERE id_producto = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssidsdi", $nombre, $categoria, $descripcion, $fecha_agregado, $cantidad_disponible, $precio, $imagen_url, $id_producto);
    
    if ($stmt->execute()) {
        echo "Producto actualizado correctamente.";
    } else {
        echo "Error al actualizar el producto: " . $stmt->error;
    }
}

// Función para eliminar un producto gourmet
function eliminarProducto($conexion, $id_producto) {
    $sql = "DELETE FROM productos_gourmet WHERE id_producto = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_producto);
    
    if ($stmt->execute()) {
        echo "Producto eliminado correctamente.";
    } else {
        echo "Error al eliminar el producto: " . $stmt->error;
    }
}

// Función para obtener todos los productos gourmet
function obtenerTodosLosProductos($conexion) {
    $sql = "SELECT * FROM productos_gourmet";
    return $conexion->query($sql);
}

// Función para obtener productos específicos de un usuario
function obtenerProductosPorUsuario($conexion, $id_usuario) {
    $sql = "SELECT p.id_producto, p.nombre, pu.cantidad 
            FROM productos_gourmet p
            JOIN carrito pu ON p.id_producto = pu.id_producto
            WHERE pu.id_usuario = ?";
            
    $stmt = $conexion->prepare($sql);
    
    if (!$stmt) {
        die("Error al preparar la consulta SQL: " . $conexion->error);
    }
    
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    
    return $stmt->get_result();
}

function actualizarCantidadProducto($conexion, $id_producto, $id_usuario, $nueva_cantidad) {
    $sql = "UPDATE usuarios_productos SET cantidad = ? WHERE id_producto = ? AND id_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iii", $nueva_cantidad, $id_producto, $id_usuario);

    if ($stmt->execute()) {
        return true;
    } else {
        echo "Error al actualizar la cantidad: " . $stmt->error;
        return false;
    }
}

// Función para eliminar un producto de "Mis Productos" de un usuario específico
function eliminarProductoDeUsuario($conexion, $id_producto, $id_usuario) {
    $sql = "DELETE FROM usuarios_productos WHERE id_producto = ? AND id_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $id_producto, $id_usuario);

    if ($stmt->execute()) {
        return true;
    } else {
        echo "Error al eliminar el producto: " . $stmt->error;
        return false;
    }
}

?>
