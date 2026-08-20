@extends('layouts.tecnico')

@section('title', 'Mi Panel')
@section('page-title', 'Mi Panel')
@section('breadcrumb', 'Inicio')

@section('content')

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card" style="border-color:#3b82f6;">
        <div class="stat-icon" style="background:#eff6ff;">📋</div>
        <div><div class="num">{{ $totalAsignadas }}</div><div class="label">Asignaciones Activas</div></div>
    </div>
    <div class="stat-card" style="border-color:#ea580c;">
        <div class="stat-icon" style="background:#fff7ed;">⚙️</div>
        <div><div class="num">{{ $enProceso }}</div><div class="label">En Proceso</div></div>
    </div>
    <div class="stat-card" style="border-color:#16a34a;">
        <div class="stat-icon" style="background:#f0fdf4;">✅</div>
        <div><div class="num">{{ $completadas }}</div><div class="label">Completadas</div></div>
    </div>
</div>

<div style="display:grid; grid-template-columns:2fr 1fr; gap:20px; align-items:start;">

    {{-- Mis asignaciones activas --}}
    <div class="card">
        <div class="card-header">
            <h3>📋 Mis Asignaciones Activas</h3>
            <a href="{{ route('tecnico.asignaciones') }}" class="btn btn-secondary btn-sm">Ver todas</a>
        </div>
        @if($misAsignaciones->isEmpty())
            <div class="empty-state">
                <div class="icon">🎉</div>
                <p>¡No tienes asignaciones pendientes!</p>
            </div>
        @else
        <table>
            <thead>
                <tr><th>#</th><th>Cliente</th><th>Equipo</th><th>Tipo</th><th>Estado</th><th></th></tr>
            </thead>
            <tbody>
                @foreach($misAsignaciones as $a)
                <tr>
                    <td><strong>#{{ $a->solicitud->id_solicitud }}</strong></td>
                    <td>{{ $a->solicitud->cliente->usuario->nombre }}</td>
                    <td>{{ $a->solicitud->electrodomestico->marca }} {{ $a->solicitud->electrodomestico->tipo }}</td>
                    <td>{{ ucfirst($a->solicitud->tipo_solicitud) }}</td>
                    <td>
                        <span class="badge badge-{{ $a->solicitud->estado_solicitud }}">
                            {{ ucfirst(str_replace('_',' ',$a->solicitud->estado_solicitud)) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('tecnico.solicitudes.show', $a->solicitud->id_solicitud) }}"
                           class="btn btn-primary btn-sm">Ver</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- Citas de hoy --}}
    <div class="card">
        <div class="card-header">
            <h3>📅 Citas de Hoy</h3>
            <span style="font-size:0.78rem; color:#94a3b8;">{{ \Carbon\Carbon::today()->format('d/m/Y') }}</span>
        </div>
        <div class="card-body" style="padding:0;">
            @if($citasHoy->isEmpty())
                <div class="empty-state" style="padding:24px;">
                    <div class="icon">😌</div>
                    <p>Sin citas para hoy</p>
                </div>
            @else
                @foreach($citasHoy as $cita)
                <div style="padding:14px 18px; border-bottom:1px solid #f1f5f9;">
                    <p style="font-weight:700; font-size:1rem; color:#166534;">🕐 {{ $cita->hora }}</p>
                    <p style="font-weight:600; font-size:0.875rem; margin-top:4px;">
                        {{ $cita->solicitud->cliente->usuario->nombre }}
                    </p>
                    <p style="color:#64748b; font-size:0.8rem;">
                        {{ $cita->solicitud->electrodomestico->marca }}
                        {{ $cita->solicitud->electrodomestico->tipo }}
                    </p>
                    <a href="{{ route('tecnico.solicitudes.show', $cita->solicitud->id_solicitud) }}"
                       class="btn btn-primary btn-sm" style="margin-top:8px;">Ver servicio</a>
                </div>
                @endforeach
            @endif
        </div>
    </div>

</div>

@endsection
