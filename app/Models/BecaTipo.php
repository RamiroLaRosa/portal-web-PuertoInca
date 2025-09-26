<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BecaTipo extends Model
{
    use SoftDeletes;

    protected $table = 'becas_tipo';

    protected $fillable = [
        'titulo',
        'descripcion',
        'requisito',
        'icono',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActivos($q) {
        return $q->where('is_active', 1);
    }
}
