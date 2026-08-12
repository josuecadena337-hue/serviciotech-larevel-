<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table = 'solicitudes';
    protected $primaryKey = 'id_solicitud';

    protected $fillable = [
        'tipo_solicitud',
        'descripcion_problema',
        'estado_solicitud',
        'id_cliente',
        'id_equipo',
        'id_categoria',
    ];

    // --- RELACIONES ---

    // Una solicitud pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_usuario');
    }

    // Una solicitud pertenece a un electrodoméstico
    public function electrodomestico()
    {
        return $this->belongsTo(Electrodomestico::class, 'id_equipo', 'id_equipo');
    }

    // Una solicitud pertenece a una categoría de falla
    public function categoriaFalla()
    {
        return $this->belongsTo(CategoriaFalla::class, 'id_categoria', 'id_categoria');
    }

    // Una solicitud tiene muchas asignaciones
    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class, 'id_solicitud', 'id_solicitud');
    }

    // Una solicitud tiene muchas citas
    public function citas()
    {
        return $this->hasMany(Cita::class, 'id_solicitud', 'id_solicitud');
    }

    // Una solicitud tiene muchas evidencias
    public function evidencias()
    {
        return $this->hasMany(Evidencia::class, 'id_solicitud', 'id_solicitud');
    }
}
