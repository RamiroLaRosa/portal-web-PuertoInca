<?php

// app/Models/InicioEstadistica.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InicioEstadistica extends Model
{
    use SoftDeletes;

    protected $table = 'inicio_estadistica';
    protected $fillable = ['icono', 'descripcion', 'cantidad', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
        'cantidad'  => 'integer',
    ];

    public function scopeActive($q)
    {
        return $q->where('is_active', 1);
    }
}
