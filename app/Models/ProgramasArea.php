<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProgramasArea extends Model
{
    protected $table = 'programa_areas';

    protected $fillable = [
        'programa_id', 'nombre', 'descripcion', 'imagen', 'is_active',
    ];

    protected $casts   = ['is_active' => 'boolean'];

    public function scopeActive($q){ return $q->where('is_active', 1); }

    public function getImagenUrlAttribute(): string
    {
        $p = $this->imagen ?: '/images/no-photo.jpg';
        $p = ltrim($p, './');
        if (Str::startsWith($p, ['http://','https://'])) return $p;
        return asset($p);
    }
}
