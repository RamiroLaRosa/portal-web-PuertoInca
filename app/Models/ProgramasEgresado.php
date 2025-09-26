<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProgramasEgresado extends Model
{
    protected $table = 'programa_egresados'; // tu tabla
    protected $fillable = [
        'programa_id',
        'nombre',
        'cargo',
        'imagen',
        'is_active',
    ];

    protected $appends = ['imagen_url'];

    public function getImagenUrlAttribute(): string
    {
        $p = $this->imagen ?: '/images/no-photo.jpg';
        $p = ltrim($p, './');
        if (Str::startsWith($p, ['http://','https://'])) return $p;
        return asset($p);
    }

}
