@extends('layouts.admin')

@section('title', 'Gestionar Solicitud #' . $solicitud->id_solicitud)
@section('page-title', 'Solicitud #' . $solicitud->id_solicitud)
@section('breadcrumb', 'Solicitudes › Gestionar')

@push('styles')
<style>
    /* ── MODALES ─────────────────────────────── */
    .modal-overlay {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        display: flex; align-items: center; justify-content: center;
        z-index: 1000; opacity: 0; pointer-events: none;
        transition: opacity 0.2s ease;
    }
    .modal-overlay.active { opacity: 1; pointer-events: auto; }
    .modal-content {
        background: white; width: 100%; max-width: 500px;
        border-radius: 14px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        transform: translateY(20px); transition: transform 0.2s ease;
        overflow: hidden;
    }
    .modal-overlay.active .modal-content { transform: translateY(0); }
    .modal-header {
        padding: 20px 24px; border-bottom: 1px solid #e2e8f0;
        display: flex; align-items: center; justify-content: space-between;
    }
    .modal-header h3 { font-size: 1.1rem; font-weight: 700; color: #0f172a; }
    .btn-close {
        background: transparent; border: none; font-size: 1.2rem;
        color: #94a3b8; cursor: pointer; transition: color 0.2s;
    }
    .btn-close:hover { color: #dc2626; }
    .modal-body { padding: 24px; max-height: 70vh; overflow-y: auto; }
    .modal-footer {
        padding: 16px 24px; border-top: 1px solid #e2e8f0;
        display: flex; justify-content: flex-end; gap: 12px;
        background: #f8fafc;
    }
</style>
@endpush

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

    {{-- Columna derecha: asignaciones y acciones --}}
    <div>

        {{-- Panel de Acciones (Botones que abren Modales) --}}
        <div class="card">
            <div class="card-header"><h3>⚙️ Acciones de Gestión</h3></div>
            <div class="card-body" style="display:flex; flex-direction:column; gap:12px;">
                <button type="button" onclick="openModal('modal-estado')" class="btn btn-secondary" style="width:100%; justify-content:center;">
                    🔄 Cambiar Estado Manualmente
                </button>
                <button type="button" onclick="openModal('modal-asignar')" class="btn btn-amber" style="width:100%; justify-content:center;">
                    👷 Asignar Técnico
                </button>
                <button type="button" onclick="openModal('modal-cita')" class="btn btn-success" style="width:100%; justify-content:center;">
                    📅 Agendar Cita
                </button>
            </div>
        </div>

        {{-- Técnico Asignado --}}
        <div class="card">
            <div class="card-header"><h3>👷 Técnico Actual</h3></div>
            <div class="card-body">
                @php $asignacionActiva = $solicitud->asignaciones->where('estado','activa')->first(); @endphp
                @if($asignacionActiva)
                <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:12px; font-size:0.85rem; color:#16a34a;">
                    ✅ Asignado a: <strong>{{ $asignacionActiva->tecnico->usuario->nombre }}</strong>
                </div>
                @else
                <div style="background:#fffbeb; border:1px solid #fde68a; border-radius:8px; padding:12px; font-size:0.85rem; color:#d97706;">
                    ⚠️ Aún no hay ningún técnico asignado.
                </div>
                @endif
            </div>
        </div>

        {{-- Citas Programadas --}}
        @if($solicitud->citas->isNotEmpty())
        <div class="card">
            <div class="card-header"><h3>📅 Citas Programadas</h3></div>
            <div class="card-body" style="padding:16px;">
                @foreach($solicitud->citas as $cita)
                <div style="background:#f8fafc; border-radius:8px; padding:10px 12px; margin-bottom:8px; font-size:0.85rem;">
                    <p style="font-weight:600;">📅 {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }} a las {{ $cita->hora }}</p>
                    <p style="color:#64748b; font-size:0.78rem; margin-top:2px;">{{ $cita->tecnico->usuario->nombre }}</p>
                    <span class="badge badge-{{ $cita->estado }}" style="margin-top:4px;">{{ ucfirst($cita->estado) }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

{{-- =========================================================
     MODAL: CAMBIAR ESTADO
     ========================================================= --}}
<div id="modal-estado" class="modal-overlay" onclick="closeModalOnOverlay(event, 'modal-estado')">
    <div class="modal-content">
        <div class="modal-header">
            <h3>🔄 Cambiar Estado</h3>
            <button class="btn-close" onclick="closeModal('modal-estado')">✖</button>
        </div>
        <form method="POST" action="{{ route('admin.solicitudes.estado', $solicitud->id_solicitud) }}">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Nuevo Estado *</label>
                    <select name="estado_solicitud" class="form-control" required>
                        @foreach(['pendiente','asignada','agendada','en_proceso','completada','cancelada'] as $e)
                            <option value="{{ $e }}" {{ $solicitud->estado_solicitud == $e ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_',' ',$e)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-estado')">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>

{{-- =========================================================
     MODAL: ASIGNAR TÉCNICO
     ========================================================= --}}
<div id="modal-asignar" class="modal-overlay" onclick="closeModalOnOverlay(event, 'modal-asignar')">
    <div class="modal-content">
        <div class="modal-header">
            <h3>👷 Asignar Técnico</h3>
            <button class="btn-close" onclick="closeModal('modal-asignar')">✖</button>
        </div>
        <form method="POST" action="{{ route('admin.solicitudes.asignar', $solicitud->id_solicitud) }}">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Selecciona un Técnico *</label>
                    <select name="id_tecnico" class="form-control" required>
                        <option value="">— Selecciona —</option>
                        @foreach($tecnicos as $t)
                            <option value="{{ $t->id_usuario }}"
                                {{ ($asignacionActiva?->id_tecnico == $t->id_usuario) ? 'selected' : '' }}>
                                {{ $t->usuario->nombre }}
                                ({{ ucfirst($t->disponibilidad) }} — {{ $t->especialidad }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-asignar')">Cancelar</button>
                <button type="submit" class="btn btn-amber">Confirmar Asignación</button>
            </div>
        </form>
    </div>
</div>

{{-- =========================================================
     MODAL: AGENDAR CITA
     ========================================================= --}}
<div id="modal-cita" class="modal-overlay" onclick="closeModalOnOverlay(event, 'modal-cita')">
    <div class="modal-content">
        <div class="modal-header">
            <h3>📅 Agendar Cita</h3>
            <button class="btn-close" onclick="closeModal('modal-cita')">✖</button>
        </div>
        <form method="POST" action="{{ route('admin.solicitudes.cita', $solicitud->id_solicitud) }}">
            @csrf
            <div class="modal-body">
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
                        <input type="date" name="fecha" class="form-control" min="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Hora *</label>
                        <input type="time" name="hora" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-cita')">Cancelar</button>
                <button type="submit" class="btn btn-success">Guardar Cita</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('active');
        document.body.style.overflow = 'auto';
    }
    function closeModalOnOverlay(event, modalId) {
        if (event.target.id === modalId) closeModal(modalId);
    }
</script>
@endpush
