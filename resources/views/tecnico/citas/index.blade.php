@extends('layouts.tecnico')

@section('title', 'Mi Agenda')
@section('page-title', 'Mi Agenda')
@section('breadcrumb', 'Agenda')

@section('content')

<div class="card">
    <div class="card-header">
        <h3>📅 Todas mis Citas ({{ $citas->count() }})</h3>
    </div>

    @if($citas->isEmpty())
        <div class="empty-state">
            <div class="icon">📅</div>
            <p>Aún no tienes citas programadas.</p>
            <p style="font-size:0.8rem; margin-top:6px; color:#94a3b8;">Las citas son asignadas por el administrador.</p>
        </div>
    @else
    <table>
        <thead>
            <tr><th>Fecha</th><th>Hora</th><th>Cliente</th><th>Equipo</th><th>Estado Servicio</th><th>Estado Cita</th><th></th></tr>
        </thead>
        <tbody>
            @foreach($citas as $cita)
            <tr>
                <td>
                    <strong>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</strong>
                    @if(\Carbon\Carbon::parse($cita->fecha)->isToday())
                        <span style="background:#dcfce7; color:#16a34a; font-size:0.7rem; font-weight:700; padding:2px 6px; border-radius:4px; margin-left:4px;">HOY</span>
                    @endif
                </td>
                <td>{{ $cita->hora }}</td>
                <td>{{ $cita->solicitud->cliente->usuario->nombre }}</td>
                <td>{{ $cita->solicitud->electrodomestico->marca }} {{ $cita->solicitud->electrodomestico->tipo }}</td>
                <td>
                    <span class="badge badge-{{ $cita->solicitud->estado_solicitud }}">
                        {{ ucfirst(str_replace('_',' ',$cita->solicitud->estado_solicitud)) }}
                    </span>
                </td>
                <td>
                    <span class="badge badge-{{ $cita->estado }}">{{ ucfirst($cita->estado) }}</span>
                </td>
                <td>
                    <a href="{{ route('tecnico.solicitudes.show', $cita->solicitud->id_solicitud) }}"
                       class="btn btn-primary btn-sm">Ver</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

@endsection
