<?php

// app/Models/Presentacion.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Presentacion extends Model
{
    use SoftDeletes;

    // Si tu tabla se llama 'presentation', cámbiala aquí:
    protected $table = 'presentacion';

    protected $fillable = [
        'titulo',
        'nombre_director',
        'palabras_director',
        'foto_director',
        'is_active',
    ];
}
