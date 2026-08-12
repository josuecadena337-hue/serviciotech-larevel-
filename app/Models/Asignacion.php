<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    protected $table = 'asignaciones';
    protected $primaryKey = 'id_asignacion';

    protected $fillable = [
        'id_solicitud',
        'id_tecnico',
        'id_admin',
        'fecha_reasignacion',
        'motivo_reasignacion',
        'estado',
    ];

    // --- RELACIONES ---

    // Una asignación pertenece a una solicitud
    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'id_solicitud', 'id_solicitud');
    }

    // Una asignación pertenece a un técnico
    public function tecnico()
    {
        return $this->belongsTo(Tecnico::class, 'id_tecnico', 'id_usuario');
    }

    // Una asignación fue hecha por un administrador
    public function administrador()
    {
        return $this->belongsTo(Administrador::class, 'id_admin', 'id_usuario');
    }
}
