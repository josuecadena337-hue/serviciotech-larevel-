@extends('layouts.cliente')

@section('title', 'Mis Equipos')
@section('page-title', 'Mis Equipos')
@section('breadcrumb', 'Mis Equipos')

@section('topbar-actions')
    <a href="{{ route('cliente.equipos.create') }}" class="btn btn-primary">➕ Nuevo Equipo</a>
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <h3>🖥️ Mis Electrodomésticos ({{ $equipos->count() }})</h3>
    </div>

    @if($equipos->isEmpty())
        <div class="empty-state">
            <div class="icon">🖥️</div>
            <p>Aún no tienes equipos registrados.</p>
            <a href="{{ route('cliente.equipos.create') }}" class="btn btn-primary">
                ➕ Registrar mi primer equipo
            </a>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>N° de Serie</th>
                    <th>Registrado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($equipos as $equipo)
                <tr>
                    <td>
                        @php
                            $iconos = ['Nevera'=>'❄️','Lavadora'=>'⚡','Aire Acondicionado'=>'💨','Estufa'=>'🍳','Microondas'=>'📡','Televisor'=>'📺','Otro'=>'🔧'];
                        @endphp
                        {{ $iconos[$equipo->tipo] ?? '🔧' }} {{ $equipo->tipo }}
                    </td>
                    <td><strong>{{ $equipo->marca }}</strong></td>
                    <td>{{ $equipo->modelo ?? '—' }}</td>
                    <td><code style="background:#f1f5f9; padding:2px 6px; border-radius:4px; font-size:0.8rem;">{{ $equipo->serie ?? '—' }}</code></td>
                    <td>{{ \Carbon\Carbon::parse($equipo->created_at)->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('cliente.solicitudes.create') }}?equipo={{ $equipo->id_equipo }}"
                           class="btn btn-primary btn-sm">🔧 Solicitar servicio</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection
