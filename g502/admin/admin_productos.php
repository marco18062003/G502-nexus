<?php
// admin/admin_productos.php - VERSIÓN CON BUSCADOR
require_once('seguridad_admin.php'); 
require_once('../config/db.php');     

// 1. LÓGICA DE BÚSQUEDA
$busqueda = '';
$condicion_sql = '';

if (isset($_GET['buscar']) && !empty($_GET['buscar'])) {
    // Sanear el término de búsqueda
    $busqueda = mysqli_real_escape_string($conn, trim($_GET['buscar']));
    
    // Crear la condición WHERE para buscar en 3 campos
    // Usamos LIKE y % para buscar coincidencias parciales
    $condicion_sql = " WHERE 
        ca LIKE '%$busqueda%' OR 
        producto LIKE '%$busqueda%' OR 
        caracteristica LIKE '%$busqueda%'";
}

// 2. OBTENER PRODUCTOS (Aplicando la condición de búsqueda si existe)
$query = "SELECT id, ca, producto, caracteristica, precio, cantidad, imagen, es_tendencia 
          FROM donjorgito1" . $condicion_sql . " 
          ORDER BY producto ASC";
          
$resultado = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel G502 - Edición Completa con Buscador</title>
    <style>
        body { font-family: sans-serif; margin: 20px; background-color: #f4f7f6; }
        table { border-collapse: collapse; width: 98%; margin: 20px auto; background-color: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1); font-size: 0.9em;}
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #007bff; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        input[type="text"], input[type="number"], input[type="url"] { width: 95%; padding: 4px; border: 1px solid #ccc; border-radius: 3px; }
        input[type="number"] { width: 60px; }
        select { padding: 4px; border: 1px solid #ccc; border-radius: 3px; }
        button { padding: 8px 10px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; transition: background-color 0.3s; }
        .success, .error { padding: 10px; border-radius: 5px; margin: 10px auto; width: 98%; }
        .success { color: #155724; background-color: #d4edda; border: 1px solid #c3e6cb; }
        .error { color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; }
        .header { display: flex; justify-content: space-between; align-items: center; width: 98%; margin: auto; }
        h1 { color: #333; }
        .search-container { width: 98%; margin: 10px auto; padding: 15px; background-color: #e9ecef; border-radius: 5px;}
        .search-container input[type="text"] { width: 400px; }
        .search-container button { background-color: #007bff; }
        .search-container button:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
 
    <div class="header">
        <p><a href="index.php" style="color: var(--primary-color); text-decoration: none;"><i class="fas fa-arrow-left"></i> Volver al Dashboard</a></p>
        <h1>Gestión de Productos (Proyecto G502)</h1>
        <p>
            <span style="font-weight: bold;">Admin: </span><?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?> 
            | <a href="../publico1/logout.php" style="color: #dc3545; text-decoration: none;">Cerrar Sesión</a>
        </p>
    </div>

    <div class="search-container">
        <form method="GET" action="admin_productos.php">
            <input type="text" name="buscar" 
                   placeholder="Buscar por CA, Producto o Característica..." 
                   value="<?php echo $busqueda; ?>">
            <button type="submit">Buscar</button>
            <?php if (!empty($busqueda)): ?>
                <a href="admin_productos.php" style="margin-left: 10px; color: #dc3545;">Limpiar Búsqueda</a>
            <?php endif; ?>
        </form>
    </div>

    <?php
    // Mostrar mensaje de estado 
    if (isset($_GET['status'])) {
        $status = $_GET['status'];
        if ($status == 'success') {
            echo '<p class="success">✅ Producto actualizado con éxito.</p>';
        } elseif ($status == 'error') {
            echo '<p class="error">❌ Error al actualizar el producto. Revise los logs.</p>';
        } elseif ($status == 'error_validacion') {
            echo '<p class="error">❌ Error de validación: Datos inválidos enviados.</p>';
        }
    }

    if ($resultado && mysqli_num_rows($resultado) > 0) {
    ?>
        <table>
            <tr>
                <th>ID</th>
                <th>CA</th>
                <th>Producto</th>
                <th>Característica</th>
                <th>Precio (double)</th>
                <th>Cantidad (int)</th>
                <th>Imagen</th>
                <th>¿Tendencia? (0/1)</th>
                <th>Acción</th>
            </tr>
            <?php while ($item = mysqli_fetch_assoc($resultado)): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['id']); ?></td>
                
                <form action="procesar_edicion_precio.php" method="POST">
                    
                    <td><input type="text" name="ca" value="<?php echo htmlspecialchars($item['ca']); ?>" required></td>
                    <td><input type="text" name="producto" value="<?php echo htmlspecialchars($item['producto']); ?>" required></td>
                    <td><input type="text" name="caracteristica" value="<?php echo htmlspecialchars($item['caracteristica']); ?>" required></td>
                    
                    <td><input type="number" step="0.01" name="precio" value="<?php echo htmlspecialchars($item['precio']); ?>" min="0.01" required></td>
                    <td><input type="number" name="cantidad" value="<?php echo htmlspecialchars($item['cantidad']); ?>" min="0" required></td>
                    
                    <td><input type="text" name="imagen" value="<?php echo htmlspecialchars($item['imagen']); ?>" required ></td>
                    
                    <td>
                        <select name="es_tendencia">
                            <option value="1" <?php echo ($item['es_tendencia'] == 1) ? 'selected' : ''; ?>>Sí (1)</option>
                            <option value="0" <?php echo ($item['es_tendencia'] == 0) ? 'selected' : ''; ?>>No (0)</option>
                        </select>
                    </td>

                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>">

                    <td>
                        <button type="submit">Actualizar</button>
                    </td>
                </form>
            </tr>
            <?php endwhile; ?>
        </table>
        
        <?php 
        $num_resultados = mysqli_num_rows($resultado);
        echo "<p style='width: 98%; margin: 10px auto;'>Mostrando $num_resultados resultados" . (!empty($busqueda) ? " para la búsqueda: <b>" . htmlspecialchars($busqueda) . "</b>" : "") . ".</p>";
        
    } else {
        echo "<p style='width: 98%; margin: 20px auto;' class='error'>No se encontraron productos " . (!empty($busqueda) ? "que coincidan con la búsqueda: <b>" . htmlspecialchars($busqueda) . "</b>." : "en la base de datos.") . "</p>";
    }
    mysqli_close($conn); 
    ?>
</body>
</html>