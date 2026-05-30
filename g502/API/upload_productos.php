<?php
require_once '../config/db.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || empty($input['products']) || empty($input['category'])) {
    echo json_encode(['message' => '❌ Datos inválidos.']);
    exit;
}

$category = $input['category'];
$products = $input['products'];
$inserted = 0;

$stmt = $conn->prepare("
    INSERT IGNORE INTO plu_products 
    (name, plu_code, category, quantity, description, description2, state) 
    VALUES (?, ?, ?, ?, ?, ?, 'Activo')
");

foreach ($products as $p) {
    $plu    = trim($p['plu']    ?? '');
    $nombre = trim($p['nombre'] ?? 'Desconocido');
    $qty    = max(1, (int)($p['qty'] ?? 1));
    $nota   = !empty($p['desc']) ? trim($p['desc']) : '';

    if (empty($plu)) continue;

    // description  = nombre del producto → Descripción Base en Manager
    // description2 = nota del usuario   → Nota / Plantilla en Manager
    $stmt->bind_param("sssiss", $nombre, $plu, $category, $qty, $nombre, $nota);
    $stmt->execute();
    if ($stmt->affected_rows > 0) $inserted++;
}

$stmt->close();
echo json_encode(['message' => "✅ $inserted producto(s) subidos a plu_products."]);