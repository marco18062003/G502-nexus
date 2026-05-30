<?php
session_start();

// EL MURO DE SEGURIDAD
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: adminlogin.php");
    exit();
}

// Incluir la conexión a la base de datos (usando $conn, estilo procedural)
require_once '../config/db.php'; 

$productos = [];
$error_message = '';

// 1. Obtener todos los productos de la base de datos
$sql = "SELECT id, nombre, precio, stock, imagen_url FROM productos ORDER BY id DESC";

if ($resultado = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($resultado) > 0) {
        // Almacenar todos los productos en un array
        while($fila = mysqli_fetch_assoc($resultado)){
            $productos[] = $fila;
        }
        mysqli_free_result($resultado); // Liberar memoria
    } else {
        $error_message = "No hay productos registrados en la base de datos.";
    }
} else {
    $error_message = "ERROR: No se pudo ejecutar $sql. " . mysqli_error($conn);
}

// Dejamos la conexión abierta si necesitas otros scripts, o puedes cerrarla aquí:
// mysqli_close($conn); 

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Productos | g502 Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Gestionar Productos y Precios</h1>
        <p>Aquí puedes modificar los precios, stocks y datos de los productos de **g502**.</p>
        
        <a href="index.php" class="btn btn-secondary mb-3">← Volver al Dashboard</a>
        <a href="editar_producto.php?id=new" class="btn btn-success mb-3">✚ Añadir Nuevo Producto</a>

        <?php if (!empty($error_message)): ?>
            <div class="alert alert-warning"><?php echo htmlspecialchars($error_message); ?></div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($producto['id']); ?></td>
                                <td><img src="<?php echo htmlspecialchars($producto['imagen_url']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" style="width: 50px; height: 50px; object-fit: cover;"></td>
                                <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                                <td>$<?php echo number_format($producto['precio'], 2); ?></td>
                                <td><?php echo htmlspecialchars($producto['stock']); ?></td>
                                <td>
                                    <a href="editar_producto.php?id=<?php echo $producto['id']; ?>" class="btn btn-sm btn-primary">Editar</a>
                                    <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?php echo $producto['id']; ?>)">Eliminar</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
    
    <script>
    function confirmDelete(id) {
        if (confirm("¿Estás seguro de que quieres eliminar el producto con ID " + id + "? Esta acción no se puede deshacer.")) {
            // Aquí iría una solicitud AJAX o una redirección a un script de eliminación
            window.location.href = 'eliminar_producto.php?id=' + id; 
        }
    }
    </script>
</body>
</html>