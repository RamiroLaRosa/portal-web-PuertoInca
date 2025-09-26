<?php

// app/Models/InicioHero.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InicioHero extends Model
{
    use SoftDeletes; 

    protected $table = 'inicio_hero';
    protected $fillable = ['titulo', 'descripcion', 'foto', 'is_active'];
}
