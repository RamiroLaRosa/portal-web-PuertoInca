<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Noticia extends Model
{
    use SoftDeletes;

    protected $table = 'noticias';

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha', 
        'imagen',  
        'documento',
        'is_active',
    ];

    protected $casts = [
        'fecha' => 'date',
        'is_active' => 'boolean',
    ];

    public function scopeActive($q)
    {
        return $q->where('is_active', 1);
    }

    public function getImagenUrlAttribute(): string
    {
        $p = $this->imagen ?: '/images/no-photo.jpg';
        $p = ltrim($p, './');
        if (Str::startsWith($p, ['http://','https://'])) return $p;
        return asset($p);
    }

    public function getFechaHumanAttribute(): string
    {
        $d = $this->fecha ? Carbon::parse($this->fecha) : Carbon::now();
        $d->locale('es');
        return $d->translatedFormat('j \d\e F, Y'); // ej: 15 de Abril, 2025
    }

    public function getDocumentoUrlAttribute(): ?string
    {
        if (!$this->documento) return null;
        $p = ltrim($this->documento, './');
        return str_starts_with($p, 'http') ? $p : asset($p);
    }
}
