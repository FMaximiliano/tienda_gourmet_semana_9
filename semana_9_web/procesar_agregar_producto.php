<?php
session_start();
include 'conexion.php';

$id_producto = $_POST['id_producto'];
$cantidad = $_POST['cantidad'];
$id_usuario = $_SESSION['id_usuario'];

$sql_verificar_producto_gourmet = "SELECT * FROM productos_gourmet WHERE id_producto = ?";
$stmt_gourmet = $conexion->prepare($sql_verificar_producto_gourmet);

if (!$stmt_gourmet) {
    die("Error al preparar la consulta SQL en productos_gourmet: " . $conexion->error);
}

$stmt_gourmet->bind_param("i", $id_producto);
$stmt_gourmet->execute();
$resultado_gourmet = $stmt_gourmet->get_result();

if ($resultado_gourmet->num_rows > 0) {
    // El producto existe en productos_gourmet, verificar si ya está en productos
    $producto_gourmet = $resultado_gourmet->fetch_assoc();

    $sql_verificar_producto = "SELECT * FROM productos WHERE ID = ?";
    $stmt_producto = $conexion->prepare($sql_verificar_producto);

    if (!$stmt_producto) {
        die("Error al preparar la consulta SQL en productos: " . $conexion->error);
    }

    $stmt_producto->bind_param("i", $id_producto);
    $stmt_producto->execute();
    $resultado_producto = $stmt_producto->get_result();

    if ($resultado_producto->num_rows === 0) {
        // El producto no existe en 'productos', insertarlo
        $sql_insertar_producto = "INSERT INTO productos (ID, nombre, descripcion, categoria, precio, cantidad_en_inventario)
            VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_insertar = $conexion->prepare($sql_insertar_producto);

        if (!$stmt_insertar) {
            die("Error al preparar la consulta SQL al insertar en productos: " . $conexion->error);
        }

        $stmt_insertar->bind_param(
            "isssdi",
            $producto_gourmet['id_producto'],
            $producto_gourmet['nombre'],
            $producto_gourmet['descripcion'],
            $producto_gourmet['categoria'],
            $producto_gourmet['precio'],
            $producto_gourmet['cantidad_disponible']
        );
        $stmt_insertar->execute();
    }

    // Paso 2: Agregar el producto al carrito
    $sql_agregar_carrito = "INSERT INTO carrito (id_usuario, id_producto, cantidad, monto_total)
                            VALUES (?, ?, ?, ?)";
    $monto_total = $producto_gourmet['precio'] * $cantidad;
    $stmt_carrito = $conexion->prepare($sql_agregar_carrito);

    if (!$stmt_carrito) {
        die("Error al preparar la consulta SQL en carrito: " . $conexion->error);
    }

    $stmt_carrito->bind_param("iiid", $id_usuario, $id_producto, $cantidad, $monto_total);

    if ($stmt_carrito->execute()) {
        echo "Producto agregado al carrito correctamente.";
    } else {
        echo "Error al agregar el producto al carrito.";
    }
} else {
    echo "Error: Producto no encontrado.";
}
?>



