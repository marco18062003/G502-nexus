<?php
// g502 - Ultra Pro Supplier Hub 
$today_name = date('l'); 

// Fictional brand data with added "Inventory Status" logic
$suppliers = [
    [
        "name" => "Bavaria (AB InBev)", 
        "color" => "#f59e0b", 
        "rep" => "Juan Ruiz", 
        "phone" => "3001234567", 
        "visit_day" => "Monday", 
        "min_order" => "$450k", 
        "avg_monthly_spend" => "$12.4M",
        "low_stock_items" => 5, // Logic: items from this brand < 10 units
        "cat" => "Beers"
    ],
    [
        "name" => "Coca-Cola FEMSA", 
        "color" => "#ef4444", 
        "rep" => "Diana M.", 
        "phone" => "3119876543", 
        "visit_day" => "Tuesday", 
        "min_order" => "8 Crates", 
        "avg_monthly_spend" => "$8.2M",
        "low_stock_items" => 2,
        "cat" => "Sodas"
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>G502 | Corporate Supply Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        :root { --bg: #0f172a; --panel: #1e293b; --accent: #38bdf8; --warning: #fbbf24; --danger: #f87171; }
        
        body { background: var(--bg); color: #f1f5f9; font-family: 'Inter', sans-serif; margin: 0; padding: 15px; }
        
        /* Dashboard Stats Bar */
        .stats-bar { 
            display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 15px; margin-bottom: 30px; 
        }
        .mini-stat { background: var(--panel); padding: 15px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.05); }
        .mini-stat small { color: #94a3b8; font-size: 0.7rem; text-transform: uppercase; font-weight: 700; }
        .mini-stat div { font-size: 1.2rem; font-weight: 800; margin-top: 5px; color: var(--accent); }

        /* Supplier Grid */
        .supplier-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 20px; }

        .pro-card { 
            background: var(--panel); border-radius: 28px; padding: 25px; 
            border: 1px solid rgba(255,255,255,0.08); position: relative;
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
        }

        /* Stock Alert Badge */
        .stock-alert {
            background: rgba(248, 113, 113, 0.1); border: 1px solid var(--danger);
            color: var(--danger); padding: 10px; border-radius: 12px;
            font-size: 0.8rem; font-weight: 700; display: flex; align-items: center; gap: 8px;
            margin: 15px 0;
        }

        .brand-header { display: flex; justify-content: space-between; align-items: center; }
        .brand-name { font-size: 1.6rem; font-weight: 800; letter-spacing: -0.5px; }
        
        .finance-info { 
            display: flex; justify-content: space-between; 
            background: rgba(0,0,0,0.2); padding: 12px; border-radius: 14px; margin: 15px 0;
        }
        .finance-info div span { display: block; font-size: 0.65rem; color: #64748b; font-weight: 700; }
        .finance-info div b { font-size: 0.9rem; color: #cbd5e1; }

        .action-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .btn { 
            display: flex; align-items: center; justify-content: center; gap: 8px;
            padding: 14px; border-radius: 16px; text-decoration: none; font-weight: 700; font-size: 0.85rem;
        }
        .btn-call { background: white; color: var(--bg); grid-column: span 2; }
        .btn-wa { background: #128c7e; color: white; }
        .btn-sec { background: rgba(255,255,255,0.05); color: white; border: 1px solid rgba(255,255,255,0.1); }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

<div class="container">
    <header style="margin-bottom: 30px;">
        <h1 style="font-size: 2.5rem; margin:0;">G502 <span style="color:var(--accent)">Partners</span></h1>
        <p style="color:#64748b; margin-top:5px;">Supply chain intelligence & logistics</p>
    </header>

    <div class="stats-bar">
        <div class="mini-stat">
            <small>Active Suppliers</small>
            <div><?php echo count($suppliers); ?> Brands</div>
        </div>
        <div class="mini-stat">
            <small>Deliveries Today</small>
            <div>2 Trucks</div>
        </div>
        <div class="mini-stat">
            <small>Monthly Volume</small>
            <div>$43.2M COP</div>
        </div>
    </div>

    <div class="supplier-grid">
        <?php foreach ($suppliers as $s): ?>
        <div class="pro-card">
            <div class="brand-header">
                <span style="color:<?php echo $s['color']; ?>; font-weight:900; font-size:0.7rem;">● <?php echo $s['cat']; ?></span>
                <span style="color:#64748b; font-size:0.75rem; font-weight:700;"><?php echo $s['visit_day']; ?></span>
            </div>

            <h2 class="brand-name"><?php echo $s['name']; ?></h2>
            
            <div class="finance-info">
                <div><span>Avg. Monthly Spend</span><b><?php echo $s['avg_monthly_spend']; ?></b></div>
                <div><span>Min Order</span><b><?php echo $s['min_order']; ?></b></div>
            </div>

            <?php if($s['low_stock_items'] > 0): ?>
            <div class="stock-alert">
                <i class="ri-error-warning-fill"></i>
                CRITICAL STOCK: <?php echo $s['low_stock_items']; ?> items need restock
            </div>
            <?php endif; ?>

            <div style="margin-bottom:20px;">
                <div style="display:flex; align-items:center; gap:10px; color:#94a3b8; font-size:0.9rem;">
                    <i class="ri-user-smile-line" style="color:var(--accent)"></i>
                    <span>Rep: <b><?php echo $s['rep']; ?></b></span>
                </div>
            </div>

            <div class="action-grid">
                <a href="tel:<?php echo $s['phone']; ?>" class="btn btn-call"><i class="ri-phone-fill"></i> Place Official Order</a>
                <a href="https://wa.me/57<?php echo $s['phone']; ?>" class="btn btn-wa"><i class="ri-whatsapp-line"></i> Chat</a>
                <a href="#" class="btn btn-sec"><i class="ri-file-list-3-line"></i> Catalog</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

  <?php
// G502 - Imaginary Brand Data
$imaginary_brands = [
    ["name" => "Bavaria", "color1" => "#f59e0b", "color2" => "#d97706"],
    ["name" => "Coca-Cola", "color1" => "#ef4444", "color2" => "#991b1b"],
    ["name" => "Postobón", "color1" => "#ec4899", "color2" => "#be185d"],
    ["name" => "Alquería", "color1" => "#3b82f6", "color2" => "#1d4ed8"],
    ["name" => "Nestlé", "color1" => "#64748b", "color2" => "#334155"],
    ["name" => "P&G", "color1" => "#0ea5e9", "color2" => "#0369a1"],
    ["name" => "Colgate", "color1" => "#dc2626", "color2" => "#7f1d1d"],
    ["name" => "Zenú", "color1" => "#10b981", "color2" => "#065f46"]
];
?>

<style>
    :root {
        --slider-bg: #ffffff;
        --brand-text: #334155;
    }

    .g502-brand-section {
        padding: 40px 0;
        background: #f8fafc;
        border-radius: 30px;
        margin: 20px 0;
    }

    .slider-title {
        text-align: center;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 3px;
        font-size: 0.9rem;
        color: #94a3b8;
        margin-bottom: 30px;
    }

    /* The Scroll Container */
    .brand-wrapper {
        display: flex;
        overflow-x: auto;
        gap: 25px;
        padding: 10px 30px;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
    }

    .brand-wrapper::-webkit-scrollbar { display: none; }

    .brand-item {
        flex: 0 0 auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        scroll-snap-align: center;
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .brand-item:hover { transform: scale(1.1) rotate(3deg); }

    /* The Imaginary Logo */
    .brand-logo {
        width: 85px;
        height: 85px;
        border-radius: 24px; /* Squircle shape like iOS */
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 900;
        color: white;
        box-shadow: 0 10px 20px -5px rgba(0,0,0,0.15);
        margin-bottom: 12px;
        position: relative;
        border: 4px solid white;
    }

    /* Small "Official" Checkmark */
    .brand-logo::after {
        content: "\eb7b"; /* Remix Icon Check */
        font-family: 'remixicon';
        position: absolute;
        top: -5px;
        right: -5px;
        background: #38bdf8;
        width: 20px;
        height: 20px;
        font-size: 12px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid white;
    }

    .brand-label {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--brand-text);
    }
</style>

<section class="g502-brand-section">
    <div class="slider-title">Top Suppliers & Brands</div>
    
    <div class="brand-wrapper">
        <?php foreach ($imaginary_brands as $brand): ?>
            <div class="brand-item">
                <div class="brand-logo" style="background: linear-gradient(135deg, <?php echo $brand['color1']; ?>, <?php echo $brand['color2']; ?>);">
                    <?php echo substr($brand['name'], 0, 1); ?>
                </div>
                <span class="brand-label"><?php echo $brand['name']; ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</section>              

</body>
</html>