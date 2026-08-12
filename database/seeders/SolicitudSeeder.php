<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Solicitud;
use App\Models\Cliente;
use App\Models\Electrodomestico;
use App\Models\CategoriaFalla;

class SolicitudSeeder extends Seeder
{
    /**
     * Crea solicitudes de prueba en diferentes estados.
     */
    public function run(): void
    {
        $juan  = Cliente::whereHas('usuario', fn($q) => $q->where('correo', 'juan@gmail.com'))->first();
        $ana   = Cliente::whereHas('usuario', fn($q) => $q->where('correo', 'ana@gmail.com'))->first();
        $pedro = Cliente::whereHas('usuario', fn($q) => $q->where('correo', 'pedro@gmail.com'))->first();

        $nevera  = Electrodomestico::where('tipo', 'Nevera')->first();
        $lavadora = Electrodomestico::where('tipo', 'Lavadora')->first();
        $aire    = Electrodomestico::where('tipo', 'Aire Acondicionado')->first();
        $estufa  = Electrodomestico::where('tipo', 'Estufa')->first();

        $catNevera  = CategoriaFalla::where('nombre', 'Nevera')->first();
        $catLavadora = CategoriaFalla::where('nombre', 'Lavadora')->first();
        $catAire    = CategoriaFalla::where('nombre', 'Aire Acondicionado')->first();
        $catEstufa  = CategoriaFalla::where('nombre', 'Estufa')->first();

        // Solicitud 1 — Pendiente
        Solicitud::create([
            'tipo_solicitud'      => 'correctivo',
            'descripcion_problema'=> 'La nevera no enfría adecuadamente, hace ruido extraño.',
            'estado_solicitud'    => 'pendiente',
            'id_cliente'          => $juan->id_usuario,
            'id_equipo'           => $nevera->id_equipo,
            'id_categoria'        => $catNevera->id_categoria,
        ]);

        // Solicitud 2 — En proceso
        Solicitud::create([
            'tipo_solicitud'      => 'correctivo',
            'descripcion_problema'=> 'La lavadora hace ruido al centrifugar y gotea agua.',
            'estado_solicitud'    => 'en_proceso',
            'id_cliente'          => $juan->id_usuario,
            'id_equipo'           => $lavadora->id_equipo,
            'id_categoria'        => $catLavadora->id_categoria,
        ]);

        // Solicitud 3 — Completada
        Solicitud::create([
            'tipo_solicitud'      => 'preventivo',
            'descripcion_problema'=> 'Mantenimiento preventivo del aire acondicionado.',
            'estado_solicitud'    => 'completada',
            'id_cliente'          => $ana->id_usuario,
            'id_equipo'           => $aire->id_equipo,
            'id_categoria'        => $catAire->id_categoria,
        ]);

        // Solicitud 4 — Asignada
        Solicitud::create([
            'tipo_solicitud'      => 'correctivo',
            'descripcion_problema'=> 'Las hornillas de la estufa no encienden correctamente.',
            'estado_solicitud'    => 'asignada',
            'id_cliente'          => $pedro->id_usuario,
            'id_equipo'           => $estufa->id_equipo,
            'id_categoria'        => $catEstufa->id_categoria,
        ]);
    }
}
