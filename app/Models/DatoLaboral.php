<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatoLaboral extends Model
{
    protected $table = 'datos_laborales';
    public $timestamps = true;

    protected $fillable = [
        'docente_id',
        'institucion',
        'cargo',
        'experiencia',
        'inicio_labor',
        'termino_labor',
        'tiempo_cargo',
        'is_active',
    ];
}
