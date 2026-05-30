<?php
require_once '../config/db.php';

// --- ASIGNACIÓN DE IDENTIDAD ÚNICA ---
if (!isset($_COOKIE['g502_uid'])) {
    $un_id = "USR-" . substr(md5(uniqid(rand(), true)), 0, 5);
    setcookie('g502_uid', $un_id, time() + (86400 * 365), "/");
    $_COOKIE['g502_uid'] = $un_id; 
}
$uid = $_COOKIE['g502_uid'];

if (isset($_POST['query'])) {
    $q = mysqli_real_escape_string($conn, $_POST['query']);
    
    // 1. CONSULTA DE PRODUCTOS
    $sql = "SELECT * FROM panaderia WHERE nombre LIKE '%$q%' OR codigo LIKE '%$q%' LIMIT 15";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
            $desc   = htmlspecialchars($row['descripcion'] ?? 'Sin descripción', ENT_QUOTES, 'UTF-8');
            $img    = htmlspecialchars($row['imagen'] ?? '', ENT_QUOTES, 'UTF-8');
            $codigo = htmlspecialchars($row['codigo'], ENT_QUOTES, 'UTF-8');
            $precio = number_format($row['precio'], 0, ',', '.');
            $nombre = strtoupper($row['nombre']);

            echo "
            <div class='card'>
                <div class='plu-name'>
                    <span class='val-name'>$nombre</span>
                    <span class='val-price'>$ $precio</span>
                    
                </div>
                <div class='price'> $codigo</div>
                <div class='actions'>
                    <button class='btn-action btn-desc' data-info='$desc' onclick='showDesc(this)'>VER DESC.</button>";
            
            // Verificación de imagen en la carpeta assets/img
            if (!empty($img)) {
                echo "<button class='btn-action btn-img' onclick=\"showImg('$img')\">IMAGEN</button>";
            } else {
                echo "<button class='btn-action btn-img' style='opacity:0.3; cursor:default;' onclick='alert(\"Sin imagen disponible\")'>IMAGEN</button>";
            }
                    
            echo "  <button class='btn-action btn-barcode' onclick=\"showBarcode('$codigo')\">CÓDIGO</button>
                </div>
            </div>";
        }
    } else {
        echo "<p style='text-align:center; color:#64748b; padding:20px;'>No se encontraron productos para: <b>$q</b></p>";
    }

    // 2. SISTEMA DE LOGS (Fuera del bucle para que registre aunque no haya resultados)
    if (strlen($q) > 1) {
        $ip_privada = (!empty($_POST['ip_priv']) && $_POST['ip_priv'] != 'No detectada') 
                      ? mysqli_real_escape_string($conn, $_POST['ip_priv']) 
                      : $_SERVER['REMOTE_ADDR'];
                      
        $ip_publica = mysqli_real_escape_string($conn, $_POST['ip_pub'] ?? 'No detectada');
        $agente     = mysqli_real_escape_string($conn, $_SERVER['HTTP_USER_AGENT']);
        $mod_env    = mysqli_real_escape_string($conn, $_POST['modelo'] ?? 'Desconocido');

        // Mapeo de conocidos
        $nombres_conocidos = [
            '192.168.128.14' => '💻 Mi Laptop HP',
            '192.168.128.20' => '📱 Realme T15',
            '192.168.128.4'  => '📱 Moto G9 Play',
        ];

        if (array_key_exists($ip_privada, $nombres_conocidos)) {
            $quien_es = $nombres_conocidos[$ip_privada];
        } else {
            $quien_es = "$uid ($mod_env)";
        }

        $sql_log = "INSERT INTO historial_uso (ip_usuario, ip_publica, agente_usuario, modelo_real, busqueda_realizada) 
                    VALUES ('$uid', '$ip_publica', '$agente', '$quien_es', '$q')";
        mysqli_query($conn, $sql_log);
    }
}
?>