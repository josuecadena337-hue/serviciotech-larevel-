<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'nombre',
        'correo',
        'telefono',
        'contrasena',
        'estado',
        'intentos_fallidos',
        'id_rol',
    ];

    // Campos ocultos (no se muestran en JSON, por seguridad)
    protected $hidden = ['contrasena'];

    // Decirle a Laravel cuál es el campo de contraseña
    protected $authPasswordName = 'contrasena';

    // --- RELACIONES ---

    // Un usuario pertenece a un rol
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
    }

    // Un usuario puede ser cliente
    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'id_usuario', 'id_usuario');
    }

    // Un usuario puede ser técnico
    public function tecnico()
    {
        return $this->hasOne(Tecnico::class, 'id_usuario', 'id_usuario');
    }

    // Un usuario puede ser administrador
    public function administrador()
    {
        return $this->hasOne(Administrador::class, 'id_usuario', 'id_usuario');
    }

    // Método auxiliar: saber si es admin
    public function esAdmin()
    {
        return $this->rol->nombre === 'admin';
    }

    // Método auxiliar: saber si es técnico
    public function esTecnico()
    {
        return $this->rol->nombre === 'tecnico';
    }

    // Método auxiliar: saber si es cliente
    public function esCliente()
    {
        return $this->rol->nombre === 'cliente';
    }
}
