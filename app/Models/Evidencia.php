<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evidencia extends Model
{
    protected $table = 'evidencias';
    protected $primaryKey = 'id_evidencia';

    protected $fillable = [
        'tipo',
        'url_archivo',
        'descripcion',
        'id_solicitud',
        'subido_por',
        'fecha_subida',
    ];

    protected $attributes = [
        'fecha_subida' => null,
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->fecha_subida)) {
                $model->fecha_subida = now();
            }
        });
    }

    // --- RELACIONES ---

    // Una evidencia pertenece a una solicitud
    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'id_solicitud', 'id_solicitud');
    }

    // Una evidencia fue subida por un usuario (técnico o admin)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'subido_por', 'id_usuario');
    }
}
