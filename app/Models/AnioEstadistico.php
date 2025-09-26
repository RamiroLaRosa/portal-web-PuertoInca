<?php

// app/Models/AnioEstadistico.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnioEstadistico extends Model
{
    protected $table = 'anio_estadistico';
    protected $fillable = ['anio', 'is_active'];
    public $timestamps = true;
}
