<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class AdmisionResultado extends Model
{
    use SoftDeletes;

    protected $table = 'admision_resultados';

    protected $fillable = [
        'programa_id',
        'turno_id',
        'documento',   // ruta relativa o absoluta del PDF
        'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];
    protected $appends = ['documento_url'];

    // Relaciones
    public function programa()
    {
        return $this->belongsTo(\App\Models\ProgramasEstudio::class, 'programa_id');
    }

    public function turno()
    {
        return $this->belongsTo(\App\Models\Turno::class, 'turno_id');
    }

    public function scopeActivos($q)
    {
        return $q->where('is_active', 1);
    }

    // URL pública del PDF
    public function getDocumentoUrlAttribute(): string
    {
        $doc = $this->documento ?: '';
        if ($doc && preg_match('#^https?://#', $doc)) return $doc;          // URL absoluta
        if ($doc && Storage::disk('public')->exists($doc))                // storage/app/public
            return Storage::disk('public')->url($doc);
        return $doc ? asset(ltrim($doc, '/')) : '#';                         // /public
    }

    // (Opcional) elimina el archivo del disco public al force delete
    protected static function booted(): void
    {
        static::forceDeleted(function (self $model) {
            $doc = $model->getOriginal('documento');
            if ($doc && !preg_match('#^https?://#', $doc) && Storage::disk('public')->exists($doc)) {
                Storage::disk('public')->delete($doc);
            }
        });
    }
}
