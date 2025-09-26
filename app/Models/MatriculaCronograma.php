<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MatriculaCronograma extends Model
{
    use SoftDeletes;

    protected $table = 'matricula_cronograma';

    protected $fillable = [
        'titulo',
        'fecha',
        'descripcion',
        'icono',      // ej: "fa-solid fa-calendar"
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
