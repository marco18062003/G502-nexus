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

      <link rel="stylesheet" type="text/css" 
      href="assets/css/cartdesign.css?v=1730030000">

      <link rel="stylesheet" type="text/css" 
      href="assets/css/buscar.css?v=1730030000">
      
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
    <?php if ($is_logged_in && isset($_SESSION['nombre_usuario'])): ?>
        <span>¡Hola! Bienvenido <br> <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></span>
    <?php elseif ($is_logged_in): ?>
        <span>¡Hola! Bienvenido <br> Usuario</span>
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