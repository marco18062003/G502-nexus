<?php
session_start();

// EL MURO DE SEGURIDAD
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: adminlogin.php");
    exit();
}

require_once '../config/db.php'; 

$producto = [
    'id' => null, 
    'nombre' => '', 
    'descripcion' => '', 
    'precio' => '', 
    'stock' => '', 
    'imagen_url' => ''
];
$is_new = false;
$error_message = '';
$success_message = '';

// Determinar si es Edición o Creación
if (isset($_GET['id']) && $_GET['id'] !== 'new') {
    $id = intval($_GET['id']);
    
    // 1. Obtener datos del producto existente
    if ($stmt = mysqli_prepare($conn, "SELECT id, nombre, descripcion, precio, stock, imagen_url FROM productos WHERE id = ?")) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($resultado) == 1) {
            $producto = mysqli_fetch_assoc($resultado);
        } else {
            $error_message = "Producto no encontrado.";
            $id = null;
        }
        mysqli_stmt_close($stmt);
    } else {
        $error_message = "Error en la preparación de la consulta de obtención.";
    }
} elseif (isset($_GET['id']) && $_GET['id'] === 'new') {
    $is_new = true;
}

// 2. Manejar el envío del formulario (Guardar/Actualizar)
if ($_SERVER["REQUEST_METHOD"] == "POST" && $id !== null || ($is_new && $_SERVER["REQUEST_METHOD"] == "POST")) {
    
    // Sanear y validar la entrada
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio = filter_var($_POST['precio'], FILTER_VALIDATE_FLOAT);
    $stock = filter_var($_POST['stock'], FILTER_VALIDATE_INT);
    $imagen_url = trim($_POST['imagen_url']);

    if ($precio === false || $stock === false) {
        $error_message = "El precio y el stock deben ser números válidos.";
    } elseif (empty($nombre) || $precio <= 0) {
        $error_message = "El nombre y el precio son obligatorios.";
    } else {
        // 3. Crear o Actualizar
        if ($is_new) {
            // CREAR NUEVO PRODUCTO (Insert)
            $sql = "INSERT INTO productos (nombre, descripcion, precio, stock, imagen_url) VALUES (?, ?, ?, ?, ?)";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssdss", $nombre, $descripcion, $precio, $stock, $imagen_url);
                if (mysqli_stmt_execute($stmt)) {
                    $success_message = "¡Producto **" . htmlspecialchars($nombre) . "** creado con éxito!";
                    // Redirigir para evitar resubmission
                    header("Refresh: 2; URL=gestionar_productos.php"); 
                } else {
                    $error_message = "ERROR al crear producto: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
            }
        } else {
            // ACTUALIZAR PRODUCTO EXISTENTE (Update)
            $sql = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, stock = ?, imagen_url = ? WHERE id = ?";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssdsii", $nombre, $descripcion, $precio, $stock, $imagen_url, $id);
                if (mysqli_stmt_execute($stmt)) {
                    $success_message = "¡Producto **" . htmlspecialchars($nombre) . "** actualizado con éxito!";
                    // Recargar datos para mostrar el cambio en el formulario
                    // Nota: En un sistema real, se debería volver a cargar la variable $producto aquí.
                } else {
                    $error_message = "ERROR al actualizar producto: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
            }
        }
    }
    
    // Si hubo un error o éxito, recargar las variables del formulario POST en la variable $producto 
    // para que el usuario no pierda lo que escribió.
    $producto['nombre'] = $nombre;
    $producto['descripcion'] = $descripcion;
    $producto['precio'] = $precio;
    $producto['stock'] = $stock;
    $producto['imagen_url'] = $imagen_url;
}

// mysqli_close($conn); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $is_new ? 'Crear Nuevo Producto' : 'Editar Producto'; ?> | g502 Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4"><?php echo $is_new ? 'Crear Nuevo Producto' : 'Editar Producto ID ' . htmlspecialchars($producto['id']); ?></h1>
        
        <a href="gestionar_productos.php" class="btn btn-secondary mb-4">← Volver al Listado</a>

        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form method="POST" action="editar_producto.php?id=<?php echo $is_new ? 'new' : htmlspecialchars($producto['id']); ?>">
            
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Producto *</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required 
                       value="<?php echo htmlspecialchars($producto['nombre']); ?>">
            </div>
            
            <div class="mb-3">
                <label for="precio" class="form-label">Precio (€/$) *</label>
                <input type="number" step="0.01" class="form-control" id="precio" name="precio" required 
                       value="<?php echo htmlspecialchars($producto['precio']); ?>">
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stock (Cantidad)</label>
                <input type="number" class="form-control" id="stock" name="stock" required 
                       value="<?php echo htmlspecialchars($producto['stock']); ?>">
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
            </div>
            
            <div class="mb-3">
                <label for="imagen_url" class="form-label">URL de la Imagen</label>
                <input type="text" class="form-control" id="imagen_url" name="imagen_url" 
                       value="<?php echo htmlspecialchars($producto['imagen_url']); ?>">
                <?php if (!empty($producto['imagen_url'])): ?>
                    <img src="<?php echo htmlspecialchars($producto['imagen_url']); ?>" alt="Vista previa" class="img-thumbnail mt-2" style="max-width: 150px;">
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">
                <?php echo $is_new ? 'Crear Producto' : 'Guardar Cambios'; ?>
            </button>
        </form>
    </div>
</body>
</html>