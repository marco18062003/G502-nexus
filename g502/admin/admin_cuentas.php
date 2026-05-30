<?php
require_once('seguridad_admin.php');

class FinanceController {
    private $db;
    public function __construct($conn) { $this->db = $conn; }

    

    public function getMonthlyExpenses($month) {
        $res = $this->db->prepare("SELECT IFNULL(SUM(monto), 0) as total FROM expenses WHERE month COLLATE utf8mb4_unicode_ci = ?");
        $res->bind_param("s", $month);
        $res->execute();
        $row = $res->get_result()->fetch_assoc();
        return $row['total'];
    }

    public function getAnalytics($month) {
        // 1. Get Sales data
        $stmt = $this->db->prepare("SELECT 
            (SELECT IFNULL(SUM(monto),0) FROM finance 
             WHERE DATE_FORMAT(fecha, '%Y-%m') COLLATE utf8mb4_unicode_ci = ?) as total_finance,
            (SELECT IFNULL(SUM(total),0) FROM finance2 
             WHERE DATE_FORMAT(fecha_pedido, '%Y-%m') COLLATE utf8mb4_unicode_ci = ?) as total_finance2,
            (SELECT COUNT(*) FROM finance 
             WHERE DATE_FORMAT(fecha, '%Y-%m') COLLATE utf8mb4_unicode_ci = ?) as tx_count");

        $stmt->bind_param("sss", $month, $month, $month);
        $stmt->execute();
        $data = $stmt->get_result()->fetch_assoc();

        $venta_total = $data['total_finance'] + $data['total_finance2'];
        $ganancia    = $venta_total * 0.18;

        $porcentaje = 18; // variable para ajustar la ganancia deseada manualmente pero debe conectarse a db.php para ser dinámica

        // 2. Get Expenses correctly
        $gastos_mes = $this->getMonthlyExpenses($month); // Multiplicamos por +1 para convertir a positivo, ya que en la tabla se guardan como negativos

        // 3. CORRECT DYNAMIC META CALCULATION
        // ... cálculos previos ...

$goal = ($porcentaje > 0) ? (100 / $porcentaje) * $gastos_mes : 0;

$falta = $goal - $venta_total; // Lo que realmente falta para llegar a la meta
$falta_visual = max(0, $falta); // Si ya pasaste la meta, muestra 0, no números negativos

// AQUÍ ESTABA EL ERROR: Validación de división por cero
if ($goal > 0) {
    $falta_porcentaje = ($falta_visual / $goal) * 100;
} else {
    $falta_porcentaje = 0; 
}

return [
    'equity'     => $venta_total,
    'tx_count'   => $data['tx_count'],
    'ganancia'   => $ganancia,
    'meta'       => $goal,
    'falta'      => $falta_visual,
    'falta2'     => $falta_porcentaje,
    'gastos_mes' => $gastos_mes
];
    }

    public function getChartData($month) {
        $res = $this->db->prepare("SELECT fecha, monto FROM finance WHERE DATE_FORMAT(fecha, '%Y-%m') COLLATE utf8mb4_unicode_ci = ? ORDER BY fecha ASC");
        $res->bind_param("s", $month);
        $res->execute();
        $result = $res->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getFullHistory($month) {
        $res = $this->db->prepare("SELECT fecha, monto FROM finance WHERE DATE_FORMAT(fecha, '%Y-%m') COLLATE utf8mb4_unicode_ci = ? ORDER BY fecha DESC");
        $res->bind_param("s", $month);
        $res->execute();
        return $res->get_result();
    }
}

$controller = new FinanceController($conn);

// ✅ Mes seleccionado
$viewMonth = $_GET['month_view'] ?? date('Y-m');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tx_submit'])) {
    $stmt = $conn->prepare("INSERT INTO finance (fecha, monto) VALUES (?, ?) ON DUPLICATE KEY UPDATE monto = VALUES(monto)");
    $stmt->bind_param("sd", $_POST['date'], $_POST['amount']);
    $stmt->execute();
    header("Location: " . $_SERVER['PHP_SELF'] . "?month_view=" . $viewMonth);
    exit;
}

$stats     = $controller->getAnalytics($viewMonth);
$chartData = $controller->getChartData($viewMonth);
$history   = $controller->getFullHistory($viewMonth);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>G502 | Finance Hub</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        :root { 
            --bg: #0f172a; 
            --panel: #1e293b; 
            --accent: #38bdf8; 
            --text: #f1f5f9; 
            --success: #22c55e; 
            --danger: #f87171; 
        }
        
        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        
        body { 
            background: var(--bg); 
            color: var(--text); 
            font-family: 'Inter', system-ui, -apple-system, sans-serif; 
            margin: 0; 
            padding: 10px; 
            line-height: 1.4; 
        }

