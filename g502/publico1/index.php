<?php
session_start(); // Always start the session at the very beginning of your PHP file

// Check if the 'user_id' and 'nombre_usuario' are set in the session
// This determines if the user is logged in
$is_logged_in = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
$user_name = ''; // Initialize an empty string for the user's name

if ($is_logged_in) {
    // If logged in, get the user's name from the session
    // Make sure 'nombre_usuario' is set when you log in a user
    $user_name = htmlspecialchars($_SESSION['nombre_usuario']);
}

// --- PHP Code to Fetch Products in Trend ---
// INCLUDE YOUR DATABASE CONNECTION FILE HERE
// Make sure the path is correct. For example, if 'db.php' is in a 'config' folder:
require_once '../config/db.php'; // <--- IMPORTANT: Adjust this path as needed!

$productos_en_tendencia = []; // Initialize an empty array for products

if ($conn) { // Proceed only if the database connection is successful
    // Query to get 4 products from the 'donjorgito1' table.
    // We select id, producto (name), imagen, and precio.
    // ORDER BY id DESC to get the most recently added, or adjust based on your "trend" logic.
    $sql_tendencia = "SELECT id, producto, imagen, precio FROM donjorgito1 ORDER BY id DESC LIMIT 10";
    
    $result_tendencia = mysqli_query($conn, $sql_tendencia);

    if ($result_tendencia) {
        while ($row = mysqli_fetch_assoc($result_tendencia)) {
            $productos_en_tendencia[] = $row;
        }
        mysqli_free_result($result_tendencia); // Free the memory used by the result set
    } else {
        // Handle database query error
        echo "<div class='alert alert-warning'>Error al cargar productos en tendencia: " . mysqli_error($conn) . "</div>";
    }
    // You might want to close the connection here if you don't need it later in the page
    // mysqli_close($conn); 
} else {
    // Handle database connection error if require_once failed
    echo "<div class='alert alert-danger'>Error al conectar con la base de datos para productos en tendencia.</div>";
}

    // iamgenes cambian (move)
$base_carousel_image_path = '../images/'; 

// Array que contiene la información de cada slide
// Cada elemento del array representa un slide con su imagen, título, subtítulo y, opcionalmente, un botón.
$carousel_slides = [
    [
        'image' => $base_carousel_image_path . 'slide.jpg',
        'title' => 'PROMOCIONES ESPECIALES DE VERANO',
        'subtitle' => 'Los mejores licores con descuentos increíbles.',
        'button_text' => 'Ver Ofertas',
        'button_link' => 'buscar.php?query=promociones', // Enlace a la página de promociones
    ],
    [
        'image' => $base_carousel_image_path . 'slide-1.jpg',
        'title' => 'DESCUBRE NUESTROS PRODUCTOS EXCLUSIVOS',
        'subtitle' => 'Una selección única para paladares exigentes.',
        'button_text' => 'Explorar',
        'button_link' => 'productos.php', // Enlace a una página general de productos
    ],
    [
        'image' => $base_carousel_image_path . 'slide-3.jpg',
        'title' => 'ENVÍO RÁPIDO Y SEGURO A TU PUERTA',
        'subtitle' => 'Disfruta sin salir de casa.',
        'button_text' => 'Más Información',
        'button_link' => 'ayuda.php#envio', // Enlace a la sección de envío en tu página de ayuda
    ],
    [
        'image' => $base_carousel_image_path . 'slide-4.jpg',
        'title' => 'REGÍSTRATE Y OBTÉN UN 10% DE DESCUENTO',
        'subtitle' => 'No te pierdas nuestras ofertas exclusivas.',
        'button_text' => 'Registrarse',
        'button_link' => 'registro.php', // Enlace a la página de registro
    ],
];
// --- END PHP Code to Fetch Products in Trend ---
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>DON JORGITO</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="author" content="Marco">
  <meta name="keywords" content="Pagina de Licores">
  <link rel="icon" href="assets/icon1.png" type="image/jpeg">
  <meta name="description" content="Pagina de Licores">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" 
      href="assets/css/style.css?v=1730030000">
     

    <link rel="stylesheet" type="text/css" 
      href="assets/css/styleme.css?v=1730030000">
    
    <link rel="stylesheet" type="text/css" 
      href="assets/css/sectionmain.css?v=1730030000">
    
      <link rel="stylesheet" type="text/css" 
      href="assets/css/estilosbuscar.css?v=1730030000">
      
      <link rel="stylesheet" type="text/css" 
      href="assets/css/estilos.css?v=1730030000">

      <link rel="stylesheet" type="text/css" 
      href="assets/css/sectioncategorias.css?v=1730030000">

      <link rel="stylesheet" type="text/css" 
      href="assets/css/v¿¿carusell.css?v=1730030000">

      <link rel="stylesheet" type="text/css" 
      href="assets/css/newproducts.css?v=1730030000">
      
    <link
    href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap"
    rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">-->
  
</head>

