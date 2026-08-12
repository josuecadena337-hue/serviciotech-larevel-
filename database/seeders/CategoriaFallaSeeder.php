<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoriaFalla;

class CategoriaFallaSeeder extends Seeder
{
    /**
     * Crea las categorías de falla por tipo de electrodoméstico.
     */
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Nevera',              'descripcion' => 'Fallas en refrigeradores y neveras'],
            ['nombre' => 'Lavadora',            'descripcion' => 'Fallas en lavadoras y secadoras'],
            ['nombre' => 'Aire Acondicionado',  'descripcion' => 'Fallas en aires acondicionados'],
            ['nombre' => 'Estufa',              'descripcion' => 'Fallas en estufas de gas o eléctricas'],
            ['nombre' => 'Microondas',          'descripcion' => 'Fallas en hornos microondas'],
            ['nombre' => 'Televisor',           'descripcion' => 'Fallas en televisores'],
            ['nombre' => 'Otro',                'descripcion' => 'Otros electrodomésticos'],
        ];

        foreach ($categorias as $categoria) {
            CategoriaFalla::create($categoria);
        }
    }
}
