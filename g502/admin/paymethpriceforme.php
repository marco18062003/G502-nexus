<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generador de Cobro | g502</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #000; color: #d4af37; padding: 50px; }
        .form-container { background: #111; padding: 30px; border-radius: 15px; border: 1px solid #d4af37; }
        input { background: #222 !important; color: white !important; border: 1px solid #444 !important; }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 form-container">
                <h3 class="text-center mb-4">💰 Crear Cobro g502</h3>
                <form action="paymeth2.php" method="GET">
                    <div class="mb-3">
                        <label>Nombre del Cliente:</label>
                        <input type="text" name="customer_name" class="form-control" placeholder="Ej: Marco Beltrán" required>
                    </div>
                    <div class="mb-3">
                        <label>Valor a Cobrar (Pesos COP):</label>
                        <input type="number" name="precio" class="form-control" placeholder="Ej: 55000" required>
                    </div>
                    <button type="submit" class="btn btn-warning w-100 mt-3">Generar Link de Pago</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>