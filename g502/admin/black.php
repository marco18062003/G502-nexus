<?php
include '../config/db.php'; // Using your standard connection
session_start();

// --- 1. HANDLE NEW JOB POSTING ---
if (isset($_POST['post_job'])) {
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $desc   = mysqli_real_escape_string($conn, $_POST['descripcion']);
    $req    = mysqli_real_escape_string($conn, $_POST['requisitos']);

    $sql = "INSERT INTO vacantes (titulo, descripcion, requisitos) VALUES ('$titulo', '$desc', '$req')";
    mysqli_query($conn, $sql);
    header("Location: black.php?status=posted");
}

// --- 2. FETCH DATA ---
$vacantes = mysqli_query($conn, "SELECT * FROM vacantes ORDER BY fecha_publicacion DESC");
$postulados = mysqli_query($conn, "SELECT * FROM postulaciones ORDER BY fecha_postulacion DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Admin Panel | g502</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #000; color: #fff; font-family: 'Montserrat', sans-serif; }
        .admin-card { background: #111; border: 1px solid #d4af37; border-radius: 15px; padding: 25px; margin-bottom: 30px; }
        .text-gold { color: #d4af37; }
        .table { color: #fff; border-color: #333; }
        .form-control { background: #222; border: 1px solid #444; color: #fff; }
        .form-control:focus { background: #222; color: #fff; border-color: #d4af37; box-shadow: none; }
        .btn-gold { background: #d4af37; color: #000; font-weight: bold; }
        .cv-link { color: #d4af37; text-decoration: none; }
        .cv-link:hover { text-decoration: underline; }
    </style>
</head>
<body class="p-4">
    <?php include 'includes/header.php'; ?>

<div class="container">
    <h1 class="text-gold mb-4"><i class="fas fa-user-shield"></i> Don Jorgito <span class="fw-light">Admin Panel</span></h1>

    <div class="admin-card">
        <h3 class="mb-4 text-gold">Publicar Nueva Vacante</h3>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Título del Puesto</label>
                <input type="text" name="titulo" class="form-control" placeholder="Ej: Curador de Vinos" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="3" required></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Requisitos</label>
                    <textarea name="requisitos" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <button type="submit" name="post_job" class="btn btn-gold px-5">Publicar en g502</button>
        </form>
    </div>

    <div class="admin-card">
        <h3 class="mb-4 text-gold">Candidatos Postulados</h3>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Nombre</th>
                        <th>Vacante</th>
                        <th>Propuesta (The Deal)</th>
                        <th>Hoja de Vida</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($p = mysqli_fetch_assoc($postulados)): ?>
                    <tr>
                        <td class="small"><?php echo date('d/m/y', strtotime($p['fecha_postulacion'])); ?></td>
                        <td><strong><?php echo $p['nombre']; ?></strong><br><small class="text-secondary"><?php echo $p['email']; ?></small></td>
                        <td><span class="badge bg-dark border border-warning"><?php echo $p['vacante']; ?></span></td>
                        <td><small><?php echo $p['propuesta']; ?></small></td>
                        <td>
                            <a href="<?php echo $p['cv_path']; ?>" target="_blank" class="cv-link">
                                <i class="fas fa-file-pdf"></i> Ver CV
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>