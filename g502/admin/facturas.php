<?php
session_start();
require_once '../config/db.php'; // Aquí ya viene definida tu variable $conn

header('Content-Type: application/json');

// Recibimos la información del JSON enviado por JS
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || empty($data['productos'])) {
    echo json_encode(['status' => 'error', 'message' => 'El carrito está vacío']);
    exit;
}

// 1. Iniciar Transacción en MySQLi
mysqli_begin_transaction($conn);

try {
    // Datos de la factura_base
    $numeroFactura = "FAC-" . strtoupper(substr(uniqid(), -5));
    $cajeroId = $_SESSION['user_id'] ?? 1;
    $clienteId = 1;
    $subtotal = $data['total'];
    $impuestos = 0;
    $total = $data['total'];
    $metodo_pago = $data['metodo_pago'];
    $cambio = $data['cambio'];
    $estado = 'Completada';

    // 2. Insertar en factura_base
    $sqlBase = "INSERT INTO factura_base (numero_factura, fecha_venta, cliente_id, cajero_id, subtotal, impuestos, total, metodo_pago, estado, cambio) 
                VALUES (?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmtBase = mysqli_prepare($conn, $sqlBase);
    mysqli_stmt_bind_param($stmtBase, "siidddsss", $numeroFactura, $clienteId, $cajeroId, $subtotal, $impuestos, $total, $metodo_pago, $estado, $cambio);
    
    if (!mysqli_stmt_execute($stmtBase)) {
        throw new Exception("Error en factura_base: " . mysqli_error($conn));
    }

    $ventaId = mysqli_insert_id($conn); // Obtenemos el ID generado

    // 3. Insertar en factura (detalle)
    $sqlDetalle = "INSERT INTO factura (venta_id, producto_id, nombre_producto, precio_unidad, cantidad, subtotal_item) 
                   VALUES (?, ?, ?, ?, ?, ?)";
    $stmtDetalle = mysqli_prepare($conn, $sqlDetalle);

    foreach ($data['productos'] as $prod) {
        $subtotalItem = $prod['precio'] * $prod['cantidad'];
        mysqli_stmt_bind_param($stmtDetalle, "iisdid", $ventaId, $prod['id'], $prod['nombre'], $prod['precio'], $prod['cantidad'], $subtotalItem);
        
        if (!mysqli_stmt_execute($stmtDetalle)) {
            throw new Exception("Error en detalle de factura: " . mysqli_error($conn));
        }
    }

    // Si todo salió bien, guardamos cambios
    mysqli_commit($conn);
    echo json_encode(['status' => 'success', 'numero_factura' => $numeroFactura]);

} catch (Exception $e) {
    // Si algo falló, deshacemos todo para evitar descuadres
    mysqli_rollback($conn);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

mysqli_close($conn); // Cerramos la conexión al final
?>