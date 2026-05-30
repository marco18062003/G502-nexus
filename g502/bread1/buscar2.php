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
    $sql = "SELECT * FROM Hoja1 WHERE NOMBRE LIKE '%$q%' OR PLU LIKE '%$q%' OR EAN LIKE '%$q%' OR MARCA LIKE '%$q%' LIMIT 150";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
            
            $nombre = strtoupper($row['NOMBRE']);
            $plu    = !empty($row['PLU']) ? htmlspecialchars($row['PLU'], ENT_QUOTES, 'UTF-8') : null;
            $ean    = !empty($row['EAN']) ? htmlspecialchars($row['EAN'], ENT_QUOTES, 'UTF-8') : null;
            $marca  = strtoupper($row['MARCA'] ?? 'SIN MARCA');
            
            $desc   = "Producto: $nombre | Marca: $marca";
            $img    = ""; 
            $precio = "0"; 

            $codigo_barra = (!empty($ean)) ? $ean : $plu;

            // --- VERIFICAR TODAS LAS PROMOCIONES DEL PRODUCTO ---
            $promo_badges = "";
            if ($plu) {
                $plu_int = intval($plu);
                $promo_sql = "SELECT evento, `f.inicia`, `f.termina` FROM book_10_sheet1_ WHERE plu = $plu_int";
                $promo_res = mysqli_query($conn, $promo_sql);
                if ($promo_res && mysqli_num_rows($promo_res) > 0) {
                    // Color por tipo de evento
                    $colores = [
                        'impresionante' => ['bg' => '#faeeda', 'color' => '#633806', 'emoji' => '🔥'],
                        'insuperable'   => ['bg' => '#dcfce7', 'color' => '#166534', 'emoji' => '💚'],
                        'mi descuento'  => ['bg' => '#eff6ff', 'color' => '#1e40af', 'emoji' => '🏷️'],
                        'diamante'      => ['bg' => '#f3e8ff', 'color' => '#6b21a8', 'emoji' => '💎'],
                        'aniversario'   => ['bg' => '#fce7f3', 'color' => '#9d174d', 'emoji' => '🎉'],
                    ];

                    while ($promo = mysqli_fetch_assoc($promo_res)) {
                        $ciclo = htmlspecialchars($promo['evento']);
                        $desde = htmlspecialchars($promo['f.inicia']);
                        $hasta = htmlspecialchars($promo['f.termina']);

                        // Buscar color según evento
                        $evento_lower = strtolower($ciclo);
                        $estilo = ['bg' => '#f1f5f9', 'color' => '#334155', 'emoji' => '🏷️']; // default
                        foreach ($colores as $key => $val) {
                            if (strpos($evento_lower, $key) !== false) {
                                $estilo = $val;
                                break;
                            }
                        }

                        $promo_badges .= "
                        <div style='display:inline-flex; align-items:center; gap:6px; background:{$estilo['bg']}; color:{$estilo['color']}; font-size:12px; font-weight:600; padding:4px 10px; border-radius:8px; margin-bottom:6px; margin-right:4px;'>
                            {$estilo['emoji']} " . strtoupper($ciclo) . " &nbsp;·&nbsp; $desde al $hasta
                        </div>";
                    }

                    $promo_badges = "<div style='margin-bottom:10px;'>$promo_badges</div>";
                }
            }
            // -----------------------------------------------------

            echo "
            <div class='card' style='box-sizing: border-box; margin-bottom: 12px; background: #ffffff; padding: 16px; border-radius: 14px; border-left: 6px solid #85B820; box-shadow: 0 2px 8px rgba(0,0,0,0.06);'>
                
                $promo_badges

                <!-- SECCIÓN SUPERIOR: Nombre y Marca -->
                <div style='margin-bottom: 10px;'>
                    <span style='font-size: 1.15rem; font-weight: 700; color: #0f172a; display: block; line-height: 1.3;'>$nombre</span>
                    <span style='font-size: 0.78rem; font-weight: 600; color: #64748b; background: #f1f5f9; padding: 2px 8px; border-radius: 6px; display: inline-block; margin-top: 4px;'>🏭 $marca</span>
                </div>
                
                <!-- SECCIÓN INTERMEDIA: Códigos -->
                <div style='display: flex; flex-direction: column; gap: 6px; margin-bottom: 14px; background: #f8fafc; padding: 10px; border-radius: 10px;'>";
                    if ($plu) {
                        echo "
                        <div style='display: flex; justify-content: space-between; align-items: center; font-size: 0.9rem;'>
                            <span style='color: #64748b; font-weight: 500;'>Código PLU (Balanza):</span>
                            <strong style='color: #1d4ed8; font-family: monospace; font-size: 1rem; background: #eff6ff; padding: 2px 6px; border-radius: 4px;'>$plu</strong>
                        </div>";
                    }
                    if ($ean) {
                        echo "
                        <div style='display: flex; justify-content: space-between; align-items: center; font-size: 0.9rem; border-top: 1px dashed #e2e8f0; padding-top: 6px;'>
                            <span style='color: #64748b; font-weight: 500;'>Código EAN (Barras):</span>
                            <strong style='color: #166534; font-family: monospace; font-size: 1rem; background: #f0fdf4; padding: 2px 6px; border-radius: 4px;'>$ean</strong>
                        </div>";
                    }
            echo "
                </div>

                <!-- SECCIÓN INFERIOR: Botones -->
                <div style='display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px;'>
                    <button class='btn-action btn-desc' data-info='$desc' onclick='showDesc(this)' style='padding: 12px 4px; font-weight: 700; font-size: 0.75rem; border-radius: 8px;'>VER DESC.</button>";
            
                    if (!empty($img)) {
                        echo "<button class='btn-action btn-img' onclick=\"showImg('$img')\" style='padding: 12px 4px; font-weight: 700; font-size: 0.75rem; border-radius: 8px;'>IMAGEN</button>";
                    } else {
                        echo "<button class='btn-action btn-img' style='opacity:0.3; cursor:default; padding: 12px 4px; font-weight: 700; font-size: 0.75rem; border-radius: 8px;' onclick='alert(\"Sin imagen disponible\")'>IMAGEN</button>";
                    }
                    
            echo "  <button class='btn-action btn-barcode' onclick=\"showBarcode('$codigo_barra')\" style='padding: 12px 4px; font-weight: 700; font-size: 0.75rem; border-radius: 8px; background: #0f172a; color: white;'>BARRA</button>
                </div>
            </div>";
        }
    } else {
        echo "<p style='text-align:center; color:#64748b; padding:20px; font-weight:500;'>No se encontraron productos para: <b>$q</b></p>";
    }

    // 2. SISTEMA DE LOGS
    if (strlen($q) > 1) {
        $ip_privada = (!empty($_POST['ip_priv']) && $_POST['ip_priv'] != 'No detectada') 
                      ? mysqli_real_escape_string($conn, $_POST['ip_priv']) 
                      : $_SERVER['REMOTE_ADDR'];
                      
        $ip_publica = mysqli_real_escape_string($conn, $_POST['ip_pub'] ?? 'No detectada');
        $agente     = mysqli_real_escape_string($conn, $_SERVER['HTTP_USER_AGENT']);
        $mod_env    = mysqli_real_escape_string($conn, $_POST['modelo'] ?? 'Desconocido');

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