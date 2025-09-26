<?php

// app/Models/TemaEstadistico.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemaEstadistico extends Model
{
    protected $table = 'tema_estadistico';
    protected $fillable = ['tema', 'is_active'];

    public $timestamps = true;
}
