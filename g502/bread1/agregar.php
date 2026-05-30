<?php
// 1. Manejo de errores (útil en desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../config/db.php';

// 2. Verificamos datos obligatorios
if (isset($_POST['codigo'], $_POST['nombre'], $_POST['categoria'])) {
    
    // Limpieza de datos
    $codigo    = mysqli_real_escape_string($conn, trim($_POST['codigo']));
    $nombre    = mysqli_real_escape_string($conn, trim($_POST['nombre']));
    $desc      = mysqli_real_escape_string($conn, $_POST['descripcion'] ?? '');
    $categoria = mysqli_real_escape_string($conn, trim($_POST['categoria']));
    $precio    = intval($_POST['precio'] ?? 0);
    
    $nombre_imagen = ""; 

    // 3. Procesamiento de la Imagen
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $permitidos = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($ext, $permitidos)) {
            // Renombramos la imagen con el código para que sea única
            $nombre_imagen = $codigo . "." . $ext;
            $directorio = "assets/img/";
            
            if (!is_dir($directorio)) {
                mkdir($directorio, 0777, true);
            }

            $ruta_final = $directorio . $nombre_imagen;
            
            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $ruta_final)) {
                $nombre_imagen = ""; // Reset si falló la subida
                echo "Error: No se pudo mover el archivo a $directorio. <br>";
            }
        } else {
            echo "Error: Formato de imagen no permitido (solo JPG, PNG, WEBP). <br>";
        }
    }

    // 4. Inserción en la Base de Datos (Corregida la variable y comillas)
    // Nota: El campo 'id' no se pone si es AUTO_INCREMENT
    $sql = "INSERT INTO panaderia (codigo, nombre, descripcion, imagen, precio, categoria) 
            VALUES ('$codigo', '$nombre', '$desc', '$nombre_imagen', $precio, '$categoria')";
    
    if (mysqli_query($conn, $sql)) {
        echo "ÉXITO: Producto [$nombre] con PLU [$codigo] guardado correctamente.";
    } else {
        // Manejo de error por duplicado (si el código es PRIMARY KEY o UNIQUE)
        if (mysqli_errno($conn) == 1062) {
            echo "ERROR: El código (PLU) $codigo ya existe en la base de datos.";
        } else {
            echo "Error en g502: " . mysqli_error($conn);
        }
    }
} else {
    echo "Error: Datos incompletos.";
}
?>