<?php
// admin/eliminar_producto.php

require_once('../config/db.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Ejecutamos la eliminación en la tabla panaderia
    $query = "DELETE FROM panaderia WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        header("Location: gestion_productos.php?status=deleted");
    } else {
        header("Location: gestion_productos.php?status=error");
    }
} else {
    header("Location: gestion_productos.php");
}
exit();
?>