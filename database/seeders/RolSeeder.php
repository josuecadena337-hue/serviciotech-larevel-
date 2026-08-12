<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolSeeder extends Seeder
{
    /**
     * Crea los 3 roles del sistema.
     */
    public function run(): void
    {
        $roles = ['admin', 'tecnico', 'cliente'];

        foreach ($roles as $nombre) {
            Rol::create(['nombre' => $nombre]);
        }
    }
}
