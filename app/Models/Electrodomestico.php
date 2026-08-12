<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Electrodomestico extends Model
{
    protected $table = 'electrodomesticos';
    protected $primaryKey = 'id_equipo';

    protected $fillable = ['tipo', 'marca', 'modelo', 'serie', 'id_cliente'];

    // --- RELACIONES ---

    // Un electrodoméstico pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_usuario');
    }

    // Un electrodoméstico tiene muchas solicitudes
    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class, 'id_equipo', 'id_equipo');
    }
}
