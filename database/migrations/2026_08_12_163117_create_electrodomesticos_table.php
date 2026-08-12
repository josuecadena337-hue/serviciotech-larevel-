<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de electrodomésticos.
     * Cada equipo pertenece a un cliente.
     */
    public function up(): void
    {
        Schema::create('electrodomesticos', function (Blueprint $table) {
            $table->id('id_equipo');
            $table->string('tipo', 100);        // Nevera, Lavadora, etc.
            $table->string('marca', 100);
            $table->string('modelo', 100)->nullable();
            $table->string('serie', 100)->unique()->nullable(); // número de serie único
            // Llave foránea: cada equipo pertenece a un cliente
            $table->unsignedBigInteger('id_cliente');
            $table->foreign('id_cliente')->references('id_usuario')->on('clientes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('electrodomesticos');
    }
};