<body>
    
  <header class="main-header">
    <div class="header-content">
        <div class="header-logo">
            <a href="index.php">
               <img src="../images/logo1.png" alt="Tu Logo" width="200" height="100">
            </a>
        </div>

        

        <div class="header-slogan">
        <?php if ($is_logged_in): ?>
            <span>¡Hola! Bienvenido <br> <?php echo $user_name; ?></span>
        <?php else: ?>
            <span>;)</span>
        <?php endif; ?>

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
            <option value="cigarrillos">Cigarrillos</option>
            <option value="comestibles">Comestibles</option>
            <option value="bebidas">bebidas</option>
            <option value="cremas">Cremas de whisky</option>
            <option value="Champaña">Champaña</option>
            <option value="Brandy">Brandy</option>
            <option value="Tequila">Tequila</option>
            <option value="Aperitivo">Aperitivo</option>
            <option value="Desechables">Desechables</option>
            <option value="Limpieza">Limpieza</option>
            <option value="Personal">Personal</option>
            <option value="otros">otros</option>
            <option value="Promoxiones">Promoxiones</option>
            
          </select>
        </form>
      </div>

        <div class="header-search">
    <div class="autocomplete-wrapper"> 
        <form action="buscar.php" method="GET">
            <div class="search-container">
                <input type="text" placeholder="Buscar productos..." name="query" class="search-input" id="buscador"> 
                <button type="submit" class="search-icon">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
        
        <div id="resultados-busqueda" class="autocomplete-dropdown">
            </div>
    </div>
</div>


        <div class="header-user-actions" >
            <a href="login.php" class="action-item" style="color:#333" aria-label="Mi Cuenta">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user" style="color:#333">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
        <circle cx="12" cy="7" r="4"></circle>
    </svg>
    <span>Cuenta</span>
</a>
            <a href="favoritos.php" class="action-item" aria-label="Mis Favoritos" style="color:#333">
                <svg xmlns="http://www.w3.org/2000/svg" style="color:#333" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
                <span>Favoritos</span>
            </a>
            <a href="ver_carrito.php" class="action-item cart-item" aria-label="Ver Carrito" style="color:#333">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="color:#333" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                
                <span>Carrito</span>
            </a>
        </div>
    </div>

    <div>
        <div id="boton-menu" style="color: white; cursor: pointer; padding: 10px; background: #232f3e; text-align: center;">
    <i class="fas fa-bars"></i> 
</div>
         <nav class="secondary-nav" style="text-align: center">
             <ul>
                 <li><a href="brand.php">Marcas</a></li>
                 <li><a href="buscar.php?query=aguardiente">Mas Vendidos</a></li>
                <li><a href="buscar.php?query=cigarrillos">Promociones</a></li>
                <li><a href="buscar.php?query=comestibles">Descuestos</a></li>
                <li><a href="hire2.php">Contratar</a></li>
                <li> <a href="weabout.php">Sobre Nosotros</a></li> 
                <li><a href="newproducts.php">Nuevo</a></li> </ul>
         </nav> 
    </div> 

</header>
        <!--images move-->
  <section>
    <div>
        <div class="slideshow slide-in arrow-absolute text-white" style="height: 80vh; width:100%; position: relative;">
            <div class="swiper-wrapper"> 
                
                <?php foreach ($carousel_slides as $index => $slide): ?>
                
                    <div class="swiper-slide jarallax <?php echo ($index === 0) ? 'swiper-slide-active' : ''; ?>">
                        
                        <img src="<?php echo htmlspecialchars($slide['image']); ?>" class="jarallax-img" alt="<?php echo htmlspecialchars($slide['title']); ?>">
                        
                        <div class="banner-content w-100">
                            <div class="container-fluid">
                                <div class="row justify-content-center text-center">
                                    <div class="col-md-10 pt-5">
                                        
                                        <h2 class="display-xl text-white ls-0 mt-5 pt-5 txt-fx slide-up">
                                            <?php echo htmlspecialchars($slide['title']); ?>
                                        </h2>
                                        
                                        <?php if (!empty($slide['subtitle'])): ?>
                                            <p class="lead mt-3 txt-fx slide-up" data-delay="0.2s">
                                                <?php echo htmlspecialchars($slide['subtitle']); ?>
                                            </p>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($slide['button_text']) && !empty($slide['button_link'])): ?>
                                            <a href="<?php echo htmlspecialchars($slide['button_link']); ?>" 
                                               class="btn btn-primary btn-lg mt-4 txt-fx slide-up" data-delay="0.4s">
                                                <?php echo htmlspecialchars($slide['button_text']); ?>
                                            </a>
                                        <?php endif; ?>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    
                <?php endforeach; ?>
                
            </div>        
            
            <div class="pagination-wrapper position-absolute">
                <div class="container">
                    <div class="slideshow-swiper-pagination text-center"></div>
                </div>
            </div>
            
            <div class="icon-arrow icon-arrow-left text-white"><svg width="50" height="50" viewBox="0 0 24 24">
                <use xlink:href="#arrow-left"></use>
            </svg></div>
            <div class="icon-arrow icon-arrow-right text-white"><svg width="50" height="50" viewBox="0 0 24 24">
                <use xlink:href="#arrow-right"></use>
            </svg></div>
            
        </div>
    </div>
