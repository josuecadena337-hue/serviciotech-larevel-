<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tecnico extends Model
{
    protected $table = 'tecnicos';
    protected $primaryKey = 'id_usuario';
    public $incrementing = false;

    protected $fillable = ['id_usuario', 'especialidad', 'disponibilidad'];

    // --- RELACIONES ---

    // El técnico ES un usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    // Un técnico tiene muchas asignaciones
    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class, 'id_tecnico', 'id_usuario');
    }

    // Un técnico tiene muchas citas
    public function citas()
    {
        return $this->hasMany(Cita::class, 'id_tecnico', 'id_usuario');
    }
}
