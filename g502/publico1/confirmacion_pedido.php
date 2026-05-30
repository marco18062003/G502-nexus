<?php
// confirmacion_pedido.php - Procesa el pedido y lo guarda en la base de datos

session_start();

// 1. Configuración de errores para desarrollo (Recuerda cambiar a 0 en producción)
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

// Incluir el archivo de conexión a la base de datos
require_once '../config/db.php'; // ASEGÚRATE DE QUE ESTA RUTA ES CORRECTA

$order_id = 'N/A'; // Valor por defecto

// Asegúrate de que el método de la solicitud sea POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 2. Recuperar información del cliente del formulario y sanear
    $nombre_cliente = mysqli_real_escape_string($conn, $_POST['nombre_cliente'] ?? '');
    $email_cliente = mysqli_real_escape_string($conn, $_POST['email_cliente'] ?? '');
    $telefono_cliente = mysqli_real_escape_string($conn, $_POST['telefono_cliente'] ?? '');
    $direccion_cliente = mysqli_real_escape_string($conn, $_POST['direccion_cliente'] ?? '');
    $ciudad_cliente = mysqli_real_escape_string($conn, $_POST['ciudad_cliente'] ?? '');

    if (empty($nombre_cliente) || empty($email_cliente) || empty($telefono_cliente) || empty($direccion_cliente) || empty($ciudad_cliente)) {
        die("Error: Faltan datos del cliente. Por favor, completa todos los campos.");
    }

    // 3. Recuperar información del carrito de la sesión
    $cartItems = $_SESSION['cart'] ?? [];

    if (empty($cartItems)) {
        die("Error: El carrito está vacío. No se puede procesar un pedido sin productos.");
    }

    $totalCartPrice = 0;
    foreach ($cartItems as $item) {
        $totalCartPrice += (float)($item['price'] * $item['quantity']);
    }
    
    // Asumimos un id_cliente dummy (0) si no tienes registro de usuarios
// Use logged-in user ID if available, otherwise 0 for guests
$id_cliente = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 
              (isset($_POST['id_cliente']) ? (int)$_POST['id_cliente'] : 0);

    // Iniciar una transacción de base de datos
    mysqli_begin_transaction($conn);

    try {
        // 4. Insertar el pedido en la tabla 'pedidos'
        // *** CAMBIO CRUCIAL: Se añaden id_cliente, total, total_pedido, y estado_pedido (pendiente) ***
        $sql_pedido = "INSERT INTO pedidos 
                       (id_cliente, nombre_cliente, email_cliente, telefono_cliente, direccion_cliente, ciudad_cliente, total_final, total_pedido, fecha_pedido, estado_pedido) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'pendiente')";
                       
        $stmt_pedido = mysqli_prepare($conn, $sql_pedido);
        if (!$stmt_pedido) {
            throw new Exception("Error al preparar la consulta de pedido: " . mysqli_error($conn));
        }
        
        // Tipos de datos: i (id_cliente), sssss (datos cliente), dd (totales)
        mysqli_stmt_bind_param($stmt_pedido, "isssssdd", 
            $id_cliente, 
            $nombre_cliente, 
            $email_cliente, 
            $telefono_cliente, 
            $direccion_cliente, 
            $ciudad_cliente, 
            $totalCartPrice, // Columna 'total'
            $totalCartPrice  // Columna 'total_pedido'
        );
        
        if (!mysqli_stmt_execute($stmt_pedido)) {
            throw new Exception("Error al ejecutar la inserción del pedido: " . mysqli_stmt_error($stmt_pedido));
        }

        $order_id = mysqli_insert_id($conn); // Obtener el ID del pedido

        mysqli_stmt_close($stmt_pedido); 

        // 5. Insertar los detalles del pedido en la tabla 'detalle_pedido'
        // Se ha corregido la cadena de tipos de bind_param.
        $sql_detalle = "INSERT INTO detalle_pedido (id_pedido, id_producto, nombre_producto, caracteristica, cantidad, precio_unitario, total) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_detalle = mysqli_prepare($conn, $sql_detalle);
        if (!$stmt_detalle) {
            throw new Exception("Error al preparar la consulta de detalle de pedido: " . mysqli_error($conn));
        }

        foreach ($cartItems as $productId => $item) {
            $prod_id = (int)$productId; 
            $caracteristica_value = $item['caracteristica'] ?? ''; // Usamos string vacío si no existe
            $line_total = (float)($item['price'] * $item['quantity']); // Total de la línea
            
            // Tipos: i (id_pedido), i (id_producto), s (nombre), s (caracteristica), i (cantidad), d (precio_unitario), d (total_linea)
            mysqli_stmt_bind_param($stmt_detalle, "iissidd", 
                $order_id, 
                $prod_id, 
                $item['name'], 
                $caracteristica_value, 
                $item['quantity'], 
                $item['price'], 
                $line_total
            );
            
            if (!mysqli_stmt_execute($stmt_detalle)) {
                throw new Exception("Error al ejecutar la inserción del detalle: " . mysqli_stmt_error($stmt_detalle));
            }
        }

        mysqli_stmt_close($stmt_detalle); 

        // Si todo fue exitoso, confirmar la transacción
        mysqli_commit($conn);

        // 6. Vaciar el carrito después de un pedido exitoso
        unset($_SESSION['cart']);

    } catch (Exception $e) {
        // Si hay algún error, revertir la transacción
        mysqli_rollback($conn);
        error_log("Error al guardar el pedido: " . $e->getMessage());
        // Muestra un mensaje detallado SÓLO durante el desarrollo:
        $errorMessage = "Hubo un error al procesar tu pedido. Inténtalo de nuevo. Error: " . $e->getMessage();
        die($errorMessage); 
    } finally {
        mysqli_close($conn);
    }

} 
// El resto del script sigue mostrando la página de confirmación HTML
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Confirmado - Don Jorgito</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="stylesheet" href="estilosbuscar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="styleme.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../publico1/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="../publico1/assets/css/styleme.css">
    <style>
        /* ... (tus estilos CSS) ... */
        .confirmation-container {
            max-width: 700px;
            margin: 80px auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            border-radius: 10px;
            text-align: center;
        }
        .confirmation-container h1 {
            color: #28a745;
            margin-bottom: 20px;
            font-size: 2.5em;
        }
        .confirmation-container p {
            font-size: 1.1em;
            color: #555;
            margin-bottom: 15px;
        }
        .confirmation-container .order-id {
            font-size: 1.3em;
            font-weight: bold;
            color: #007bff;
        }
        .confirmation-container .btn-continue {
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1.1em;
            margin-top: 30px;
            display: inline-block;
        }
        .confirmation-container .btn-continue:hover {
            background-color: #0056b3;
        }
        .fas.fa-check-circle {
            font-size: 4em;
            color: #28a745;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <header class="main-header">
    <div class="header-content">
        <div class="header-logo">
            <a href="index.php">
               <img src="../images/logo1.png" alt="Tu Logo" width="200" height="100">
            </a>
        </div>

        <div class="header-slogan" sty>
            <span> ;) </span>
        </div>

      <div class="header-dropdown-menu">
        <form id="categoryForm" action="buscar.php" method="GET">
           <select class="category-select" name="query" aria-label="Seleccionar categoría" style="background-color:#232f3e;color:#f8f8f8" onchange="this.form.submit()">
             <option selected value="all">Categorías</option>
             <option value="cerveza">Cerveza</option>
             <option value="aguardiente">Aguardiente</option>
             <option value="ron">Ron</option>
             <option value="whisky">Whisky</option>
             <option value="vinos">Vinos</option>
             <option value="cremas">Cremas de whisky</option>
             <option value="cigarrillos">Cigarrillos</option>
             <option value="comestibles">Comestibles</option>
             <option value="otros">Otros</option>
           </select>
        </form>
      </div>

        <div class="header-search">
          <form action="buscar.php" method="GET">
               <div class="search-container">
             <input type="text" placeholder="Buscar productos..." name="query" class="search-input">
             <button type="submit" class="search-icon">
                 <i class="fas fa-search"></i> </button>
               </div>
          </form>
        </div>


        <div class="header-user-actions" >
            <a href="login.php" class="action-item" style="color:#333" aria-label="Mi Cuenta">
     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user" style="color:#333">
         <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
         <circle cx="12" cy="7" r="4"></circle>
     </svg>
     <span>Cuenta</span>