</section>
                                          <!--end images move-->


                                          <!-- icon and slogen-->
                                       
  <section class="features" style="position:relative; margin-top: -230px; z-index: 10;">
    <div class="container-lg">
        <div class="bg-white p-5 shadow-lg rounded-3 my-5">
            <div class="row text-center row-cols-1 row-cols-md-2 row-cols-lg-4 gy-5">

                <!-- Feature Item: Recoger en Tienda -->
                <div class="col border-end border-2">
                    <div class="feature-item px-3">
                        <div class="text-primary mb-3">
                            <i class="fas fa-store fa-3x" style="color: #555;"></i>
                        </div>
                        <h5 class="fw-bold text-uppercase">RECOGER EN TIENDA</h5>
                        <p class="text-muted small">Compra online y retira en 30 minutos sin costo.</p>
                    </div>
                </div>

                <!-- Feature Item: Envío Rápido -->
                <div class="col border-end border-2">
                    <div class="feature-item px-3">
                        <div class="text-primary mb-3">
                            <i class="fas fa-truck-fast fa-3x"style="color: #555;"></i>
                        </div>
                        <h5 class="fw-bold text-uppercase">ENVÍO RÁPIDO Y SEGURO</h5>
                        <p class="text-muted small">Entrega garantizada en tu domicilio el mismo día.</p>
                    </div>
                </div>

                <!-- Feature Item: Garantía y Cambios -->
                <div class="col border-end border-2">
                    <div class="feature-item px-3">
                        <div class="text-primary mb-3">
                            <i class="fas fa-sync-alt fa-3x" style="color: #555;"></i> <!-- Cambio de ícono a fa-sync-alt -->
                        </div>
                        <h5 class="fw-bold text-uppercase">GARANTÍA Y CAMBIOS</h5>
                        <p class="text-muted small">Devoluciones fáciles y gratuitas en todos los productos.</p>
                    </div>
                </div>

                <!-- Feature Item: Medios de Pago -->
                <div class="col">
                    <div class="feature-item px-3">
                        <div class="text-primary mb-3">
                            <i class="fas fa-wallet fa-3x" style="color: #555;"></i>
                        </div>
                        <h5 class="fw-bold text-uppercase">VARIOS MEDIOS DE PAGO</h5>
                        <p class="text-muted small">Aceptamos **Nequi**, **Daviplata** y todas las tarjetas.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
                                          <!--end set of slogen-->

<?php
// NOTA IMPORTANTE: Se asume que $conn (conexión a la base de datos) ya está definida.

// ==========================================================
// A. LÓGICA PHP: Extracción de Categorías ÚNICAS de donjorgito1
// ==========================================================
$categorias_unicas = []; // Array para almacenar las categorías únicas
$icono_defecto = 'fas fa-tag'; // Ícono por defecto, ya que 'donjorgito1' no tiene columna de ícono

// Consulta para obtener todos los valores únicos y ordenados de la columna 'ca'
$sql_categorias_unicas = "SELECT DISTINCT ca FROM donjorgito1 WHERE ca IS NOT NULL AND ca != '' ORDER BY ca ASC"; 

$resultado_categorias_unicas = mysqli_query($conn, $sql_categorias_unicas);

if ($resultado_categorias_unicas) {
    if (mysqli_num_rows($resultado_categorias_unicas) > 0) {
        // Almacenar todas las categorías únicas
        while ($fila = mysqli_fetch_assoc($resultado_categorias_unicas)) {
            // Guardamos solo el valor de la columna 'ca'
            $categorias_unicas[] = htmlspecialchars($fila['ca']);
        }
    }
    // Liberar memoria del resultado de la consulta
    mysqli_free_result($resultado_categorias_unicas);
}
?>

<section id="navegacion-categorias-slider" class="py-5 bg-light">
    <div class="container-fluid">
        <h3 class="text-center mb-4 fw-bold text-uppercase">Explora por Categoría</h3>

        <?php if (!empty($categorias_unicas)): ?>
        <div class="categoria-slider-wrapper">
            <div class="row flex-nowrap overflow-auto g-4 pb-3" id="categoria-scroller">
                
                <?php foreach ($categorias_unicas as $nombre_categoria): ?>
                
                <div class="col-auto"> 
                    <a href="buscar.php?query=<?php echo urlencode($nombre_categoria); ?>" 
                       class="categoria-item-circle d-flex flex-column align-items-center text-decoration-none text-dark"
                       title="Ver productos de <?php echo $nombre_categoria; ?>">
                        
                        <div class="circle-icon-container shadow-sm bg-white border border-secondary border-opacity-25 p-3 mb-2">
                            <i class="<?php echo $icono_defecto; ?> fs-2 text-primary"></i>
                        </div>
                        <small class="text-center fw-semibold text-truncate w-100 px-1"><?php echo $nombre_categoria; ?></small>
                    </a>
                </div>
                
                <?php endforeach; ?>
                
            </div>
        </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                Aún no hay categorías (valores de 'ca') en la tabla donjorgito1.
            </div>
        <?php endif; ?>
        
    </div>
</section>
          <!-- end categorias slider-->
  
<?php


// ==========================================================
// A. LÓGICA PHP: Extracción de Marcas ÚNICAS de donjorgito1
// ==========================================================
$marcas_unicas = []; // Array para almacenar las marcas únicas
$icono_marca_defecto = 'fas fa-store'; // Nuevo ícono por defecto para marcas

