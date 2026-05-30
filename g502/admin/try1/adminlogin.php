<?php
session_start();
$email = $password = "";
$error_message = "";

// Redirigir si ya está logueado como administrador
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: ./index.php"); // Redirección al dashboard si ya está logueado
    exit;
}

// 1. INCLUSIÓN DEL ARCHIVO DE CONEXIÓN
require_once '../config/db.php'; 

// 2. VERIFICACIÓN DE CONEXIÓN: Usamos $conn (la variable de tu db.php)
if (!isset($conn) || !$conn) {
    $error_message = "Error interno del sistema: No se pudo establecer la conexión con la base de datos.";
    goto render_page; 
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 3. Recoger y sanear datos
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // 4. Preparar la consulta
    $sql = "SELECT id, nombre_usuario, password, rol FROM usuarios WHERE email = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) { 
        
        // Asignar parámetros
        mysqli_stmt_bind_param($stmt, "s", $param_email);
        $param_email = $email;
        
        if (mysqli_stmt_execute($stmt)) {
            // Obtener resultado
            mysqli_stmt_store_result($stmt);
            
            if (mysqli_stmt_num_rows($stmt) == 1) {
                // Vincular resultados a variables
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $rol);
                if (mysqli_stmt_fetch($stmt)) {
                    
                    // 5. Verificar Contraseña y Rol
                    if (password_verify($password, $hashed_password)) {
                        
                        // LÓGICA DE VERIFICACIÓN DE ROL LIMPIA
                        if ($rol === 'administrador') {
                            
                            // ÉXITO: Iniciar la sesión de administrador
                            $_SESSION['admin_logged_in'] = true;
                            $_SESSION['user_id'] = $id;
                            $_SESSION['username'] = $username;
                            
                            header("Location: ./index.php"); // Redirección final al dashboard
                            exit; // CRUCIAL para detener la ejecución y ejecutar la redirección
                        } else {
                            $error_message = "Acceso denegado. Esta área es solo para administradores.";
                        }
                    } else {
                        $error_message = "El email o la contraseña no son válidos.";
                    }
                }
            } else {
                $error_message = "El email o la contraseña no son válidos.";
            }
        } else {
            $error_message = "Oops! Algo salió mal con la ejecución de la consulta.";
        }
        mysqli_stmt_close($stmt);
    } else {
        $error_message = "Error de preparación de la consulta: " . mysqli_error($conn);
    }
}

render_page:
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login de Administrador g502</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .wrapper { max-width: 350px; padding: 20px; margin: 100px auto; background-color: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; margin-bottom: 25px; color: #333; }
        .alert { text-align: center; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Panel de Administración</h2>
        <p>Inicia sesión para gestionar **g502**.</p>

        <?php 
        if (!empty($error_message)) {
            echo '<div class="alert alert-danger">' . htmlspecialchars($error_message) . '</div>';
        }
        ?>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($email); ?>">
            </div>    
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="d-grid gap-2">
                <input type="submit" class="btn btn-primary" value="Acceder">
            </div>
        </form>
    </div>
</body>
</html>
