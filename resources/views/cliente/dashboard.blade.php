@extends('layouts.cliente')

@section('title', 'Dashboard')
@section('page-title', 'Mi Panel')
@section('breadcrumb', 'Inicio')

@push('styles')
<style>
    /* ── MODALES ─────────────────────────────── */
    .modal-overlay {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        display: flex; align-items: center; justify-content: center;
        z-index: 1000;
        opacity: 0; pointer-events: none;
        transition: opacity 0.2s ease;
    }

    .modal-overlay.active { opacity: 1; pointer-events: auto; }

    .modal-content {
        background: white; width: 100%; max-width: 500px;
        border-radius: 14px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
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
    <button onclick="openModal('modal-solicitud')" class="btn btn-primary">
        ➕ Solicitar Servicio
    </button>
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
                <button onclick="openModal('modal-solicitud')" class="btn btn-primary">
                    ➕ Hacer mi primera solicitud
                </button>
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
                <button onclick="openModal('modal-equipo')" class="btn btn-primary">
                    + Nuevo Equipo
                </button>
            </div>
        </div>
        <div class="card">
            <div class="card-body" style="text-align:center; padding:30px;">
                <div style="font-size:2.5rem; margin-bottom:12px;">🔧</div>
                <h3 style="margin-bottom:8px;">Solicitar Servicio</h3>
                <p style="color:#64748b; font-size:0.875rem; margin-bottom:16px;">
                    Pide reparación o mantenimiento para tu equipo
                </p>
                <button onclick="openModal('modal-solicitud')" class="btn btn-primary">
                    + Nueva Solicitud
                </button>
            </div>
        </div>
    </div>


    {{-- =========================================================
         MODAL: REGISTRAR EQUIPO
         ========================================================= --}}
    @php
        // Obtenemos los tipos de equipos (lógica rápida sin tocar el controlador)
        $tiposEquipos = ['Nevera', 'Lavadora', 'Aire Acondicionado', 'Estufa', 'Microondas', 'Televisor', 'Otro'];
    @endphp
    <div id="modal-equipo" class="modal-overlay" onclick="closeModalOnOverlay(event, 'modal-equipo')">
        <div class="modal-content">
            <div class="modal-header">
                <h3>🖥️ Registrar Nuevo Equipo</h3>
                <button class="btn-close" onclick="closeModal('modal-equipo')">✖</button>
            </div>
            <form action="{{ route('cliente.equipos.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tipo de Electrodoméstico *</label>
                        <select name="tipo" class="form-control" required>
                            <option value="">-- Selecciona --</option>
                            @foreach($tiposEquipos as $tipo)
                                <option value="{{ $tipo }}">{{ $tipo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Marca *</label>
                        <input type="text" name="marca" class="form-control" placeholder="Ej: Samsung, LG..." required>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label>Modelo (Opcional)</label>
                            <input type="text" name="modelo" class="form-control" placeholder="Ej: RT38K5982SL">
                        </div>
                        <div class="form-group">
                            <label>Número de Serie (Opcional)</label>
                            <input type="text" name="serie" class="form-control" placeholder="Número único">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('modal-equipo')">Cancelar</button>
                    <button type="submit" class="btn btn-primary">💾 Guardar Equipo</button>
                </div>
            </form>
        </div>
    </div>


    {{-- =========================================================
         MODAL: SOLICITAR SERVICIO
         ========================================================= --}}
    @php
        // Obtenemos los equipos del cliente actual y categorías (sin tocar el controlador)
        $mis_equipos = Auth::user()->cliente->electrodomesticos()->get();
        $categoriasFalla = \App\Models\CategoriaFalla::all();
    @endphp
    <div id="modal-solicitud" class="modal-overlay" onclick="closeModalOnOverlay(event, 'modal-solicitud')">
        <div class="modal-content">
            <div class="modal-header">
                <h3>🔧 Solicitar Servicio</h3>
                <button class="btn-close" onclick="closeModal('modal-solicitud')">✖</button>
            </div>
            
            @if($mis_equipos->isEmpty())
                <div class="modal-body" style="text-align: center; padding: 40px 20px;">
                    <div style="font-size: 3rem; margin-bottom: 15px;">⚠️</div>
                    <h4 style="margin-bottom: 10px; color: #0f172a;">No tienes equipos registrados</h4>
                    <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 20px;">
                        Para poder solicitar un servicio, primero debes registrar al menos un electrodoméstico.
                    </p>
                    <button type="button" class="btn btn-primary" onclick="closeModal('modal-solicitud'); openModal('modal-equipo');">
                        + Registrar mi primer equipo
                    </button>
                </div>
            @else
                <form action="{{ route('cliente.solicitudes.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Selecciona tu Equipo *</label>
                            <select name="id_equipo" class="form-control" required>
                                <option value="">-- Elige un equipo --</option>
                                @foreach($mis_equipos as $eq)
                                    <option value="{{ $eq->id_equipo }}">{{ $eq->marca }} {{ $eq->tipo }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label>Categoría del Problema *</label>
                                <select name="id_categoria" class="form-control" required>
                                    <option value="">-- Elige --</option>
                                    @foreach($categoriasFalla as $cat)
                                        <option value="{{ $cat->id_categoria }}">{{ $cat->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Tipo de Servicio *</label>
                                <select name="tipo_solicitud" class="form-control" required>
                                    <option value="">-- Elige --</option>
                                    <option value="preventivo">Mantenimiento Preventivo</option>
                                    <option value="correctivo">Reparación (Correctivo)</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Describe el problema *</label>
                            <textarea name="descripcion_problema" class="form-control" rows="4" placeholder="Detalla qué le pasa al equipo..." required minlength="10" maxlength="500"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeModal('modal-solicitud')">Cancelar</button>
                        <button type="submit" class="btn btn-primary">🚀 Enviar Solicitud</button>
                    </div>
                </form>
            @endif
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Función para abrir un modal
    function openModal(modalId) {
        document.getElementById(modalId).classList.add('active');
        document.body.style.overflow = 'hidden'; // Evita scroll de fondo
    }

    // Función para cerrar un modal
    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('active');
        document.body.style.overflow = 'auto'; // Restaura el scroll
    }

    // Cierra el modal si haces clic por fuera del contenido (en la zona gris)
    function closeModalOnOverlay(event, modalId) {
        if (event.target.id === modalId) {
            closeModal(modalId);
        }
    }
</script>
@endpush
