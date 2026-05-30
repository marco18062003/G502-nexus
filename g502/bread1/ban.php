<?php
require_once('../admin/seguridad_admin.php');
require_once '../config/db.php';

if (isset($_GET['uid'])) {
    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    
    // IMPORTANTE: Verifica que el nombre de la tabla sea 'usuarios_baneados'
    $sql = "INSERT IGNORE INTO usuarios_baneados_pan (usuario_id) VALUES ('$uid')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: log.php?status=success");
        exit(); // Siempre usa exit después de un header
    } else {
        echo "Error en la base de datos: " . mysqli_error($conn);
    }
} else {
    echo "No se recibió el ID del usuario.";
}
?>