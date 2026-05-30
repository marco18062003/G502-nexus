<?php
// Configuración de zona horaria
require_once('../admin/seguridad_admin.php');
date_default_timezone_set('America/Bogota');
require_once '../config/db.php';


// Diccionario de IPs conocidas para g502
$nombres_conocidos = [
    '192.168.128.14' => '💻 Mi Laptop HP',
    '192.168.128.20' => '📱 Realme T15 (Compañero)',
    '192.168.128.4'  => '📱 Moto G9 Play',
    '127.0.0.1'      => '🏠 Localhost',
    '::1'            => '🏠 Localhost'
];

// 1. CONSULTA PARA RESUMEN DE USUARIOS (Agrupado)
// 1. CONSULTA PARA RESUMEN DE USUARIOS (Agrupado corregido)
$query_resumen = "SELECT 
                    MAX(agente_usuario) as agente_usuario, -- Tomamos el más reciente
                    ip_usuario, 
                    modelo_real, 
                    COUNT(*) as total_busquedas, 
                    DATE_SUB(MAX(fecha), INTERVAL 5 HOUR) as ultima_conexion 
                  FROM historial_uso 
                  GROUP BY ip_usuario, modelo_real -- Agrupamos solo por lo esencial
                  ORDER BY ultima_conexion DESC";
$res_resumen = mysqli_query($conn, $query_resumen);

// 2. CONSULTA PARA HISTORIAL COMPLETO (Detallado)
$query_historial = "SELECT *, DATE_SUB(fecha, INTERVAL 5 HOUR) as fecha_ajustada 
                    FROM historial_uso 
                    ORDER BY fecha DESC 
                    LIMIT 500";
