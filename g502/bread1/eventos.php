<?php
require_once '../config/db.php';

// ── BAN CHECK ────────────────────────────────────────────────────────────────
$ip_usuario = isset($_COOKIE['g502_uid']) ? $_COOKIE['g502_uid'] : 'NUEVO';
if ($ip_usuario !== 'NUEVO') {
    $uid_clean = mysqli_real_escape_string($conn, $ip_usuario);
    $check_res = mysqli_query($conn, "SELECT usuario_id FROM usuarios_baneados_pan WHERE usuario_id = '$uid_clean'");
    if ($check_res && mysqli_num_rows($check_res) > 0) {
        http_response_code(403);
        die("<div style='display:flex;flex-direction:column;align-items:center;justify-content:center;height:100vh;background:#f8d7da;color:#721c24;font-family:sans-serif;text-align:center;padding:20px;box-sizing:border-box;'>
            <h1 style='font-size:3rem;'>🚫 Acceso Denegado</h1>
            <p style='font-size:1.2rem;'>Tu dispositivo ha sido bloqueado permanentemente.</p>
            <p style='font-size:0.9rem;'>Si crees que esto es un error, contacta al administrador.</p></div>");
    }
}

// ── AJAX ACTIONS ─────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    $action = $_POST['action'];

    // Helper: escape
    $s = fn($v) => mysqli_real_escape_string($conn, $v ?? '');

    if ($action === 'add') {
        $c1 = $s($_POST['col1']);
        $c2 = (int)($_POST['col2'] ?? 0);
        $c3 = $s($_POST['col3']);
        $c4 = $s($_POST['col4']);
        $c5 = $s($_POST['col5']);
        $sql = "INSERT INTO book_10_sheet1_ (`COL 1`,`COL 2`,`COL 3`,`COL 4`,`COL 5`)
                VALUES ('$c1',$c2,'$c3','$c4','$c5')";
        $ok = mysqli_query($conn, $sql);
        echo json_encode(['ok' => (bool)$ok, 'error' => mysqli_error($conn)]);
        exit;
    }

    if ($action === 'edit') {
        $c1  = $s($_POST['col1']);
        $c2  = (int)($_POST['col2'] ?? 0);
        $c3  = $s($_POST['col3']);
        $c4  = $s($_POST['col4']);
        $c5  = $s($_POST['col5']);
        $old = (int)($_POST['old_col2'] ?? $c2);
        $sql = "UPDATE book_10_sheet1_
                SET `COL 1`='$c1', `COL 2`=$c2, `COL 3`='$c3', `COL 4`='$c4', `COL 5`='$c5'
                WHERE `COL 2`=$old";
        $ok = mysqli_query($conn, $sql);
        echo json_encode(['ok' => (bool)$ok, 'error' => mysqli_error($conn)]);
        exit;
    }

    if ($action === 'delete') {
        $c2 = (int)($_POST['col2'] ?? 0);
        $ok = mysqli_query($conn, "DELETE FROM book_10_sheet1_ WHERE `COL 2`=$c2");
        echo json_encode(['ok' => (bool)$ok]);
        exit;
    }

    if ($action === 'get') {
        $c2  = (int)($_POST['col2'] ?? 0);
        $res = mysqli_query($conn, "SELECT * FROM book_10_sheet1_ WHERE `COL 2`=$c2");
        $row = mysqli_fetch_assoc($res);
        echo json_encode($row ?: []);
        exit;
    }

    if ($action === 'list') {
        $q = $s($_POST['q'] ?? '');
        $where = $q
            ? "WHERE `COL 1` LIKE '%$q%' OR `COL 2` LIKE '%$q%' OR `COL 5` LIKE '%$q%'"
            : '';
        $res  = mysqli_query($conn, "SELECT * FROM book_10_sheet1_ $where ORDER BY `COL 2` DESC");
        $rows = [];
        while ($r = mysqli_fetch_assoc($res)) $rows[] = $r;
        echo json_encode($rows);
        exit;
    }

    echo json_encode(['ok' => false, 'msg' => 'Acción desconocida']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>g502 Pro – Eventos</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/button.css?v=1730030000">
    <style>
        :root { --p: #85B820; --s: #85B820; --bg: #f1f5f9; --white: #ffffff; }
        *, *::before, *::after { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); margin: 0; padding: 15px; padding-bottom: 100px; }
        .container { max-width: 750px; margin: 0 auto; }

        /* SEARCH BAR */
        .search-section { position: sticky; top: 10px; z-index: 10; margin-bottom: 20px; }
        .search-bar {
            display: flex; align-items: center; background: #fff;
            border: 2px solid var(--p); border-radius: 50px;
            padding: 6px 6px 6px 18px;
            box-shadow: 0 4px 20px rgba(133,184,32,.2);
            transition: box-shadow .2s, border-color .2s; gap: 8px;
        }
        .search-bar:focus-within { box-shadow: 0 4px 24px rgba(133,184,32,.4); border-color: #6a9518; }
        .search-icon { font-size: 1.1rem; flex-shrink: 0; opacity: .5; }
        #busqueda {
            flex: 1; border: none; outline: none; font-size: 1rem;
            font-family: 'Inter', sans-serif; background: transparent;
            color: #1e293b; padding: 10px 0; min-width: 0;
        }
        #busqueda::placeholder { color: #94a3b8; }

        /* TABLE */
        .table-wrapper { background: var(--white); border-radius: 18px; box-shadow: 0 2px 12px rgba(0,0,0,.07); overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 560px; }
        thead tr { background: var(--p); }
        thead th {
            color: #fff; font-size: .76rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .05em;
            padding: 13px 14px; text-align: left; white-space: nowrap;
        }
        thead th.sortable { cursor: pointer; user-select: none; }
        thead th.sortable:hover { background: #78a81c; }
        .sort-arrow { margin-left: 4px; opacity: .7; }
        tbody tr { border-bottom: 1px solid #f0f4f8; transition: background .15s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #f8faf3; }
        tbody td { padding: 11px 14px; font-size: .85rem; color: #1e293b; vertical-align: middle; }

        .pill {
            display: inline-block; padding: 3px 10px; border-radius: 99px;
            font-size: .72rem; font-weight: 700;
            background: #e9f5cc; color: #4a7a00; white-space: nowrap;
        }
        code.plu {
            background: #f1f5f9; padding: 2px 7px;
            border-radius: 5px; font-size: .8rem; font-weight: 600;
        }

        /* ACTION BUTTONS */
        .actions { display: flex; gap: 5px; flex-wrap: wrap; }
        .btn-ev {
            padding: 6px 10px; border: none; border-radius: 7px;
            font-size: .72rem; font-weight: 700; color: #fff;
            cursor: pointer; transition: transform .1s, opacity .15s;
            display: flex; align-items: center; gap: 3px;
        }
        .btn-ev:active { transform: scale(.93); opacity: .85; }
        .btn-edit   { background: #3b82f6; }
        .btn-copy   { background: #8b5cf6; }
        .btn-delete { background: #ef4444; }

        /* MODAL */
        .modal {
            display: none; position: fixed; z-index: 200;
            left: 0; top: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,.8);
            align-items: center; justify-content: center;
        }
        .modal-content {
            background: #fff; padding: 25px; border-radius: 20px;
            width: 92%; max-width: 420px; position: relative;
            max-height: 90vh; overflow-y: auto;
        }
        .close-modal { position: absolute; top: 15px; right: 15px; font-size: 25px; cursor: pointer; color: #64748b; }

        /* FORM */
        .ev-form label { font-size: .75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: .04em; display: block; margin-bottom: 3px; margin-top: 12px; }
        .ev-form input, .ev-form select {
            width: 100%; padding: 11px 13px;
            border: 1.5px solid #dde1e9; border-radius: 9px;
            font-family: 'Inter', sans-serif; font-size: .9rem;
            outline: none; transition: border-color .2s;
        }
        .ev-form input:focus, .ev-form select:focus { border-color: var(--p); }
        .btn-submit {
            width: 100%; padding: 15px; background: var(--s);
            color: #fff; border: none; border-radius: 11px;
            font-weight: 800; font-size: 1rem; cursor: pointer;
            margin-top: 18px; letter-spacing: .03em; transition: background .2s;
        }
        .btn-submit:hover { background: #6a9518; }

        /* FAB */
        .btn-flotante {
            position: fixed; bottom: 25px; right: 25px;
            width: 65px; height: 65px; background: var(--s);
            color: #fff; border-radius: 50%; border: none; font-size: 35px;
            box-shadow: 0 5px 20px rgba(0,0,0,.3); cursor: pointer; z-index: 100;
            display: flex; align-items: center; justify-content: center;
        }

        /* EMPTY / LOADING */
        .empty { text-align: center; padding: 50px 20px; color: #94a3b8; font-size: .9rem; }
        .empty span { font-size: 3rem; display: block; margin-bottom: 10px; }

        /* PAGE HEADER */
        .page-header { display: flex; align-items: center; gap: 10px; margin-bottom: 18px; }
        .page-header h1 { font-size: 1.4rem; font-weight: 800; color: #1e293b; margin: 0; }
        .badge { background: var(--p); color: #fff; font-size: .72rem; font-weight: 700; padding: 3px 10px; border-radius: 99px; }

        /* LOGO */
        .logo-container { display: flex; justify-content: center; align-items: center; width: 100%; margin: 20px 0; }
        .logo-container img { width: 450px; max-width: 90%; height: auto; filter: drop-shadow(0 4px 6px rgba(0,0,0,.1)); }
        @media (min-width: 768px) { #logo-mobile-only { display: none !important; } }
    </style>
</head>
<body>

<!-- NAV BAR -->
<div class="mobile-nav-bar">
    <div class="nav-group">
        <div class="nav-divider"></div>
        <button onclick="window.location.href='../admin/index.php'" class="nav-item">
            <span class="nav-icon">🛠️</span>
            <span class="nav-text">Admin</span>
        </button>
        <button onclick="window.location.href='gestion_productos.php'" class="nav-item">
            <span class="nav-icon">📊</span>
            <span class="nav-text">Base Datos</span>
        </button>
        <button onclick="window.location.href='eventos.php'" class="nav-item highlight">
            <span class="nav-icon">📅</span>
            <span class="nav-text">Eventos</span>
        </button>
    </div>
</div>

<div class="container">
    <div class="page-header">
        <h1>📅 Eventos</h1>
        <span class="badge" id="totalBadge">…</span>
    </div>

    <div class="search-section">
        <div class="search-bar">
            <span class="search-icon">🔍</span>
            <input type="text" id="busqueda" placeholder="Buscar nombre, código, tipo…" autocomplete="off">
        </div>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th class="sortable" data-col="COL 1" onclick="sortTable('COL 1')">Nombre <span class="sort-arrow">↕</span></th>
                    <th class="sortable" data-col="COL 2" onclick="sortTable('COL 2')">Código <span class="sort-arrow">↕</span></th>
                    <th class="sortable" data-col="COL 3" onclick="sortTable('COL 3')">Inicio <span class="sort-arrow">↕</span></th>
                    <th class="sortable" data-col="COL 4" onclick="sortTable('COL 4')">Fin <span class="sort-arrow">↕</span></th>
                    <th>Tipo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tablebody">
                <tr><td colspan="6"><div class="empty"><span>⏳</span>Cargando…</div></td></tr>
            </tbody>
        </table>
    </div>
</div>

<button class="btn-flotante" onclick="openAddModal()">+</button>

<div id="mainModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal()">&times;</span>
        <div id="modalBody"></div>
    </div>
</div>

<div id="logo-mobile-only" class="logo-container">
    <img src="../assets/img/carulla.png" alt="Logo Carulla">
</div>
<p style="text-align:center;margin-top:20px;font-size:.8rem;color:#94a3b8;">g502 – Eventos</p>

<script>
let allRows = [];
let sortCol = 'COL 2';
let sortDir = -1;

const modal     = document.getElementById('mainModal');
const modalBody = document.getElementById('modalBody');

function closeModal() { modal.style.display = 'none'; }
window.onclick = e => { if (e.target === modal) closeModal(); };

// ── API HELPER ────────────────────────────────────────────────────────────────
async function api(params) {
    const fd = new FormData();
    Object.entries(params).forEach(([k,v]) => fd.append(k, v ?? ''));
    const res = await fetch('eventos.php', { method:'POST', body:fd });
    return res.json();
}

// ── LOAD ──────────────────────────────────────────────────────────────────────
async function loadTable() {
    const q    = document.getElementById('busqueda').value;
    const data = await api({ action:'list', q });
    allRows    = data;
    document.getElementById('totalBadge').textContent =
        data.length + ' evento' + (data.length !== 1 ? 's' : '');
    renderTable();
}

function renderTable() {
    const tbody = document.getElementById('tablebody');
    if (!allRows.length) {
        tbody.innerHTML = `<tr><td colspan="6"><div class="empty"><span>📭</span>Sin eventos. Pulsa + para agregar.</div></td></tr>`;
        return;
    }
    const sorted = [...allRows].sort((a,b) => {
        const av = String(a[sortCol] ?? '').toLowerCase();
        const bv = String(b[sortCol] ?? '').toLowerCase();
        // numeric sort for COL 2
        if (sortCol === 'COL 2') return (Number(a[sortCol]) - Number(b[sortCol])) * sortDir;
        return (av < bv ? -1 : av > bv ? 1 : 0) * sortDir;
    });

    tbody.innerHTML = sorted.map(r => `
        <tr>
            <td><strong>${esc(r['COL 1'])}</strong></td>
            <td><code class="plu">${esc(r['COL 2'])}</code></td>
            <td>${esc(r['COL 3'])}</td>
            <td>${esc(r['COL 4'])}</td>
            <td><span class="pill">${esc(r['COL 5'])}</span></td>
            <td>
                <div class="actions">
                    <button class="btn-ev btn-edit"   onclick="openEditModal(${r['COL 2']})">✏️ Editar</button>
                    <button class="btn-ev btn-copy"   onclick="copyRow(${r['COL 2']})">📋 Copiar</button>
                    <button class="btn-ev btn-delete" onclick="deleteRow(${r['COL 2']},'${esc(r['COL 1'])}')">🗑️ Eliminar</button>
                </div>
            </td>
        </tr>`).join('');
}

function esc(s) {
    return String(s ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

// ── SORT ──────────────────────────────────────────────────────────────────────
function sortTable(col) {
    sortDir = (sortCol === col) ? sortDir * -1 : 1;
    sortCol = col;
    document.querySelectorAll('.sort-arrow').forEach(el => el.textContent = '↕');
    const th = document.querySelector(`th[data-col="${col}"] .sort-arrow`);
    if (th) th.textContent = sortDir === 1 ? '↑' : '↓';
    renderTable();
}

// ── FORM ──────────────────────────────────────────────────────────────────────
const TIPOS = ['diamante','impresionante','insuperable','aniversario','mi descuento'];

function buildForm(d = {}, isEdit = false) {
    const c5val = (d['COL 5'] || '').toLowerCase().trim();
    const opts  = TIPOS.map(t =>
        `<option value="${t}" ${c5val === t ? 'selected' : ''}>${t.charAt(0).toUpperCase()+t.slice(1)}</option>`
    ).join('');

    return `
    <form id="evForm" class="ev-form" onsubmit="submitForm(event)">
        <input type="hidden" name="old_col2" value="${esc(d['COL 2']||'')}">

        <label>Nombre del Producto (COL 1)</label>
        <input type="text" name="col1" placeholder="Ej: Suavizante Floral"
               value="${esc(d['COL 1']||'')}" required maxlength="51">

        <label>Código / PLU (COL 2) — clave primaria</label>
        <input type="number" name="col2" placeholder="Ej: 3818132"
               value="${esc(d['COL 2']||'')}" required ${isEdit ? '' : ''}>

        <label>Fecha Inicio (COL 3)</label>
        <input type="text" name="col3" placeholder="Ej: 01-jun"
               value="${esc(d['COL 3']||'')}" maxlength="6">

        <label>Fecha Fin (COL 4)</label>
        <input type="text" name="col4" placeholder="Ej: 30-jul"
               value="${esc(d['COL 4']||'')}" maxlength="6">

        <label>Tipo / Ciclo (COL 5)</label>
        <select name="col5">
            <option value="">-- Selecciona --</option>
            ${opts}
        </select>

        <button type="submit" class="btn-submit">💾 GUARDAR</button>
    </form>`;
}

// ── ADD ───────────────────────────────────────────────────────────────────────
function openAddModal() {
    modalBody.innerHTML = `<h3 style="margin-bottom:4px;">➕ Nuevo Evento</h3>` + buildForm();
    modal.style.display = 'flex';
}

// ── EDIT ──────────────────────────────────────────────────────────────────────
async function openEditModal(col2) {
    modalBody.innerHTML = `<p style="text-align:center;color:#94a3b8;padding:30px;">Cargando…</p>`;
    modal.style.display = 'flex';
    const data = await api({ action:'get', col2 });
    modalBody.innerHTML = `<h3 style="margin-bottom:4px;">✏️ Editar Evento</h3>` + buildForm(data, true);
}

// ── COPY ──────────────────────────────────────────────────────────────────────
async function copyRow(col2) {
    const data = await api({ action:'get', col2 });
    data['COL 2'] = '';
    data['COL 1'] = (data['COL 1'] || '') + ' (copia)';
    modalBody.innerHTML = `<h3 style="margin-bottom:4px;">📋 Copiar Evento</h3>` + buildForm(data);
    modal.style.display = 'flex';
}

// ── DELETE ────────────────────────────────────────────────────────────────────
function deleteRow(col2, nombre) {
    modalBody.innerHTML = `
        <div style="text-align:center;padding:10px 0 20px;">
            <span style="font-size:3rem;">🗑️</span>
            <h3 style="margin:10px 0 5px;">Eliminar Evento</h3>
            <p style="color:#64748b;font-size:.9rem;margin-bottom:20px;">
                ¿Seguro que deseas eliminar <strong>${esc(nombre)}</strong>?<br>
                Esta acción no se puede deshacer.
            </p>
            <div style="display:flex;gap:10px;">
                <button onclick="closeModal()"
                        style="flex:1;padding:13px;background:#f1f5f9;border:none;border-radius:10px;font-weight:700;cursor:pointer;">
                    Cancelar
                </button>
                <button onclick="confirmDelete(${col2})"
                        style="flex:1;padding:13px;background:#ef4444;color:#fff;border:none;border-radius:10px;font-weight:700;cursor:pointer;">
                    Eliminar
                </button>
            </div>
        </div>`;
    modal.style.display = 'flex';
}

async function confirmDelete(col2) {
    await api({ action:'delete', col2 });
    closeModal();
    loadTable();
}

// ── SUBMIT ────────────────────────────────────────────────────────────────────
async function submitForm(e) {
    e.preventDefault();
    const fd      = new FormData(document.getElementById('evForm'));
    const oldCol2 = fd.get('old_col2');
    const params  = {
        action:  oldCol2 ? 'edit' : 'add',
        old_col2: oldCol2,
        col1: fd.get('col1'),
        col2: fd.get('col2'),
        col3: fd.get('col3'),
        col4: fd.get('col4'),
        col5: fd.get('col5'),
    };
    const res = await api(params);
    if (res.ok) { closeModal(); loadTable(); }
    else alert('Error al guardar: ' + (res.error || 'revisa los datos'));
}

// ── SEARCH ────────────────────────────────────────────────────────────────────
let t;
document.getElementById('busqueda').addEventListener('input', () => {
    clearTimeout(t);
    t = setTimeout(loadTable, 250);
});

// ── INIT ──────────────────────────────────────────────────────────────────────
loadTable();
</script>
</body>
</html>
