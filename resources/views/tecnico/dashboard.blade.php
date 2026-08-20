<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Técnico — ServicioTech</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:#f1f5f9; }
        .header { background:linear-gradient(135deg,#166534,#16a34a); color:white; padding:20px 40px; display:flex; justify-content:space-between; align-items:center; }
        .header h1 { font-size:1.4rem; }
        .header p  { font-size:0.85rem; opacity:0.8; }
        .btn-logout { background:rgba(255,255,255,0.15); color:white; border:1px solid rgba(255,255,255,0.3); padding:8px 18px; border-radius:8px; cursor:pointer; font-family:'Inter',sans-serif; font-size:0.9rem; }
        .content { padding:40px; max-width:900px; margin:0 auto; }
        .welcome { background:white; border-radius:12px; padding:30px; margin-bottom:24px; box-shadow:0 2px 8px rgba(0,0,0,0.06); }
        .welcome h2 { color:#166534; }
        .welcome p  { color:#64748b; margin-top:6px; }
        .cards { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; }
        .card { background:white; border-radius:12px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.06); border-left:4px solid; }
        .card.amarillo { border-color:#f59e0b; }
        .card.azul     { border-color:#3b82f6; }
        .card.verde    { border-color:#16a34a; }
        .card .num   { font-size:2rem; font-weight:700; }
        .card .label { color:#64748b; font-size:0.875rem; margin-top:4px; }
    </style>
</head>
<body>
<div class="header">
    <div>
        <h1>Panel de Técnico</h1>
        <p>Mis Servicios Asignados — {{ Auth::user()->nombre }}</p>
    </div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-logout">→ Cerrar Sesión</button>
    </form>
</div>
<div class="content">
    <div class="welcome">
        <h2>🔧 ¡Hola, {{ Auth::user()->nombre }}!</h2>
        <p>Aquí puedes ver tus servicios asignados, actualizar estados y subir evidencias.</p>
    </div>
    <div class="cards">
        <div class="card amarillo">
            <div class="num">0</div>
            <div class="label">Servicios Pendientes</div>
        </div>
        <div class="card azul">
            <div class="num">0</div>
            <div class="label">En Proceso</div>
        </div>
        <div class="card verde">
            <div class="num">0</div>
            <div class="label">Completados Hoy</div>
        </div>
    </div>
</div>
</body>
</html>
