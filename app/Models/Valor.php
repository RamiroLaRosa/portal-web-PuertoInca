<?php

// app/Models/Valor.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Valor extends Model {
    use SoftDeletes;
    protected $table = 'valores';
    protected $fillable = ['nombre','descripcion','icono','is_active'];
    protected $casts   = ['is_active' => 'boolean'];
}
