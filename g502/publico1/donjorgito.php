<?php

require_once('../admin/seguridad_admin.php');
$host        = 'localhost';
$usuario_db  = 'u584797177_Marco';
$password_db = 'Grupoexito2025@';
$nombre_db   = 'u584797177_dios1';

$mysqli = new mysqli($host, $usuario_db, $password_db, $nombre_db);
if ($mysqli->connect_errno) {
    die("<div class='mensaje error'>Error de conexión: " . $mysqli->connect_error . "</div>");
}
$mysqli->set_charset("utf8mb4");

$mensaje_usuario = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ca             = trim($_POST['ca'] ?? '');
    $producto       = trim($_POST['producto'] ?? '');
    $caracteristica = trim($_POST['caracteristica'] ?? '');
    $precio         = trim($_POST['precio'] ?? '');
    $cantidad       = trim($_POST['cantidad'] ?? '');
    $marca          = trim($_POST['marca'] ?? '');
    $ean            = trim($_POST['ean'] ?? '');
    $imagen         = '';

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen_temp   = $_FILES['imagen']['tmp_name'];
        $imagen_nombre = basename($_FILES['imagen']['name']);
        $carpeta_destino = '../Donjorgitofinal/';
        $ruta_destino    = $carpeta_destino . $imagen_nombre;

        if (move_uploaded_file($imagen_temp, $ruta_destino)) {
            $imagen = $ruta_destino;
        } else {
            $mensaje_usuario = "<div class='mensaje error'>Error al subir la imagen.</div>";
        }
    } else {
        $mensaje_usuario = "<div class='mensaje error'>Por favor selecciona una imagen.</div>";
    }

    if (empty($mensaje_usuario)) {
        $sql = "INSERT INTO donjorgito1 (ca, producto, caracteristica, precio, cantidad, imagen, marca, ean) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ssssssss", $ca, $producto, $caracteristica, $precio, $cantidad, $imagen, $marca, $ean);
            if ($stmt->execute()) {
                $mensaje_usuario = "<div class='mensaje exito'>¡Producto registrado con éxito!</div>";
            } else {
                $mensaje_usuario = "<div class='mensaje error'>Error al guardar: " . $stmt->error . "</div>";
            }
            $stmt->close();
        } else {
            $mensaje_usuario = "<div class='mensaje error'>Error al preparar: " . $mysqli->error . "</div>";
        }
    }
}

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Productos</title>

    <!-- Librería para escanear códigos de barras/QR -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <style>
        * { box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f8f8f8;
            color: #333;
        }
        form {
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 450px;
            margin: 30px auto;
        }
        h2 { text-align: center; color: #444; margin-bottom: 25px; }
        label { display: block; margin-bottom: 6px; font-weight: bold; color: #555; }
        input[type="text"], select, input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover { background-color: #218838; }
        .mensaje { margin: 20px auto; padding: 12px; border-radius: 5px; text-align: center; font-weight: bold; max-width: 450px; }
        .exito { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        /* EAN input con botón de cámara */
        .ean-wrapper {
            display: flex;
            gap: 8px;
            align-items: center;
            margin-bottom: 15px;
        }
        .ean-wrapper input {
            flex: 1;
            margin-bottom: 0;
        }
        .btn-scan {
            padding: 10px 14px;
            font-size: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #fff;
            cursor: pointer;
            transition: background 0.2s;
            white-space: nowrap;
        }
        .btn-scan:hover { background: #f0f0f0; }

        /* Modal del escáner */
        #scanner-modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.75);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }
        #scanner-modal.active { display: flex; }
        .scanner-box {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            width: 320px;
            max-width: 95vw;
            text-align: center;
        }
        .scanner-box h3 { margin: 0 0 15px; color: #333; }
        #reader { width: 100%; border-radius: 8px; overflow: hidden; }
        #btn-close-scanner {
            margin-top: 15px;
            padding: 10px 24px;
            background: #dc3545;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 15px;
            width: 100%;
        }
        #btn-close-scanner:hover { background: #c82333; }
        #scanner-status { margin-top: 10px; font-size: 13px; color: #666; min-height: 20px; }
    </style>
</head>
<body>

<?php echo $mensaje_usuario; ?>

<!-- MODAL DEL ESCÁNER -->
<div id="scanner-modal">
    <div class="scanner-box">
        <h3>📷 Escanear EAN</h3>
        <div id="reader"></div>
        <p id="scanner-status">Apunta la cámara al código de barras</p>
        <button id="btn-close-scanner" onclick="stopScanner()">✕ Cancelar</button>
    </div>
</div>

<form action="" method="POST" enctype="multipart/form-data">
    <p><a href="../admin/index.php" style="color:#28a745; text-decoration:none;">← Volver al Dashboard</a></p>
    <h2>Registro de Productos</h2>

    <div>
        <label for="ca">Categoría:</label>
        <select id="ca" name="ca" required>
            <option value="">Selecciona una categoría</option>
            <option value="aguardiente">Aguardiente</option>
            <option value="aperitivo">Aperitivo</option>
            <option value="bebes">Bebes</option>
            <option value="bebidas">Bebidas</option>
            <option value="bebidas_instantaneas">Bebidas instantáneas</option>
            <option value="brandy">Brandy</option>
            <option value="canasta_familiar">Canasta familiar/Despensa</option>
            <option value="carnes frias">Carnes frías</option>
            <option value="cereales">Cereales</option>
            <option value="cerveza">Cerveza</option>
            <option value="champaña">Champaña</option>
            <option value="chocolates">Chocolates</option>
            <option value="cigarrillos">Cigarrillos</option>
            <option value="comidas_instantaneas">Comidas instantáneas</option>
            <option value="cremas">Cremas de whisky</option>
            <option value="desechables">Desechables</option>
            <option value="dulces">Dulces</option>
            <option value="galletas">Galletas</option>
            <option value="gomas">Gomas</option>
            <option value="lacteos">Lácteos</option>
            <option value="limpieza">Limpieza</option>
            <option value="pm">Mujer</option>
            <option value="ph">Hombre</option>
            <option value="otros">Otros</option>
            <option value="panaderia">Panadería</option>
            <option value="pasabocas">Pasabocas</option>
            <option value="ponques">Ponqués</option>
            <option value="promociones">Promociones</option>
            <option value="ron">Ron</option>
            <option value="tequila">Tequila</option>
            <option value="vinos">Vinos</option>
            <option value="whisky">Whisky</option>
        </select>
    </div>

    <div>
        <label for="marca">Marca:</label>
        <input type="text" id="marca" name="marca" required>
    </div>

    <div>
        <label for="producto">Producto:</label>
        <input type="text" id="producto" name="producto" required>
    </div>

    <div>
        <label for="caracteristica">Características:</label>
        <input type="text" id="caracteristica" name="caracteristica" required>
    </div>

    <!-- EAN con botón de escaneo -->
    <div>
        <label for="ean">EAN (código de barras):</label>
        <div class="ean-wrapper">
            <input type="text" id="ean" name="ean" placeholder="Ej: 7702001234567" autocomplete="off">
            <button type="button" class="btn-scan" onclick="startScanner()" title="Escanear con cámara">📷</button>
        </div>
    </div>

    <div>
        <label for="precio">Precio:</label>
        <input type="text" id="precio" name="precio" required>
    </div>

    <div>
        <label for="cantidad">Cantidad:</label>
        <input type="text" id="cantidad" name="cantidad" required>
    </div>

    <div>
        <label for="imagen">Seleccionar Imagen:</label>
        <input type="file" id="imagen" name="imagen" accept="image/*" required>
    </div>

    <div>
        <input type="submit" value="Registrar Producto">
    </div>
</form>

<script>
    let html5QrCode = null;

    function startScanner() {
        document.getElementById('scanner-modal').classList.add('active');
        document.getElementById('scanner-status').textContent = 'Iniciando cámara...';

        html5QrCode = new Html5Qrcode("reader");

        const config = {
            fps: 15,
            qrbox: { width: 250, height: 120 },
            formatsToSupport: [
                Html5QrcodeSupportedFormats.EAN_13,
                Html5QrcodeSupportedFormats.EAN_8,
                Html5QrcodeSupportedFormats.CODE_128,
                Html5QrcodeSupportedFormats.CODE_39,
                Html5QrcodeSupportedFormats.UPC_A,
                Html5QrcodeSupportedFormats.UPC_E,
                Html5QrcodeSupportedFormats.QR_CODE
            ]
        };

        html5QrCode.start(
            { facingMode: "environment" },
            config,
            (decodedText) => {
                // Código leído exitosamente
                document.getElementById('ean').value = decodedText;
                document.getElementById('scanner-status').textContent = '✅ Código: ' + decodedText;
                if (navigator.vibrate) navigator.vibrate(150);
                // Cerrar automáticamente después de 800ms para que el usuario vea el resultado
                setTimeout(() => stopScanner(), 800);
            }
        ).then(() => {
            document.getElementById('scanner-status').textContent = 'Apunta la cámara al código de barras';
        }).catch(err => {
            document.getElementById('scanner-status').textContent = '❌ Error: ' + err;
            console.error(err);
        });
    }

    function stopScanner() {
        if (html5QrCode) {
            html5QrCode.stop().then(() => {
                html5QrCode.clear();
                html5QrCode = null;
            }).catch(err => console.warn("Stop error:", err));
        }
        document.getElementById('scanner-modal').classList.remove('active');
    }

    // Cerrar modal si se hace clic fuera del recuadro
    document.getElementById('scanner-modal').addEventListener('click', function(e) {
        if (e.target === this) stopScanner();
    });
</script>

</body>
</html>