<?php
require_once '../config/db.php';

// SQL para vaciar la tabla por completo
$sql = "TRUNCATE TABLE historial_uso";

if (mysqli_query($conn, $sql)) {
    // Redirigir de vuelta con un mensaje de éxito
    header("Location: log?status=success");
} else {
    echo "Error al limpiar el historial: " . mysqli_error($conn);
}
exit();
?>