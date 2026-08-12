<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de solicitudes de servicio.
     * Una solicitud es cuando un cliente pide que le reparen/mantengan un equipo.
     */
    public function up(): void
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id('id_solicitud');
            $table->string('tipo_solicitud', 50);       // preventivo, correctivo
            $table->text('descripcion_problema');
            $table->string('estado_solicitud', 30)->default('pendiente');
            // Estados: pendiente, asignada, agendada, en_proceso, completada, cancelada
            $table->timestamp('fecha_solicitud')->useCurrent();
            $table->timestamp('fecha_actualizacion')->useCurrent()->useCurrentOnUpdate();
            // Llaves foráneas
            $table->unsignedBigInteger('id_cliente');
            $table->foreign('id_cliente')->references('id_usuario')->on('clientes');
            $table->unsignedBigInteger('id_equipo');
            $table->foreign('id_equipo')->references('id_equipo')->on('electrodomesticos');
            $table->unsignedBigInteger('id_categoria');
            $table->foreign('id_categoria')->references('id_categoria')->on('categoria_falla');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};
