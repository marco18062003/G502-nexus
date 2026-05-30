<?php
session_start();
require_once '../config/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Aseguramos que sea un número

    $query = "DELETE FROM usuarios WHERE id = $id";
    
    if (mysqli_query($conn, $query)) {
        header("Location: clientes.php?msg=eliminado");
    } else {
        die("Error al eliminar: " . mysqli_error($conn));
    }
} else {
    header("Location: clientes.php");
}
?>