<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdmisionCronograma extends Model
{
    use SoftDeletes;

    protected $table = 'admision_cronograma';

    protected $fillable = [
        'titulo',
        'fecha',        // puede ser rango de texto o una fecha, según tu BD
        'descripcion',
        'icono',        // ej: "fa-solid fa-calendar"
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActivos($q)
    {
        return $q->where('is_active', 1);
    }
}
