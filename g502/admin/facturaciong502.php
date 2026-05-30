<?php
include '../config/db.php'; 
session_start();

// Activar errores para depuración en g502
error_reporting(E_ALL);
ini_set('display_errors', 1);

// --- PROCESAMIENTO PHP ---
if (isset($_POST['registrar_fiscal'])) {
    // Escapar datos para evitar errores de SQL
    $nombre    = mysqli_real_escape_string($conn, $_POST['nombre']);
    $nit       = mysqli_real_escape_string($conn, $_POST['nit']);
    $dv        = intval($_POST['dv']);
    $tipo_org  = intval($_POST['tipo_org']);
    $regimen   = mysqli_real_escape_string($conn, $_POST['regimen']);
    $municipio = mysqli_real_escape_string($conn, $_POST['municipio_code']);
    $direccion = mysqli_real_escape_string($conn, $_POST['direccion']);
    $email     = mysqli_real_escape_string($conn, $_POST['email']);

    // SQL Corregido: tipo_organizacion (sin tilde) y agregada la direccion
    $sql = "INSERT INTO facturaciong502 (razon_social, nit, dv, tipo_organizacion, regimen_fiscal, municipio_code, direccion, email_facturacion) 
            VALUES ('$nombre', '$nit', $dv, $tipo_org, '$regimen', '$municipio', '$direccion', '$email')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: facturaciong502.php?status=success");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error en SQL: " . mysqli_error($conn) . "</div>";
    }
}

$registros = mysqli_query($conn, "SELECT * FROM facturaciong502 ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Fiscal Setup | g502</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/facturacion.css">
</head>
<body class="p-4">
    <?php include 'includes/header.php'; ?>

<div class="container">
    <h1 class="text-gold mb-4"><i class="fas fa-university"></i> Registro Fiscal <span class="fw-light">g502</span></h1>

    <div class="admin-card">
        <h3 class="mb-4 text-gold">Datos de Facturación</h3>
        <form method="POST" id="formFiscal">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Razón Social</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">NIT</label>
                    <input type="text" name="nit" id="nitInput" class="form-control" required>
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">DV</label>
                    <input type="number" name="dv" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tipo Organización</label>
                    <select name="tipo_org" class="form-select">
                        <option value="1">Persona Jurídica</option>
                        <option value="2">Persona Natural</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Régimen Fiscal</label>
                    <select name="regimen" class="form-select">
                        <option value="O-48">Responsable de IVA</option>
                        <option value="O-49">Régimen Simple</option>
                        <option value="R-99-PN">No Responsable de IVA</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Cód. Municipio (DANE)</label>
                    <input type="text" name="municipio_code" class="form-control" placeholder="Ej: 11001" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Dirección Física</label>
                    <input type="text" name="direccion" class="form-control" placeholder="Ej: Calle 10 # 5-20" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email Fiscal</label>
                    <input type="email" name="email" class="form-control" placeholder="admin@empresa.com" required>
                </div>
            </div>

            <button type="submit" name="registrar_fiscal" class="btn btn-gold w-100">
                <i class="fas fa-save"></i> GUARDAR EN BASE DE DATOS
            </button>
        </form>
    </div>

    <div class="admin-card mt-4">
        <h3 class="mb-4 text-gold">Registros Activos</h3>
        <div class="table-responsive">
            <table class="table table-hover text-white">
                <thead>
                    <tr>
                        <th>NIT</th>
                        <th>Razón Social</th>
                        <th>Dirección</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($r = mysqli_fetch_assoc($registros)): ?>
                    <tr>
                        <td><span class="badge bg-dark border border-warning"><?php echo $r['nit']."-".$r['dv']; ?></span></td>
                        <td><strong><?php echo $r['razon_social']; ?></strong></td>
                        <td><small><?php echo $r['direccion']; ?></small></td>
                        <td class="text-gold"><?php echo $r['email_facturacion']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nitInput = document.getElementById('nitInput');
    const form = document.getElementById('formFiscal');

    nitInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    form.addEventListener('submit', function() {
        const btn = this.querySelector('button[name="registrar_fiscal"]');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Conectando con g502...';
        btn.style.pointerEvents = 'none';
    });
});
</script>

</body>
</html>