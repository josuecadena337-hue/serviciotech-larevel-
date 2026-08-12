<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla principal de usuarios.
     * Todos los actores del sistema (cliente, técnico, admin) tienen un usuario base.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('nombre', 100);
            $table->string('correo', 150)->unique();
            $table->string('telefono', 20)->nullable();
            $table->string('contrasena'); // se guardará encriptada
            $table->string('estado', 20)->default('activo'); // activo, bloqueado
            $table->integer('intentos_fallidos')->default(0);
            $table->timestamp('fecha_registro')->useCurrent();
            // Llave foránea hacia la tabla rol
            $table->unsignedBigInteger('id_rol');
            $table->foreign('id_rol')->references('id_rol')->on('rol');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
