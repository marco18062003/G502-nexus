<?php
session_start();
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = mysqli_real_escape_string($conn, $_POST['nombre_usuario']);
    $full = mysqli_real_escape_string($conn, $_POST['nombre_completo']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $tel = mysqli_real_escape_string($conn, $_POST['telefono']);
    $ciu = mysqli_real_escape_string($conn, $_POST['ciudad']);
    $rol = mysqli_real_escape_string($conn, $_POST['rol']);
    
    // Encriptamos la contraseña
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre_usuario, nombre_completo, email, telefono, ciudad, password, rol, estado_cuenta) 
            VALUES ('$user', '$full', '$email', '$tel', '$ciu', '$pass', '$rol', 'activo')";

    if (mysqli_query($conn, $sql)) {
        header("Location: clientes.php?success=1");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
