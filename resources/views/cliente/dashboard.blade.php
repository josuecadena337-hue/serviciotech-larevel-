@extends('layouts.cliente')

@section('title', 'Dashboard')
@section('page-title', 'Mi Panel')
@section('breadcrumb', 'Inicio')

@section('topbar-actions')
    <a href="{{ route('cliente.solicitudes.create') }}" class="btn btn-primary">
        ➕ Solicitar Servicio
    </a>
@endsection

@section('content')

    {{-- Tarjetas de estadísticas --}}
    <div class="stats-grid">
        <div class="stat-card" style="border-color:#1a237e;">
            <div class="stat-icon" style="background:#eff6ff;">🖥️</div>
            <div>
                <div class="num">{{ $totalEquipos }}</div>
                <div class="label">Mis Equipos</div>
            </div>
        </div>
        <div class="stat-card" style="border-color:#f59e0b;">
            <div class="stat-icon" style="background:#fffbeb;">⏳</div>
            <div>
                <div class="num">{{ $solicitudesActivas }}</div>
                <div class="label">Solicitudes Activas</div>
            </div>
        </div>
        <div class="stat-card" style="border-color:#16a34a;">
            <div class="stat-icon" style="background:#f0fdf4;">✅</div>
            <div>
                <div class="num">{{ $serviciosCompletados }}</div>
                <div class="label">Servicios Completados</div>
            </div>
        </div>
    </div>

    {{-- Últimas solicitudes --}}
    <div class="card">
        <div class="card-header">
            <h3>📋 Mis Últimas Solicitudes</h3>
            <a href="{{ route('cliente.solicitudes') }}" class="btn btn-secondary btn-sm">Ver todas</a>
        </div>

        @if($ultimasSolicitudes->isEmpty())
            <div class="empty-state">
                <div class="icon">📭</div>
                <p>Aún no tienes solicitudes de servicio.</p>
                <a href="{{ route('cliente.solicitudes.create') }}" class="btn btn-primary">
                    ➕ Hacer mi primera solicitud
                </a>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Equipo</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ultimasSolicitudes as $s)
                    <tr>
                        <td><strong>#{{ $s->id_solicitud }}</strong></td>
                        <td>{{ $s->electrodomestico->marca }} {{ $s->electrodomestico->tipo }}</td>
                        <td>{{ ucfirst($s->tipo_solicitud) }}</td>
                        <td style="max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                            {{ $s->descripcion_problema }}
                        </td>
                        <td>
                            <span class="badge badge-{{ $s->estado_solicitud }}">
                                {{ ucfirst(str_replace('_', ' ', $s->estado_solicitud)) }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($s->fecha_solicitud)->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('cliente.solicitudes.show', $s->id_solicitud) }}"
                               class="btn btn-secondary btn-sm">Ver</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Accesos rápidos --}}
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
        <div class="card">
            <div class="card-body" style="text-align:center; padding:30px;">
                <div style="font-size:2.5rem; margin-bottom:12px;">🖥️</div>
                <h3 style="margin-bottom:8px;">Registrar Equipo</h3>
                <p style="color:#64748b; font-size:0.875rem; margin-bottom:16px;">
                    Agrega un nuevo electrodoméstico a tu perfil
                </p>
                <a href="{{ route('cliente.equipos.create') }}" class="btn btn-primary">
                    + Nuevo Equipo
                </a>
            </div>
        </div>
        <div class="card">
            <div class="card-body" style="text-align:center; padding:30px;">
                <div style="font-size:2.5rem; margin-bottom:12px;">🔧</div>
                <h3 style="margin-bottom:8px;">Solicitar Servicio</h3>
                <p style="color:#64748b; font-size:0.875rem; margin-bottom:16px;">
                    Pide reparación o mantenimiento para tu equipo
                </p>
                <a href="{{ route('cliente.solicitudes.create') }}" class="btn btn-primary">
                    + Nueva Solicitud
                </a>
            </div>
        </div>
    </div>

@endsection