$res_historial = mysqli_query($conn, $query_historial);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Acceso g502</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root { --blue: #2563eb; --bg: #f4f7f6; --text: #334155; }
        
        body { 
            font-family: 'Inter', -apple-system, sans-serif; 
            background: var(--bg); 
            color: var(--text); 
            margin: 0; 
            padding: 10px; /* Menos padding en móviles */
        }
        
        .container { max-width: 1000px; margin: auto; }
        
        h2 { 
            text-align: center; 
            color: var(--blue); 
            font-size: 1.5rem; 
            margin: 15px 0; 
        }

        /* Estilo de Pestañas (Responsivas) */
        .tabs { 
            display: flex; 
            gap: 5px; 
            margin-bottom: 15px; 
            justify-content: center; 
        }
        
        .tab-btn { 
            flex: 1; /* Crecen por igual */
            max-width: 200px;
            padding: 12px 10px; 
            border: none; 
            background: #e2e8f0; 
            border-radius: 8px; 
            cursor: pointer; 
            font-weight: bold; 
            font-size: 0.85rem;
            transition: 0.3s; 
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }
        
        .tab-btn i { font-size: 1.1rem; }
        .tab-btn.active { background: var(--blue); color: white; }

        /* Secciones */
        .content-section { 
            display: none; 
            background: white; 
            border-radius: 12px; 
            padding: 15px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
        }
        .content-section.active { display: block; }

        /* --- MAGIA PARA TABLAS RESPONSIVAS --- */
        .table-wrapper {
            width: 100%;
            overflow-x: auto; /* Scroll lateral si la tabla es muy ancha */
            -webkit-overflow-scrolling: touch;
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
            min-width: 500px; /* Evita que se colapsen las columnas en exceso */
        }
        
        th, td { 
            padding: 12px 10px; 
            text-align: left; 
            border-bottom: 1px solid #edf2f7; 
            font-size: 0.9rem;
        }
        
        th { background: #f8fafc; font-size: 0.75rem; text-transform: uppercase; color: #64748b; }

        /* Chips y textos */
        .chip { 
            display: inline-block;
            padding: 4px 8px; 
            border-radius: 6px; 
            font-size: 0.75rem; 
            background: #f1f5f9; 
            font-weight: bold; 
            white-space: nowrap;
        }
        .chip-blue { background: #dbeafe; color: #1e40af; }
        .busqueda-text { color: #059669; font-weight: bold; word-break: break-word; }
        
        .btn-danger { 
            background: #dc3545; 
            color: white; 
            padding: 10px 15px; 
            border-radius: 8px; 
            text-decoration: none; 
            font-size: 0.85rem; 
            font-weight: bold;
        }

        /* Ajustes para pantallas grandes */
        @media (min-width: 600px) {
            body { padding: 20px; }
            h2 { font-size: 2rem; }
            .tab-btn { flex-direction: row; padding: 10px 20px; font-size: 1rem; }
            th, td { font-size: 1rem; }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📊 Panel g502</h2>

    <div class="tabs">
        <button class="tab-btn active" onclick="showTab('usuarios')">
            <i class="fas fa-users"></i> <span>Resumen</span>
        </button>
        <button class="tab-btn" onclick="showTab('historial')">
            <i class="fas fa-list"></i> <span>Historial</span>
        </button>
    </div>

    <div id="usuarios" class="content-section active">
        <h3 style="margin-top:0;">Dispositivos Activos</h3>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Dispositivo</th>
                        <th>Modelo</th>
                        <th>ID</th>
                        <th>Hits</th>
                        <th>Última Conexión</th>
                        <th>Acción</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php while($user = mysqli_fetch_assoc($res_resumen)): 
                        $nombre = $nombres_conocidos[$user['ip_usuario']] ?? ($user['agente_usuario'] ?: 'Anónimo');
                    ?>
                    <tr>
                        <td><strong><?php echo $nombre; ?></strong></td>
                        <td><code class="chip chip-blue"><?php echo $user['modelo_real']; ?></code></td>
                        <td><code class="chip"><?php echo $user['ip_usuario']; ?></code></td>
                        <td><span class="chip chip-blue"><?php echo $user['total_busquedas']; ?></span></td>
                        <td style="font-size: 0.8rem;"><?php echo date('d/m H:i', strtotime($user['ultima_conexion'])); ?></td>
                        <td>
                            <a href="ban.php?uid=<?php echo $user['ip_usuario']; ?>" ... 
                              class="btn-danger" 
                               style="padding: 4px 8px; font-size: 0.7rem; background: #ef4444;"
                              onclick="return confirm('¿Bloquear permanentemente al usuario <?php echo $user['ip_usuario']; ?>?')">
                             <i class="fas fa-user-slash"></i> Ban
                         </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="historial" class="content-section">
        <div style="display:flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h3 style="margin:0;">Registros</h3>
            <a href="limpiar_historial.php" class="btn-danger" onclick="return confirm('¿Borrar todo?')">
                <i class="fas fa-trash"></i> Vaciar
            </a>
        </div>
        <div class="table-wrapper">
            <table>
        <thead>
            <tr>
                <th>Hora</th>
                <th>Usuario</th>
                <th>Modelo</th>
                <th>Búsqueda</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($res_historial)): 
                // Determinamos la identidad (Prioridad: Nombre conocido > ID de usuario)
                $quien = $nombres_conocidos[$row['ip_usuario']] ?? $row['ip_usuario'];
                // Extraemos el modelo real (el que detectamos con la función nueva)
                $modelo = $row['modelo_real'] ?: 'No detectado';
            ?>
            <tr>
                <td style="font-size: 0.75rem; color: #94a3b8; white-space: nowrap;">
                    <?php echo date('H:i:s', strtotime($row['fecha_ajustada'])); ?>
                </td>
                
                <td><span class="chip"><?php echo $quien; ?></span></td>
                
                <td><code class="chip chip-blue" style="font-size: 0.7rem;"><?php echo $modelo; ?></code></td>
                
                <td class="busqueda-text"><?php echo htmlspecialchars($row['busqueda_realizada']); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
        </div>
    </div>
</div>

<script>
function showTab(tabId) {
    document.querySelectorAll('.content-section').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    
    document.getElementById(tabId).classList.add('active');
    // Usamos el evento para marcar el botón activo
    const btn = event.currentTarget;
    btn.classList.add('active');
}
</script>

</body>
</html>