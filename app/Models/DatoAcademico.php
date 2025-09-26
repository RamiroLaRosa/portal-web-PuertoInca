<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatoAcademico extends Model
{
    protected $table = 'datos_academicos';
    public $timestamps = true;

    protected $fillable = [
        'docente_id',
        'grado',
        'situacion_academica',
        'especialidad',
        'institucion_educativa',
        'fecha_emision',
        'registro',
        'is_active',
    ];

    public function docente()
    {
        return $this->belongsTo(PlanaDocente::class, 'docente_id');
    }
}
