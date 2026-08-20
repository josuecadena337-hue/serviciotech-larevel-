@extends('layouts.admin')

@section('title', 'Solicitudes')
@section('page-title', 'Todas las Solicitudes')
@section('breadcrumb', 'Solicitudes')

@section('content')

{{-- Filtros --}}
<form method="GET" action="{{ route('admin.solicitudes') }}">
    <div class="filter-bar">
        <select name="estado" onchange="this.form.submit()">
            <option value="">— Todos los estados —</option>
            @foreach(['pendiente','asignada','agendada','en_proceso','completada','cancelada'] as $e)
                <option value="{{ $e }}" {{ request('estado') == $e ? 'selected' : '' }}>
                    {{ ucfirst(str_replace('_',' ',$e)) }}
                </option>
            @endforeach
        </select>
        <select name="tipo" onchange="this.form.submit()">
            <option value="">— Todos los tipos —</option>
            <option value="correctivo" {{ request('tipo') == 'correctivo' ? 'selected' : '' }}>Correctivo</option>
            <option value="preventivo" {{ request('tipo') == 'preventivo' ? 'selected' : '' }}>Preventivo</option>
        </select>
        @if(request('estado') || request('tipo'))
            <a href="{{ route('admin.solicitudes') }}" class="btn btn-secondary btn-sm">✕ Limpiar filtros</a>
        @endif
        <span style="color:#94a3b8; font-size:0.8rem; margin-left:auto;">{{ $solicitudes->count() }} resultado(s)</span>
    </div>
</form>

<div class="card">
    @if($solicitudes->isEmpty())
        <div class="empty-state"><div class="icon">📭</div><p>No hay solicitudes con esos filtros.</p></div>
    @else
    <table>
        <thead>
            <tr>
                <th>#</th><th>Cliente</th><th>Equipo</th><th>Categoría</th>
                <th>Tipo</th><th>Estado</th><th>Técnico</th><th>Fecha</th><th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($solicitudes as $s)
            @php $tecnico = $s->asignaciones->where('estado','activa')->first()?->tecnico?->usuario; @endphp
            <tr>
                <td><strong>#{{ $s->id_solicitud }}</strong></td>
                <td>{{ $s->cliente->usuario->nombre }}</td>
                <td>{{ $s->electrodomestico->marca }} {{ $s->electrodomestico->tipo }}</td>
                <td>{{ $s->categoriaFalla->nombre }}</td>
                <td>
                    @if($s->tipo_solicitud=='correctivo')
                        <span style="color:#dc2626;">🔴 Correctivo</span>
                    @else
                        <span style="color:#16a34a;">🟢 Preventivo</span>
                    @endif
                </td>
                <td><span class="badge badge-{{ $s->estado_solicitud }}">{{ ucfirst(str_replace('_',' ',$s->estado_solicitud)) }}</span></td>
                <td>{{ $tecnico ? $tecnico->nombre : '—' }}</td>
                <td>{{ \Carbon\Carbon::parse($s->fecha_solicitud)->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('admin.solicitudes.show', $s->id_solicitud) }}" class="btn btn-amber btn-sm">⚙️ Gestionar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

@endsection
