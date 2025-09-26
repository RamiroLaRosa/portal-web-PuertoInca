<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MatriculaTipo extends Model
{
    use SoftDeletes;

    protected $table = 'matricula_tipos';

    protected $fillable = [
        'titulo',
        'descripcion',
        'icono',      // ej: "fa-solid fa-user-plus"
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
