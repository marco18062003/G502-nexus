<?php
// Archivo: /g502/admin/webhook_wompi.php
include '../config/db.php';

// 1. Recibimos la notificación
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Registro para auditoría (Muy útil para ver qué pasó si algo falla)
if ($json) {
    file_put_contents('log_wompi.txt', "[" . date("Y-m-d H:i:s") . "] " . $json . "\n", FILE_APPEND);
}

// 2. Verificamos que sea una actualización de transacción
if (isset($data['event']) && $data['event'] == 'transaction.updated') {
    $transaction = $data['data']['transaction'];
    $id_venta    = $transaction['reference']; 
    $estado      = $transaction['status'];    
    $wompi_id    = $transaction['id'];
    $metodo      = $transaction['payment_method_type']; // Guarda si fue NEQUI, CARD, etc.

    if ($estado == 'APPROVED') {
        // 3. ¡EL PAGO ES REAL! Actualizamos la tabla wompi1
        $id_venta_db = mysqli_real_escape_string($conn, $id_venta);
        $wompi_id_db = mysqli_real_escape_string($conn, $wompi_id);
        $metodo_db   = mysqli_real_escape_string($conn, $metodo);

        // CAMBIO AQUÍ: Ahora apunta a la tabla 'wompi1'
        $sql = "UPDATE wompi1 SET 
                estado_pago = 'PAGADO', 
                metodo_pago = '$metodo_db',
                transaccion_id = '$wompi_id_db',
                fecha_pago = NOW() 
                WHERE referencia_unica = '$id_venta_db'";
        
        mysqli_query($conn, $sql);
    }
}

// 4. Responder siempre 200 OK para que Wompi no repita el envío
http_response_code(200);
?>