        .container { max-width: 1200px; margin: 0 auto; }

        /* Responsive Header */
        header { 
            margin-bottom: 20px; 
            display: flex; 
            flex-direction: column; 
            gap: 15px; 
        }

        @media (min-width: 640px) {
            header { flex-direction: row; justify-content: space-between; align-items: center; }
            body { padding: 20px; }
        }

        h1 { margin: 0; font-size: 1.5rem; }

        .month-picker { 
            display: flex; 
            gap: 5px; 
            width: 100%; 
        }
        
        @media (min-width: 640px) { .month-picker { width: auto; } }

        .month-picker input[type="month"] { 
            flex-grow: 1;
            background: var(--panel); 
            border: 1px solid #334155; 
            color: white; 
            padding: 10px; 
            border-radius: 8px; 
            font-size: 14px;
        }

        .month-picker button { 
            width: auto;
            background: var(--accent); 
            color: var(--bg); 
            padding: 0 20px; 
            font-weight: bold; 
        }

        /* Stats Grid: 2 columns on mobile, 5 on desktop */
        .grid-stats { 
            display: grid; 
            grid-template-columns: repeat(2, 1fr); 
            gap: 10px; 
            margin-bottom: 20px; 
        }

        @media (min-width: 768px) { 
            .grid-stats { grid-template-columns: repeat(5, 1fr); gap: 15px; } 
        }

