<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $table = 'citas';
    protected $primaryKey = 'id_cita';

    protected $fillable = [
        'fecha',
        'hora',
        'estado',
        'motivo_reprogramacion',
        'id_solicitud',
        'id_tecnico',
    ];

    // --- RELACIONES ---

    // Una cita pertenece a una solicitud
    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'id_solicitud', 'id_solicitud');
    }

    // Una cita pertenece a un técnico
    public function tecnico()
    {
        return $this->belongsTo(Tecnico::class, 'id_tecnico', 'id_usuario');
    }
}