// Consulta para obtener todos los valores únicos y ordenados de la columna 'marca'
// NOTA: Se excluyen las filas donde la marca sea NULL o vacía.
$sql_marcas_unicas = "SELECT DISTINCT marca FROM donjorgito1 WHERE marca IS NOT NULL AND marca != '' ORDER BY marca ASC"; 

$resultado_marcas_unicas = mysqli_query($conn, $sql_marcas_unicas);

if ($resultado_marcas_unicas) {
    if (mysqli_num_rows($resultado_marcas_unicas) > 0) {
        // Almacenar todas las marcas únicas
        while ($fila = mysqli_fetch_assoc($resultado_marcas_unicas)) {
            // Guardamos solo el valor de la columna 'marca'
            $marcas_unicas[] = htmlspecialchars($fila['marca']);
        }
    }
    // Liberar memoria del resultado de la consulta
    mysqli_free_result($resultado_marcas_unicas);
}
?>
    
<section id="navegacion-marcas-slider" class="py-5">
    <div class="container-fluid">
        <h3 class="text-center mb-4 fw-bold text-uppercase">Marcas</h3>

        <?php if (!empty($marcas_unicas)): ?>
        <div class="marca-slider-wrapper">
            <div class="row flex-nowrap overflow-auto g-4 pb-3" id="marca-scroller">
                
                <?php foreach ($marcas_unicas as $nombre_marca): ?>
                
                <div class="col-auto"> 
                    <a href="buscar.php?query=<?php echo urlencode($nombre_marca); ?>" 
                       class="categoria-item-circle d-flex flex-column align-items-center text-decoration-none text-dark"
                       title="Ver productos de <?php echo $nombre_marca; ?>">
                        
                        <div class="circle-icon-container shadow-sm bg-white border border-secondary border-opacity-25 p-3 mb-2">
                            <i class="<?php echo $icono_marca_defecto; ?> fs-2 text-info"></i>
                        </div>
                        <small class="text-center fw-semibold text-truncate w-100 px-1"><?php echo $nombre_marca; ?></small>
                    </a>
                </div>
                
                <?php endforeach; ?>
                
            </div>
        </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                Aún no hay marcas (valores de 'marca') en la tabla donjorgito1.
            </div>
        <?php endif; ?>
        
    </div>
</section>
          <!-- end marcas slider-->
                                          

  <!-- productos tendecia-->
<?php
// NOTA IMPORTANTE: Se asume que $conn (conexión a la base de datos) ya está definida.

// ==========================================================
// A. LÓGICA PHP: Extracción de 1 Producto Principal (2) y 9 Mini (1)
// ==========================================================
// Inicializar variables
$es_tendencia = null; // Producto Principal
$productos_mini = []; // Productos Mini

// 1. OBTENER EL PRODUCTO PRINCIPAL (es_tendencia = 2)
$sql_principal = "SELECT id, producto, precio, imagen, marca, ca 
                  FROM donjorgito1 
                  WHERE es_tendencia = 2 
                  LIMIT 1"; 

$resultado_principal = mysqli_query($conn, $sql_principal);

if ($resultado_principal) {
    if (mysqli_num_rows($resultado_principal) > 0) {
        $es_tendencia = mysqli_fetch_assoc($resultado_principal);
        mysqli_free_result($resultado_principal);
    }
}


// 2. OBTENER LOS 9 PRODUCTOS MINI (es_tendencia = 1)
$sql_mini = "SELECT id, producto, precio, imagen, marca, ca 
             FROM donjorgito1 
             WHERE es_tendencia = 1 
             LIMIT 9"; // Los 9 productos mini

$resultado_mini = mysqli_query($conn, $sql_mini);

if ($resultado_mini) {
    if (mysqli_num_rows($resultado_mini) > 0) {
        // Almacenar todos los mini productos
        while ($fila = mysqli_fetch_assoc($resultado_mini)) {
            $productos_mini[] = $fila;
        }
    }
    mysqli_free_result($resultado_mini);
}
?>

