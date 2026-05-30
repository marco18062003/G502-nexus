<?php
require_once '../config/db.php';

// 1. OBTENER EL ID REAL DE LA COOKIE (Igual que en buscar.php)
$ip_usuario = isset($_COOKIE['g502_uid']) ? $_COOKIE['g502_uid'] : 'NUEVO';

// 2. VERIFICAR SI ESE ID ESPECÍFICO ESTÁ BANEADO
if ($ip_usuario !== 'NUEVO') {
    $uid_clean = mysqli_real_escape_string($conn, $ip_usuario);
    $check_sql = "SELECT usuario_id FROM usuarios_baneados_pan WHERE usuario_id = '$uid_clean'";
    $check_res = mysqli_query($conn, $check_sql);

    if ($check_res && mysqli_num_rows($check_res) > 0) {
        http_response_code(403); 
        die("
        <div style='display:flex; flex-direction:column; align-items:center; justify-content:center; height:100vh; background:#f8d7da; color:#721c24; font-family:sans-serif; text-align:center; padding:20px; box-sizing:border-box;'>
            <h1 style='font-size:3rem;'>🚫 Acceso Denegado</h1>
            <p style='font-size:1.2rem;'>Tu dispositivo ha sido bloqueado permanentemente.</p>
            <p style='font-size:0.9rem;'>Si crees que esto es un error, contacta al administrador.</p>");
    }
}

// ... Resto de tu HTML ...
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>g502 Pro - Gestión Total</title>
    <script src="https://unpkg.com/@zxing/library@latest/umd/index.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" 
      href="assets/button.css?v=1730030000">
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <style>
        :root { --p: #85B820; --s: #85B820; --bg: #f1f5f9; --white: #ffffff; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); margin: 0; padding: 15px; padding-bottom: 80px; }
        .container { max-width: 600px; margin: 0 auto; }
        .search-section { position: sticky; top: 10px; z-index: 10; margin-bottom: 20px; }
        #busqueda { width: 100%; padding: 18px; border-radius: 15px; border: 2px solid var(--p); font-size: 1.1rem; box-shadow: 0 4px 12px rgba(0,0,0,0.1); outline: none; box-sizing: border-box; }
        .btn-flotante { position: fixed; bottom: 25px; right: 25px; width: 65px; height: 65px; background: var(--s); color: white; border-radius: 50%; border: none; font-size: 35px; box-shadow: 0 5px 20px rgba(0,0,0,0.3); cursor: pointer; z-index: 100; display: flex; align-items: center; justify-content: center; }
        
        /* MODAL Y GIRO */
        .modal { display: none; position: fixed; z-index: 200; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); align-items: center; justify-content: center; }
        .modal-content { background: white; padding: 25px; border-radius: 20px; width: 90%; max-width: 400px; text-align: center; position: relative; max-height: 90vh; overflow-y: auto; transition: all 0.3s; }
        .modal-barcode-wide { max-width: 95% !important; width: 95% !important; padding: 15px !important; }
        
        .close-modal { position: absolute; top: 15px; right: 15px; font-size: 25px; cursor: pointer; color: #64748b; z-index: 10; }
        
        /* Contenedor del código rotado */
        .barcode-rotate-container { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px 0; overflow: hidden; }
        .barcode-wrapper { transform: rotate(90deg); display: inline-block; margin: 60px 0; }
        
        .results-grid { display: grid; grid-template-columns: 1fr; gap: 15px; }
        .card { background: var(--white); padding: 18px; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border-left: 5px solid var(--p); }
        .val-name { font-size: 1.2rem; font-weight: 800; color: #1e293b; text-transform: uppercase; display: block; margin-bottom: 5px; }
        .val-plu { color: var(--p); font-weight: 600; font-size: 0.9rem; }
        .price { font-size: 1.5rem; font-weight: 800; color: #85B820; margin: 10px 0; }
        .actions { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px; margin-top: 10px; }
        .btn-action { padding: 12px 5px; border: none; border-radius: 8px; font-size: 0.75rem; font-weight: bold; color: white; cursor: pointer; transition: transform 0.1s; }
        .btn-action:active { transform: scale(0.95); }
        .btn-desc { background: #64748b; } .btn-img { background: #8b5cf6; } .btn-barcode { background: #0f172a; }
        .add-form input, .add-form textarea, .add-form select { width: 100%; padding: 12px; margin: 8px 0; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-family: inherit; }
    
        .search-section {
    position: sticky;
    top: 10px;
    z-index: 10;
    margin-bottom: 20px;
}

.search-bar {
    display: flex;
    align-items: center;
    background: #ffffff;
    border: 2px solid var(--p);
    border-radius: 50px;
    padding: 6px 6px 6px 18px;
    box-shadow: 0 4px 20px rgba(133, 184, 32, 0.2);
    transition: box-shadow 0.2s, border-color 0.2s;
    gap: 8px;
}

.search-bar:focus-within {
    box-shadow: 0 4px 24px rgba(133, 184, 32, 0.4);
    border-color: #6a9518;
}

.search-icon {
    font-size: 1.1rem;
    flex-shrink: 0;
    opacity: 0.5;
}

#busqueda {
    flex: 1;
    border: none;
    outline: none;
    font-size: 1rem;
    font-family: 'Inter', sans-serif;
    background: transparent;
    color: #1e293b;
    padding: 10px 0;
    min-width: 0; /* prevents overflow on small screens */
}

#busqueda::placeholder {
    color: #94a3b8;
}

.btn-scan-trigger {
    flex-shrink: 0;
    width: 44px;
    height: 44px;
    background: var(--p);
    border: none;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s, transform 0.1s;
}

.btn-scan-trigger:active {
    transform: scale(0.92);
    background: #6a9518;
}
    </style>
</head>
<body>

    <div class="mobile-nav-bar">
    <div class="nav-group">
        
        <div class="nav-divider"></div>
        <button onclick="window.location.href='../admin/index.php'" class="nav-item">
            <span class="nav-icon">🛠️</span>
            <span class="nav-text">Admin</span>
        </button>
        <button onclick="window.location.href='gestion_productos.php'" class="nav-item highlight">
            <span class="nav-icon">📊</span>
            <span class="nav-text">Base Datos</span>
        </button>
    </div>
</div>

<div class="container">
    <div class="search-section">
    <div class="search-bar">
        <span class="search-icon">🔍</span>
        <input type="text" id="busqueda" placeholder="Buscar en g502..." autocomplete="off">
        <button type="button" class="btn-scan-trigger" onclick="startScanner(this)" title="Escanear código">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 7V5a2 2 0 0 1 2-2h2"/><path d="M17 3h2a2 2 0 0 1 2 2v2"/>
                <path d="M21 17v2a2 2 0 0 1-2 2h-2"/><path d="M7 21H5a2 2 0 0 1-2-2v-2"/>
                <rect x="7" y="7" width="10" height="10" rx="1"/>
            </svg>
        </button>
    </div>
</div>
    <div id="resultados" class="results-grid"></div>
</div>

<button class="btn-flotante" onclick="openAddModal()">+</button>

<div id="mainModal" class="modal">
    <div class="modal-content" id="modalContainer">
        <span class="close-modal" onclick="closeModal()">&times;</span>
        <div id="modalBody"></div>
    </div>
</div>
<div id="logo-mobile-only" class="logo-container">
    <img src="../assets/img/carulla.png" alt="Logo Carulla">
</div>

<style>
    /* 1. POR DEFECTO: Diseño para Celulares */
    .logo-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .logo-container img {
        width: 450px; /* Muy grande como pediste */
        max-width: 90%; /* Seguridad para que no se salga de la pantalla */
        height: auto;
        filter: drop-shadow(0px 4px 6px rgba(0,0,0,0.1));
    }

    /* 2. REGLA PARA PC: Ocultar cuando la pantalla sea mayor a 768px */
    @media (min-width: 768px) {
        #logo-mobile-only {
            display: none !important;
        }
    }

    /* 3. REGLA PARA IMPRESIÓN: Decidir si lo quieres en el papel */
    @media print {
        #logo-mobile-only {
            display: flex !important; /* Cambia a 'none' si no lo quieres impreso */
            justify-content: center;
        }
        .logo-container img {
            width: 300px; /* Un poco más pequeño para el papel */
        }
    }
</style>
<p style="text-align:center; margin-top:20px; font-size:0.8rem; color:#64748b;">g502 - TODO</p>

<h2 style="text-align:center; margin-top:40px; color:#1e293b;"></h2>

<script>
    const modal = document.getElementById('mainModal');
    const modalBody = document.getElementById('modalBody');
    const modalContainer = document.getElementById('modalContainer');

    // ─── SCANNER ────────────────────────────────────────────────────────────────
    let codeReader = null;
    let scannerActive = false;

    function startScanner(btn) {
        if (scannerActive) return;

        modalContainer.classList.remove('modal-barcode-wide');
        modalBody.innerHTML = `
    <h3 style="margin:0 0 6px; font-size:1rem;">📸 Escanear Código</h3>
    <p style="font-size:0.78rem; color:#64748b; margin:0 0 10px;">
        Apunta la cámara al código de barras o QR
    </p>
    <div style="position:relative; border-radius:10px; overflow:hidden; background:#000; max-height:220px;">
        <video id="scannerVideo" 
               style="width:100%; max-height:220px; object-fit:cover; border-radius:10px; display:block;" 
               autoplay muted playsinline></video>
        <div style="
            position:absolute; left:15%; width:70%; height:2px;
            background:rgba(133,184,32,0.9);
            box-shadow:0 0 8px rgba(133,184,32,0.9);
            animation: scanLine 1.5s ease-in-out infinite alternate;
        "></div>
    </div>
    <style>
        @keyframes scanLine { from { top:25%; } to { top:75%; } }
    </style>
    <p id="scanStatus" style="margin:8px 0 0; font-size:0.78rem; color:#64748b;">
        Buscando cámara...
    </p>
    <button onclick="stopScanner()" 
            style="margin-top:10px; width:100%; padding:10px; background:#ef4444; 
                   color:white; border:none; border-radius:10px; 
                   font-weight:bold; cursor:pointer; font-size:0.85rem;">
        Cancelar
    </button>
`;
        modal.style.display = 'flex';
        scannerActive = true;

        codeReader = new ZXing.BrowserMultiFormatReader();

        codeReader.listVideoInputDevices().then(devices => {
            if (!devices || devices.length === 0) {
                document.getElementById('scanStatus').innerText = '⚠️ No se encontró cámara.';
                return;
            }

            // Prefer back camera on mobile
            const backCam = devices.find(d => /back|rear|environment/i.test(d.label)) || devices[devices.length - 1];
            document.getElementById('scanStatus').innerText = '✅ Cámara lista — apunta al código';

            codeReader.decodeFromVideoDevice(backCam.deviceId, 'scannerVideo', (result, err) => {
                if (result) {
                    const scanned = result.getText();
                    stopScanner();
                    document.getElementById('busqueda').value = scanned;
                    realizarBusqueda();
                }
                // Ignore errors — they fire constantly while scanning
            });
        }).catch(err => {
            document.getElementById('scanStatus').innerText = '⚠️ Error al acceder a la cámara.';
            console.error(err);
        });
    }

    function stopScanner() {
        if (codeReader) {
            codeReader.reset();
            codeReader = null;
        }
        scannerActive = false;
        closeModal();
    }
    // ────────────────────────────────────────────────────────────────────────────

    function closeModal() { 
        if (scannerActive) stopScanner();
        modal.style.display = 'none'; 
        modalContainer.classList.remove('modal-barcode-wide');
    }

    function getLocalIP() {
        return new Promise((resolve) => {
            const pc = new RTCPeerConnection({ iceServers: [] });
            pc.createDataChannel('');
            pc.createOffer().then(pc.setLocalDescription.bind(pc));
            pc.onicecandidate = (ice) => {
                if (!ice || !ice.candidate || !ice.candidate.candidate) return;
                const ip = /([0-9]{1,3}(\.[0-9]{1,3}){3})/.exec(ice.candidate.candidate)[1];
                resolve(ip);
                pc.onicecandidate = null;
            };
            setTimeout(() => resolve("No detectada"), 1000);
        });
    }

    async function realizarBusqueda() {
        const q = document.getElementById('busqueda').value;
        if (q.length > 0) {
            let ipPub = "Desconocida";
            let ipPriv = await getLocalIP();
            let modelo = "Desconocido";

            try {
                const res = await fetch('https://api.ipify.org?format=json');
                const data = await res.json();
                ipPub = data.ip;
            } catch(e) {}

            if (navigator.userAgentData) {
                try {
                    const info = await navigator.userAgentData.getHighEntropyValues(['model']);
                    modelo = info.model || "Genérico";
                } catch(e) {}
            }

            fetch('buscar2.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `query=${encodeURIComponent(q)}&modelo=${encodeURIComponent(modelo)}&ip_pub=${encodeURIComponent(ipPub)}&ip_priv=${encodeURIComponent(ipPriv)}`
            })
            .then(r => r.text())
            .then(html => { document.getElementById('resultados').innerHTML = html; });
        } else {
            document.getElementById('resultados').innerHTML = '';
        }
    }

    document.getElementById('busqueda').addEventListener('input', realizarBusqueda);

    function showDesc(btn) {
        modalContainer.classList.remove('modal-barcode-wide');
        modalBody.innerHTML = `<h3 style="color:var(--p)">Descripción</h3><p>${btn.getAttribute('data-info')}</p>`;
        modal.style.display = 'flex';
    }

    function showImg(src) { 
        modalContainer.classList.remove('modal-barcode-wide');
        modalBody.innerHTML = `
            <h3 style="margin-bottom:15px; color:#1e293b;">Vista Previa</h3>
            <div style="display:flex; justify-content:center; align-items:center; background:#f8fafc; padding:10px; border-radius:12px;">
                <img src="assets/img/${src}" 
                     style="max-width:200px; max-height:250px; width:auto; height:auto; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1);" 
                     onerror="this.src='https://via.placeholder.com/200?text=Sin+Imagen'">
            </div>
            <p style="margin-top:10px; font-size:0.8rem; color:#64748b;">${src}</p>
        `; 
        modal.style.display = 'flex'; 
    }

    function showBarcode(code) {
        let cleanCode = String(code).trim();
        modalContainer.classList.add('modal-barcode-wide');
        modalBody.innerHTML = `
            <h3 style="margin-bottom:10px;">Escaneo g502</h3>
            <div style="display:flex; gap:10px; margin-bottom:5px;">
                <button onclick="renderBarcode('${cleanCode}', 'CODE128')" style="flex:1; padding:10px; background:var(--p); color:white; border:none; border-radius:8px; font-weight:bold; cursor:pointer; font-size:12px;">NORMAL</button>
                <button onclick="renderBarcode('${cleanCode}', 'EAN13')" style="flex:1; padding:10px; background:#f59e0b; color:white; border:none; border-radius:8px; font-weight:bold; cursor:pointer; font-size:12px;">PANADERÍA</button>
            </div>
            <div class="barcode-rotate-container">
                <div class="barcode-wrapper">
                    <svg id="barcode"></svg>
                    <p id="barcodeLabel" style="font-weight:800; font-size:2rem; color:black; margin:15px 0;">${cleanCode}</p>
                </div>
                <small id="formatName" style="color:#64748b; margin-top:10px;">Cargando...</small>
            </div>
        `;
        modal.style.display = 'flex';
        renderBarcode(cleanCode, 'CODE128');
    }

    function renderBarcode(code, format) {
        let finalCode = code;
        let label = document.getElementById('formatName');
        if (format === 'EAN13') {
            if (finalCode.length < 12) finalCode = finalCode.padStart(12, '0');
            label.innerText = "Modo: Panadería (EAN-13)";
        } else {
            label.innerText = "Modo: Normal (CODE-128)";
        }
        try {
            JsBarcode("#barcode", finalCode, {
                format: format,
                width: 2.5,
                height: 120,
                displayValue: false,
                margin: 10,
                background: "#ffffff"
            });
            document.getElementById('barcodeLabel').innerText = finalCode;
        } catch (e) {
            label.innerText = "Error de formato";
        }
    }

    function openAddModal() {
        modalContainer.classList.remove('modal-barcode-wide');
        modalBody.innerHTML = `
            <h3 style="margin-bottom:15px;">Añadir a g502</h3>
            <form id="formNuevo" class="add-form">
                <input type="text" name="codigo" placeholder="PLU o Código" required>
                <input type="text" name="nombre" placeholder="Nombre del Producto" required>
                <select name="categoria" required>
                    <option value="">Seleccione Categoría</option>
                    <option value="frutas y vegetales">Frutas y Vegetales</option>
                    <option value="recargas">Recargas</option>
                    <option value="panaderia">Panadería</option>
                </select>
                <textarea name="descripcion" placeholder="Notas..."></textarea>
                <input type="number" name="precio" placeholder="Precio ($)" required>
                <p style="font-size:0.8rem; color:#64748b; margin-top:10px;">Foto:</p>
                <input type="file" name="foto" accept="image/*">
                <button type="submit" style="width:100%; padding:15px; background:var(--s); color:white; border:none; border-radius:10px; margin-top:20px; font-weight:bold; cursor:pointer;">GUARDAR</button>
            </form>`;
        modal.style.display = 'flex';
        document.getElementById('formNuevo').onsubmit = function(e) {
            e.preventDefault();
            fetch('agregar.php', { method: 'POST', body: new FormData(this) })
            .then(r => r.text())
            .then(res => { alert(res); closeModal(); realizarBusqueda(); });
        };
    }

    window.onclick = function(event) { if (event.target == modal) closeModal(); }

    function addRow() {
        const tbody = document.getElementById('excelBody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td data-label="PLU">
                <div class="plu-cell">
                    <input type="text" name="plu[]" class="plu-input" list="productList" autocomplete="off" placeholder="Busca...">
                    <button type="button" class="btn-scan-trigger" onclick="startScanner(this)">📸</button>
                </div>
            </td>
            <td data-label="Cantidad"><input type="number" name="qty[]" placeholder="1"></td>
            <td data-label="Descripción"><input type="text" name="desc[]" placeholder="Nota..."></td>
            <td data-label="Tipo">
                <select name="tipo[]" class="tipo-select">
                    <option value="">-- Ninguno --</option>
                    <option value="diamante"> Diamante</option>
                    <option value="impresionante"> Impresionante</option>
                    <option value="insuperable"> Insuperable</option>
                    <option value="aniversario"> Aniversario</option>
                    <option value="descuento"> Mi descuento</option>
                </select>
            </td>
        `;
        tbody.appendChild(newRow);
    }
</script>
</body>
</html>