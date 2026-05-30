<?php
session_start();
require_once '../config/db.php';

// 1. OBTENER LISTA DE USUARIOS PARA EL DESPLEGABLE
$res_usuarios = mysqli_query($conn, "SELECT id, nombre_completo, telefono FROM usuarios ORDER BY nombre_completo ASC");

// 2. REGISTRAR NUEVA DEUDA
if (isset($_POST['registrar_deuda'])) {
    $id_usuario = intval($_POST['usuario_id']); 
    $productos = mysqli_real_escape_string($conn, $_POST['productos']);
    $monto = floatval($_POST['monto']);
    $fecha = $_POST['fecha'];

    // --- PASO CRUCIAL PARA EVITAR EL ERROR DE LLAVE FORÁNEA ---
    // Buscamos los datos del usuario para asegurar que existan en la tabla clientes_g502
    $check_user = mysqli_query($conn, "SELECT nombre_completo, telefono FROM usuarios WHERE id = $id_usuario");
    $u_info = mysqli_fetch_assoc($check_user);
    
    $nom_cli = mysqli_real_escape_string($conn, $u_info['nombre_completo']);
    $tel_cli = mysqli_real_escape_string($conn, $u_info['telefono'] ?? '');

    // Insertamos en clientes_g502 solo si no existe (esto satisface la restricción CONSTRAINT)
    // Usamos el mismo ID del usuario para mantener la relación 1 a 1
    mysqli_query($conn, "INSERT IGNORE INTO clientes_g502 (id, nombre_cliente, telefono) VALUES ($id_usuario, '$nom_cli', '$tel_cli')");

    // Ahora sí, insertamos la deuda
    $sql = "INSERT INTO deudas_g502 (cliente_id, productos_detalle, monto_total, fecha_deuda, estado) 
            VALUES ($id_usuario, '$productos', $monto, '$fecha', 'Pendiente')";
    
    if(mysqli_query($conn, $sql)) {
        header("Location: gestion_deudas.php?success=1");
        exit();
    } else {
        $error_db = mysqli_error($conn);
    }
}

// 3. CAMBIAR ESTADO A PAGADO
if (isset($_GET['completar_id'])) {
    $id = intval($_GET['completar_id']);
    mysqli_query($conn, "UPDATE deudas_g502 SET estado = 'Pagado', monto_pagado = monto_total WHERE id = $id");
    header("Location: gestion_deudas.php");
    exit();
}

// 4. CONSULTA PARA LA TABLA
// Nota: Unimos con 'usuarios' para mostrar el nombre real en la lista
$query_deudas = "SELECT d.*, u.nombre_completo 
                 FROM deudas_g502 d 
                 INNER JOIN usuarios u ON d.cliente_id = u.id 
                 ORDER BY d.fecha_deuda DESC";
$deudas = mysqli_query($conn, $query_deudas);

// 5. CÁLCULO DE TOTALES
$res_total = mysqli_query($conn, "SELECT SUM(monto_total) as total_fiao FROM deudas_g502 WHERE estado = 'Pendiente'");
$dato_total = mysqli_fetch_assoc($res_total);
$total_pendiente = $dato_total['total_fiao'] ?? 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Control de Deudas - g502</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f6f9; }
        .card-fiao { border-radius: 15px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .table thead { background-color: #343a40; color: white; }
    </style>
</head>
<body>
<?php include 'includes/header.php'; ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0"><i class="fas fa-hand-holding-usd text-danger me-2"></i> g502 - Cuentas por Cobrar</h2>
        <div class="bg-white p-3 rounded-4 shadow-sm text-end">
            <span class="small text-muted d-block text-uppercase fw-bold">Total por Cobrar</span>
            <h4 class="text-danger fw-bold m-0">$<?php echo number_format($total_pendiente, 0); ?></h4>
        </div>
    </div>

    <?php if(isset($error_db)): ?>
        <div class="alert alert-danger">Error: <?php echo $error_db; ?></div>
    <?php endif; ?>

    <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> ¡Deuda registrada correctamente!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card card-fiao p-4 mb-5">
        <h5 class="fw-bold mb-3">Registrar Nueva Deuda</h5>
        <form method="POST" class="row g-3">
            <div class="col-md-3">
                <label class="form-label small fw-bold">Cliente (De tabla usuarios)</label>
                <select name="usuario_id" class="form-select" required>
                    <option value="">-- Buscar Nombre --</option>
                    <?php 
                    mysqli_data_seek($res_usuarios, 0); 
                    while($u = mysqli_fetch_assoc($res_usuarios)): ?>
                        <option value="<?php echo $u['id']; ?>">
                            <?php echo htmlspecialchars($u['nombre_completo']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Productos (Detalle)</label>
                <input type="text" name="productos" class="form-control" placeholder="Ej: 3 Leches, 1 Pan" required>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold">Monto ($)</label>
                <input type="number" name="monto" class="form-control" placeholder="0" required>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold">Fecha</label>
                <input type="date" name="fecha" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" name="registrar_deuda" class="btn btn-danger w-100 fw-bold">
                    <i class="fas fa-save"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="table-responsive bg-white p-3 rounded-4 shadow-sm">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Detalle de Productos</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th class="text-center">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while($d = mysqli_fetch_assoc($deudas)): ?>
                <tr>
                    <td class="small text-muted"><?php echo date('d/m/Y', strtotime($d['fecha_deuda'])); ?></td>
                    <td>
                        <div class="fw-bold"><?php echo htmlspecialchars($d['nombre_completo']); ?></div>
                        <small class="text-muted">ID: #<?php echo $d['cliente_id']; ?></small>
                    </td>
                    <td><span class="text-secondary"><?php echo htmlspecialchars($d['productos_detalle']); ?></span></td>
                    <td class="fw-bold text-dark">$<?php echo number_format($d['monto_total'], 0); ?></td>
                    <td>
                        <span class="badge <?php echo $d['estado'] == 'Pendiente' ? 'bg-warning text-dark' : 'bg-success'; ?> rounded-pill">
                            <?php echo strtoupper($d['estado']); ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <?php if($d['estado'] == 'Pendiente'): ?>
                            <button onclick="confirmarPago(<?php echo $d['id']; ?>)" class="btn btn-sm btn-success fw-bold px-3">
                                <i class="fas fa-check me-1"></i> PAGÓ
                            </button>
                        <?php else: ?>
                            <span class="text-success small fw-bold"><i class="fas fa-check-double"></i> SALDADO</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function confirmarPago(id) {
    if(confirm('¿Confirmar que el cliente ha pagado la deuda?')) {
        window.location.href = 'gestion_deudas.php?completar_id=' + id;
    }
}
</script>
</body>
</html>