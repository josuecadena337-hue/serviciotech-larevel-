<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaFalla extends Model
{
    protected $table = 'categoria_falla';
    protected $primaryKey = 'id_categoria';

    protected $fillable = ['nombre', 'descripcion'];

    // --- RELACIONES ---

    // Una categoría tiene muchas solicitudes
    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class, 'id_categoria', 'id_categoria');
    }
}
