<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'id_usuario';
    // No tiene auto-increment propio, el id viene de usuarios
    public $incrementing = false;

    protected $fillable = ['id_usuario', 'direccion'];

    // --- RELACIONES ---

    // El cliente ES un usuario (relación inversa)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    // Un cliente tiene muchos electrodomésticos
    public function electrodomesticos()
    {
        return $this->hasMany(Electrodomestico::class, 'id_cliente', 'id_usuario');
    }

    // Un cliente tiene muchas solicitudes
    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class, 'id_cliente', 'id_usuario');
    }
}
