<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use App\Models\Cliente;
use App\Models\Tecnico;
use App\Models\Administrador;
use App\Models\Rol;

class UsuarioSeeder extends Seeder
{
    /**
     * Crea usuarios de prueba: 1 admin, 2 técnicos, 3 clientes.
     */
    public function run(): void
    {
        // Obtenemos los IDs de cada rol
        $rolAdmin   = Rol::where('nombre', 'admin')->first()->id_rol;
        $rolTecnico = Rol::where('nombre', 'tecnico')->first()->id_rol;
        $rolCliente = Rol::where('nombre', 'cliente')->first()->id_rol;

        // ─── ADMINISTRADOR ────────────────────────────────────────
        $admin = Usuario::create([
            'nombre'   => 'Admin ServicioTech',
            'correo'   => 'admin@serviciotech.com',
            'telefono' => '3001234567',
            'contrasena' => Hash::make('admin123'),
            'estado'   => 'activo',
            'id_rol'   => $rolAdmin,
        ]);
        Administrador::create([
            'id_usuario' => $admin->id_usuario,
            'permisos'   => 'todos',
        ]);

        // ─── TÉCNICOS ─────────────────────────────────────────────
        $tecnico1 = Usuario::create([
            'nombre'   => 'Carlos Técnico',
            'correo'   => 'carlos@serviciotech.com',
            'telefono' => '3109876543',
            'contrasena' => Hash::make('tecnico123'),
            'estado'   => 'activo',
            'id_rol'   => $rolTecnico,
        ]);
        Tecnico::create([
            'id_usuario'    => $tecnico1->id_usuario,
            'especialidad'  => 'Neveras y Lavadoras',
            'disponibilidad' => 'disponible',
        ]);

        $tecnico2 = Usuario::create([
            'nombre'   => 'María Técnico',
            'correo'   => 'maria@serviciotech.com',
            'telefono' => '3207654321',
            'contrasena' => Hash::make('tecnico123'),
            'estado'   => 'activo',
            'id_rol'   => $rolTecnico,
        ]);
        Tecnico::create([
            'id_usuario'    => $tecnico2->id_usuario,
            'especialidad'  => 'Aires Acondicionados y Estufas',
            'disponibilidad' => 'disponible',
        ]);

        // ─── CLIENTES ─────────────────────────────────────────────
        $cliente1 = Usuario::create([
            'nombre'   => 'Juan Pérez',
            'correo'   => 'juan@gmail.com',
            'telefono' => '3151112233',
            'contrasena' => Hash::make('cliente123'),
            'estado'   => 'activo',
            'id_rol'   => $rolCliente,
        ]);
        Cliente::create([
            'id_usuario' => $cliente1->id_usuario,
            'direccion'  => 'Calle 45 #12-34, Bogotá',
        ]);

        $cliente2 = Usuario::create([
            'nombre'   => 'Ana García',
            'correo'   => 'ana@gmail.com',
            'telefono' => '3164445566',
            'contrasena' => Hash::make('cliente123'),
            'estado'   => 'activo',
            'id_rol'   => $rolCliente,
        ]);
        Cliente::create([
            'id_usuario' => $cliente2->id_usuario,
            'direccion'  => 'Carrera 7 #89-12, Bogotá',
        ]);

        $cliente3 = Usuario::create([
            'nombre'   => 'Pedro López',
            'correo'   => 'pedro@gmail.com',
            'telefono' => '3177778899',
            'contrasena' => Hash::make('cliente123'),
            'estado'   => 'activo',
            'id_rol'   => $rolCliente,
        ]);
        Cliente::create([
            'id_usuario' => $cliente3->id_usuario,
            'direccion'  => 'Avenida 15 #23-45, Bogotá',
        ]);
    }
}
