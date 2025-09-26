<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdmisionExonerado extends Model
{
    use SoftDeletes;

    protected $table = 'admision_exonerados';

    protected $fillable = [
        'titulo',
        'descripcion',
        'icono',     // ej: "fa-solid fa-trophy"
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
