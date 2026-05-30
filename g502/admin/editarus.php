<?php
session_start();
require_once '../config/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$mensaje = "";

$query = "SELECT * FROM usuarios WHERE id = $id";
$res = mysqli_query($conn, $query);
$u = mysqli_fetch_assoc($res);

if (!$u) { die("Usuario no encontrado."); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_u = mysqli_real_escape_string($conn, $_POST['nombre_usuario']);
    $nombre_c = mysqli_real_escape_string($conn, $_POST['nombre_completo']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $tel = mysqli_real_escape_string($conn, $_POST['telefono']);
    $dir = mysqli_real_escape_string($conn, $_POST['direccion']);
    $ciu = mysqli_real_escape_string($conn, $_POST['ciudad']);
    $est_p = mysqli_real_escape_string($conn, $_POST['estado_provincia']);
    $rol = mysqli_real_escape_string($conn, $_POST['rol']);
    $est_c = mysqli_real_escape_string($conn, $_POST['estado_cuenta']);

    $update = "UPDATE usuarios SET 
                nombre_usuario='$nombre_u', 
                nombre_completo='$nombre_c', 
                email='$email', 
                telefono='$tel', 
                direccion='$dir', 
                ciudad='$ciu', 
                estado_provincia='$est_p',
                rol='$rol',
                estado_cuenta='$est_c' 
               WHERE id = $id";
    
    if (mysqli_query($conn, $update)) {
        $mensaje = "<div class='alert alert-success'>Datos actualizados en g502 correctamente.</div>";
        // Recargar datos para el formulario
        $res = mysqli_query($conn, "SELECT * FROM usuarios WHERE id = $id");
        $u = mysqli_fetch_assoc($res);
    } else {
        $mensaje = "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Editar Cliente - g502</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light pb-5">
    <?php include 'includes/header.php'; ?>
<nav class="navbar navbar-dark bg-dark px-3 mb-4">
    <a class="navbar-brand" href="clientes.php"><i class="fas fa-arrow-left me-2"></i> Volver a Clientes</a>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold"><i class="fas fa-edit me-2"></i>Perfil del Cliente #<?php echo $id; ?></div>
                <div class="card-body">
                    <?php echo $mensaje; ?>
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Nombre de Usuario (Login)</label>
                                <input type="text" name="nombre_usuario" class="form-control" value="<?php echo htmlspecialchars($u['nombre_usuario']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Nombre Completo</label>
                                <input type="text" name="nombre_completo" class="form-control" value="<?php echo htmlspecialchars($u['nombre_completo']); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($u['email']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Teléfono</label>
                                <input type="text" name="telefono" class="form-control" value="<?php echo htmlspecialchars($u['telefono']); ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Dirección de Envío</label>
                            <textarea name="direccion" class="form-control" rows="2"><?php echo htmlspecialchars($u['direccion']); ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Ciudad</label>
                                <input type="text" name="ciudad" class="form-control" value="<?php echo htmlspecialchars($u['ciudad']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Estado / Provincia</label>
                                <input type="text" name="estado_provincia" class="form-control" value="<?php echo htmlspecialchars($u['estado_provincia']); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Rol</label>
                                <select name="rol" class="form-select">
                                    <option value="usuario" <?php echo ($u['rol'] == 'usuario') ? 'selected' : ''; ?>>Usuario</option>
                                    <option value="administrador" <?php echo ($u['rol'] == 'administrador') ? 'selected' : ''; ?>>Administrador</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Estado de Cuenta</label>
                                <select name="estado_cuenta" class="form-select">
                                    <option value="activo" <?php echo ($u['estado_cuenta'] == 'activo') ? 'selected' : ''; ?>>Activo</option>
                                    <option value="inactivo" <?php echo ($u['estado_cuenta'] == 'inactivo') ? 'selected' : ''; ?>>Inactivo</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-dark btn-lg"><i class="fas fa-save me-2"></i>ACTUALIZAR DATOS</button>
                        </div>
                    </form>

                    <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold"><i class="fas fa-users-cog me-2"></i>Gestión de Clientes</h3>
    <div>
        <button class="btn btn-success fw-bold me-2" data-bs-toggle="modal" data-bs-target="#modalNuevoCliente">
            <i class="fas fa-plus-circle me-1"></i> NUEVO CLIENTE
        </button>
        <button class="btn btn-dark" onclick="window.location.reload();">
            <i class="fas fa-sync-alt"></i>
        </button>
    </div>
</div>



                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNuevoCliente" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px;">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Registrar Nuevo Cliente</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="guardar_cliente.php" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Usuario / Nickname</label>
                            <input type="text" name="nombre_usuario" class="form-control" placeholder="Ej: jorgito99" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Nombre Completo</label>
                            <input type="text" name="nombre_completo" class="form-control" placeholder="Nombre y Apellido">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="correo@ejemplo.com" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" placeholder="Ej: +57 300...">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Contraseña Inicial</label>
                        <input type="password" name="password" class="form-control" placeholder="Asigna una clave temporal" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Dirección de Envío</label>
                        <textarea name="direccion" class="form-control" rows="2" placeholder="Calle, número, barrio..."></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Ciudad</label>
                            <input type="text" name="ciudad" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Rol</label>
                            <select name="rol" class="form-select">
                                <option value="usuario" selected>Usuario / Cliente</option>
                                <option value="administrador">Administrador</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark fw-bold px-4">GUARDAR CLIENTE</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>