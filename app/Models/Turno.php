<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Turno extends Model
{
    use SoftDeletes;

    // 👇 clave: tabla singular
    protected $table = 'turno';

    protected $fillable = ['nombre', 'descripcion', 'is_active'];

    public function scopeActivos($q)
    {
        return $q->where('is_active', 1);
    }
}
