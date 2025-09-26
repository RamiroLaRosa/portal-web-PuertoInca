<?php

// app/Models/InicioTestimonio.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class InicioTestimonio extends Model
{
    use SoftDeletes;

    protected $table = 'inicio_testimonios';
    protected $fillable = ['nombre','descripcion','imagen','puntuacion','is_active'];

    protected $casts = [
        'is_active'  => 'boolean',
        'puntuacion' => 'integer',
    ];

    // Scope: solo activos
    public function scopeActive($q) { return $q->where('is_active', 1); }

    // Accesor para devolver una URL válida de imagen
    public function getImagenUrlAttribute(): string
    {
        $p = $this->imagen ?: '/images/no-photo.jpg';
        $p = ltrim($p, './');
        if (Str::startsWith($p, ['http://','https://'])) return $p;
        return asset($p);
    }
}
