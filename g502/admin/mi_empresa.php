<?php
include '../config/db.php';
session_start();

if (isset($_POST['guardar_mi_perfil'])) {
    $razon    = mysqli_real_escape_string($conn, $_POST['razon']);
    $nit      = mysqli_real_escape_string($conn, $_POST['nit']);
    $dv       = intval($_POST['dv']);
    $dir      = mysqli_real_escape_string($conn, $_POST['direccion']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $res      = mysqli_real_escape_string($conn, $_POST['resolucion']);
    $pref     = mysqli_real_escape_string($conn, $_POST['prefijo']);
    $clave    = mysqli_real_escape_string($conn, $_POST['clave_tecnica']);
    
    // 1. Obtener el logo actual de la base de datos por si no se sube uno nuevo
    $check_logo = mysqli_query($conn, "SELECT mi_logo_path FROM mefacturaciong502 WHERE id=1");
    $current_data = mysqli_fetch_assoc($check_logo);
    $path_final = $current_data['mi_logo_path'] ?? '';

    // 2. Procesar nuevo logo si existe
    if (!empty($_FILES['logo']['name'])) {
        $target_dir = "assets/img/";
        if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
        $logo_name = "logo_emisor_" . time() . ".png";
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $target_dir . $logo_name)) {
            $path_final = $target_dir . $logo_name;
        }
    }

    // 3. SQL Corregido con ON DUPLICATE KEY UPDATE
    // Nota: Aquí listamos las columnas y luego los valores sin signos '=' intermedios
    $sql = "INSERT INTO mefacturaciong502 
            (id, mi_razon_social, mi_nit, mi_dv, mi_direccion, mi_email_fiscal, mi_logo_path, prefijo_factura, resolucion_numero, clave_tecnica) 
            VALUES 
            (1, '$razon', '$nit', $dv, '$dir', '$email', '$path_final', '$pref', '$res', '$clave')
            ON DUPLICATE KEY UPDATE 
            mi_razon_social='$razon', 
            mi_nit='$nit', 
            mi_dv=$dv, 
            mi_direccion='$dir', 
            mi_email_fiscal='$email', 
            mi_logo_path='$path_final', 
            prefijo_factura='$pref', 
            resolucion_numero='$res', 
            clave_tecnica='$clave'";
    
    if(mysqli_query($conn, $sql)){
        header("Location: mi_empresa.php?status=success");
        exit();
    } else {
        die("Error de MySQL: " . mysqli_error($conn));
    }
}

// Consultar datos para mostrar en el formulario
$res_me = mysqli_query($conn, "SELECT * FROM mefacturaciong502 WHERE id=1");
$me = mysqli_fetch_assoc($res_me);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Configuración Emisor | g502</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/facturacion.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="p-4" style="background:#000; color:#fff;">
    <?php include 'includes/header.php'; ?>

<div class="container">
    <h1 style="color:#d4af37;" class="mb-4"><i class="fas fa-user-tie"></i> Mi Perfil Fiscal <span class="fw-light">g502</span></h1>

    <div class="row">
        <div class="col-md-8">
            <div class="admin-card" style="background:#111; border: 1px solid #d4af37; padding:25px; border-radius:15px;">
                <form method="POST" enctype="multipart/form-data">
                    
                    <h5 class="text-gold mb-3"><i class="fas fa-building"></i> Información de mi Empresa</h5>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label class="form-label">Mi Razón Social (Como aparece en RUT)</label>
                            <input type="text" name="razon" class="form-control" value="<?php echo $me['mi_razon_social'] ?? ''; ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Mi NIT</label>
                            <input type="text" name="nit" class="form-control" value="<?php echo $me['mi_nit'] ?? ''; ?>" required>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">DV</label>
                            <input type="number" name="dv" class="form-control" value="<?php echo $me['mi_dv'] ?? ''; ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Dirección Fiscal</label>
                            <input type="text" name="direccion" class="form-control" value="<?php echo $me['mi_direccion'] ?? ''; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Fiscal Emisor</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $me['mi_email_fiscal'] ?? ''; ?>" required>
                        </div>
                    </div>

                    <h5 class="text-gold mt-4 mb-3"><i class="fas fa-file-contract"></i> Parámetros DIAN</h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Número de Resolución</label>
                            <input type="text" name="resolucion" class="form-control" value="<?php echo $me['resolucion_numero'] ?? ''; ?>" placeholder="Ej: 18760000001">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Prefijo</label>
                            <input type="text" name="prefijo" class="form-control" value="<?php echo $me['prefijo_factura'] ?? ''; ?>" placeholder="Ej: FE">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-gold">Clave Técnica DIAN</label>
                        <input type="text" name="clave_tecnica" class="form-control" value="<?php echo $me['clave_tecnica'] ?? ''; ?>" placeholder="Código alfanumérico largo">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Actualizar Logotipo</label>
                        <input type="file" name="logo" class="form-control" accept="image/*">
                    </div>

                    <button type="submit" name="guardar_mi_perfil" class="btn btn-gold w-100" style="background:#d4af37; color:#000; font-weight:bold;">
                        <i class="fas fa-save"></i> GUARDAR CONFIGURACIÓN EMISOR
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="admin-card text-center" style="background:#111; border: 1px solid #d4af37; padding:25px; border-radius:15px;">
                <h5 class="text-gold mb-4">Identidad Visual</h5>
                <?php if(!empty($me['mi_logo_path'])): ?>
                    <img src="<?php echo $me['mi_logo_path']; ?>" style="max-width:100%; border: 1px solid #d4af37; border-radius:10px; padding:10px; background:#fff;">
                <?php else: ?>
                    <div style="height:150px; border:2px dashed #333; display:flex; align-items:center; justify-content:center; color:#444;">
                        <i class="fas fa-image fa-3x"></i>
                    </div>
                    <p class="mt-2 text-secondary">Sin logo configurado</p>
                <?php endif; ?>
                <hr style="border-color:#333;">
                <p class="small text-gold">Datos configurados para el proyecto <strong>g502</strong></p>
            </div>
        </div>
    </div>
</div>

</body>
</html>