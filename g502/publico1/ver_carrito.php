<?php
session_start();
require_once '../config/keys.php';

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

// ─── Auto-fill if user is logged in ──────────────────────────────────────────
$usuario_logueado = null;
if (isset($_SESSION['user_id'])) {
    require_once '../config/db.php';
    $st = mysqli_prepare($conn, "SELECT nombre_completo, email, telefono, direccion, ciudad FROM usuarios WHERE id = ? LIMIT 1");
    mysqli_stmt_bind_param($st, "i", $_SESSION['user_id']);
    mysqli_stmt_execute($st);
    $usuario_logueado = mysqli_fetch_assoc(mysqli_stmt_get_result($st));
    mysqli_stmt_close($st);
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cartItems      = $_SESSION['cart'];
$totalCartPrice = 0;
?>

<?php include 'includes/header.php'; ?>

<style>
    #checkoutModal {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.7); display: none;
        justify-content: center; align-items: center;
        z-index: 10000; backdrop-filter: blur(5px);
    }
    #checkoutModal .modal-content {
        background: #fff; padding: 30px; border-radius: 12px;
        width: 95%; max-width: 500px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        max-height: 90vh; overflow-y: auto;
    }
    #checkoutModal h3 { margin-top: 0; margin-bottom: 20px; color: #333; }
    .form-control {
        width: 100%; padding: 10px; border: 1px solid #ccc;
        border-radius: 6px; box-sizing: border-box;
        font-family: inherit; font-size: 0.95rem;
    }
    .form-label {
        display: block; font-weight: 600; font-size: 0.85rem;
        color: #374151; margin-bottom: 5px;
    }
    .mb-3 { margin-bottom: 15px; }
    .w-100 { width: 100%; }
    .mb-2 { margin-bottom: 10px; }
    .btn-location {
        padding: 10px 14px; background: #2563eb; color: white;
        border: none; border-radius: 6px; cursor: pointer;
        font-size: 1.2rem; white-space: nowrap;
        transition: background 0.2s, transform 0.1s; flex-shrink: 0;
    }
    .btn-location:hover   { background: #1d4ed8; }
    .btn-location:active  { transform: scale(0.95); }
    .btn-location:disabled { opacity: 0.6; cursor: not-allowed; }
    .location-row { display: flex; gap: 8px; align-items: stretch; }
    #locationStatus { font-size: 0.78rem; margin: 5px 0 0; min-height: 16px; color: #64748b; }

    /* Autofill banner */
    .autofill-banner {
        padding: 10px 14px; border-radius: 8px;
        font-size: 0.8rem; font-weight: 500; margin-bottom: 14px;
        display: flex; align-items: center; gap: 8px;
    }
    .autofill-banner.logged { background: #eff6ff; border: 1px solid #bfdbfe; color: #1d4ed8; }
    .autofill-banner.guest  { background: #fefce8; border: 1px solid #fde68a; color: #92400e; }
    .autofill-banner a { color: inherit; font-weight: 700; }
</style>

<main class="container">
    <div class="cart-container">
        <h1 class="cart-title">Tu Carrito de Compras</h1>

        <?php if (!empty($cartItems)): ?>
            <div class="table-responsive">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Característica</th>
                            <th>Precio Unitario</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $productId => $item): ?>
                            <?php
                            $subtotal = $item['price'] * $item['quantity'];
                            $totalCartPrice += $subtotal;
                            ?>
                            <tr id="cart-item-<?php echo htmlspecialchars($productId); ?>">
                                <td data-label="Producto">
                                    <span class="cart-item-name"><?php echo htmlspecialchars($item['name']); ?></span>
                                </td>
                                <td data-label="Característica"><?php echo htmlspecialchars($item['caracteristica'] ?? 'N/A'); ?></td>
                                <td data-label="Precio Unitario" class="cart-item-price">
                                    $<?php echo number_format($item['price'], 0, ',', '.'); ?>
                                </td>
                                <td data-label="Cantidad">
                                    <input type="number"
                                        class="quantity-input-cart"
                                        value="<?php echo htmlspecialchars($item['quantity']); ?>"
                                        min="1"
                                        data-id="<?php echo htmlspecialchars($productId); ?>"
                                        id="cart-quantity-<?php echo htmlspecialchars($productId); ?>"
                                        style="width:60px; text-align:center;">
                                </td>
                                <td data-label="Subtotal" class="cart-item-subtotal"
                                    id="subtotal-<?php echo htmlspecialchars($productId); ?>">
                                    $<?php echo number_format($subtotal, 0, ',', '.'); ?>
                                </td>
                                <td data-label="Acciones">
                                    <button class="remove-item-btn"
                                            data-id="<?php echo htmlspecialchars($productId); ?>">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="cart-total" id="total-cart-price">
                Total: $<?php echo number_format($totalCartPrice, 0, ',', '.'); ?>
            </div>

            <div class="cart-actions">
                <a href="index.php" class="btn-continue-shopping">Seguir Comprando</a>
                <button class="btn-checkout" id="checkout-button">Proceder al Pago</button>
            </div>

        <?php else: ?>
            <p class="cart-empty-message">Tu carrito de compras está vacío.</p>
            <div style="text-align:center; margin-top:20px;">
                <a href="index.php" class="btn-continue-shopping">Explorar Productos</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<!-- ─── CHECKOUT MODAL ──────────────────────────────────────────────────────── -->
<div id="checkoutModal">
    <div class="modal-content">
        <h3>Información para el Pedido</h3>

        <!-- Auto-fill banner -->
        <?php if ($usuario_logueado): ?>
        <div class="autofill-banner logged">
            ✅ Sesión activa — tus datos fueron pre-llenados automáticamente.
        </div>
        <?php else: ?>
        <div class="autofill-banner guest">
            💡 <a href="login.php">Inicia sesión</a> para llenar tus datos automáticamente.
        </div>
        <?php endif; ?>

        <form id="checkoutForm" action="confirmacion_pedido.php" method="POST">

            <?php if ($usuario_logueado): ?>
            <input type="hidden" name="id_cliente" value="<?php echo (int)$_SESSION['user_id']; ?>">
            <?php endif; ?>

            <div class="mb-3">
                <label for="nombre_cliente" class="form-label">Nombre Completo:</label>
                <input type="text" id="nombre_cliente" name="nombre_cliente"
                       class="form-control" required
                       placeholder="Ej: Juan Pérez"
                       value="<?php echo htmlspecialchars($usuario_logueado['nombre_completo'] ?? ''); ?>">
            </div>

            <div class="mb-3">
                <label for="email_cliente" class="form-label">Correo Electrónico:</label>
                <input type="email" id="email_cliente" name="email_cliente"
                       class="form-control" required
                       placeholder="correo@ejemplo.com"
                       value="<?php echo htmlspecialchars($usuario_logueado['email'] ?? ''); ?>">
            </div>

            <div class="mb-3">
                <label for="telefono_cliente" class="form-label">Teléfono:</label>
                <input type="tel" id="telefono_cliente" name="telefono_cliente"
                       class="form-control" required
                       placeholder="Ej: 3001234567"
                       value="<?php echo htmlspecialchars($usuario_logueado['telefono'] ?? ''); ?>">
            </div>

            <div class="mb-3">
                <label for="direccion_cliente" class="form-label">Dirección:</label>
                <div class="location-row">
                    <input type="text" id="direccion_cliente" name="direccion_cliente"
                           class="form-control" required
                           placeholder="Escribe o usa tu ubicación 📍"
                           value="<?php echo htmlspecialchars($usuario_logueado['direccion'] ?? ''); ?>">
                    <button type="button" id="btnGetLocation" class="btn-location"
                            title="Usar mi ubicación actual">📍</button>
                </div>
                <input type="hidden" id="lat_cliente" name="lat_cliente">
                <input type="hidden" id="lng_cliente" name="lng_cliente">
                <p id="locationStatus"></p>
            </div>

            <div class="mb-3">
                <label for="ciudad_cliente" class="form-label">Ciudad:</label>
                <input type="text" id="ciudad_cliente" name="ciudad_cliente"
                       class="form-control" required
                       placeholder="Ej: Bogotá"
                       value="<?php echo htmlspecialchars($usuario_logueado['ciudad'] ?? ''); ?>">
            </div>

            <button type="submit" class="btn btn-checkout w-100 mb-2">
                Confirmar Pedido
            </button>
            <button type="button" id="closeModal" class="btn btn-secondary w-100">
                Cancelar
            </button>

        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const formatMoney = (number) =>
        '$' + new Intl.NumberFormat('es-CO').format(number);

    // ─── 1. Quantity change ───────────────────────────────────────────────────
    document.querySelectorAll('.quantity-input-cart').forEach(input => {
        input.addEventListener('change', (e) => {
            const productId   = e.target.dataset.id;
            const newQuantity = parseInt(e.target.value);
            if (newQuantity < 1 || isNaN(newQuantity)) { e.target.value = 1; return; }
            fetch('update_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ product_id: productId, quantity: newQuantity })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`subtotal-${productId}`).textContent =
                        formatMoney(data.item_subtotal);
                    document.getElementById('total-cart-price').textContent =
                        'Total: ' + formatMoney(data.total_cart_price);
                    document.querySelector('.cart-count').textContent =
                        data.new_cart_total_items;
                }
            })
            .catch(() => alert('Error al actualizar cantidad.'));
        });
    });

    // ─── 2. Remove item ───────────────────────────────────────────────────────
    document.querySelectorAll('.remove-item-btn').forEach(button => {
        button.addEventListener('click', (e) => {
            const productId = e.target.dataset.id;
            if (confirm('¿Eliminar este producto?')) {
                fetch('remove_from_cart.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ product_id: productId })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const row = document.getElementById(`cart-item-${productId}`);
                        if (row) row.remove();
                        document.getElementById('total-cart-price').textContent =
                            'Total: ' + formatMoney(data.total_cart_price);
                        document.querySelector('.cart-count').textContent =
                            data.new_cart_total_items;
                        if (data.new_cart_total_items == 0) location.reload();
                    }
                })
                .catch(() => alert('Error al eliminar producto.'));
            }
        });
    });

    // ─── 3. Checkout modal ────────────────────────────────────────────────────
    const checkoutBtn = document.getElementById('checkout-button');
    const modal       = document.getElementById('checkoutModal');
    const closeBtn    = document.getElementById('closeModal');

    if (checkoutBtn) checkoutBtn.onclick = (e) => { e.preventDefault(); modal.style.display = 'flex'; };
    if (closeBtn)    closeBtn.onclick    = () => { modal.style.display = 'none'; };
    window.onclick = (event) => { if (event.target == modal) modal.style.display = 'none'; };

    // ─── 4. GPS Location button ───────────────────────────────────────────────
    const btnGetLocation = document.getElementById('btnGetLocation');
    const locationStatus = document.getElementById('locationStatus');
    const MAPS_KEY       = '<?php echo defined("GOOGLE_MAPS_KEY") ? GOOGLE_MAPS_KEY : ""; ?>';

    if (btnGetLocation) {
        btnGetLocation.addEventListener('click', () => {
            if (!navigator.geolocation) {
                locationStatus.style.color = '#ef4444';
                locationStatus.innerText   = '⚠️ Tu navegador no soporta geolocalización.';
                return;
            }
            btnGetLocation.innerHTML   = '⏳';
            btnGetLocation.disabled    = true;
            locationStatus.style.color = '#64748b';
            locationStatus.innerText   = '📡 Obteniendo tu ubicación...';

            navigator.geolocation.getCurrentPosition(
                async (pos) => {
                    const lat = pos.coords.latitude;
                    const lng = pos.coords.longitude;
                    document.getElementById('lat_cliente').value = lat;
                    document.getElementById('lng_cliente').value = lng;
                    try {
                        const res  = await fetch(
                            `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=${MAPS_KEY}&language=es`
                        );
                        const data = await res.json();
                        if (data.status === 'OK' && data.results.length > 0) {
                            document.getElementById('direccion_cliente').value =
                                data.results[0].formatted_address;
                            const city = data.results[0].address_components
                                .find(c => c.types.includes('locality'));
                            if (city && !document.getElementById('ciudad_cliente').value)
                                document.getElementById('ciudad_cliente').value = city.long_name;
                            locationStatus.style.color = '#15803d';
                            locationStatus.innerText   = '✅ Ubicación detectada correctamente.';
                        } else {
                            document.getElementById('direccion_cliente').value = `${lat}, ${lng}`;
                            locationStatus.style.color = '#f59e0b';
                            locationStatus.innerText   = '⚠️ No se pudo convertir la dirección.';
                        }
                    } catch(e) {
                        document.getElementById('direccion_cliente').value = `${lat}, ${lng}`;
                        locationStatus.style.color = '#f59e0b';
                        locationStatus.innerText   = '⚠️ Error de red. Se guardaron las coordenadas.';
                    }
                    btnGetLocation.innerHTML = '📍';
                    btnGetLocation.disabled  = false;
                },
                (err) => {
                    btnGetLocation.innerHTML   = '📍';
                    btnGetLocation.disabled    = false;
                    locationStatus.style.color = '#ef4444';
                    const messages = {
                        1: '⚠️ Permiso denegado. Activa la ubicación en tu navegador.',
                        2: '⚠️ No se pudo detectar tu ubicación.',
                        3: '⚠️ Tiempo agotado. Intenta de nuevo.'
                    };
                    locationStatus.innerText = messages[err.code] || '⚠️ Error desconocido.';
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        });
    }
});
</script>
</body>
</html>