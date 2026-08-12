<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de evidencias.
     * El técnico sube fotos/archivos como prueba del trabajo realizado.
     */
    public function up(): void
    {
        Schema::create('evidencias', function (Blueprint $table) {
            $table->id('id_evidencia');
            $table->string('tipo', 50);          // foto, video, documento
            $table->string('url_archivo', 300);  // ruta del archivo guardado
            $table->text('descripcion')->nullable();
            $table->timestamp('fecha_subida')->useCurrent();
            // Llaves foráneas
            $table->unsignedBigInteger('id_solicitud');
            $table->foreign('id_solicitud')->references('id_solicitud')->on('solicitudes');
            $table->unsignedBigInteger('subido_por'); // usuario que subió el archivo
            $table->foreign('subido_por')->references('id_usuario')->on('usuarios');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evidencias');
    }
};
