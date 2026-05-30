<?php
session_start();
require_once '../config/db.php';

// 1. LEER CONFIGURACIÓN (Nombre y Clave)
$res_conf = mysqli_query($conn, "SELECT * FROM configuracion_g502 WHERE id = 1");
$conf = mysqli_fetch_assoc($res_conf);
$pass_maestra = $conf['password_maestra'];
$nombre_boveda = $conf['nombre_boveda'];

// 2. ACTUALIZAR CONFIGURACIÓN
if (isset($_POST['actualizar_conf'])) {
    $nuevo_nombre = mysqli_real_escape_string($conn, $_POST['nuevo_nombre']);
    $nueva_pass = mysqli_real_escape_string($conn, $_POST['nueva_pass']);
    mysqli_query($conn, "UPDATE configuracion_g502 SET nombre_boveda = '$nuevo_nombre', password_maestra = '$nueva_pass' WHERE id = 1");
    header("Location: subirarchivos.php?updated=1");
    exit;
}

// 3. LÓGICA DE SUBIDA DE ARCHIVOS (Con Nombre Personalizado)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivo'])) {
    $tipo = $_POST['tipo_documento'];
    // Capturamos el nombre que tú escribiste
    $nombre_personalizado = mysqli_real_escape_string($conn, $_POST['nombre_documento']); 
    $dir = "../uploads/documentos/";
    
    if (!file_exists($dir)) { mkdir($dir, 0777, true); }

    $ext = pathinfo($_FILES["archivo"]["name"], PATHINFO_EXTENSION);
    // El nombre físico en el servidor lleva el tiempo para que no se repita
    $nombre_seguro = time() . "_" . preg_replace("/[^a-zA-Z0-9]/", "_", $nombre_personalizado) . "." . $ext;
    $ruta_final = $dir . $nombre_seguro;

    if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $ruta_final)) {
        // Guardamos en la DB el nombre que tú elegiste
        $sql = "INSERT INTO documentos_g502 (nombre_archivo, tipo_documento, ruta) VALUES ('$nombre_personalizado', '$tipo', '$ruta_final')";
        mysqli_query($conn, $sql);
        header("Location: subirarchivos.php?upload_success=1");
        exit;
    }
}

// 4. LÓGICA ELIMINAR (Igual que antes)
if (isset($_GET['delete_id'])) {
    $id_doc = intval($_GET['delete_id']);
    $res = mysqli_query($conn, "SELECT ruta FROM documentos_g502 WHERE id = $id_doc");
    $doc = mysqli_fetch_assoc($res);
    if ($doc && file_exists($doc['ruta'])) { unlink($doc['ruta']); }
    mysqli_query($conn, "DELETE FROM documentos_g502 WHERE id = $id_doc");
    header("Location: subirarchivos.php");
    exit;
}

$documentos = mysqli_query($conn, "SELECT * FROM documentos_g502 ORDER BY fecha_subida DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $nombre_boveda; ?> - g502</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/js/subirdoc.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0"><i class="fas fa-vault text-primary"></i> <?php echo $nombre_boveda; ?></h2>
            <small class="text-muted">Gestión de Documentos g502</small>
        </div>
        <button class="btn btn-outline-secondary btn-sm" onclick="mostrarConfig()">
            <i class="fas fa-cog"></i> Ajustes
        </button>
    </div>

    <div id="panelConfig" class="glass-effect p-4 mb-4 d-none border-primary border">
        <h5 class="fw-bold mb-3">Personalizar Bóveda</h5>
        <form method="POST" class="row g-3">
            <div class="col-md-5">
                <label class="small fw-bold">Nombre de la Bóveda</label>
                <input type="text" name="nuevo_nombre" class="form-control" value="<?php echo $nombre_boveda; ?>" required>
            </div>
            <div class="col-md-5">
                <label class="small fw-bold">Clave Maestra</label>
                <input type="text" name="nueva_pass" class="form-control" value="<?php echo $pass_maestra; ?>" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" name="actualizar_conf" class="btn btn-primary w-100">Guardar</button>
            </div>
        </form>
    </div>

    <div class="glass-effect p-4 mb-5 shadow-sm border-start border-primary border-4">
        <h5 class="fw-bold mb-3"><i class="fas fa-file-upload me-2 text-primary"></i>Subir Nuevo Documento</h5>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small fw-bold">1. Nombre del Documento</label>
                    <input type="text" name="nombre_documento" class="form-control bg-light border-0" placeholder="Ej: RUT Enero 2026" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">2. Tipo</label>
                    <select name="tipo_documento" class="form-select bg-light border-0">
                        <option value="RUT">RUT</option>
                        <option value="Cedula">Cédula</option>
                        <option value="Factura">Factura / Soporte</option>
                        <option value="Inventario">Inventario</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">3. Archivo</label>
                    <input type="file" name="archivo" class="form-control bg-light border-0" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark w-100 fw-bold">GUARDAR</button>
                </div>
            </div>
        </form>
    </div>

    <hr class="mb-5">

    <div class="row">
        <?php if(mysqli_num_rows($documentos) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($documentos)): ?>
            <div class="col-md-4 mb-4">
                <div class="doc-card-premium shadow-sm border">
                    <div class="doc-badge"><?php echo $row['tipo_documento']; ?></div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="file-icon me-3">
                            <i class="fas fa-file-shield text-primary fa-xl"></i>
                        </div>
                        <div class="file-details overflow-hidden">
                            <h6 class="mb-0 text-truncate fw-bold"><?php echo $row['nombre_archivo']; ?></h6>
                            <small class="text-muted small"><?php echo date('d/m/Y', strtotime($row['fecha_subida'])); ?></small>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <button onclick="verificarAccion('ver', '<?php echo $row['ruta']; ?>', '<?php echo $pass_maestra; ?>')" class="btn btn-dark btn-sm flex-grow-1">Abrir</button>
                        <button onclick="verificarAccion('eliminar', '<?php echo $row['id']; ?>', '<?php echo $pass_maestra; ?>')" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center text-muted py-5">
                <i class="fas fa-folder-open fa-3x mb-3"></i>
                <p>No hay documentos guardados.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="assets/js/subirdoc.js"></script>
<script>
    function mostrarConfig() {
        document.getElementById('panelConfig').classList.toggle('d-none');
    }
</script>
</body>
</html>