<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProgramasConvenio extends Model
{
    use SoftDeletes;

    protected $table = 'programas_convenios';

    protected $fillable = [
        'programa_id',
        'entidad',
        'imagen',
        'documento',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($q)
    {
        return $q->where('is_active', 1);
    }

    protected $appends = ['imagen_url','documento_url'];

    public function getImagenUrlAttribute(): string
    {
        $p = $this->imagen ?: '/images/no-photo.jpg';
        $p = ltrim($p, './');
        return Str::startsWith($p, ['http://', 'https://']) ? $p : asset($p);
    }

    public function getDocumentoUrlAttribute(): ?string
    {
        if (empty($this->documento) || $this->documento === '0') return null;
        $p = ltrim($this->documento, './');
        return Str::startsWith($p, ['http://','https://']) ? $p : asset($p);
    }
}
