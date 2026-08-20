<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel') — ServicioTech</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; display: flex; min-height: 100vh; }

        /* ── SIDEBAR ─────────────────────────────── */
        .sidebar {
            width: 240px;
            background: #1a237e;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0; top: 0; bottom: 0;
        }

        .sidebar-brand {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-brand h2 {
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
        }

        .sidebar-brand p {
            color: rgba(255,255,255,0.55);
            font-size: 0.75rem;
            margin-top: 2px;
        }

        .sidebar-user {
            padding: 16px 20px;
            background: rgba(255,255,255,0.07);
            margin: 12px;
            border-radius: 10px;
        }

        .sidebar-user .user-name {
            color: white;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .sidebar-user .user-role {
            color: rgba(255,255,255,0.55);
            font-size: 0.75rem;
            margin-top: 2px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 8px 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .nav-label {
            color: rgba(255,255,255,0.35);
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 12px 8px 6px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.15s;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .nav-link.active {
            background: rgba(255,255,255,0.15);
            color: white;
            font-weight: 600;
        }

        .nav-icon { font-size: 1rem; width: 20px; text-align: center; }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 10px 12px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 8px;
            color: rgba(255,255,255,0.7);
            font-size: 0.875rem;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-logout:hover {
            background: rgba(239,68,68,0.2);
            border-color: rgba(239,68,68,0.4);
            color: #fca5a5;
        }

        /* ── MAIN CONTENT ────────────────────────── */
        .main {
            margin-left: 240px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background: white;
            padding: 16px 32px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar h1 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
        }

        .topbar .breadcrumb {
            font-size: 0.8rem;
            color: #94a3b8;
            margin-top: 2px;
        }

        .page-content { padding: 32px; }

        /* ── ALERTAS ─────────────────────────────── */
        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 24px;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #16a34a;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }

        /* ── CARDS DE ESTADÍSTICAS ───────────────── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: white;
            border-radius: 14px;
            padding: 24px;
            border-left: 4px solid;
            box-shadow: 0 1px 6px rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-icon {
            width: 50px; height: 50px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .stat-card .num   { font-size: 1.8rem; font-weight: 700; color: #0f172a; }
        .stat-card .label { font-size: 0.8rem; color: #64748b; margin-top: 2px; }

        /* ── TABLA ───────────────────────────────── */
        .card {
            background: white;
            border-radius: 14px;
            box-shadow: 0 1px 6px rgba(0,0,0,0.06);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header h3 { font-size: 1rem; font-weight: 700; color: #0f172a; }

        .card-body { padding: 24px; }

        table { width: 100%; border-collapse: collapse; }
        thead th {
            padding: 10px 14px;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        tbody td {
            padding: 14px;
            font-size: 0.875rem;
            color: #374151;
            border-bottom: 1px solid #f1f5f9;
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: #f8fafc; }

        /* ── BADGES DE ESTADO ────────────────────── */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-pendiente  { background: #fef3c7; color: #d97706; }
        .badge-asignada   { background: #dbeafe; color: #2563eb; }
        .badge-agendada   { background: #e0e7ff; color: #6366f1; }
        .badge-en_proceso { background: #fff7ed; color: #ea580c; }
        .badge-completada { background: #dcfce7; color: #16a34a; }
        .badge-cancelada  { background: #fee2e2; color: #dc2626; }

        /* ── BOTONES ─────────────────────────────── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            text-decoration: none;
            border: none;
            transition: all 0.15s;
        }

        .btn-primary {
            background: #1a237e;
            color: white;
        }
        .btn-primary:hover { background: #3949ab; transform: translateY(-1px); }

        .btn-secondary {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }
        .btn-secondary:hover { background: #e2e8f0; }

        .btn-sm { padding: 6px 12px; font-size: 0.8rem; }

        /* ── FORMULARIOS ─────────────────────────── */
        .form-group { margin-bottom: 20px; }

        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            color: #1e293b;
            background: white;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }

        .form-control:focus {
            border-color: #1a237e;
            box-shadow: 0 0 0 3px rgba(26,35,126,0.1);
        }

        .form-control.error { border-color: #dc2626; }
        .error-msg { color: #dc2626; font-size: 0.8rem; margin-top: 4px; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: #94a3b8;
        }
        .empty-state .icon { font-size: 3rem; margin-bottom: 12px; }
        .empty-state p { font-size: 0.9rem; margin-bottom: 16px; }
    </style>
    @stack('styles')
</head>
<body>

{{-- ── SIDEBAR ────────────────────────────────── --}}
<aside class="sidebar">
    <div class="sidebar-brand">
        <h2>🔧 ServicioTech</h2>
        <p>Panel de Cliente</p>
    </div>

    <div class="sidebar-user">
        <div class="user-name">{{ Auth::user()->nombre }}</div>
        <div class="user-role">👤 Cliente</div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-label">Menú</div>

        <a href="{{ route('cliente.dashboard') }}"
           class="nav-link {{ request()->routeIs('cliente.dashboard') ? 'active' : '' }}">
            <span class="nav-icon">🏠</span> Inicio
        </a>

        <a href="{{ route('cliente.equipos') }}"
           class="nav-link {{ request()->routeIs('cliente.equipos*') ? 'active' : '' }}">
            <span class="nav-icon">🖥️</span> Mis Equipos
        </a>

        <a href="{{ route('cliente.solicitudes') }}"
           class="nav-link {{ request()->routeIs('cliente.solicitudes*') ? 'active' : '' }}">
            <span class="nav-icon">📋</span> Mis Solicitudes
        </a>

        <a href="{{ route('cliente.citas') }}"
           class="nav-link {{ request()->routeIs('cliente.citas*') ? 'active' : '' }}">
            <span class="nav-icon">📅</span> Mis Citas
        </a>
    </nav>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <span>🚪</span> Cerrar Sesión
            </button>
        </form>
    </div>
</aside>

{{-- ── CONTENIDO PRINCIPAL ───────────────────── --}}
<div class="main">
    <div class="topbar">
        <div>
            <h1>@yield('page-title', 'Panel')</h1>
            <div class="breadcrumb">ServicioTech › @yield('breadcrumb', 'Inicio')</div>
        </div>
        @yield('topbar-actions')
    </div>

    <div class="page-content">

        {{-- Mensajes de éxito --}}
        @if (session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif

        {{-- Errores de validación --}}
        @if ($errors->any())
            <div class="alert alert-error">❌ {{ $errors->first() }}</div>
        @endif

        {{-- Contenido de cada vista --}}
        @yield('content')
    </div>
</div>

@stack('scripts')
</body>
</html>
