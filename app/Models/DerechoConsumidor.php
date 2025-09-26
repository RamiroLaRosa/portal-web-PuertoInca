<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DerechoConsumidor extends Model
{
    protected $table = 'derechos_consumidor';
    public $timestamps = true;

    protected $fillable = ['titulo', 'descripcion', 'icono', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
