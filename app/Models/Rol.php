<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rol';
    protected $primaryKey = 'id_rol';

    // Campos que se pueden llenar masivamente
    protected $fillable = ['nombre'];

    // --- RELACIONES ---

    // Un rol tiene muchos usuarios
    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'id_rol', 'id_rol');
    }
}
