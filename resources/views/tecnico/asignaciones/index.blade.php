@extends('layouts.tecnico')

@section('title', 'Mis Asignaciones')
@section('page-title', 'Mis Asignaciones')
@section('breadcrumb', 'Asignaciones')

@section('content')

<div class="card">
    <div class="card-header">
        <h3>📋 Servicios Asignados ({{ $asignaciones->count() }})</h3>
    </div>

    @if($asignaciones->isEmpty())
        <div class="empty-state">
            <div class="icon">🎉</div>
            <p>¡No tienes asignaciones activas por ahora!</p>
        </div>
    @else
    <table>
        <thead>
            <tr>
                <th>#</th><th>Cliente</th><th>Equipo</th>
                <th>Categoría</th><th>Tipo</th><th>Estado</th><th>Asignado</th><th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($asignaciones as $a)
            <tr>
                <td><strong>#{{ $a->solicitud->id_solicitud }}</strong></td>
                <td>{{ $a->solicitud->cliente->usuario->nombre }}</td>
                <td>
                    {{ $a->solicitud->electrodomestico->marca }}
                    {{ $a->solicitud->electrodomestico->tipo }}
                </td>
                <td>{{ $a->solicitud->categoriaFalla->nombre }}</td>
                <td>
                    @if($a->solicitud->tipo_solicitud == 'correctivo')
                        <span style="color:#dc2626;">🔴 Correctivo</span>
                    @else
                        <span style="color:#16a34a;">🟢 Preventivo</span>
                    @endif
                </td>
                <td>
                    <span class="badge badge-{{ $a->solicitud->estado_solicitud }}">
                        {{ ucfirst(str_replace('_',' ',$a->solicitud->estado_solicitud)) }}
                    </span>
                </td>
                <td>{{ \Carbon\Carbon::parse($a->fecha_asignacion)->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('tecnico.solicitudes.show', $a->solicitud->id_solicitud) }}"
                       class="btn btn-primary btn-sm">⚙️ Gestionar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

@endsection
