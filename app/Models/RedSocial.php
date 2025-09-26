<?php

// app/Models/RedSocial.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RedSocial extends Model
{
    use SoftDeletes;

    protected $table = 'redes_sociales';

    protected $fillable = [
        'nombre',        // VARCHAR
        'enlace',        // VARCHAR (URL)
        'icono',         // Ej: "fa-brands fa-facebook-f"
        'is_active',     // tinyint(1)
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
