@extends('layouts.cliente')

@section('title', 'Solicitar Servicio')
@section('page-title', 'Solicitar Servicio')
@section('breadcrumb', 'Mis Solicitudes › Nueva')

@section('content')

<div class="card" style="max-width:680px;">
    <div class="card-header">
        <h3>🔧 Nueva Solicitud de Servicio</h3>
    </div>
    <div class="card-body">

        @if($equipos->isEmpty())
            <div class="empty-state">
                <div class="icon">🖥️</div>
                <p>Primero debes registrar un equipo para poder solicitar un servicio.</p>
                <a href="{{ route('cliente.equipos.create') }}" class="btn btn-primary">
                    ➕ Registrar mi primer equipo
                </a>
            </div>
        @else

        <form method="POST" action="{{ route('cliente.solicitudes.store') }}">
            @csrf

            {{-- Seleccionar equipo --}}
            <div class="form-group">
                <label>¿Cuál equipo necesita servicio? *</label>
                <select name="id_equipo" class="form-control {{ $errors->has('id_equipo') ? 'error' : '' }}" required>
                    <option value="">— Selecciona un equipo —</option>
                    @foreach($equipos as $equipo)
                        <option value="{{ $equipo->id_equipo }}"
                            {{ (old('id_equipo', request('equipo')) == $equipo->id_equipo) ? 'selected' : '' }}>
                            {{ $equipo->tipo }} — {{ $equipo->marca }} {{ $equipo->modelo }}
                        </option>
                    @endforeach
                </select>
                @error('id_equipo') <p class="error-msg">{{ $message }}</p> @enderror
                <p style="color:#94a3b8; font-size:0.78rem; margin-top:4px;">
                    ¿No ves tu equipo? <a href="{{ route('cliente.equipos.create') }}" style="color:#1a237e;">Regístralo aquí</a>
                </p>
            </div>

            <div class="form-grid">
                {{-- Tipo de servicio --}}
                <div class="form-group">
                    <label>Tipo de Servicio *</label>
                    <select name="tipo_solicitud" class="form-control {{ $errors->has('tipo_solicitud') ? 'error' : '' }}" required>
                        <option value="">— Selecciona —</option>
                        <option value="correctivo"  {{ old('tipo_solicitud') == 'correctivo'  ? 'selected' : '' }}>
                            🔴 Correctivo (está dañado)
                        </option>
                        <option value="preventivo"  {{ old('tipo_solicitud') == 'preventivo'  ? 'selected' : '' }}>
                            🟢 Preventivo (mantenimiento)
                        </option>
                    </select>
                    @error('tipo_solicitud') <p class="error-msg">{{ $message }}</p> @enderror
                </div>

                {{-- Categoría --}}
                <div class="form-group">
                    <label>Categoría del Problema *</label>
                    <select name="id_categoria" class="form-control {{ $errors->has('id_categoria') ? 'error' : '' }}" required>
                        <option value="">— Selecciona —</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id_categoria }}"
                                {{ old('id_categoria') == $cat->id_categoria ? 'selected' : '' }}>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_categoria') <p class="error-msg">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Descripción del problema --}}
            <div class="form-group">
                <label>Describe el Problema *</label>
                <textarea name="descripcion_problema" class="form-control {{ $errors->has('descripcion_problema') ? 'error' : '' }}"
                          rows="4"
                          placeholder="Describe con detalle qué le pasa al equipo. Ej: La nevera hace un ruido fuerte y no enfría bien desde hace 3 días..."
                          required>{{ old('descripcion_problema') }}</textarea>
                @error('descripcion_problema') <p class="error-msg">{{ $message }}</p> @enderror
                <p style="color:#94a3b8; font-size:0.78rem; margin-top:4px;">Mínimo 10 caracteres. Cuanto más detalles, mejor.</p>
            </div>

            <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:10px; padding:14px 18px; margin-bottom:20px;">
                <p style="font-size:0.85rem; color:#16a34a;">
                    ✅ <strong>¿Qué pasa después?</strong> Un administrador revisará tu solicitud y asignará un técnico especializado. Te notificaremos el estado por correo.
                </p>
            </div>

            <div style="display:flex; gap:12px;">
                <button type="submit" class="btn btn-primary">📤 Enviar Solicitud</button>
                <a href="{{ route('cliente.solicitudes') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>

        @endif
    </div>
</div>

@endsection