        .stat-card { 
            background: var(--panel); 
            padding: 12px; 
            border-radius: 12px; 
            border: 1px solid rgba(255,255,255,0.05); 
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .currency { font-size: 1.1rem; font-weight: 800; color: var(--accent); margin-top: 4px; overflow: hidden; text-overflow: ellipsis; }
        .small-label { color: #94a3b8; text-transform: uppercase; font-size: 0.6rem; font-weight: 700; letter-spacing: 0.5px; }

        /* Layout Columns */
        .main-layout { 
            display: grid; 
            grid-template-columns: 1fr; 
            gap: 15px; 
        }

        @media (min-width: 1024px) { 
            .main-layout { grid-template-columns: 1fr 320px; gap: 20px; } 
        }

        .panel { 
            background: var(--panel); 
            padding: 15px; 
            border-radius: 16px; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Scrollable Table for Mobile */
        .table-container { 
            width: 100%; 
            overflow-x: auto; 
            -webkit-overflow-scrolling: touch;
            margin-top: 10px;
        }

        table { width: 100%; border-collapse: collapse; min-width: 320px; }
        th { text-align: left; color: #94a3b8; font-size: 0.7rem; padding: 10px 5px; border-bottom: 1px solid #334155; }
        td { padding: 12px 5px; border-bottom: 1px solid #334155; font-size: 0.85rem; }

        /* Form Styling */
        input, button { 
            width: 100%; 
            background: #0f172a; 
            border: 1px solid #334155; 
            color: white; 
            padding: 14px; 
            margin-top: 10px; 
            border-radius: 10px; 
            font-size: 16px; /* Prevents auto-zoom on iOS */
        }

        button { 
            background: var(--accent); 
            color: var(--bg); 
            font-weight: 800; 
            border: none; 
            cursor: pointer; 
            transition: opacity 0.2s;
        }
        
        button:active { opacity: 0.8; }

        .chart-container { height: 220px; width: 100%; margin-top: 10px; }
        .empty-state { text-align: center; opacity: 0.4; padding: 30px 0; font-size: 0.9rem; }
    </style>
</head>
<body>
<?php include 'includes/header.php'; ?>

<div class="container">
    <header>
        <h1>G502 <span style="color:var(--accent)">Finassnce Hub</span></h1>
        <form method="GET" class="month-picker">
            <input type="month" name="month_view" value="<?php echo $viewMonth; ?>">
            <button type="submit">Ver</button>
        </form>
    </header>

    <p style="opacity:0.4; margin: -15px 0 20px 0; font-size: 0.8rem;">
        Mostrando datos de: <strong style="color:var(--accent)"><?php echo date('F Y', strtotime($viewMonth . '-01')); ?></strong>
    </p>

    <div class="grid-stats">
        <div class="stat-card">
            <div class="small-label">VENTA TOTAL</div>
            <div class="currency">$<?php echo number_format($stats['equity'], 0); ?></div>
        </div>
        <div class="stat-card">
            <div class="small-label">GANANCIA (18%)</div>
            <div class="currency" style="color:var(--success)">$<?php echo number_format($stats['ganancia'], 0); ?></div>
        </div>
        <div class="stat-card">
            <div class="small-label">META</div>
            <div class="currency" style="color:white"><?php echo number_format($stats['meta'], 0); ?></div>
        </div>
        <div class="stat-card">
            <div class="small-label">FALTA</div>
            <div class="currency" style="color:var(--danger)">$<?php echo number_format($stats['falta'], 0); ?></div>
        </div>
        <div class="stat-card" style="border: 1px solid rgba(248, 113, 113, 0.3);">
            <div class="small-label">GASTOS MES</div>
            <div class="currency" style="color:var(--danger)">$<?php echo number_format(abs($stats['gastos_mes']), 0); ?></div>
            <small><a href="expenses.php?month_view=<?php echo $viewMonth; ?>" style="color:#64748b;">ver detalle →</a></small>
        </div>
        <div class="stat-card">
            <div class="small-label">FALTA (%)</div>
            <div class="currency" style="color:var(--danger)"><?php echo number_format($stats['falta2'], 0); ?>%</div>
        </div>
    </div>

    <div class="main-layout">
        <div class="left-col">
            <div class="panel">
                <h3 style="margin-top:0">Flujo Mensual</h3>
                <div class="chart-container"><canvas id="financeChart"></canvas></div>
            </div>
            
            <div class="panel">
                <h3 style="margin-top:0">Transacciones</h3>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Fecha</th><th>Monto</th><th>Estado</th></tr></thead>
                        <tbody>
                            <?php 
                            $hasRows = false;
                            while($row = $history->fetch_assoc()): 
                                $hasRows = true;
                            ?>
                            <tr>
                                <td><?php echo date('d M', strtotime($row['fecha'])); ?></td>
                                <td><strong>$<?php echo number_format($row['monto'], 2); ?></strong></td>
                                <td style="color:var(--success)"><i class="ri-check-line"></i></td>
                            </tr>
                            <?php endwhile; ?>
                            <?php if (!$hasRows): ?>
                            <tr><td colspan="3" class="empty-state">No hay transacciones este mes.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="right-col">
            <div class="panel">
                <h3 style="margin-top:0"><i class="ri-add-circle-line"></i> Nueva Entrada</h3>
                <form method="POST">
                    <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>">
                    <input type="number" step="0.01" name="amount" placeholder="Monto ($)" required>
                    <button type="submit" name="tx_submit">Registrar Fondos</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const chartData = <?php echo json_encode($chartData); ?>;
    const ctx = document.getElementById('financeChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.map(r => r.fecha),
            datasets: [{
                data: chartData.map(r => r.monto),
                borderColor: '#38bdf8',
                backgroundColor: 'rgba(56, 189, 248, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { display: false },
                x: { ticks: { color: '#64748b', font: { size: 10 } }, grid: { display: false } }
            }
        }
    });
</script>

</body>
</html>