<section id="ofertas-proporcionales-9" class="py-5">
    <div class="container-fluid">
        <h3 class="text-center mb-5 fw-bold text-uppercase">OFERTAS EXCLUSIVAS DonJorgito</h3>
        
        <div class="row g-3" id="ofertas-grid-v9"> 
            
            <?php 
            // CONDICIÓN: Verifica que exista el producto destacado (2) Y al menos 1 miniatura (1)
            if ($es_tendencia && !empty($productos_mini)): 
            ?>

            <div class="col-12 col-lg-6">
                <div class="promo-grande-contenedor shadow h-100">
                    <a href="buscar.php?query=<?php echo htmlspecialchars($es_tendencia['id']); ?>" class="d-block h-100" title="Ver Oferta Destacada">
                        
                        <span class="promo-tag badge bg-warning text-dark position-absolute top-0 start-0 m-3 fs-6 z-100">
                            🔥 MÁS VENDIDO
                        </span>

                        <img src="../Donjorgitofinal/<?php echo htmlspecialchars($es_tendencia['imagen']); ?>" 
                             class="img-fluid rounded w-100 h-100 object-fit-cover promo-imagen" 
                             alt="<?php echo htmlspecialchars($es_tendencia['producto']); ?>">
                        
                        <div class="item-info-overlay text-white p-4">
                            <p class="mb-1 fw-normal text-opacity-75"><?php echo htmlspecialchars($es_tendencia['ca']); ?></p> 
                            <span class="fw-bolder display-6"><?php echo htmlspecialchars($es_tendencia['producto']); ?></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="row g-3" id="mini-grid-ajuste-9">
                    <?php 
                    $contador_mini = 0;
                    // BUCLE: Itera sobre los productos mini (es_tendencia = 1)
                    foreach ($productos_mini as $producto):
                        $contador_mini++;
                        if ($contador_mini > 9) break; 
                    ?>
                        <div class="col-4"> 
                            <div class="mini-promo-item shadow-sm">
                                <a href="buscar.php?query=<?php echo htmlspecialchars($producto['id']); ?>" class="d-block promo-link-wrapper h-100" title="<?php echo htmlspecialchars($producto['producto']); ?>">
                                    
                                    <img src="../Donjorgitofinal/<?php echo htmlspecialchars($producto['imagen']); ?>" 
                                         class="img-fluid rounded w-100 h-100 object-fit-cover promo-imagen" 
                                         alt="<?php echo htmlspecialchars($producto['producto']); ?>">
                                    
                                    <div class="mini-info-static p-2">
                                        <small class="d-block text-white text-opacity-75 fw-normal text-truncate"><?php echo htmlspecialchars($producto['marca']); ?></small>
                                        <p class="mb-0 fw-bold text-truncate text-white" title="<?php echo htmlspecialchars($producto['producto']); ?>"><?php echo htmlspecialchars($producto['producto']); ?></p>
                                        <span class="text-warning fw-bolder">$<?php echo number_format($producto['precio'], 0, ',', '.'); ?></span>
                                    </div>

                                    <div class="item-hover-overlay">
                                        <i class="fas fa-search-plus text-white fs-4"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <?php 
                    // RELLENO (PLACEHOLDERS): Rellena si hay menos de 9 miniaturas.
                    $faltantes = 9 - count($productos_mini);
                    for ($i = 0; $i < $faltantes; $i++):
                    ?>
                        <div class="col-4"> 
                            <div class="mini-promo-item shadow-sm d-flex align-items-center justify-content-center bg-light text-muted">
                                <p class="text-center p-2 mb-0 small">Próximamente más productos</p>
                            </div>
                        </div>
                    <?php endfor; ?>
                    
                </div>
            </div>
            <?php else: ?>
                <div class="col-12 text-center my-5">
                    <div class="alert alert-info">
                        Aún no hay ofertas completas. Asegúrate de tener un producto con es_tendencia = 2 y al menos uno con es_tendencia = 1.
                    </div>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</section>
  <!-- end productos tendecia-->




  <section class="py-4">
    <div class="container-fluid">
      <div class="row">

        <div class="col-md-6">
          <div class="banner-ad bg-secondary-subtle mb-3"
                style="background: url('../images/imagenespresentacion/x1.png');
                      background-repeat: no-repeat;
                      background-position: right bottom;
                       background-size: 295px 244px;">
           <div class="banner-content p-5">

             <div class="fs-6 pt-5">Hasta un 25% de descuento</div>
             <h3 class="banner-title">CLUB COLOMBIA</h3>
             <a href="buscar.php?query=bavaria" class="btn btn-dark text-uppercase">MOSTRAR</a>

           </div>

          </div>
        </div>
        <div class="col-md-6">
          <div class="banner-ad bg-secondary-subtle"
            style="background: url('../images/imagenespresentacion/x2.png');
                      background-repeat: no-repeat;
                      background-position: right bottom;
                       background-size: 295px 244px;">
           <div class="banner-content p-5">

             <div class="fs-6 pt-5">Hasta un 25% de descuento</div>
             <h3 class="banner-title">AGUILA</h3>
             <a href="buscar.php?query=bavaria" class="btn btn-dark text-uppercase">MOSTRAR</a>

           </div>

          </div>
        </div>

      </div>
    </div>
  </section>

<?php

// ==========================================================
// A. LÓGICA PHP: Extracción de Productos Más Vendidos (es_tendencia = 1)
// ==========================================================
$productos_mas_vendidos = []; // Array para almacenar los productos

// Consulta para obtener todos los productos marcados como mini/más vendidos (es_tendencia = 1)
$sql_vendidos = "SELECT id, producto, precio, imagen, marca 
                 FROM donjorgito1 
                 WHERE es_tendencia = 1 
                 ORDER BY RAND() 
                 LIMIT 20"; // Límite de 20 productos para el slider

$resultado_vendidos = mysqli_query($conn, $sql_vendidos);

if ($resultado_vendidos) {
    if (mysqli_num_rows($resultado_vendidos) > 0) {
        // Almacenar todos los productos
        while ($fila = mysqli_fetch_assoc($resultado_vendidos)) {
            $productos_mas_vendidos[] = $fila;
        }
    }
    // Liberar memoria del resultado de la consulta
    mysqli_free_result($resultado_vendidos);
}
?>

