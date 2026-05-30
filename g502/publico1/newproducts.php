<?php
session_start();
require_once '../config/db.php';

$is_logged_in = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);

// Fetch only the 20 most recent products
$sql_nuevos = "SELECT id, producto, imagen, precio, caracteristica FROM donjorgito1 ORDER BY id DESC LIMIT 20";
$result_nuevos = mysqli_query($conn, $sql_nuevos);
$productos_nuevos = mysqli_fetch_all($result_nuevos, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Nuevos Lanzamientos | DON JORGITO</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/newproducts.css"> 
    <style>
        .new-header {
            background: linear-gradient(135deg, #232f3e 0%, #1a222c 100%);
            color: white;
            padding: 80px 0;
            margin-bottom: 50px;
            text-align: center;
            border-bottom: 4px solid #e47911;
        }
        .grid-nuevos {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 25px;
        }
        @media (max-width: 1200px) { .grid-nuevos { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 768px) { .grid-nuevos { grid-template-columns: repeat(2, 1fr); } }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container mb-5">
    <div class="grid-nuevos">
        <?php foreach ($productos_nuevos as $producto): ?>
            <div class="product-item shadow-sm border-0 rounded-4 overflow-hidden bg-white h-100 d-flex flex-column">
                <div class="position-relative">
                    <span class="position-absolute top-0 start-0 m-3 badge rounded-pill bg-primary" style="z-index: 5;">NUEVO</span>
                    
                    <a href="buscar.php?query=<?php echo $producto['producto']; ?>">
                        <img src="../Donjorgitofinal/<?php echo htmlspecialchars($producto['imagen']); ?>" 
                             class="w-100 p-3" style="height: 200px; object-fit: contain;"
                             alt="<?php echo htmlspecialchars($producto['producto']); ?>">
                    </a>
                </div>

                <div class="p-3 mt-auto text-center">
                    <h6 class="fw-bold text-dark mb-1 text-truncate"><?php echo htmlspecialchars($producto['producto']); ?></h6>
                    <p class="text-muted small mb-3"><?php echo htmlspecialchars($producto['caracteristica'] ?? 'Disponible'); ?></p>
                    
                    <?php if ($is_logged_in): ?>
                        <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded-3">
                            <span class="fw-bold text-primary">$<?php echo number_format($producto['precio'], 0, ',', '.'); ?></span>
                            
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-outline-dark btn-sm w-100 rounded-pill">Iniciar sesión para ver precio</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>