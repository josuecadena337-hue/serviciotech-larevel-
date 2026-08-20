@extends('layouts.cliente')

@section('title', 'Detalle de Solicitud #' . $solicitud->id_solicitud)
@section('page-title', 'Solicitud #' . $solicitud->id_solicitud)
@section('breadcrumb', 'Mis Solicitudes › Detalle')

@section('topbar-actions')
    <a href="{{ route('cliente.solicitudes') }}" class="btn btn-secondary">← Volver</a>
@endsection

@section('content')

<div style="display:grid; grid-template-columns:2fr 1fr; gap:24px; align-items:start;">

    {{-- Columna izquierda --}}
    <div>
        {{-- Info principal --}}
        <div class="card">
            <div class="card-header">
                <h3>📋 Información de la Solicitud</h3>
                <span class="badge badge-{{ $solicitud->estado_solicitud }}">
                    {{ ucfirst(str_replace('_', ' ', $solicitud->estado_solicitud)) }}
                </span>
            </div>
            <div class="card-body">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
                    <div>
                        <p style="font-size:0.75rem; color:#94a3b8; font-weight:600; text-transform:uppercase; margin-bottom:4px;">Equipo</p>
                        <p style="font-weight:600;">{{ $solicitud->electrodomestico->tipo }}</p>
                        <p style="color:#64748b; font-size:0.875rem;">{{ $solicitud->electrodomestico->marca }} {{ $solicitud->electrodomestico->modelo }}</p>
                    </div>
                    <div>
                        <p style="font-size:0.75rem; color:#94a3b8; font-weight:600; text-transform:uppercase; margin-bottom:4px;">Tipo de Servicio</p>
                        @if($solicitud->tipo_solicitud == 'correctivo')
                            <p style="font-weight:600; color:#dc2626;">🔴 Correctivo</p>
                        @else
                            <p style="font-weight:600; color:#16a34a;">🟢 Preventivo</p>
                        @endif
                    </div>
                    <div>
                        <p style="font-size:0.75rem; color:#94a3b8; font-weight:600; text-transform:uppercase; margin-bottom:4px;">Categoría</p>
                        <p style="font-weight:600;">{{ $solicitud->categoriaFalla->nombre }}</p>
                    </div>
                    <div>
                        <p style="font-size:0.75rem; color:#94a3b8; font-weight:600; text-transform:uppercase; margin-bottom:4px;">Fecha de Solicitud</p>
                        <p style="font-weight:600;">{{ \Carbon\Carbon::parse($solicitud->fecha_solicitud)->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                <div>
                    <p style="font-size:0.75rem; color:#94a3b8; font-weight:600; text-transform:uppercase; margin-bottom:8px;">Descripción del Problema</p>
                    <div style="background:#f8fafc; border-radius:8px; padding:14px; color:#374151; font-size:0.9rem; line-height:1.6;">
                        {{ $solicitud->descripcion_problema }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Evidencias --}}
        @if($solicitud->evidencias->isNotEmpty())
        <div class="card">
            <div class="card-header">
                <h3>📸 Evidencias del Técnico</h3>
            </div>
            <div class="card-body">
                @foreach($solicitud->evidencias as $ev)
                <div style="display:flex; align-items:center; gap:12px; padding:10px 0; border-bottom:1px solid #f1f5f9;">
                    <span style="font-size:1.5rem;">
                        @if($ev->tipo == 'foto') 📷
                        @elseif($ev->tipo == 'video') 🎥
                        @else 📄 @endif
                    </span>
                    <div style="flex:1;">
                        <p style="font-weight:600; font-size:0.875rem;">{{ ucfirst($ev->tipo) }}</p>
                        <p style="color:#64748b; font-size:0.8rem;">{{ $ev->descripcion }}</p>
                        <p style="color:#94a3b8; font-size:0.75rem;">Por: {{ $ev->usuario->nombre }} — {{ \Carbon\Carbon::parse($ev->fecha_subida)->format('d/m/Y') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- Columna derecha --}}
    <div>
        {{-- Técnico asignado --}}
        <div class="card">
            <div class="card-header"><h3>👨‍🔧 Técnico Asignado</h3></div>
            <div class="card-body">
                @php $asignacion = $solicitud->asignaciones->where('estado', 'activa')->first(); @endphp
                @if($asignacion)
                    <div style="text-align:center; padding:10px 0;">
                        <div style="font-size:2.5rem; margin-bottom:8px;">👷</div>
                        <p style="font-weight:700; font-size:1rem;">{{ $asignacion->tecnico->usuario->nombre }}</p>
                        <p style="color:#64748b; font-size:0.85rem; margin-top:2px;">{{ $asignacion->tecnico->especialidad }}</p>
                        <p style="color:#94a3b8; font-size:0.78rem; margin-top:8px;">Asignado el {{ \Carbon\Carbon::parse($asignacion->fecha_asignacion)->format('d/m/Y') }}</p>
                    </div>
                @else
                    <div style="text-align:center; color:#94a3b8; padding:20px 0;">
                        <div style="font-size:2rem; margin-bottom:8px;">⏳</div>
                        <p style="font-size:0.875rem;">Esperando asignación de técnico</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Citas --}}
        <div class="card">
            <div class="card-header"><h3>📅 Citas</h3></div>
            <div class="card-body">
                @if($solicitud->citas->isEmpty())
                    <div style="text-align:center; color:#94a3b8; padding:16px 0;">
                        <div style="font-size:1.8rem; margin-bottom:6px;">📅</div>
                        <p style="font-size:0.85rem;">Sin citas programadas</p>
                    </div>
                @else
                    @foreach($solicitud->citas as $cita)
                    <div style="padding:10px 0; border-bottom:1px solid #f1f5f9;">
                        <p style="font-weight:600; font-size:0.875rem;">
                            {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }} a las {{ $cita->hora }}
                        </p>
                        <span class="badge badge-{{ $cita->estado }}" style="margin-top:4px;">
                            {{ ucfirst($cita->estado) }}
                        </span>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

</div>

@endsection