<section id="slider-mas-vendidos" class="py-5 bg-white">
    <div class="container-fluid">
        <h3 class="text-center mb-4 fw-bold text-uppercase text-danger">🛒 Nuestros Prodcutos Más Vendidos</h3>

        <?php if (!empty($productos_mas_vendidos)): ?>
        <div class="vendidos-slider-wrapper">
            <div class="row flex-nowrap overflow-auto g-3 pb-3" id="vendidos-scroller">
                
                <?php foreach ($productos_mas_vendidos as $producto): ?>
                
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-auto"> 
                    <a href="buscar.php?query=<?php echo htmlspecialchars($producto['id']); ?>" 
                       class="d-block card-cuadrado-link text-decoration-none h-100 shadow-sm border"
                       title="<?php echo htmlspecialchars($producto['producto']); ?>">
                        
                        <div class="item-square-container">
                            <img src="../Donjorgitofinal/<?php echo htmlspecialchars($producto['imagen']); ?>" 
                                 class="img-fluid w-100 h-100 object-fit-cover" 
                                 alt="<?php echo htmlspecialchars($producto['producto']); ?>">
                        </div>
                            
                        <div class="item-info-vendidos p-2 text-dark">
                            <small class="d-block text-muted text-truncate"><?php echo htmlspecialchars($producto['marca']); ?></small>
                            <p class="mb-0 fw-semibold text-truncate" title="<?php echo htmlspecialchars($producto['producto']); ?>"><?php echo htmlspecialchars($producto['producto']); ?></p>
                            <span class="text-danger fw-bolder">$<?php echo number_format($producto['precio'], 0, ',', '.'); ?></span>
                        </div>
                    </a>
                </div>
                
                <?php endforeach; ?>
                
            </div>
        </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                Aún no hay productos marcados como "Más Vendidos" (es_tendencia = 1) en la tabla donjorgito1.
            </div>
        <?php endif; ?>
        
    </div>
</section>
          <!-- end mas vendidos slider-->



  <section class="py-5">
    <div class="container-fluid">
      <div class="row">

        <div class="col-md-6">
          <div class="banner-ad bg-secondary-subtle mb-3"
            style="background: url('https://pngimg.com/uploads/red_bull/red_bull_PNG2.png');
                      background-repeat: no-repeat;
                      background-position: right bottom;
                       background-size: 295px 244px;"><div class="banner-content p-5">

             <div class="fs-6 pt-5">Upto 25% Off</div>
             <h3 class="banner-title">RED BULL</h3>
             <a href="buscar.php?query=comestibles" class="btn btn-dark text-uppercase">MOSTRAR</a>

           </div>

          </div>
        </div>
        <div class="col-md-6">
          <div class="banner-ad bg-secondary-subtle"
            style="background: url('../images/imagenespresentacion/x4.png');
                      background-repeat: no-repeat;
                      background-position: right bottom;
                       background-size: 295px 244px;"><div class="banner-content p-5">

             <div class="fs-6 pt-5">Upto 25% Off</div>
             <h3 class="banner-title">SIX PACK</h3>
             <a href="buscar.php?query=bavaria" class="btn btn-dark text-uppercase">MOSTRAR</a>

           </div>

          </div>
        </div>

      </div>
    </div>
  </section>

<!-- productos nuevos-->
<section class="py-5" style="background: #f8fafc; overflow: hidden;">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold" style="color: #1e293b; letter-spacing: -1px;">
                <span style="border-left: 5px solid #2563eb; padding-left: 15px;">Productos Nuevos</span>
            </h3>
            <div class="d-none d-md-block">
                <small class="text-muted">Desliza para explorar →</small>
            </div>
        </div>
        
        <div class="product-slider d-flex flex-nowrap overflow-auto" id="productos-nuevos-scroller"> 

            <?php if (!empty($productos_en_tendencia)): ?>
                <?php foreach ($productos_en_tendencia as $producto): ?>
                
                <div class="col-auto mb-4"> 
                    <div class="product-item"> 
                        <div class="badge-premium"></div>

                        <figure>
                            <a href="buscar.php?query=<?php echo $producto['id']; ?>">
                                <?php if (!empty($producto['imagen'])): ?>
                                    <img src="../Donjorgitofinal/<?php echo htmlspecialchars($producto['imagen']); ?>" 
                                         alt="<?php echo htmlspecialchars($producto['producto']); ?>" 
                                         loading="lazy">
                                <?php else: ?>
                                    <div class="no-image-placeholder d-flex flex-column align-items-center justify-content-center" style="height: 220px; background: #f1f5f9;">
                                        <i class="fas fa-image fa-2x text-muted mb-2"></i>
                                        <span class="small text-muted">Sin vista previa</span>
                                    </div>
                                <?php endif; ?>
                            </a>
                        </figure>

                        <div class="product-info p-3">
                            <h5 class="text-truncate mb-1" title="<?php echo htmlspecialchars($producto['producto']); ?>">
                                <?php echo htmlspecialchars($producto['producto']); ?>
                            </h5>
                            
                            <p class="text-muted small mb-3">
                                <?php echo htmlspecialchars($producto['caracteristica'] ?? 'Edición Especial'); ?>
                            </p>

                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <?php if ($is_logged_in): ?>
                                    <span class="price-tag">
                                        $<?php echo number_format($producto['precio'], 0, ',', '.'); ?>
                                    </span>
                                    
                                <?php else: ?>
                                    <a href="login.php" class="btn btn-sm btn-outline-primary w-100 rounded-pill">
                                        Ver Precio
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php endforeach; ?>
            <?php else: ?>
                <div class='col-12 text-center py-5'>
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Próximamente nuevos productos para ti.</p>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</section>

<!-- end productos nuevos-->
 


  
<section id="beneficios-g502" class="py-5 bg-light">
    <div class="container-fluid">
        <h2 class="text-center mb-5 fw-bold text-uppercase text-secondary">¿Por qué comprar en G502?</h2> 
        
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-4 text-center">
            
            <div class="col">
                <div class="feature-item p-3 p-md-4 border rounded shadow-sm bg-white h-100">
                    <div class="mb-3 text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M21.5 15a3 3 0 0 0-1.9-2.78l1.87-7a1 1 0 0 0-.18-.87A1 1 0 0 0 20.5 4H6.8l-.33-1.26A1 1 0 0 0 5.5 2h-2v2h1.23l2.48 9.26a1 1 0 0 0 1 .74H18.5a1 1 0 0 1 0 2h-13a1 1 0 0 0 0 2h1.18a3 3 0 1 0 5.64 0h2.36a3 3 0 1 0 5.82 1a2.94 2.94 0 0 0-.4-1.47A3 3 0 0 0 21.5 15Zm-3.91-3H9L7.34 6H19.2ZM9.5 20a1 1 0 1 1 1-1a1 1 0 0 1-1 1Zm8 0a1 1 0 1 1 1-1a1 1 0 0 1-1 1Z" />
                        </svg>
                    </div>
                    <h5 class="fw-bold mb-1 fs-6 text-dark">Envío Rápido</h5>
                    <p class="card-text small text-muted">Entrega a domicilio garantizada.</p>
                </div>
            </div>

            <div class="col">
                <div class="feature-item p-3 p-md-4 border rounded shadow-sm bg-white h-100">
                    <div class="mb-3 text-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M19.63 3.65a1 1 0 0 0-.84-.2a8 8 0 0 1-6.22-1.27a1 1 0 0 0-1.14 0a8 8 0 0 1-6.22 1.27a1 1 0 0 0-.84.2a1 1 0 0 0-.37.78v7.45a9 9 0 0 0 3.77 7.33l3.65 2.6a1 1 0 0 0 1.16 0l3.65-2.6A9 9 0 0 0 20 11.88V4.43a1 1 0 0 0-.37-.78ZM18 11.88a7 7 0 0 1-2.93 5.7L12 19.77l-3.07-2.19A7 7 0 0 1 6 11.88v-6.3a10 10 0 0 0 6-1.39a10 10 0 0 0 6 1.39Zm-4.46-2.29l-2.69 2.7l-.89-.9a1 1 0 0 0-1.42 1.42l1.6 1.6a1 1 0 0 0 1.42 0L15 11a1 1 0 0 0-1.42-1.42Z" />
                        </svg>
                    </div>
                    <h5 class="fw-bold mb-1 fs-6 text-dark">Pago 100% Seguro</h5>
                    <p class="card-text small text-muted">Transacciones protegidas y cifradas.</p>
                </div>
            </div>
            
            <div class="col">
                <div class="feature-item p-3 p-md-4 border rounded shadow-sm bg-white h-100">
                    <div class="mb-3 text-warning">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M22 5H2a1 1 0 0 0-1 1v4a3 3 0 0 0 2 2.82V22a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-9.18A3 3 0 0 0 23 10V6a1 1 0 0 0-1-1Zm-7 2h2v3a1 1 0 0 1-2 0Zm-4 0h2v3a1 1 0 0 1-2 0ZM7 7h2v3a1 1 0 0 1-2 0Zm-3 4a1 1 0 0 1-1-1V7h2v3a1 1 0 0 1-1 1Zm10 10h-4v-2a2 2 0 0 1 4 0Zm5 0h-3v-2a4 4 0 0 0-8 0v2H5v-8.18a3.17 3.17 0 0 0 1-.6a3 3 0 0 0 4 0a3 3 0 0 0 4 0a3 3 0 0 0 4 0a3.17 3.17 0 0 0 1 .6Zm2-11a1 1 0 0 1-2 0V7h2ZM4.3 3H20a1 1 0 0 0 0-2H4.3a1 1 0 0 0 0 2Z" />
                        </svg>
                    </div>
                    <h5 class="fw-bold mb-1 fs-6 text-dark">Productos Originales</h5>
                    <p class="card-text small text-muted">Garantía total de calidad.</p>
                </div>
            </div>

            <div class="col">
                <div class="feature-item p-3 p-md-4 border rounded shadow-sm bg-white h-100">
                    <div class="mb-3 text-info">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M12 8.35a3.07 3.07 0 0 0-3.54.53a3 3 0 0 0 0 4.24L11.29 16a1 1 0 0 0 1.42 0l2.83-2.83a3 3 0 0 0 0-4.24A3.07 3.07 0 0 0 12 8.35Zm2.12 3.36L12 13.83l-2.12-2.12a1 1 0 0 1 0-1.42a1 1 0 0 1 1.41 0a1 1 0 0 0 1.42 0a1 1 0 0 1 1.41 0a1 1 0 0 1 0 1.42ZM12 2A10 10 0 0 0 2 12a9.89 9.89 0 0 0 2.26 6.33l-2 2a1 1 0 0 0-.21 1.09A1 1 0 0 0 3 22h9a10 10 0 0 0 0-20Zm0 18H5.41l.93-.93a1 1 0 0 0 0-1.41A8 8 0 1 1 12 20Z" />
                        </svg>
                    </div>
                    <h5 class="fw-bold mb-1 fs-6 text-dark">Soporte 24/7</h5>
                    <p class="card-text small text-muted">Ayuda disponible cuando la necesites.</p>
                </div>
            </div>

            <div class="col">
                <div class="feature-item p-3 p-md-4 border rounded shadow-sm bg-white h-100">
                    <div class="mb-3 text-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M18 7h-.35A3.45 3.45 0 0 0 18 5.5a3.49 3.49 0 0 0-6-2.44A3.49 3.49 0 0 0 6 5.5A3.45 3.45 0 0 0 6.35 7H6a3 3 0 0 0-3 3v2a1 1 0 0 0 1 1h1v6a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3v-6h1a1 1 0 0 0 1-1v-2a3 3 0 0 0-3-3Zm-7 13H8a1 1 0 0 1-1-1v-6h4Zm0-9H5v-1a1 1 0 0 1 1-1h5Zm0-4H9.5A1.5 1.5 0 1 1 11 5.5Zm2-1.5A1.5 1.5 0 1 1 14.5 7H13ZM17 19a1 1 0 0 1-1 1h-3v-7h4Zm2-8h-6V9h5a1 1 0 0 1 1 1Z" />
                        </svg>
                    </div>
                    <h5 class="fw-bold mb-1 fs-6 text-dark">Ofertas y Descuentos</h5>
                    <p class="card-text small text-muted">Los mejores precios del mercado.</p>
                </div>
            </div>

        </div>
    </div>
