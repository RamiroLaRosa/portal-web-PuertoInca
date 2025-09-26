<?php

// app/Models/PlanaJerarquica.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PlanaJerarquica extends Model
{
    use SoftDeletes;

    protected $table = 'plana_jerarquica';
    protected $fillable = ['nombre', 'cargo', 'imagen', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Solo registros activos
    public function scopeActive($q)
    {
        return $q->where('is_active', 1);
    }

    // URL segura para la imagen (soporta rutas relativas y absolutas)
    public function getImagenUrlAttribute(): string
    {
        $path = $this->imagen ?: '/images/no-photo.jpg';
        $path = ltrim($path, './'); // quita ./ si viene así
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }
        return asset($path);
    }
}
