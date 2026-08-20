@extends('layouts.tecnico')

@section('title', 'Servicio #' . $solicitud->id_solicitud)
@section('page-title', 'Servicio #' . $solicitud->id_solicitud)
@section('breadcrumb', 'Asignaciones › Detalle')

@section('topbar-actions')
    <a href="{{ route('tecnico.asignaciones') }}" class="btn btn-secondary">← Volver</a>
@endsection

@section('content')

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; align-items:start;">

    {{-- Info del servicio --}}
    <div>
        <div class="card">
            <div class="card-header">
                <h3>📋 Información del Servicio</h3>
                <span class="badge badge-{{ $solicitud->estado_solicitud }}">
                    {{ ucfirst(str_replace('_',' ',$solicitud->estado_solicitud)) }}
                </span>
            </div>
            <div class="card-body">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:16px;">
                    <div>
                        <p style="font-size:0.72rem; color:#94a3b8; font-weight:600; text-transform:uppercase; margin-bottom:3px;">Cliente</p>
                        <p style="font-weight:600;">{{ $solicitud->cliente->usuario->nombre }}</p>
                        <p style="color:#64748b; font-size:0.8rem;">📞 {{ $solicitud->cliente->usuario->telefono ?? 'Sin teléfono' }}</p>
                        <p style="color:#64748b; font-size:0.8rem;">📍 {{ $solicitud->cliente->direccion ?? 'Sin dirección' }}</p>
                    </div>
                    <div>
                        <p style="font-size:0.72rem; color:#94a3b8; font-weight:600; text-transform:uppercase; margin-bottom:3px;">Equipo</p>
                        <p style="font-weight:600;">{{ $solicitud->electrodomestico->tipo }}</p>
                        <p style="color:#64748b; font-size:0.8rem;">{{ $solicitud->electrodomestico->marca }} {{ $solicitud->electrodomestico->modelo }}</p>
                        @if($solicitud->electrodomestico->serie)
                            <p style="color:#94a3b8; font-size:0.75rem;">Serie: {{ $solicitud->electrodomestico->serie }}</p>
                        @endif
                    </div>
                    <div>
                        <p style="font-size:0.72rem; color:#94a3b8; font-weight:600; text-transform:uppercase; margin-bottom:3px;">Tipo / Categoría</p>
                        <p style="font-weight:600;">{{ ucfirst($solicitud->tipo_solicitud) }}</p>
                        <p style="color:#64748b; font-size:0.8rem;">{{ $solicitud->categoriaFalla->nombre }}</p>
                    </div>
                    <div>
                        <p style="font-size:0.72rem; color:#94a3b8; font-weight:600; text-transform:uppercase; margin-bottom:3px;">Fecha Solicitud</p>
                        <p style="font-weight:600;">{{ \Carbon\Carbon::parse($solicitud->fecha_solicitud)->format('d/m/Y') }}</p>
                    </div>
                </div>
                <div style="background:#f8fafc; border-radius:8px; padding:12px; font-size:0.875rem; color:#374151; line-height:1.6;">
                    <p style="font-size:0.72rem; color:#94a3b8; font-weight:600; text-transform:uppercase; margin-bottom:6px;">Problema Reportado</p>
                    {{ $solicitud->descripcion_problema }}
                </div>
            </div>
        </div>

        {{-- Citas --}}
        @if($solicitud->citas->isNotEmpty())
        <div class="card">
            <div class="card-header"><h3>📅 Citas Programadas</h3></div>
            <div class="card-body" style="padding:0;">
                @foreach($solicitud->citas as $cita)
                <div style="padding:14px 18px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">
                    <div>
                        <p style="font-weight:700; color:#166534;">📅 {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }} — {{ $cita->hora }}</p>
                    </div>
                    <span class="badge badge-{{ $cita->estado }}">{{ ucfirst($cita->estado) }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Evidencias subidas --}}
        @if($solicitud->evidencias->isNotEmpty())
        <div class="card">
            <div class="card-header"><h3>📸 Evidencias Subidas</h3></div>
            <div class="card-body" style="padding:0;">
                @foreach($solicitud->evidencias as $ev)
                <div style="padding:12px 18px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:10px;">
                    <span style="font-size:1.4rem;">{{ $ev->tipo=='foto' ? '📷' : ($ev->tipo=='video' ? '🎥' : '📄') }}</span>
                    <div>
                        <p style="font-weight:600; font-size:0.8rem;">{{ ucfirst($ev->tipo) }}</p>
                        <p style="color:#64748b; font-size:0.78rem;">{{ $ev->descripcion }}</p>
                        <p style="color:#94a3b8; font-size:0.75rem;">{{ \Carbon\Carbon::parse($ev->fecha_subida)->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- Acciones del técnico --}}
    <div>

        {{-- Actualizar estado --}}
        <div class="card">
            <div class="card-header"><h3>🔄 Actualizar Estado</h3></div>
            <div class="card-body">
                <p style="color:#64748b; font-size:0.85rem; margin-bottom:14px;">
                    Cambia el estado del servicio según el avance del trabajo.
                </p>
                <form method="POST" action="{{ route('tecnico.solicitudes.estado', $solicitud->id_solicitud) }}"
                      style="display:flex; flex-direction:column; gap:10px;">
                    @csrf
                    @if($solicitud->estado_solicitud !== 'en_proceso' && $solicitud->estado_solicitud !== 'completada')
                    <button type="submit" name="estado_solicitud" value="en_proceso" class="btn btn-orange" style="width:100%; justify-content:center;">
                        ⚙️ Marcar como En Proceso
                    </button>
                    @endif
                    @if($solicitud->estado_solicitud !== 'completada')
                    <button type="submit" name="estado_solicitud" value="completada" class="btn btn-success" style="width:100%; justify-content:center;">
                        ✅ Marcar como Completado
                    </button>
                    @else
                    <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:12px; text-align:center; color:#16a34a; font-weight:600; font-size:0.9rem;">
                        ✅ Servicio Completado
                    </div>
                    @endif
                </form>
            </div>
        </div>

        {{-- Subir evidencia --}}
        <div class="card">
            <div class="card-header"><h3>📸 Registrar Evidencia</h3></div>
            <div class="card-body">
                <form method="POST" action="{{ route('tecnico.solicitudes.evidencia', $solicitud->id_solicitud) }}"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label>Tipo de Evidencia *</label>
                        <select name="tipo" class="form-control" required>
                            <option value="">— Selecciona —</option>
                            <option value="foto"      {{ old('tipo')=='foto'      ? 'selected' : '' }}>📷 Foto</option>
                            <option value="video"     {{ old('tipo')=='video'     ? 'selected' : '' }}>🎥 Video</option>
                            <option value="documento" {{ old('tipo')=='documento' ? 'selected' : '' }}>📄 Documento</option>
                        </select>
                        @error('tipo') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label>Descripción *</label>
                        <textarea name="descripcion" class="form-control" rows="3"
                                  placeholder="Describe brevemente la evidencia..."
                                  required>{{ old('descripcion') }}</textarea>
                        @error('descripcion') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label>Archivo (opcional, máx 5MB)</label>
                        <input type="file" name="archivo" class="form-control"
                               accept="image/*,video/*,.pdf,.doc,.docx">
                        @error('archivo') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">
                        📤 Guardar Evidencia
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection
