<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Llama a todos los seeders en orden.
     * El orden importa porque hay llaves foráneas (foreign keys).
     * Ejemplo: no puedes crear un usuario sin que exista primero el rol.
     */
    public function run(): void
    {
        $this->call([
            RolSeeder::class,            // 1° Primero los roles
            UsuarioSeeder::class,        // 2° Usuarios (necesitan el rol)
            CategoriaFallaSeeder::class, // 3° Categorías de falla
            ElectrodomesticoSeeder::class, // 4° Equipos (necesitan el cliente)
            SolicitudSeeder::class,      // 5° Solicitudes (necesitan cliente, equipo y categoría)
        ]);
    }
}
