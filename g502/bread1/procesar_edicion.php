<?php
require_once('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    
    // 1. LIMPIEZA DE DATOS
    $codigo      = mysqli_real_escape_string($conn, $_POST['codigo']);
    $nombre      = mysqli_real_escape_string($conn, $_POST['nombre']);
    $descripcion = mysqli_real_escape_string($conn, $_POST['description']);
    $categoria   = mysqli_real_escape_string($conn, $_POST['categoria']);
    $precio      = mysqli_real_escape_string($conn, $_POST['precio']);
    $nombre_imagen = mysqli_real_escape_string($conn, $_POST['imagen_actual']);

    // 2. MANEJO DE LA IMAGEN (Ruta corregida a assets/img/)
    if (isset($_FILES['foto_subida']) && $_FILES['foto_subida']['error'] == 0) {
        
        // USAMOS LA MISMA RUTA QUE EN "AGREGAR"
        $ruta_destino = "assets/img/"; 
        
        if (!is_dir($ruta_destino)) {
            mkdir($ruta_destino, 0777, true);
        }

        // Forzamos extensión en minúsculas para evitar errores de lectura
        $ext = strtolower(pathinfo($_FILES['foto_subida']['name'], PATHINFO_EXTENSION));
        
        // Nombre consistente con tu proyecto
        $nuevo_nombre = $codigo . "_" . time() . "." . $ext;
        
        if (move_uploaded_file($_FILES['foto_subida']['tmp_name'], $ruta_destino . $nuevo_nombre)) {
            $nombre_imagen = $nuevo_nombre;
            
            // Borramos la imagen anterior si existe para no acumular basura
            if (!empty($_POST['imagen_actual']) && file_exists($ruta_destino . $_POST['imagen_actual'])) {
                @unlink($ruta_destino . $_POST['imagen_actual']);
            }
        }
    }

    // 3. ACTUALIZACIÓN
    $query = "UPDATE panaderia SET 
                codigo = '$codigo', 
                nombre = '$nombre', 
                descripcion = '$descripcion', 
                categoria = '$categoria', 
                precio = '$precio', 
                imagen = '$nombre_imagen' 
              WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        header("Location: gestion_productos.php?status=success");
    } else {
        header("Location: gestion_productos.php?status=error");
    }
}
exit();
?>