</a>
            <a href="donjorgito.php" class="action-item" aria-label="Mis Favoritos" style="color:#333">
                 <svg xmlns="http://www.w3.org/2000/svg" style="color:#333" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart">
                     <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                 </svg>
                 <span>Favoritos</span>
            </a>
            <a href="ver_carrito.php" class="action-item cart-item" aria-label="Ver Carrito" style="color:#333">
                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="color:#333" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart">
                     <circle cx="9" cy="21" r="1"></circle>
                     <circle cx="20" cy="21" r="1"></circle>
                     <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                 </svg>
                 <span class="cart-count">0</span>
                 <span>Carrito</span>
            </a>
        </div>
    </div>

    <nav class="secondary-nav" style="text-align: center">
    <ul>
        <li><a href="buscar.php?query=cerveza">Cerveza</a></li>
        <li><a href="buscar.php?query=aguardiente">Aguardiente</a></li>
        <li><a href="buscar.php?query=ron">Ron</a></li>
        <li><a href="buscar.php?query=whisky">Whisky</a></li>
        <li><a href="buscar.php?query=vinos">Vinos</a></li>
        <li><a href="buscar.php?query=cremas">Cremas</a></li>
        <li><a href="buscar.php?query=cigarrillos">Cigarrillos</a></li>
        <li><a href="buscar.php?query=comestibles">Comestibles</a></li>
        <li><a href="buscar.php?query=otros">Promoxion</a></li>
        <li><a href="buscar.php?query=otros">Mas Vendidos</a></li>
        <li><a href="buscar.php?query=otros">Descuentos</a></li>
    </ul>
</nav>

</header style="borden:0px">

    <main class="container">
        <div class="confirmation-container">
            <i class="fas fa-check-circle"></i>
            <h1>¡Pedido Confirmado!</h1>
            <p>Gracias por tu compra en Don Jorgito.</p>
            <p>Tu pedido con ID: <span class="order-id">#<?php echo htmlspecialchars($order_id); ?></span> ha sido recibido con éxito.</p>
            <p>Hemos enviado una confirmación a tu correo electrónico. Te contactaremos pronto para coordinar la entrega.</p>
            <a href="index.php" class="btn-continue">Volver a la Tienda</a>
        </div>
    </main>

    <footer class="main-footer">
        <div class="footer-content">
            <p>&copy; <?php echo date('Y'); ?> Tu Tienda. Todos los derechos reservados.</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>
</body>
</html>