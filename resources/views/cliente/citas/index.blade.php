@extends('layouts.cliente')

@section('title', 'Mis Citas')
@section('page-title', 'Mis Citas')
@section('breadcrumb', 'Mis Citas')

@section('content')

<div class="card">
    <div class="card-header">
        <h3>📅 Citas Programadas ({{ $citas->count() }})</h3>
    </div>

    @if($citas->isEmpty())
        <div class="empty-state">
            <div class="icon">📅</div>
            <p>Aún no tienes citas programadas.</p>
            <p style="font-size:0.8rem; color:#94a3b8;">Las citas son asignadas por el administrador después de que se aprueba tu solicitud.</p>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Equipo</th>
                    <th>Técnico</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($citas as $cita)
                <tr>
                    <td>
                        <strong>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</strong><br>
                        <span style="color:#94a3b8; font-size:0.78rem;">
                            {{ \Carbon\Carbon::parse($cita->fecha)->locale('es')->isoFormat('dddd') }}
                        </span>
                    </td>
                    <td>{{ $cita->hora }}</td>
                    <td>{{ $cita->solicitud->electrodomestico->marca }} {{ $cita->solicitud->electrodomestico->tipo }}</td>
                    <td>{{ $cita->tecnico->usuario->nombre }}</td>
                    <td>
                        <span class="badge badge-{{ $cita->estado }}">
                            {{ ucfirst($cita->estado) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection
