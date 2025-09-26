<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdmisionModalidad extends Model
{
    use SoftDeletes;

    protected $table = 'admision_modalidades';

    protected $fillable = [
        'titulo',
        'descripcion',
        'icono',      // ej: "fa-solid fa-trophy"
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
