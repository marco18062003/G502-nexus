<?php
session_start();
require_once '../config/db.php'; 

// 1. Verificación de Usuario
$is_logged_in = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
$user_name = '';

if ($is_logged_in) {
    $user_name = htmlspecialchars($_SESSION['nombre_usuario']);
    $user_id = $_SESSION['user_id'];
} else {
    header("Location: login.php");
    exit;
}

// 2. Consulta de Favoritos
$productos_favoritos = [];
$sql_favs = "SELECT p.id, p.producto, p.imagen, p.precio, p.ca 
             FROM donjorgito1 p 
             INNER JOIN favoritos f ON p.id = f.producto_id 
             WHERE f.usuario_id = '$user_id'";

$result_favs = mysqli_query($conn, $sql_favs);

if ($result_favs) {
    while ($row = mysqli_fetch_assoc($result_favs)) {
        $productos_favoritos[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Mis Favoritos | DON JORGITO</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

    <style>
        :root { --azul-oscuro: #001f3f; }
        .fav-main-content { padding: 50px 0; min-height: 65vh; background-color: #f8f9fa; }
        .product-card-fav { 
            background: white; border-radius: 12px; padding: 20px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.08); position: relative;
            transition: transform 0.2s; height: 100%; display: flex; flex-direction: column;
        }
        .btn-delete-fav {
            position: absolute; top: 12px; right: 12px; color: #ff4d4d;
            border: none; background: none; font-size: 1.2rem; cursor: pointer; z-index: 10;
        }
        .img-fav-container { height: 160px; display: flex; align-items: center; justify-content: center; margin-bottom: 15px; }
        .img-fav-container img { max-height: 100%; object-fit: contain; }
        
        /* Botón personalizado g502 */
        .btn-g502-cart {
            background-color: var(--azul-oscuro);
            color: white;
            border: none;
            font-weight: 600;
            transition: background 0.3s;
        }
        .btn-g502-cart:hover { background-color: #003366; color: white; }
        
        .quantity-control input::-webkit-outer-spin-button,
        .quantity-control input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    </style>
</head>

<body>
    
<header class="main-header">
    <div class="header-content d-flex align-items-center justify-content-between p-3 border-bottom">
        <div class="header-logo">
            <a href="index.php"><img src="../images/logo1.png" alt="Logo" width="150"></a>
        </div>
        <div class="header-user-actions">
            <a href="favoritos.php" class="btn btn-outline-dark position-relative me-2">
                <i class="fas fa-heart"></i>
                <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle"><?php echo count($productos_favoritos); ?></span>
            </a>
            <a href="ver_carrito.php" class="btn btn-outline-dark"><i class="fas fa-shopping-cart"></i></a>
        </div>
    </div>
</header>

<main class="fav-main-content">
    <div class="container">
        <h2 class="mb-4 fw-bold"><i class="fas fa-heart text-danger me-2"></i>Mis Favoritos</h2>
        
        <div class="row g-4">
            <?php if (count($productos_favoritos) > 0): ?>
                <?php foreach ($productos_favoritos as $prod): ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product-card-fav text-center">
                            
                            <button class="btn-delete-fav" onclick="confirmDelete(<?php echo $prod['id']; ?>)" title="Eliminar de favoritos">
                                <i class="fas fa-trash-alt"></i>
                            </button>

                            <div class="img-fav-container">
                                <img src="../Donjorgitofinal/<?php echo $prod['imagen']; ?>" alt="<?php echo htmlspecialchars($prod['producto']); ?>">
                            </div>

                            <div class="flex-grow-1">
                                <small class="text-muted d-block"><?php echo htmlspecialchars($prod['ca']); ?></small>
                                <h6 class="fw-bold"><?php echo htmlspecialchars($prod['producto']); ?></h6>
                                <p class="text-primary fw-bold fs-5">$<?php echo number_format($prod['precio'], 0, ',', '.'); ?></p>
                            </div>

                            <div class="quantity-control d-flex align-items-center justify-content-center mb-3">
                                <button class="btn btn-sm btn-outline-secondary px-3" onclick="changeQty(<?php echo $prod['id']; ?>, -1)">-</button>
                                <input type="number" id="quantity-<?php echo $prod['id']; ?>" value="1" min="1" readonly 
                                       class="form-control form-control-sm text-center mx-2" style="width: 50px; font-weight: bold;">
                                <button class="btn btn-sm btn-outline-secondary px-3" onclick="changeQty(<?php echo $prod['id']; ?>, 1)">+</button>
                            </div>

                            <button class="btn btn-g502-cart w-100 add-to-cart-btn" data-id="<?php echo $prod['id']; ?>">
                                <i class="fas fa-cart-plus me-2"></i>Agregar
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <i class="far fa-heart fa-4x text-muted mb-3"></i>
                    <p class="fs-5 text-muted">Aún no tienes productos guardados.</p>
                    <a href="index.php" class="btn btn-primary px-4">Explorar catálogo</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<footer class="bg-dark text-white pt-4 pb-2 mt-5">
    <div class="container text-center">
        <p class="small mb-0">DON JORGITO &copy; 2025 | Proyecto g502</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../config/carrito.js"></script>

<script>
    // Función para cambiar cantidad en el input
    function changeQty(id, delta) {
        const input = document.getElementById('quantity-' + id);
        let val = parseInt(input.value) + delta;
        if (val < 1) val = 1;
        input.value = val;
    }

    // Confirmación antes de eliminar
    function confirmDelete(id) {
        if(confirm('¿Estás seguro de quitar este producto de tus favoritos?')) {
            window.location.href = 'eliminar_favorito.php?id=' + id;
        }
    }
</script>

</body>
</html>