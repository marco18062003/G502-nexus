<?php
include '../config/db.php';
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Paths | g502</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #000; color: #fff; font-family: 'Poppins', sans-serif; }
        .text-gold { color: #d4af37; }
        .border-gold { border: 1px solid #d4af37 !important; }
        .bg-dark-card { background: #111; border-radius: 15px; transition: 0.3s; height: 100%; }
        .bg-dark-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(212, 175, 55, 0.2); }
        .status-badge { font-size: 0.7rem; padding: 3px 8px; border-radius: 20px; }
        .btn-setup { background: #d4af37; color: #000; font-weight: bold; font-size: 0.8rem; border: none; }
        .btn-setup:hover { background: #b8962e; color: #000; }
        .path-icon { background: rgba(212, 175, 55, 0.1); width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin: 0 auto 15px; }
        
        /* Estilos específicos para el Modal */
        .modal-content { border: 1px solid #d4af37; box-shadow: 0 0 30px rgba(212, 175, 55, 0.3); }
        .copy-btn { cursor: pointer; color: #d4af37; margin-left: 10px; }
        .copy-btn:hover { color: #fff; }
    </style>
</head>
<body class="p-4">
    <?php include 'includes/header.php'; ?>

<div class="container">
    <header class="mb-5 text-center text-md-start">
        <h1 class="text-gold fw-bold"><i class="fas fa-route"></i> Payment Paths</h1>
        <p class="text-secondary">Configura las rutas de pago disponibles para tus clientes en <strong>g502</strong></p>
    </header>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="bg-dark-card border-gold p-4 text-center">
                <span class="badge bg-success status-badge mb-3">ACTIVO</span>
                <div class="path-icon"><i class="fas fa-university text-gold fa-2x"></i></div>
                <h5 class="fw-bold">API Bancolombia / Wompi</h5>
                <p class="small text-secondary">QR dinámico, PSE, Nequi y Corresponsales.</p>
                <hr class="border-secondary">
                <a href="paymethpriceforme.php" class="btn btn-setup w-100">CONFIGURAR LLAVES</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="bg-dark-card border-gold p-4 text-center">
                <span class="badge bg-success status-badge mb-3">ACTIVO</span>
                <div class="path-icon"><i class="fas fa-landmark text-gold fa-2x"></i></div>
                <h5 class="fw-bold">Bancolombia</h5>
                <p class="small text-secondary">Bre-ve, Nequi, Cuenta de Ahorros y QR manual.</p>
                <hr class="border-secondary">
                <button type="button" class="btn btn-setup w-100" data-bs-toggle="modal" data-bs-target="#modalBogota">
                    VER DATOS DE PAGO
                </button>
            </div>
        </div>

        <div class="col-md-4">
            <div class="bg-dark-card border-gold p-4 text-center">
                <span class="badge bg-success status-badge mb-3">ACTIVO</span>
                <div class="path-icon"><i class="fas fa-landmark text-gold fa-2x"></i></div>
                <h5 class="fw-bold">Banco de Bogotá</h5>
                <p class="small text-secondary">Bre-ve, Cuenta de Ahorros y QR manual.</p>
                <hr class="border-secondary">
                <button type="button" class="btn btn-setup w-100" data-bs-toggle="modal" data-bs-target="#modalBogota">
                    VER DATOS DE PAGO
                </button>
            </div>
        </div>

        <div class="col-md-4">
            <div class="bg-dark-card border-gold p-4 text-center">
                <span class="badge bg-success status-badge mb-3">ACTIVO</span>
                <div class="path-icon"><i class="fas fa-truck text-gold fa-2x"></i></div>
                <h5 class="fw-bold">Contra Entrega</h5>
                <p class="small text-secondary">Pago en efectivo al recibir el licor.</p>
                <hr class="border-secondary">
                <a href="#" class="btn btn-setup w-100">AJUSTAR ZONAS</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="bg-dark-card border-gold p-4 text-center">
                <span class="badge bg-warning text-dark status-badge mb-3">BETA</span>
                <div class="path-icon"><i class="fab fa-bitcoin text-gold fa-2x"></i></div>
                <h5 class="fw-bold">Binance Pay / Crypto</h5>
                <p class="small text-secondary">Recibe USDT o BTC sin comisiones.</p>
                <hr class="border-secondary">
                <a href="#" class="btn btn-setup w-100">CONECTAR WALLET</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="bg-dark-card border-secondary p-4 text-center" style="opacity: 0.6;">
                <span class="badge bg-danger status-badge mb-3">INACTIVO</span>
                <div class="path-icon"><i class="fas fa-credit-card text-gold fa-2x"></i></div>
                <h5 class="fw-bold">Tarjetas Globales</h5>
                <p class="small text-secondary">Visa, Mastercard (Vía Stripe).</p>
                <hr class="border-secondary">
                <a href="#" class="btn btn-outline-secondary w-100">VINCULAR</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="bg-dark-card border-secondary p-4 text-center d-flex flex-column align-items-center justify-content-center" style="border-style: dashed !important;">
                <i class="fas fa-plus-circle fa-3x text-secondary mb-2"></i>
                <p class="text-secondary small">Agregar nueva vía de pago</p>
                <button class="btn btn-sm btn-outline-secondary">Explorar</button>
            </div>
        </div>
    </div>

    <footer class="mt-5 text-center">
        <p class="small text-secondary">Desarrollado para el ecosistema <strong>g502</strong> &copy; 2026</p>
    </footer>
</div>

<div class="modal fade" id="modalBogota" tabindex="-1" aria-labelledby="modalBogotaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-gold" id="modalBogotaLabel border-0"><i class="fas fa-university"></i> Transferencia Directa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="mb-4">
                    <p class="text-secondary small mb-2">ESCANEA EL QR DESDE TU APP</p>
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=CuentaAhorros-G502" alt="QR de Pago" class="img-fluid rounded border-gold p-2 bg-white" style="width: 180px;">
                </div>

                <div class="bg-black p-3 rounded text-start border border-secondary">
                    <div class="mb-3">
                        <label class="text-secondary small d-block">Número de Cuenta (Ahorros):</label>
                        <span class="fw-bold text-white" id="n_cuenta">000-123456-78</span>
                        <i class="fas fa-copy copy-btn" onclick="copyToClipboard('000-123456-78')"></i>
                    </div>
                    <div class="mb-3">
                        <label class="text-secondary small d-block">Titular:</label>
                        <span class="fw-bold text-white">Don Jorgito Shop G502</span>
                    </div>
                    <div class="">
                        <label class="text-secondary small d-block">Llave Bre-v / Celular:</label>
                        <span class="fw-bold text-white" id="n_cel">300 123 4567</span>
                        <i class="fas fa-copy copy-btn" onclick="copyToClipboard('3001234567')"></i>
                    </div>
                </div>
                
                <p class="mt-3 text-warning small"><i class="fas fa-info-circle"></i> Envía el comprobante por WhatsApp después de transferir.</p>
            </div>
            <div class="modal-footer border-0 d-flex justify-content-center">
                <a href="https://wa.me/573001234567" target="_blank" class="btn btn-setup px-4">
                    <i class="fab fa-whatsapp"></i> ENVIAR COMPROBANTE
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert("Copiado al portapapeles: " + text);
        });
    }
</script>

</body>
</html>