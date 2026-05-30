<?php
// Archivo: guardar_sesion_pago.php
session_start();
header('Content-Type: application/json');

// Leer los datos del POS (enviados como JSON)
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

if (isset($input['precio']) && $input['precio'] > 0) {
    // Guardamos en la sesión
    $_SESSION['pago_pendiente_monto'] = (int)$input['precio'];
    $_SESSION['pago_pendiente_cliente'] = $input['cliente'] ?? 'Cliente G502';
    
    echo json_encode(['status' => 'ok']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Monto inválido']);
}
?>