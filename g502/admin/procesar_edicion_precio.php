<?php
// admin/procesar_edicion_precio.php - VERSIÓN CORREGIDA

require_once('seguridad_admin.php');
require_once('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: admin_productos.php');
    exit();
}

// 1. OBTENER Y SANEAR TODOS LOS DATOS
$id                 = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$ca                 = filter_input(INPUT_POST, 'ca', FILTER_SANITIZE_STRING);
$producto           = filter_input(INPUT_POST, 'producto', FILTER_SANITIZE_STRING);
$caracteristica     = filter_input(INPUT_POST, 'caracteristica', FILTER_SANITIZE_STRING);
$precio             = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
$cantidad           = filter_input(INPUT_POST, 'cantidad', FILTER_VALIDATE_INT);

// 🛑 CORRECCIÓN CLAVE: Usamos FILTER_SANITIZE_STRING. 
// Esto acepta rutas de archivos relativas (Donjorgitofinal/...) 
// sin considerarlas un error, lo que evita que se borre el valor.
$imagen             = filter_input(INPUT_POST, 'imagen', FILTER_SANITIZE_STRING); 
$es_tendencia       = filter_input(INPUT_POST, 'es_tendencia', FILTER_VALIDATE_INT);


// 2. VALIDACIÓN BÁSICA
if (
    $id === false || $id <= 0 || 
    $precio === false || $precio <= 0 ||
    $cantidad === false || $cantidad < 0 ||
    $es_tendencia === false || ($es_tendencia !== 0 && $es_tendencia !== 1) ||
    empty($ca) || empty($producto) || empty($caracteristica)
) {
    header('Location: admin_productos.php?status=error_validacion');
    exit();
}

// 3. CONSULTA DE ACTUALIZACIÓN MASIVA con Sentencias Preparadas
$query = "UPDATE donjorgito1 SET 
            ca = ?, 
            producto = ?, 
            caracteristica = ?, 
            precio = ?, 
            cantidad = ?, 
            imagen = ?, 
            es_tendencia = ? 
          WHERE id = ?";
$status = 'error'; 

if ($stmt = mysqli_prepare($conn, $query)) {
    // 4. VINCULAR PARÁMETROS: 
    // Tipos: sssdisii (s: string, d: double, i: integer)
    mysqli_stmt_bind_param($stmt, "sssdisii", 
        $ca, 
        $producto, 
        $caracteristica, 
        $precio, 
        $cantidad, 
        $imagen, // Se pasa el string de la ruta
        $es_tendencia,
        $id
    );

    if (mysqli_stmt_execute($stmt)) {
        $status = 'success';
    } else {
        // Usa error_log para depuración, pero evita mostrar errores al usuario final
        error_log("Error al actualizar el producto (ID: $id): " . mysqli_error($conn));
    }

    mysqli_stmt_close($stmt);

} else {
    error_log("Error al preparar la consulta: " . mysqli_error($conn));
}

mysqli_close($conn);
header("Location: admin_productos.php?status=$status");
exit();
?>