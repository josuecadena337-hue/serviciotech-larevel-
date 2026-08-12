<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de citas.
     * Una cita es la fecha y hora acordada para que el técnico visite al cliente.
     */
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id('id_cita');
            $table->date('fecha');
            $table->time('hora');
            $table->string('estado', 30)->default('pendiente');
            // Estados: pendiente, confirmada, reprogramada, cancelada, completada
            $table->text('motivo_reprogramacion')->nullable();
            // Llaves foráneas
            $table->unsignedBigInteger('id_solicitud');
            $table->foreign('id_solicitud')->references('id_solicitud')->on('solicitudes');
            $table->unsignedBigInteger('id_tecnico');
            $table->foreign('id_tecnico')->references('id_usuario')->on('tecnicos');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
