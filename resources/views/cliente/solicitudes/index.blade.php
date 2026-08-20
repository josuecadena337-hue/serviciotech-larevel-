@extends('layouts.cliente')

@section('title', 'Mis Solicitudes')
@section('page-title', 'Mis Solicitudes')
@section('breadcrumb', 'Mis Solicitudes')

@section('topbar-actions')
    <a href="{{ route('cliente.solicitudes.create') }}" class="btn btn-primary">➕ Nueva Solicitud</a>
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <h3>📋 Historial de Solicitudes ({{ $solicitudes->count() }})</h3>
    </div>

    @if($solicitudes->isEmpty())
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
                    <th>Categoría</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Técnico</th>
                    <th>Fecha</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($solicitudes as $s)
                @php
                    $tecnico = $s->asignaciones->where('estado', 'activa')->first()?->tecnico?->usuario;
                @endphp
                <tr>
                    <td><strong>#{{ $s->id_solicitud }}</strong></td>
                    <td>{{ $s->electrodomestico->marca }} {{ $s->electrodomestico->tipo }}</td>
                    <td>{{ $s->categoriaFalla->nombre }}</td>
                    <td>
                        @if($s->tipo_solicitud == 'correctivo')
                            <span style="color:#dc2626;">🔴 Correctivo</span>
                        @else
                            <span style="color:#16a34a;">🟢 Preventivo</span>
                        @endif
                    </td>
                    <td style="max-width:180px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                        {{ $s->descripcion_problema }}
                    </td>
                    <td>
                        <span class="badge badge-{{ $s->estado_solicitud }}">
                            {{ ucfirst(str_replace('_', ' ', $s->estado_solicitud)) }}
                        </span>
                    </td>
                    <td>{{ $tecnico ? $tecnico->nombre : '—' }}</td>
                    <td>{{ \Carbon\Carbon::parse($s->fecha_solicitud)->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('cliente.solicitudes.show', $s->id_solicitud) }}"
                           class="btn btn-secondary btn-sm">👁️ Ver</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection
