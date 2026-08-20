@extends('layouts.admin')

@section('title', 'Gestionar Solicitud #' . $solicitud->id_solicitud)
@section('page-title', 'Solicitud #' . $solicitud->id_solicitud)
@section('breadcrumb', 'Solicitudes › Gestionar')

@section('topbar-actions')
    <a href="{{ route('admin.solicitudes') }}" class="btn btn-secondary">← Volver</a>
@endsection

@section('content')

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; align-items:start;">

    {{-- Info de la solicitud --}}
    <div>
        <div class="card">
            <div class="card-header">
                <h3>📋 Detalle de la Solicitud</h3>
                <span class="badge badge-{{ $solicitud->estado_solicitud }}">
                    {{ ucfirst(str_replace('_',' ',$solicitud->estado_solicitud)) }}
                </span>
            </div>
            <div class="card-body">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:16px;">
                    <div>
                        <p style="font-size:0.72rem; color:#94a3b8; font-weight:600; text-transform:uppercase; margin-bottom:3px;">Cliente</p>
                        <p style="font-weight:600;">{{ $solicitud->cliente->usuario->nombre }}</p>
                        <p style="color:#64748b; font-size:0.8rem;">{{ $solicitud->cliente->usuario->correo }}</p>
                        <p style="color:#64748b; font-size:0.8rem;">📞 {{ $solicitud->cliente->usuario->telefono ?? 'Sin teléfono' }}</p>
                    </div>
                    <div>
                        <p style="font-size:0.72rem; color:#94a3b8; font-weight:600; text-transform:uppercase; margin-bottom:3px;">Equipo</p>
                        <p style="font-weight:600;">{{ $solicitud->electrodomestico->tipo }}</p>
                        <p style="color:#64748b; font-size:0.8rem;">{{ $solicitud->electrodomestico->marca }} {{ $solicitud->electrodomestico->modelo }}</p>
                    </div>
                    <div>
                        <p style="font-size:0.72rem; color:#94a3b8; font-weight:600; text-transform:uppercase; margin-bottom:3px;">Tipo / Categoría</p>
                        <p style="font-weight:600;">{{ ucfirst($solicitud->tipo_solicitud) }}</p>
                        <p style="color:#64748b; font-size:0.8rem;">{{ $solicitud->categoriaFalla->nombre }}</p>
                    </div>
                    <div>
                        <p style="font-size:0.72rem; color:#94a3b8; font-weight:600; text-transform:uppercase; margin-bottom:3px;">Fecha</p>
                        <p style="font-weight:600;">{{ \Carbon\Carbon::parse($solicitud->fecha_solicitud)->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                <div style="background:#f8fafc; border-radius:8px; padding:12px; font-size:0.875rem; color:#374151; line-height:1.6;">
                    <p style="font-size:0.72rem; color:#94a3b8; font-weight:600; text-transform:uppercase; margin-bottom:6px;">Descripción del Problema</p>
                    {{ $solicitud->descripcion_problema }}
                </div>
            </div>
        </div>

        {{-- Cambiar estado --}}
        <div class="card">
            <div class="card-header"><h3>🔄 Cambiar Estado</h3></div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.solicitudes.estado', $solicitud->id_solicitud) }}" style="display:flex; gap:10px; align-items:flex-end;">
                    @csrf
                    <div class="form-group" style="flex:1; margin:0;">
                        <label>Nuevo estado</label>
                        <select name="estado_solicitud" class="form-control">
                            @foreach(['pendiente','asignada','agendada','en_proceso','completada','cancelada'] as $e)
                                <option value="{{ $e }}" {{ $solicitud->estado_solicitud == $e ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_',' ',$e)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>

        {{-- Evidencias --}}
        @if($solicitud->evidencias->isNotEmpty())
        <div class="card">
            <div class="card-header"><h3>📸 Evidencias</h3></div>
            <div class="card-body" style="padding:0;">
                @foreach($solicitud->evidencias as $ev)
                <div style="padding:12px 18px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:10px;">
                    <span style="font-size:1.3rem;">{{ $ev->tipo=='foto' ? '📷' : ($ev->tipo=='video' ? '🎥' : '📄') }}</span>
                    <div>
                        <p style="font-weight:600; font-size:0.8rem;">{{ ucfirst($ev->tipo) }}</p>
                        <p style="color:#64748b; font-size:0.78rem;">{{ $ev->descripcion }} — {{ $ev->usuario->nombre }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- Columna derecha: acciones --}}
    <div>

        {{-- Asignar técnico --}}
        <div class="card">
            <div class="card-header"><h3>👷 Asignar Técnico</h3></div>
            <div class="card-body">
                @php $asignacionActiva = $solicitud->asignaciones->where('estado','activa')->first(); @endphp

                @if($asignacionActiva)
                <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:12px; margin-bottom:14px; font-size:0.85rem; color:#16a34a;">
                    ✅ Actualmente asignado: <strong>{{ $asignacionActiva->tecnico->usuario->nombre }}</strong>
                </div>
                @endif

                <form method="POST" action="{{ route('admin.solicitudes.asignar', $solicitud->id_solicitud) }}">
                    @csrf
                    <div class="form-group">
                        <label>Selecciona un Técnico *</label>
                        <select name="id_tecnico" class="form-control" required>
                            <option value="">— Selecciona —</option>
                            @foreach($tecnicos as $t)
                                <option value="{{ $t->id_usuario }}"
                                    {{ $asignacionActiva?->id_tecnico == $t->id_usuario ? 'selected' : '' }}>
                                    {{ $t->usuario->nombre }}
                                    ({{ ucfirst($t->disponibilidad) }} — {{ $t->especialidad }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_tecnico') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="btn btn-amber" style="width:100%;">
                        👷 {{ $asignacionActiva ? 'Reasignar Técnico' : 'Asignar Técnico' }}
                    </button>
                </form>
            </div>
        </div>

        {{-- Agendar cita --}}
        <div class="card">
            <div class="card-header"><h3>📅 Agendar Cita</h3></div>
            <div class="card-body">
                @if($solicitud->citas->isNotEmpty())
                <div style="margin-bottom:16px;">
                    @foreach($solicitud->citas as $cita)
                    <div style="background:#f8fafc; border-radius:8px; padding:10px 12px; margin-bottom:8px; font-size:0.85rem;">
                        <p style="font-weight:600;">📅 {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }} a las {{ $cita->hora }}</p>
                        <p style="color:#64748b; font-size:0.78rem; margin-top:2px;">{{ $cita->tecnico->usuario->nombre }}</p>
                        <span class="badge badge-{{ $cita->estado }}" style="margin-top:4px;">{{ ucfirst($cita->estado) }}</span>
                    </div>
                    @endforeach
                </div>
                @endif

                <form method="POST" action="{{ route('admin.solicitudes.cita', $solicitud->id_solicitud) }}">
                    @csrf
                    <div class="form-group">
                        <label>Técnico para la cita *</label>
                        <select name="id_tecnico" class="form-control" required>
                            <option value="">— Selecciona —</option>
                            @foreach($tecnicos as $t)
                                <option value="{{ $t->id_usuario }}">{{ $t->usuario->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Fecha *</label>
                            <input type="date" name="fecha" class="form-control"
                                   min="{{ date('Y-m-d') }}" value="{{ old('fecha') }}" required>
                            @error('fecha') <p class="error-msg">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group">
                            <label>Hora *</label>
                            <input type="time" name="hora" class="form-control" value="{{ old('hora') }}" required>
                            @error('hora') <p class="error-msg">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success" style="width:100%;">
                        📅 Confirmar Cita
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection
