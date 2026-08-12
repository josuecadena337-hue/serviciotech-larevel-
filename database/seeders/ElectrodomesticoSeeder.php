<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Electrodomestico;
use App\Models\Cliente;

class ElectrodomesticoSeeder extends Seeder
{
    /**
     * Crea electrodomésticos de prueba para los clientes.
     */
    public function run(): void
    {
        // Obtenemos los clientes por correo
        $juan = Cliente::whereHas('usuario', fn($q) => $q->where('correo', 'juan@gmail.com'))->first();
        $ana  = Cliente::whereHas('usuario', fn($q) => $q->where('correo', 'ana@gmail.com'))->first();
        $pedro = Cliente::whereHas('usuario', fn($q) => $q->where('correo', 'pedro@gmail.com'))->first();

        // Equipos de Juan
        Electrodomestico::create([
            'tipo'       => 'Nevera',
            'marca'      => 'Samsung',
            'modelo'     => 'RT38K5982S8',
            'serie'      => 'SN-2024-001',
            'id_cliente' => $juan->id_usuario,
        ]);
        Electrodomestico::create([
            'tipo'       => 'Lavadora',
            'marca'      => 'LG',
            'modelo'     => 'WM3900HWA',
            'serie'      => 'LG-2023-045',
            'id_cliente' => $juan->id_usuario,
        ]);

        // Equipos de Ana
        Electrodomestico::create([
            'tipo'       => 'Aire Acondicionado',
            'marca'      => 'Carrier',
            'modelo'     => '38MFC009D515',
            'serie'      => 'CA-2024-078',
            'id_cliente' => $ana->id_usuario,
        ]);

        // Equipos de Pedro
        Electrodomestico::create([
            'tipo'       => 'Estufa',
            'marca'      => 'Mabe',
            'modelo'     => 'EK7260FX0',
            'serie'      => 'MB-2022-112',
            'id_cliente' => $pedro->id_usuario,
        ]);
        Electrodomestico::create([
            'tipo'       => 'Microondas',
            'marca'      => 'Haceb',
            'modelo'     => 'HM-1.1',
            'serie'      => 'HC-2023-200',
            'id_cliente' => $pedro->id_usuario,
        ]);
    }
}