</section>

  <footer class="main-footer pt-5 pb-4">
    <div class="container-lg">
        <div class="row">
            
            <div class="col-md-4 mb-4 mb-md-0 text-center text-md-start">
                <h5 class="text-uppercase fw-bold mb-3">DON JORGITO</h5>
                <p class="small">
                    Tu tienda de licores de confianza. <br>
                    ¡Disfruta responsablemente!
                </p>
                <ul class="list-unstyled small mt-3">
                    <li><i class="fas fa-map-marker-alt me-2"></i> Dirección ####</li>
                    <li><i class="fas fa-phone me-2"></i> +57 ####</li>
                    <li><i class="fas fa-envelope me-2"></i> contacto@donjorgito.com</li>
                </ul>
            </div>

            <div class="col-md-4 mb-4 mb-md-0 text-center">
                <h5 class="text-uppercase fw-bold mb-3">Enlaces Rápidos</h5>
                <ul class="list-unstyled">
                    <li><a href="index.php" class="text-decoration-none text-white small">Inicio</a></li>
                    <li><a href="buscar.php?query=a" class="text-decoration-none text-white small">Productos</a></li>
                    <li><a href="weabout.php" class="text-decoration-none text-white small">Nuestra Historia</a></li>
                    <li><a href="politicas.php" class="text-decoration-none text-white small">Políticas</a></li>
                </ul>
            </div>

            <div class="col-md-4 text-center text-md-end">
                <h5 class="text-uppercase fw-bold mb-3">Síguenos</h5>
                <div class="social-links fs-4">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

        </div>
    </div>
    
    <div class="container-fluid border-top border-secondary mt-4 pt-3">
        <div class="text-center small">
            <p class="mb-0">&copy; <?php echo date('Y'); ?> Tu Tienda. Todos los derechos reservados. | Desarrollado para g502</p>
        </div>
    </div>
</footer>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Código de inicialización del carrusel "Productos Más Vendidos"
        const productsCarousel = new Swiper('.products-carousel', {
            // Parámetros esenciales de Swiper para ver múltiples slides
            slidesPerView: 1, 
            spaceBetween: 20, 
            loop: true, 

            // Breakpoints responsivos
            breakpoints: {
                576: { slidesPerView: 2, spaceBetween: 30, },
                768: { slidesPerView: 3, spaceBetween: 40, },
                992: { slidesPerView: 4, spaceBetween: 50, },
                1200: { slidesPerView: 5, spaceBetween: 60, },
            },

            // Flechas de navegación
            navigation: {
                nextEl: '.products-carousel-next',
                prevEl: '.products-carousel-prev',
            },

            // ... (Paginación comentada)
        });
    });
</script>
<script src="js/jquery-1.11.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jarallax@2.1.3/dist/jarallax.min.js"></script> 

<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>

<script src="js/plugins.js"></script>
<script src="js/script.js"></script>

<script src="assets/js/imagenesmove.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" 
    integrity="sha256-/JqT3SQfawR5GIIeSjXgLqj1qF6tH5A5Uf1oG3H9v2Q=" 
    crossorigin="anonymous"></script> 

<script src="assets/js/search-ia.js"></script>
<script>
// Supongamos que le pones id="boton-menu" a tu botón de 3 rayitas
document.getElementById('boton-menu').addEventListener('click', function() {
    // Esto quita o pone la clase 'abierto' a tu nav
    document.querySelector('.secondary-nav').classList.toggle('abierto');
});
</script>
</body>

</html>