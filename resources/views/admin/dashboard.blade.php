@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Inicio')

@section('topbar-actions')
    <a href="{{ route('admin.solicitudes') }}" class="btn btn-amber">📋 Ver Solicitudes</a>
@endsection

@section('content')

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card" style="border-color:#3b82f6;">
        <div class="stat-icon" style="background:#eff6ff;">👥</div>
        <div><div class="num">{{ $totalClientes }}</div><div class="label">Clientes</div></div>
    </div>
    <div class="stat-card" style="border-color:#16a34a;">
        <div class="stat-icon" style="background:#f0fdf4;">🔧</div>
        <div><div class="num">{{ $totalTecnicos }}</div><div class="label">Técnicos</div></div>
    </div>
    <div class="stat-card" style="border-color:#f59e0b;">
        <div class="stat-icon" style="background:#fffbeb;">⏳</div>
        <div><div class="num">{{ $pendientes }}</div><div class="label">Pendientes</div></div>
    </div>
    <div class="stat-card" style="border-color:#8b5cf6;">
        <div class="stat-icon" style="background:#f5f3ff;">📊</div>
        <div><div class="num">{{ $totalSolicitudes }}</div><div class="label">Total Solicitudes</div></div>
    </div>
</div>

<div style="display:grid; grid-template-columns:2fr 1fr; gap:20px; align-items:start;">

    {{-- Últimas solicitudes --}}
    <div class="card">
        <div class="card-header">
            <h3>📋 Últimas Solicitudes</h3>
            <a href="{{ route('admin.solicitudes') }}" class="btn btn-secondary btn-sm">Ver todas</a>
        </div>
        @if($ultimasSolicitudes->isEmpty())
            <div class="empty-state"><div class="icon">📭</div><p>Sin solicitudes aún</p></div>
        @else
        <table>
            <thead>
                <tr>
                    <th>#</th><th>Cliente</th><th>Equipo</th><th>Tipo</th><th>Estado</th><th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($ultimasSolicitudes as $s)
                <tr>
                    <td><strong>#{{ $s->id_solicitud }}</strong></td>
                    <td>{{ $s->cliente->usuario->nombre }}</td>
                    <td>{{ $s->electrodomestico->marca }} {{ $s->electrodomestico->tipo }}</td>
                    <td>{{ ucfirst($s->tipo_solicitud) }}</td>
                    <td><span class="badge badge-{{ $s->estado_solicitud }}">{{ ucfirst(str_replace('_',' ',$s->estado_solicitud)) }}</span></td>
                    <td>
                        <a href="{{ route('admin.solicitudes.show', $s->id_solicitud) }}" class="btn btn-secondary btn-sm">Gestionar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- Técnicos disponibles --}}
    <div class="card">
        <div class="card-header">
            <h3>🔧 Técnicos Disponibles</h3>
        </div>
        <div class="card-body" style="padding:0;">
            @if($tecnicosDisponibles->isEmpty())
                <div class="empty-state" style="padding:24px;"><div class="icon">😔</div><p>Sin técnicos disponibles</p></div>
            @else
                @foreach($tecnicosDisponibles as $t)
                <div style="padding:14px 18px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:12px;">
                    <span style="font-size:1.5rem;">👷</span>
                    <div style="flex:1;">
                        <p style="font-weight:600; font-size:0.875rem;">{{ $t->usuario->nombre }}</p>
                        <p style="color:#64748b; font-size:0.78rem;">{{ $t->especialidad }}</p>
                    </div>
                    <span class="badge badge-disponible">Disponible</span>
                </div>
                @endforeach
            @endif
        </div>
    </div>

</div>

{{-- Resumen de estados --}}
<div class="card">
    <div class="card-header"><h3>📈 Resumen General</h3></div>
    <div class="card-body">
        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px;">
            <div style="text-align:center; padding:16px; background:#fff7ed; border-radius:10px;">
                <div style="font-size:1.8rem; font-weight:700; color:#ea580c;">{{ $enProceso }}</div>
                <div style="color:#ea580c; font-size:0.8rem; font-weight:600;">En Proceso</div>
            </div>
            <div style="text-align:center; padding:16px; background:#f0fdf4; border-radius:10px;">
                <div style="font-size:1.8rem; font-weight:700; color:#16a34a;">{{ $completadas }}</div>
                <div style="color:#16a34a; font-size:0.8rem; font-weight:600;">Completadas</div>
            </div>
            <div style="text-align:center; padding:16px; background:#f8fafc; border-radius:10px;">
                <div style="font-size:1.8rem; font-weight:700; color:#64748b;">{{ $totalSolicitudes - $pendientes - $enProceso - $completadas }}</div>
                <div style="color:#64748b; font-size:0.8rem; font-weight:600;">Otras</div>
            </div>
        </div>
    </div>
</div>

@endsection
