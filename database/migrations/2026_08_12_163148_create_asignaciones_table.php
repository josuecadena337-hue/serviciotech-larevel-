<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de asignaciones.
     * Registra qué técnico fue asignado a cada solicitud y quién lo asignó.
     */
    public function up(): void
    {
        Schema::create('asignaciones', function (Blueprint $table) {
            $table->id('id_asignacion');
            // Llaves foráneas
            $table->unsignedBigInteger('id_solicitud');
            $table->foreign('id_solicitud')->references('id_solicitud')->on('solicitudes');
            $table->unsignedBigInteger('id_tecnico');
            $table->foreign('id_tecnico')->references('id_usuario')->on('tecnicos');
            $table->unsignedBigInteger('id_admin');
            $table->foreign('id_admin')->references('id_usuario')->on('administradores');
            // Datos de la asignación
            $table->timestamp('fecha_asignacion')->useCurrent();
            $table->timestamp('fecha_reasignacion')->nullable();
            $table->text('motivo_reasignacion')->nullable();
            $table->string('estado', 30)->default('activa'); // activa, reasignada, cancelada
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asignaciones');
    }
};
