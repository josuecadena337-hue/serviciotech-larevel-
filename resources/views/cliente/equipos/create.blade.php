@extends('layouts.cliente')

@section('title', 'Registrar Equipo')
@section('page-title', 'Registrar Equipo')
@section('breadcrumb', 'Mis Equipos › Nuevo')

@section('content')

<div class="card" style="max-width:600px;">
    <div class="card-header">
        <h3>🖥️ Datos del Electrodoméstico</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('cliente.equipos.store') }}">
            @csrf

            <div class="form-group">
                <label>Tipo de Electrodoméstico *</label>
                <select name="tipo" class="form-control {{ $errors->has('tipo') ? 'error' : '' }}" required>
                    <option value="">— Selecciona el tipo —</option>
                    @foreach($tipos as $tipo)
                        <option value="{{ $tipo }}" {{ old('tipo') == $tipo ? 'selected' : '' }}>
                            {{ $tipo }}
                        </option>
                    @endforeach
                </select>
                @error('tipo') <p class="error-msg">{{ $message }}</p> @enderror
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label>Marca *</label>
                    <input type="text" name="marca" class="form-control {{ $errors->has('marca') ? 'error' : '' }}"
                           placeholder="Ej: Samsung, LG, Mabe..." value="{{ old('marca') }}" required>
                    @error('marca') <p class="error-msg">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label>Modelo</label>
                    <input type="text" name="modelo" class="form-control"
                           placeholder="Ej: RT38K5982S8" value="{{ old('modelo') }}">
                </div>
            </div>

            <div class="form-group">
                <label>Número de Serie</label>
                <input type="text" name="serie" class="form-control {{ $errors->has('serie') ? 'error' : '' }}"
                       placeholder="Ej: SN-2024-001 (opcional)" value="{{ old('serie') }}">
                @error('serie') <p class="error-msg">{{ $message }}</p> @enderror
                <p style="color:#94a3b8; font-size:0.78rem; margin-top:4px;">
                    El número de serie está en la etiqueta del equipo
                </p>
            </div>

            <div style="display:flex; gap:12px; margin-top:8px;">
                <button type="submit" class="btn btn-primary">✅ Registrar Equipo</button>
                <a href="{{ route('cliente.equipos') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection
