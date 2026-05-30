<?php
require_once('../admin/seguridad_admin.php');
require_once('../config/db.php'); 

$busqueda = isset($_GET['buscar']) ? mysqli_real_escape_string($conn, $_GET['buscar']) : '';
$where = $busqueda ? "WHERE nombre LIKE '%$busqueda%' OR codigo LIKE '%$busqueda%'" : "";

$query = "SELECT * FROM panaderia $where ORDER BY nombre ASC";
$resultado = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>g502 | Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --success: #10b981;
            --danger: #ef4444;
            --bg: #f8fafc;
            --text: #1e293b;
        }

        body { font-family: 'Inter', sans-serif; background-color: var(--bg); color: var(--text); margin: 0; padding: 10px; }
        .container { max-width: 1400px; margin: 0 auto; padding-top: 75px; } 

        .mobile-nav-bar {
            position: fixed; top: 0; left: 0; right: 0;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            z-index: 1000; padding: 8px 15px;
        }

        .nav-group { max-width: 600px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; gap: 10px; }
        .nav-item { display: flex; flex-direction: column; align-items: center; background: transparent; border: none; cursor: pointer; flex: 1; padding: 5px; border-radius: 12px; }
        .nav-icon { font-size: 1.2rem; }
        .nav-text { font-size: 0.65rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin-top: 2px; }
        .nav-item.highlight { background: var(--primary); box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); }
        .nav-item.highlight .nav-text, .nav-item.highlight .nav-icon { color: white; }

        .header { background: white; padding: 20px; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .search-box { display: flex; gap: 8px; }
        .search-box input { flex: 1; padding: 10px; border: 1px solid #e2e8f0; border-radius: 10px; }

        .table-container { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; }
        
        /* --- MÓVIL (CARD DESIGN) --- */
        thead { display: none; } /* Escondemos cabecera en móvil */
        tr { 
            display: block; 
            border-bottom: 3px solid #f1f5f9; 
            padding: 15px; 
            margin-bottom: 5px;
        }
        td { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding: 8px 0; 
        }
        td::before { 
            content: attr(data-label); 
            font-weight: 700; 
            font-size: 0.7rem; 
            color: #64748b; 
            text-transform: uppercase; 
        }
        input, select, textarea { width: 60%; padding: 8px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.9rem; }

        /* --- PC (EXCEL LOOK) --- */
        @media (min-width: 768px) {
            thead { display: table-header-group; }
            th { background: #f1f5f9; padding: 15px; text-align: left; font-size: 0.75rem; color: #64748b; text-transform: uppercase; }
            tr { display: table-row; }
            td { display: table-cell; padding: 12px 15px; border-bottom: 1px solid #f1f5f9; }
            td::before { display: none; }
            input, select, textarea { width: 100%; }
        }

        .btn-save { background: var(--success); color: white; border: none; padding: 10px 15px; border-radius: 8px; font-weight: 600; cursor: pointer; }
        .btn-delete { background: #fee2e2; color: var(--danger); padding: 10px 15px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.85rem; }
        
        .status-msg { padding: 15px; border-radius: 12px; margin-bottom: 20px; text-align: center; font-weight: 600; }
        .success { background: #dcfce7; color: #166534; }
        .error { background: #fee2e2; color: #991b1b; }

        .img-preview { 
            width: 50px; height: 50px; border-radius: 8px; object-fit: cover; 
            border: 1px solid #e2e8f0; background: #f8fafc;
        }
    </style>
</head>
<body>
    
<div class="mobile-nav-bar">
    <div class="nav-group">
        <button onclick="window.location.href='../admin/index.php'" class="nav-item">
            <span class="nav-icon">🛠️</span>
            <span class="nav-text">Admin</span>
        </button>
        <button onclick="window.location.href='index.php'" class="nav-item highlight">
            <span class="nav-icon">🔍</span>
            <span class="nav-text">Buscar PLU</span>
        </button>
    </div>
</div>

<div class="container">
    <div class="header">
        <h1>🍞 g502 <span style="font-weight:400; color:#64748b;">| Inventario</span></h1>
        <form class="search-box" method="GET">
            <input type="text" name="buscar" placeholder="Buscar..." value="<?php echo htmlspecialchars($busqueda); ?>">
            <button type="submit" class="btn-save" style="background: var(--primary);">Buscar</button>
        </form>
    </div>

    <?php if (isset($_GET['status'])): ?>
    <?php 
        $status = $_GET['status'];
        // Definimos si es un mensaje de éxito o de error
        $esExito = ($status == 'success' || $status == 'deleted');
        $clase = $esExito ? 'success' : 'error';
        
        // Personalizamos el texto según el caso
        if ($status == 'success') $mensaje = "✨ Cambios guardados";
        elseif ($status == 'deleted') $mensaje = "🗑️ Producto eliminado correctamente";
        else $mensaje = "❌ Hubo un error";
    ?>
    <div class="status-msg <?php echo $clase; ?>">
        <?php echo $mensaje; ?>
    </div>
<?php endif; ?>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>PLU</th><th>Producto</th><th>Descripción</th><th>Categoría</th><th>Precio</th><th>Imagen</th><th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                <form action="procesar_edicion.php" method="POST" enctype="multipart/form-data">
                <tr>
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    
                    <td data-label="PLU"><input type="text" name="codigo" value="<?php echo $row['codigo']; ?>"></td>
                    <td data-label="Producto"><input type="text" name="nombre" value="<?php echo $row['nombre']; ?>"></td>
                    <td data-label="Descripción"><textarea name="description" rows="1"><?php echo $row['descripcion']; ?></textarea></td>
                    <td data-label="Categoría">
                        <select name="categoria">
                            <option value="Panaderia" <?php echo $row['categoria'] == 'Panaderia' ? 'selected' : ''; ?>>Panadería</option>
                            <option value="Recargas" <?php echo $row['categoria'] == 'Recargas' ? 'selected' : ''; ?>>Recargas</option>
                            <option value="Frutas y Vegetales" <?php echo $row['categoria'] == 'Frutas y Vegetales' ? 'selected' : ''; ?>>Frutas</option>
                        </select>
                    </td>
                    <td data-label="Precio"><input type="number" name="precio" value="<?php echo $row['precio']; ?>"></td>
                    
                    <td data-label="Imagen">
                        <div style="display: flex; flex-direction: column; align-items: center; gap: 5px;">
                            <?php 
                            $ruta_foto = "assets/img/" . $row['imagen']; 
                            if(!empty($row['imagen']) && file_exists($ruta_foto)): ?>
                                <img src="<?php echo $ruta_foto; ?>?v=<?php echo time(); ?>" class="img-preview">
                            <?php else: ?>
                                <div class="img-preview" style="display:flex; align-items:center; justify-content:center; font-size:0.6rem; color:red;">❌</div>
                            <?php endif; ?>
                            <input type="file" name="foto_subida" accept="image/*" style="font-size: 0.6rem; width: 100%;">
                            <input type="hidden" name="imagen_actual" value="<?php echo $row['imagen']; ?>">
                        </div>
                    </td>
                    
                    <td data-label="Acciones">
                        <div style="display: flex; gap: 5px; width: 100%;">
                            <button type="submit" class="btn-save">OK</button>
                            <a href="eliminar_producto.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('¿Borrar?');">🗑️</a>
                        </div>
                    </td>
                </tr>
                </form>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>