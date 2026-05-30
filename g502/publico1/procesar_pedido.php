<?php
// procesar_pedido.php - Guarda el pedido en la BD y envía un correo electrónico

session_start(); // ¡Importante! Siempre al inicio del archivo

// Asegúrate de que este archivo exista y la conexión a la BD sea correcta
require_once '../config/db.php'; 

// --- Configuración de Correo ---
// Cambia estas direcciones por las reales de tu tienda.
// Es crucial que el 'From' sea de un dominio válido para evitar problemas de SPAM.
$admin_email = "tu_correo_admin@donjorgito.com"; // <-- CORREO DEL ADMINISTRADOR/PROPIETARIO DE LA TIENDA
$from_email = "no-responder@tudominio.com"; // <-- CAMBIA 'tudominio.com' por el dominio real de tu sitio web
$reply_to_email = $admin_email; // Las respuestas irán al administrador


// Solo procesa si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Recoger datos del cliente desde el formulario y sanitizarlos
    $nombre_cliente = htmlspecialchars(trim($_POST['nombre_cliente'] ?? ''));
    $email_cliente = htmlspecialchars(trim($_POST['email_cliente'] ?? ''));
    $telefono_cliente = htmlspecialchars(trim($_POST['telefono_cliente'] ?? ''));
    $direccion_cliente = htmlspecialchars(trim($_POST['direccion_cliente'] ?? ''));
    $ciudad_cliente = htmlspecialchars(trim($_POST['ciudad_cliente'] ?? ''));

    // --- Validación de datos de entrada ---
    $errors = []; // Array para guardar errores de validación

    if (empty($nombre_cliente)) $errors[] = "El nombre del cliente es obligatorio.";
    if (empty($email_cliente)) $errors[] = "El email del cliente es obligatorio.";
    if (empty($telefono_cliente)) $errors[] = "El teléfono del cliente es obligatorio.";
    if (empty($direccion_cliente)) $errors[] = "La dirección del cliente es obligatoria.";
    if (empty($ciudad_cliente)) $errors[] = "La ciudad del cliente es obligatoria.";
    
    if (!empty($email_cliente) && !filter_var($email_cliente, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El formato del correo electrónico no es válido.";
    }

    // Si hay errores de validación, redirigir o mostrar un mensaje
    if (!empty($errors)) {
        // Podrías pasar los errores a la página anterior o mostrarlos directamente
        // Para simplificar, aquí se detiene la ejecución y se muestra el error
        // En un entorno real, redirigirías a la página del formulario con mensajes de error.
        die("Errores de validación: <br>" . implode("<br>", $errors));
    }

    // Asegurarse de que el carrito no esté vacío
    if (empty($_SESSION['cart'])) {
        header("Location: ver_carrito.php?error=carrito_vacio");
        exit();
    }

    $cartItems = $_SESSION['cart'];
    $totalPedido = 0;

    // Calcular el total del pedido
    foreach ($cartItems as $item) {
        $price = is_numeric($item['price']) ? (float)$item['price'] : 0;
        $quantity = is_numeric($item['quantity']) ? (int)$item['quantity'] : 0;
        $totalPedido += $price * $quantity;
    }

    // 2. Iniciar transacción para asegurar la integridad de los datos
    mysqli_autocommit($conn, FALSE); // Desactivar el auto-commit
    $insert_pedido_success = false;
    $id_pedido = 0; // Inicializar por si falla

    // 3. Guardar el pedido en la tabla `pedidos`
    $stmt_pedido = mysqli_prepare($conn, "INSERT INTO pedidos (nombre_cliente, email_cliente, telefono_cliente, direccion_cliente, ciudad_cliente, total_pedido, estado_pedido) VALUES (?, ?, ?, ?, ?, ?, 'pendiente')");
    
    if ($stmt_pedido === false) {
        // Log de error y reversión si la preparación falla
        error_log("Error de preparación de statement para pedidos: " . mysqli_error($conn));
        mysqli_rollback($conn); // Revertir cualquier cosa que se haya hecho
        die("Error interno al procesar el pedido. Por favor, inténtalo de nuevo más tarde. (Código: P1)");
    }

    // 'sssssd' -> string, string, string, string, string, double (tipos de las variables)
    mysqli_stmt_bind_param($stmt_pedido, "sssssd", $nombre_cliente, $email_cliente, $telefono_cliente, $direccion_cliente, $ciudad_cliente, $totalPedido);

    if (mysqli_stmt_execute($stmt_pedido)) {
        $id_pedido = mysqli_insert_id($conn); // Obtener el ID del pedido recién insertado
        $insert_pedido_success = true;
    } else {
        error_log("Error al insertar pedido: " . mysqli_error($conn));
    }
    mysqli_stmt_close($stmt_pedido);

    // 4. Guardar los detalles del pedido en la tabla `detalle_pedido`
    $insert_detalle_success = true; // Asumimos éxito inicialmente
    if ($insert_pedido_success) { // Solo si el pedido principal se insertó bien
        foreach ($cartItems as $productId => $item) {
            $nombre_producto = $item['name'] ?? 'Producto Desconocido';
            $cantidad = $item['quantity'] ?? 0;
            $precio_unitario = $item['price'] ?? 0;
            $caracteristica_producto = $item['caracteristica'] ?? NULL; // Obtener la característica

            // Asegúrate de que los tipos sean correctos para bind_param
            $product_id_int = (int)$productId;
            $cantidad_int = (int)$cantidad;
            $precio_unitario_float = (float)$precio_unitario;

            // Prepara la consulta para incluir la característica
            // 'iissid' -> id_pedido(int), id_producto(int), nombre_producto(string), caracteristica(string), cantidad(int), precio_unitario(double)
            $stmt_detalle = mysqli_prepare($conn, "INSERT INTO detalle_pedido (id_pedido, id_producto, nombre_producto, caracteristica, cantidad, precio_unitario) VALUES (?, ?, ?, ?, ?, ?)");
            
            if ($stmt_detalle === false) {
                error_log("Error de preparación de statement para detalle_pedido: " . mysqli_error($conn));
                $insert_detalle_success = false;
                break; // Salir del bucle si hay un error crítico
            }
            
            mysqli_stmt_bind_param($stmt_detalle, "iissid", $id_pedido, $product_id_int, $nombre_producto, $caracteristica_producto, $cantidad_int, $precio_unitario_float);

            if (!mysqli_stmt_execute($stmt_detalle)) {
                $insert_detalle_success = false;
                error_log("Error al insertar detalle de pedido para producto ID " . $productId . ": " . mysqli_error($conn));
                break; // Salir del bucle si hay un error en la inserción de detalles
            }
            mysqli_stmt_close($stmt_detalle);
        }
    }

    // 5. Confirmar o revertir la transacción
    if ($insert_pedido_success && $insert_detalle_success) {
        mysqli_commit($conn); // Confirmar todas las operaciones si todo fue bien
        
        // 6. Vaciar el carrito después de un pedido exitoso
        unset($_SESSION['cart']); 

        // 7. Enviar correo electrónico de notificación (al administrador y al cliente)
        
        // Construir el mensaje de los detalles del pedido para los correos
        $orderDetailsMessage = "";
        foreach ($cartItems as $item) {
            $char_display = !empty($item['caracteristica']) ? " (" . htmlspecialchars($item['caracteristica']) . ")" : "";
            $orderDetailsMessage .= "- " . htmlspecialchars($item['name']) . $char_display . " (x" . htmlspecialchars($item['quantity']) . ") - $" . number_format(htmlspecialchars($item['price']), 0, ',', '.') . " c/u\n";
        }

        // --- Correo para el Administrador ---
        $email_subject_admin = "Nuevo Pedido de Don Jorgito (#" . $id_pedido . ")";
        $email_message_admin = "Se ha realizado un nuevo pedido en tu tienda:\n\n";
        $email_message_admin .= "ID del Pedido: #" . $id_pedido . "\n";
        $email_message_admin .= "Cliente: " . $nombre_cliente . "\n";
        $email_message_admin .= "Email: " . $email_cliente . "\n";
        $email_message_admin .= "Teléfono: " . $telefono_cliente . "\n";
        $email_message_admin .= "Dirección: " . $direccion_cliente . ", " . $ciudad_cliente . "\n";
        $email_message_admin .= "Total del Pedido: $" . number_format($totalPedido, 0, ',', '.') . "\n\n";
        $email_message_admin .= "Detalles del Pedido:\n" . $orderDetailsMessage;
        $email_message_admin .= "\nAccede a tu panel de administración para ver los detalles completos.";

        $headers_admin = "From: " . $from_email . "\r\n";
        $headers_admin .= "Reply-To: " . $reply_to_email . "\r\n"; // Las respuestas del admin irán a tu correo real
        $headers_admin .= "Content-Type: text/plain; charset=UTF-8\r\n";

        $mail_sent_admin = mail($admin_email, $email_subject_admin, $email_message_admin, $headers_admin);
        if (!$mail_sent_admin) {
            error_log("Error al enviar correo al administrador para el pedido #" . $id_pedido);
        }

        // --- Correo para el Cliente ---
        $email_subject_client = "Confirmación de Pedido #" . $id_pedido . " en Don Jorgito";
        $email_message_client = "¡Gracias por tu compra, " . $nombre_cliente . "!\n\n";
        $email_message_client .= "Hemos recibido tu pedido (#" . $id_pedido . ") con éxito.\n\n";
        $email_message_client .= "Detalles de tu pedido:\n" . $orderDetailsMessage;
        $email_message_client .= "\nTotal del Pedido: $" . number_format($totalPedido, 0, ',', '.') . "\n";
        $email_message_client .= "\nTe contactaremos pronto para coordinar la entrega.\n\n";
        $email_message_client .= "Atentamente,\nEl equipo de Don Jorgito";

        $headers_client = "From: " . $from_email . "\r\n";
        $headers_client .= "Reply-To: " . $reply_to_email . "\r\n"; // Las respuestas del cliente irán al admin
        $headers_client .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        $mail_sent_client = mail($email_cliente, $email_subject_client, $email_message_client, $headers_client);
        if (!$mail_sent_client) {
            error_log("Error al enviar correo al cliente para el pedido #" . $id_pedido . ": " . $email_cliente);
        }

        // 8. Redirigir a una página de confirmación exitosa
        header("Location: confirmacion_pedido.php?id=" . $id_pedido);
        exit();

    } else {
        mysqli_rollback($conn); // Revertir todas las operaciones si algo falló
        error_log("Fallo al procesar pedido completo para cliente: " . $email_cliente . ". Detalles: " . mysqli_error($conn));
        // Redirigir a la página del carrito con un mensaje de error
        header("Location: ver_carrito.php?error=fallo_al_procesar_pedido");
        exit();
    }

} else {
    // Si alguien intenta acceder directamente a esta página sin un método POST, redirigir al inicio.
    header("Location: index.php");
    exit();
}

// Asegúrate de cerrar la conexión a la base de datos al final
mysqli_close($conn); 
?>