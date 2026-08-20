@extends('layouts.tecnico')

@section('title', 'Servicio #' . $solicitud->id_solicitud)
@section('page-title', 'Servicio #' . $solicitud->id_solicitud)
@section('breadcrumb', 'Asignaciones › Detalle')

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
        {{-- Panel de botones para Modales --}}
        <div class="card">
            <div class="card-header"><h3>⚙️ Acciones Rápidas</h3></div>
            <div class="card-body" style="display:flex; flex-direction:column; gap:12px;">
                @if($solicitud->estado_solicitud === 'completada')
                    <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:12px; text-align:center; color:#16a34a; font-weight:600; font-size:0.9rem;">
                        ✅ Este servicio ya ha sido completado.
                    </div>
                @else
                    <button type="button" onclick="openModal('modal-estado')" class="btn btn-orange" style="width:100%; justify-content:center;">
                        🔄 Actualizar Avance
                    </button>
                    <button type="button" onclick="openModal('modal-evidencia')" class="btn btn-primary" style="width:100%; justify-content:center;">
                        📸 Registrar Evidencia
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- =========================================================
     MODAL: ACTUALIZAR ESTADO
     ========================================================= --}}
<div id="modal-estado" class="modal-overlay" onclick="closeModalOnOverlay(event, 'modal-estado')">
    <div class="modal-content">
        <div class="modal-header">
            <h3>🔄 Actualizar Avance</h3>
            <button class="btn-close" onclick="closeModal('modal-estado')">✖</button>
        </div>
        <form method="POST" action="{{ route('tecnico.solicitudes.estado', $solicitud->id_solicitud) }}">
            @csrf
            <div class="modal-body" style="display:flex; flex-direction:column; gap:12px;">
                <p style="color:#64748b; font-size:0.875rem; margin-bottom:10px;">
                    Selecciona en qué fase se encuentra tu trabajo actualmente.
                </p>
                
                @if($solicitud->estado_solicitud !== 'en_proceso')
                <button type="submit" name="estado_solicitud" value="en_proceso" class="btn btn-orange" style="width:100%; justify-content:center; padding:12px;">
                    ⚙️ Marcar como "En Proceso"
                </button>
                @endif
                
                <button type="submit" name="estado_solicitud" value="completada" class="btn btn-success" style="width:100%; justify-content:center; padding:12px;">
                    ✅ Marcar como "Completado"
                </button>
            </div>
        </form>
    </div>
</div>

{{-- =========================================================
     MODAL: REGISTRAR EVIDENCIA
     ========================================================= --}}
<div id="modal-evidencia" class="modal-overlay" onclick="closeModalOnOverlay(event, 'modal-evidencia')">
    <div class="modal-content">
        <div class="modal-header">
            <h3>📸 Registrar Evidencia</h3>
            <button class="btn-close" onclick="closeModal('modal-evidencia')">✖</button>
        </div>
        <form method="POST" action="{{ route('tecnico.solicitudes.evidencia', $solicitud->id_solicitud) }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Tipo de Evidencia *</label>
                    <select name="tipo" class="form-control" required>
                        <option value="">— Selecciona —</option>
                        <option value="foto">📷 Foto</option>
                        <option value="video">🎥 Video</option>
                        <option value="documento">📄 Documento</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Descripción *</label>
                    <textarea name="descripcion" class="form-control" rows="3" placeholder="Describe lo que se ve en la foto/video..." required minlength="5"></textarea>
                </div>
                <div class="form-group">
                    <label>Archivo (Opcional, máx 5MB)</label>
                    <input type="file" name="archivo" class="form-control" accept="image/*,video/*,.pdf,.doc,.docx">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-evidencia')">Cancelar</button>
                <button type="submit" class="btn btn-primary">📤 Guardar Evidencia</button>
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
