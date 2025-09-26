<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MatriculaDetalleRequisito extends Model
{
    use SoftDeletes;

    protected $table = 'matricula_detalle_requisitos';

    protected $fillable = [
        'matricula_requisitos_id',
        'descripcion',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relación (muchos a uno) con la cabecera de requisitos
    public function requisito()
    {
        return $this->belongsTo(\App\Models\MatriculaRequisito::class, 'matricula_requisitos_id');
    }
}
