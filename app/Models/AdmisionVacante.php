<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdmisionVacante extends Model
{
    use SoftDeletes;

    protected $table = 'admision_vacantes';

    protected $fillable = [
        'programa_estudio_id',
        'vacantes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'vacantes'  => 'integer',
    ];

    // Relaciones
    public function programa()
    {
        return $this->belongsTo(\App\Models\ProgramasEstudio::class, 'programa_estudio_id');
    }
}
