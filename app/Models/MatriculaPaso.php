<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MatriculaPaso extends Model
{
    use SoftDeletes;

    protected $table = 'matricula_pasos';

    protected $fillable = [
        'numero_paso',      // int
        'titulo',           // string
        'descripcion',      // text/string
        'is_active',        // tinyint/bool
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'numero_paso' => 'integer',
    ];
}
