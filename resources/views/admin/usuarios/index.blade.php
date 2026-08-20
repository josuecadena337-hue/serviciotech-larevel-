@extends('layouts.admin')

@section('title', 'Gestionar Usuarios')
@section('page-title', 'Gestionar Usuarios')
@section('breadcrumb', 'Usuarios')

@section('content')

{{-- TÉCNICOS --}}
<div class="card">
    <div class="card-header">
        <h3>🔧 Técnicos ({{ $tecnicos->count() }})</h3>
    </div>
    @if($tecnicos->isEmpty())
        <div class="empty-state"><div class="icon">🔧</div><p>Sin técnicos registrados</p></div>
    @else
    <table>
        <thead>
            <tr><th>Técnico</th><th>Correo</th><th>Teléfono</th><th>Especialidad</th><th>Disponibilidad</th><th>Cambiar</th></tr>
        </thead>
        <tbody>
            @foreach($tecnicos as $t)
            <tr>
                <td><strong>{{ $t->usuario->nombre }}</strong></td>
                <td>{{ $t->usuario->correo }}</td>
                <td>{{ $t->usuario->telefono ?? '—' }}</td>
                <td>{{ $t->especialidad ?? '—' }}</td>
                <td><span class="badge badge-{{ $t->disponibilidad }}">{{ ucfirst($t->disponibilidad) }}</span></td>
                <td>
                    <form method="POST" action="{{ route('admin.tecnicos.disponibilidad', $t->id_usuario) }}" style="display:flex; gap:6px;">
                        @csrf
                        <select name="disponibilidad" class="form-control" style="padding:5px 8px; font-size:0.78rem; width:auto;">
                            <option value="disponible" {{ $t->disponibilidad=='disponible' ? 'selected' : '' }}>Disponible</option>
                            <option value="ocupado"    {{ $t->disponibilidad=='ocupado'    ? 'selected' : '' }}>Ocupado</option>
                            <option value="inactivo"   {{ $t->disponibilidad=='inactivo'   ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        <button type="submit" class="btn btn-amber btn-sm">✓</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

{{-- CLIENTES --}}
<div class="card">
    <div class="card-header">
        <h3>👥 Clientes ({{ $clientes->count() }})</h3>
    </div>
    @if($clientes->isEmpty())
        <div class="empty-state"><div class="icon">👥</div><p>Sin clientes registrados</p></div>
    @else
    <table>
        <thead>
            <tr><th>Cliente</th><th>Correo</th><th>Teléfono</th><th>Dirección</th><th>Estado</th></tr>
        </thead>
        <tbody>
            @foreach($clientes as $c)
            <tr>
                <td><strong>{{ $c->usuario->nombre }}</strong></td>
                <td>{{ $c->usuario->correo }}</td>
                <td>{{ $c->usuario->telefono ?? '—' }}</td>
                <td>{{ $c->direccion ?? '—' }}</td>
                <td>
                    @if($c->usuario->estado == 'activo')
                        <span class="badge badge-completada">Activo</span>
                    @else
                        <span class="badge badge-cancelada">{{ ucfirst($c->usuario->estado) }}</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

@endsection
