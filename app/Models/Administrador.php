<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    protected $table = 'administradores';
    protected $primaryKey = 'id_usuario';
    public $incrementing = false;

    protected $fillable = ['id_usuario', 'permisos'];

    // --- RELACIONES ---

    // El administrador ES un usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    // Un administrador hace muchas asignaciones
    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class, 'id_admin', 'id_usuario');
    }
}
