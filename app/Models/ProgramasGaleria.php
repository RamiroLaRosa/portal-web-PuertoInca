<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProgramasGaleria extends Model
{
    use SoftDeletes;

    protected $table = 'programa_galeria';
    protected $fillable = [
        'programa_id',
        'nombre',
        'imagen',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = ['imagen_url'];

    public function getImagenUrlAttribute(): string
    {
        $p = $this->imagen ?: '/images/no-photo.jpg';
        $p = ltrim($p, './');                           // quita ./ o .//
        if (Str::startsWith($p, ['http://','https://'])) {
            return $p;
        }
        return asset($p);                               // => https://tusitio.com/images/...
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', 1);
    }
}
