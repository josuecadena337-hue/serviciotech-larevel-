<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin — ServicioTech</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:#f1f5f9; }
        .header { background:linear-gradient(135deg,#1a237e,#3949ab); color:white; padding:20px 40px; display:flex; justify-content:space-between; align-items:center; }
        .header h1 { font-size:1.4rem; }
        .header p  { font-size:0.85rem; opacity:0.8; }
        .btn-logout { background:rgba(255,255,255,0.15); color:white; border:1px solid rgba(255,255,255,0.3); padding:8px 18px; border-radius:8px; cursor:pointer; font-family:'Inter',sans-serif; font-size:0.9rem; }
        .content { padding:40px; max-width:1000px; margin:0 auto; }
        .welcome { background:white; border-radius:12px; padding:30px; margin-bottom:24px; box-shadow:0 2px 8px rgba(0,0,0,0.06); }
        .welcome h2 { color:#1a237e; }
        .welcome p  { color:#64748b; margin-top:6px; }
        .cards { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px; }
        .card { background:white; border-radius:12px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.06); border-left:4px solid; }
        .card.azul   { border-color:#3949ab; }
        .card.verde  { border-color:#16a34a; }
        .card.amarillo{ border-color:#f59e0b; }
        .card.morado { border-color:#9333ea; }
        .card .num   { font-size:2rem; font-weight:700; }
        .card .label { color:#64748b; font-size:0.875rem; margin-top:4px; }
        .actions { background:white; border-radius:12px; padding:30px; box-shadow:0 2px 8px rgba(0,0,0,0.06); }
        .actions h3 { color:#1e293b; margin-bottom:6px; }
        .actions p  { color:#64748b; font-size:0.875rem; margin-bottom:20px; }
        .action-btns { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; }
        .btn-action { padding:14px; border-radius:10px; border:none; font-family:'Inter',sans-serif; font-size:0.9rem; font-weight:600; cursor:pointer; transition:transform 0.1s; }
        .btn-action:hover { transform:translateY(-2px); }
        .btn-action.azul   { background:#eff6ff; color:#3949ab; }
        .btn-action.verde  { background:#f0fdf4; color:#16a34a; }
        .btn-action.morado { background:#faf5ff; color:#9333ea; }
    </style>
</head>
<body>
<div class="header">
    <div>
        <h1>Panel de Administrador</h1>
        <p>ServicioTech — Sistema de Gestión</p>
    </div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-logout">→ Cerrar Sesión</button>
    </form>
</div>
<div class="content">
    <div class="welcome">
        <h2>⚙️ ¡Hola, {{ Auth::user()->nombre }}!</h2>
        <p>Administra clientes, técnicos, solicitudes y genera reportes del sistema.</p>
    </div>
    <div class="cards">
        <div class="card azul">
            <div class="num">3</div>
            <div class="label">Clientes Activos</div>
        </div>
        <div class="card verde">
            <div class="num">2</div>
            <div class="label">Técnicos</div>
        </div>
        <div class="card amarillo">
            <div class="num">4</div>
            <div class="label">Solicitudes Pendientes</div>
        </div>
        <div class="card morado">
            <div class="num">0</div>
            <div class="label">Servicios Completados</div>
        </div>
    </div>
    <div class="actions">
        <h3>Gestión Administrativa</h3>
        <p>Desde aquí puedes administrar todos los aspectos del sistema.</p>
        <div class="action-btns">
            <button class="btn-action azul">👥 Gestionar Clientes</button>
            <button class="btn-action verde">🔧 Gestionar Técnicos</button>
            <button class="btn-action morado">📊 Ver Reportes</button>
        </div>
    </div>
</div>
</body>
</html>
