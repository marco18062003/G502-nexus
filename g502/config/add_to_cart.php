<?php
// add_to_cart.php - Procesa la adición de productos al carrito de la sesión

// 1. INICIA LA SESIÓN: Esto es fundamental para que el carrito persista entre solicitudes.
session_start();

// 2. INCLUYE LA CONEXIÓN A LA BASE DE DATOS: Necesario para obtener detalles del producto.
// Asegúrate de que 'db.php' esté en la misma carpeta que add_to_cart.php.
require_once 'db.php'; 

// 3. ESTABLECE EL ENCABEZADO DE LA RESPUESTA: ¡CRÍTICO! Esto le dice al navegador que esperamos JSON.
header('Content-Type: application/json');

// 4. PREPARA EL ARRAY DE RESPUESTA: Lo usaremos para comunicarnos con JavaScript.
$response = ['success' => false, 'message' => ''];

// 5. INICIALIZA EL CARRITO EN LA SESIÓN si aún no existe.
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// 6. VERIFICA EL MÉTODO DE LA SOLICITUD: Solo procesamos solicitudes POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 7. OBTIENE Y DECODIFICA LOS DATOS JSON ENVIADOS DESDE JAVASCRIPT.
    $input = file_get_contents('php://input');
    $data = json_decode($input, true); // 'true' para obtener un array asociativo

    // 8. EXTRAE LOS DATOS DE PRODUCTO Y CANTIDAD.
    $productId = $data['product_id'] ?? null;
    $quantity = $data['quantity'] ?? null;

    // 9. VALIDA LA ENTRADA: Asegúrate de que los datos son válidos y seguros.
    if ($productId && is_numeric($productId) && $quantity !== null && is_numeric($quantity) && $quantity > 0) {
        $productId = (int)$productId; // Convierte a entero para seguridad
        $quantity = (int)$quantity;   // Convierte a entero para seguridad

        // 10. LÓGICA DEL CARRITO: Actualiza la cantidad si el producto ya existe, o lo añade.
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
            $response['success'] = true;
            $response['message'] = 'Cantidad del producto actualizada en el carrito.';
        } else {
            // Si es un producto nuevo, OBTÉN SUS DETALLES DE LA BASE DE DATOS.
            // Asegúrate de que 'donjorgito1' y los nombres de las columnas ('producto', 'precio', 'imagen', 'caracteristica')
            // coincidan con los de tu tabla de productos.
            $stmt = mysqli_prepare($conn, "SELECT producto, precio, imagen, caracteristica FROM donjorgito1 WHERE id = ?"); 
            
            // Manejo de errores si la preparación de la consulta falla
            if ($stmt === false) {
                $response['message'] = 'Error en la preparación de la consulta SQL: ' . mysqli_error($conn);
                echo json_encode($response); // Envía la respuesta JSON de error
                exit(); // Detiene la ejecución del script
            }

            mysqli_stmt_bind_param($stmt, "i", $productId); // 'i' indica que $productId es un entero
            mysqli_stmt_execute($stmt); // Ejecuta la consulta
            $result = mysqli_stmt_get_result($stmt); // Obtiene el resultado
            $product = mysqli_fetch_assoc($result); // Obtiene la fila como un array asociativo

            // 11. SI EL PRODUCTO SE ENCONTRÓ EN LA DB, AÑÁDELO AL CARRITO DE SESIÓN.
            if ($product) {
                $_SESSION['cart'][$productId] = [
                    'name' => $product['producto'],
                    'price' => $product['precio'],
                    'quantity' => $quantity,
                    'image_name' => $product['imagen'], 
                    'caracteristica' => $product['caracteristica']
                ];
                $response['success'] = true;
                $response['message'] = 'Producto añadido al carrito.';
            } else {
                $response['message'] = 'Producto no encontrado en la base de datos con el ID proporcionado.';
            }
            mysqli_stmt_close($stmt); // Cierra la declaración preparada
        }
        
        // 12. CALCULA EL TOTAL DE ÍTEMS EN EL CARRITO para poder actualizar el frontend.
        $total_items_in_cart = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total_items_in_cart += $item['quantity'];
        }
        $response['cart_total_items'] = $total_items_in_cart;

    } else {
        $response['message'] = 'Datos de producto (ID o cantidad) inválidos o faltantes en la solicitud.';
    }
} else {
    // 13. SI LA SOLICITUD NO ES POST, ENVIAR UN MENSAJE DE ERROR.
    $response['message'] = 'Método de solicitud no permitido. Se requiere POST.';
}

// 14. ENCODIFICA LA RESPUESTA PHP A JSON Y LA ENVÍA AL NAVEGADOR.
echo json_encode($response);

// 15. TERMINA LA EJECUCIÓN DEL SCRIPT. ¡CRÍTICO para evitar salidas adicionales!
exit(); 
?>