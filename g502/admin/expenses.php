<?php
require_once('seguridad_admin.php');

// 1. HANDLE NEW ENTRY
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_expense'])) {
    $stmt = $conn->prepare("INSERT INTO expenses (month, monto, categoria, descripcion) VALUES (?, ?, ?, ?)");
    $month_val = $_POST['month_input']; 
    $amount = -(abs((float)$_POST['amount'])); 
    $cat = !empty($_POST['categoria_input']) ? $_POST['categoria_input'] : 'General';
    $desc = !empty($_POST['descripcion_input']) ? $_POST['descripcion_input'] : '';
    $stmt->bind_param("sdss", $month_val, $amount, $cat, $desc);
    $stmt->execute();
    header("Location: " . $_SERVER['PHP_SELF'] . "?month_view=" . $month_val);
    exit;
}

// 2. SET THE VIEWING MONTH
// If you picked a month to "look", we use that. If not, we use the current month.
$viewMonth = $_GET['month_view'] ?? date('Y-m');

// 3. CALCULATE NET WORTH FOR SELECTED MONTH
$queryMonth = $conn->prepare("SELECT SUM(monto) as month_balance FROM expenses WHERE month = ?");
$queryMonth->bind_param("s", $viewMonth);
$queryMonth->execute();
$monthData = $queryMonth->get_result()->fetch_assoc();
$monthWorth = $monthData['month_balance'] ?? 0;

// 4. FETCH LIST FOR SELECTED MONTH
$history = $conn->prepare("SELECT * FROM expenses WHERE month = ? ORDER BY id DESC");
$history->bind_param("s", $viewMonth);
$history->execute();
$result = $history->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>G502 | Monthly Analysis</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        :root { --bg: #0f172a; --panel: #1e293b; --danger: #f43f5e; --success: #22c55e; --text: #f1f5f9; }
        body { background: var(--bg); color: var(--text); font-family: 'Segoe UI', sans-serif; padding: 20px; }
        .container { max-width: 900px; margin: auto; }
        
        .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        
        /* Net Worth Highlight */
        .net-worth-box { 
            background: var(--panel); 
            padding: 25px; 
            border-radius: 15px; 
            text-align: center;
            border-bottom: 4px solid <?php echo $monthWorth < 0 ? 'var(--danger)' : 'var(--success)'; ?>;
        }
        .net-worth-box h2 { margin: 0; font-size: 0.9rem; color: #94a3b8; text-transform: uppercase; }
        .net-worth-box div { font-size: 3rem; font-weight: 800; color: <?php echo $monthWorth < 0 ? 'var(--danger)' : 'var(--success)'; ?>; }

        .grid { display: grid; grid-template-columns: 1fr 1.5fr; gap: 20px; margin-top: 20px; }
        .card { background: var(--panel); padding: 20px; border-radius: 12px; border: 1px solid #334155; }
        
        input, button, select { width: 100%; padding: 12px; margin: 5px 0 15px 0; border-radius: 8px; border: 1px solid #475569; background: #0f172a; color: white; box-sizing: border-box; }
        .btn-add { background: var(--danger); border: none; font-weight: bold; cursor: pointer; }
        .btn-look { background: #334155; border: none; font-weight: bold; cursor: pointer; padding: 10px; }
        
        table { width: 100%; border-collapse: collapse; }
        td { padding: 12px 5px; border-bottom: 1px solid #1e293b; }
        .amt { font-weight: bold; text-align: right; color: var(--danger); }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

<div class="container">
    <div class="header-flex">
        <h1>G502 <span style="color:var(--danger)">TRACKER</span></h1>
        
        <form method="GET" style="display:flex; gap:10px; align-items: flex-end;">
            <div>
                <label style="font-size:0.7rem;">VIEW MONTH:</label>
                <input type="month" name="month_view" value="<?php echo $viewMonth; ?>" style="margin:0; padding:8px;">
            </div>
            <button type="submit" class="btn-look">LOOK</button>
        </form>
    </div>

    <div class="net-worth-box">
        <h2>Balance for <?php echo $viewMonth; ?></h2>
        <div>$<?php echo number_format($monthWorth, 2); ?></div>
    </div>

    <div class="grid">
        <div class="card">
            <h3 style="margin-top:0">New Expense</h3>
            <form method="POST">
                <input type="month" name="month_input" value="<?php echo $viewMonth; ?>" required>
                <input type="number" step="0.01" name="amount" placeholder="0.00" required autofocus>
                <input type="text" name="categoria_input" placeholder="Category">
                <input type="text" name="descripcion_input" placeholder="Description">
                <button type="submit" name="add_expense" class="btn-add">SAVE ENTRY</button>
            </form>
        </div>

        <div class="card">
            <h3 style="margin-top:0">Entries for this month</h3>
            <table>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>
                        <strong><?php echo htmlspecialchars($row['categoria']); ?></strong><br>
                        <small style="opacity:0.5"><?php echo htmlspecialchars($row['descripcion']); ?></small>
                    </td>
                    <td class="amt">$<?php echo number_format($row['monto'], 2); ?></td>
                </tr>
                <?php endwhile; ?>
                <?php if($result->num_rows == 0): ?>
                    <tr><td colspan="2" style="text-align:center; opacity:0.5; padding:40px;">No data for this month.</td></tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>

</body>
</html>