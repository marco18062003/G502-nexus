<?php
// update_order_status.php - Lógica de backend para cambiar el estado del pedido

session_start();
header('Content-Type: application/json');

// 1. CONEXIÓN: Asume que db.php está un nivel arriba.
require_once '../config/db.php'; 

if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Error: No se pudo conectar a la base de datos.']);
    exit;
}

// 2. Obtener y validar datos JSON enviados por AJAX
$input = file_get_contents('php://input');
$data = json_decode($input, true);

$orderId = $data['order_id'] ?? null;
$newStatus = $data['new_status'] ?? null;
$validStatuses = ['pendiente', 'en_proceso', 'entregado', 'cancelado'];

// 3. Validación de datos
if (!$orderId || !$newStatus || !in_array($newStatus, $validStatuses)) {
    echo json_encode(['success' => false, 'message' => 'Parámetros inválidos (ID de pedido o estado no válido).']);
    mysqli_close($conn);
    exit;
}

// 4. Actualizar la base de datos (Usando la columna 'estado_pedido')
try {
    $stmt = mysqli_prepare($conn, "UPDATE pedidos SET estado_pedido = ? WHERE id = ?");
    
    if ($stmt === false) {
        throw new Exception("Error al preparar la consulta SQL. Puede que la tabla 'pedidos' no exista.");
    }

    mysqli_stmt_bind_param($stmt, "si", $newStatus, $orderId);
    
    if (mysqli_stmt_execute($stmt)) {
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo json_encode(['success' => true, 'message' => 'Estado actualizado.']);
        } else {
            echo json_encode(['success' => true, 'message' => 'No se encontró el pedido o el estado es el mismo.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al ejecutar la actualización: ' . mysqli_error($conn)]);
    }
    mysqli_stmt_close($stmt);
} catch (\Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error del servidor: ' . $e->getMessage()]);
}

mysqli_close($conn);
?>
