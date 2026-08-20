<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Técnico') — ServicioTech</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; display: flex; min-height: 100vh; }

        .sidebar { width: 240px; background: #166534; min-height: 100vh; display: flex; flex-direction: column; position: fixed; left: 0; top: 0; bottom: 0; }
        .sidebar-brand { padding: 22px 20px; border-bottom: 1px solid rgba(255,255,255,0.12); }
        .sidebar-brand h2 { color: white; font-size: 1.05rem; font-weight: 700; }
        .sidebar-brand p  { color: rgba(255,255,255,0.5); font-size: 0.72rem; margin-top: 2px; }
        .sidebar-user { padding: 14px 20px; background: rgba(255,255,255,0.08); margin: 12px; border-radius: 10px; }
        .sidebar-user .user-name { color: white; font-size: 0.875rem; font-weight: 600; }
        .sidebar-user .user-role { color: #86efac; font-size: 0.72rem; margin-top: 2px; font-weight: 600; }
        .sidebar-nav { flex: 1; padding: 8px 12px; display: flex; flex-direction: column; gap: 3px; }
        .nav-label { color: rgba(255,255,255,0.3); font-size: 0.68rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; padding: 12px 8px 5px; }
        .nav-link { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 8px; color: rgba(255,255,255,0.7); text-decoration: none; font-size: 0.875rem; font-weight: 500; transition: all 0.15s; }
        .nav-link:hover { background: rgba(255,255,255,0.1); color: white; }
        .nav-link.active { background: rgba(255,255,255,0.15); color: white; font-weight: 600; }
        .nav-icon { font-size: 1rem; width: 20px; text-align: center; }
        .sidebar-footer { padding: 14px 12px; border-top: 1px solid rgba(255,255,255,0.1); }
        .btn-logout { display: flex; align-items: center; gap: 10px; width: 100%; padding: 10px 12px; background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.12); border-radius: 8px; color: rgba(255,255,255,0.7); font-size: 0.875rem; font-family: 'Inter', sans-serif; cursor: pointer; transition: all 0.15s; }
        .btn-logout:hover { background: rgba(239,68,68,0.2); border-color: rgba(239,68,68,0.3); color: #fca5a5; }

        .main { margin-left: 240px; flex: 1; display: flex; flex-direction: column; }
        .topbar { background: white; padding: 16px 32px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; }
        .topbar h1 { font-size: 1.2rem; font-weight: 700; color: #0f172a; }
        .topbar .breadcrumb { font-size: 0.78rem; color: #94a3b8; margin-top: 2px; }
        .page-content { padding: 28px 32px; }

        .alert { padding: 13px 18px; border-radius: 10px; margin-bottom: 20px; font-size: 0.875rem; display: flex; align-items: center; gap: 10px; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; }
        .alert-error   { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; margin-bottom: 24px; }
        .stat-card { background: white; border-radius: 12px; padding: 20px; border-left: 4px solid; box-shadow: 0 1px 4px rgba(0,0,0,0.06); display: flex; align-items: center; gap: 14px; }
        .stat-icon { width: 46px; height: 46px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
        .stat-card .num   { font-size: 1.7rem; font-weight: 700; color: #0f172a; }
        .stat-card .label { font-size: 0.78rem; color: #64748b; margin-top: 1px; }

        .card { background: white; border-radius: 12px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); overflow: hidden; margin-bottom: 20px; }
        .card-header { padding: 18px 22px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; }
        .card-header h3 { font-size: 0.95rem; font-weight: 700; color: #0f172a; }
        .card-body { padding: 22px; }

        table { width: 100%; border-collapse: collapse; }
        thead th { padding: 10px 14px; text-align: left; font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; background: #f8fafc; border-bottom: 1px solid #e2e8f0; }
        tbody td { padding: 13px 14px; font-size: 0.875rem; color: #374151; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: #f8fafc; }

        .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 600; white-space: nowrap; }
        .badge-pendiente  { background: #fef3c7; color: #d97706; }
        .badge-asignada   { background: #dbeafe; color: #2563eb; }
        .badge-agendada   { background: #e0e7ff; color: #6366f1; }
        .badge-en_proceso { background: #fff7ed; color: #ea580c; }
        .badge-completada { background: #dcfce7; color: #16a34a; }
        .badge-cancelada  { background: #fee2e2; color: #dc2626; }
        .badge-confirmada { background: #dcfce7; color: #16a34a; }

        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; font-size: 0.8rem; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; text-decoration: none; border: none; transition: all 0.15s; }
        .btn-primary   { background: #166534; color: white; }
        .btn-primary:hover { background: #15803d; }
        .btn-orange { background: #ea580c; color: white; }
        .btn-orange:hover { background: #c2410c; }
        .btn-success { background: #16a34a; color: white; }
        .btn-success:hover { background: #15803d; }
        .btn-secondary { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
        .btn-secondary:hover { background: #e2e8f0; }
        .btn-sm { padding: 5px 12px; font-size: 0.75rem; }

        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 0.8rem; font-weight: 600; color: #374151; margin-bottom: 5px; }
        .form-control { width: 100%; padding: 9px 12px; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 0.875rem; font-family: 'Inter', sans-serif; color: #1e293b; background: white; transition: border-color 0.2s, box-shadow 0.2s; outline: none; }
        .form-control:focus { border-color: #16a34a; box-shadow: 0 0 0 3px rgba(22,163,74,0.1); }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .error-msg { color: #dc2626; font-size: 0.78rem; margin-top: 3px; }

        .empty-state { text-align: center; padding: 40px 20px; color: #94a3b8; }
        .empty-state .icon { font-size: 2.5rem; margin-bottom: 10px; }
        .empty-state p { font-size: 0.875rem; }
    </style>
    @stack('styles')
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand">
        <h2>🔧 ServicioTech</h2>
        <p>Panel de Técnico</p>
    </div>
    <div class="sidebar-user">
        <div class="user-name">{{ Auth::user()->nombre }}</div>
        <div class="user-role">🔧 Técnico</div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Mi Trabajo</div>
        <a href="{{ route('tecnico.dashboard') }}" class="nav-link {{ request()->routeIs('tecnico.dashboard') ? 'active' : '' }}">
            <span class="nav-icon">🏠</span> Inicio
        </a>
        <a href="{{ route('tecnico.asignaciones') }}" class="nav-link {{ request()->routeIs('tecnico.asignaciones*') || request()->routeIs('tecnico.solicitudes*') ? 'active' : '' }}">
            <span class="nav-icon">📋</span> Mis Asignaciones
        </a>
        <a href="{{ route('tecnico.citas') }}" class="nav-link {{ request()->routeIs('tecnico.citas*') ? 'active' : '' }}">
            <span class="nav-icon">📅</span> Mi Agenda
        </a>
    </nav>
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout"><span>🚪</span> Cerrar Sesión</button>
        </form>
    </div>
</aside>

<div class="main">
    <div class="topbar">
        <div>
            <h1>@yield('page-title', 'Panel')</h1>
            <div class="breadcrumb">ServicioTech › Técnico › @yield('breadcrumb', 'Inicio')</div>
        </div>
        @yield('topbar-actions')
    </div>
    <div class="page-content">
        @if (session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-error">❌ {{ $errors->first() }}</div>
        @endif
        @yield('content')
    </div>
</div>

@stack('scripts')
</body>
</html>
