<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class AdmisionTitulo extends Model
{
    use SoftDeletes;

    protected $table = 'admision_titulo';

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',      // guarda ruta relativa (p.ej. "admision_titulo/abc.jpg" o "images/no-photo.jpg")
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = ['imagen_url'];

    public function getImagenUrlAttribute(): string
    {
        $img = $this->imagen ?: 'images/no-photo.jpg';

        // URL absoluta (por si guardaste links externos)
        if ($img && preg_match('#^https?://#', $img)) {
            return $img;
        }

        // Archivo en storage/app/public/... (requiere `php artisan storage:link`)
        if ($img && Storage::disk('public')->exists($img)) {
            return Storage::disk('public')->url($img);
        }

        // Fallback: archivo dentro de /public/...
        return asset($img);
    }

    // (Opcional) Al force delete, borra el archivo físico del disco public
    protected static function booted(): void
    {
        static::forceDeleted(function (self $model) {
            $img = $model->getOriginal('imagen');
            if (
                $img &&
                $img !== 'images/no-photo.jpg' &&
                !preg_match('#^https?://#', $img) &&
                Storage::disk('public')->exists($img)
            ) {
                Storage::disk('public')->delete($img);
            }
        });
    }
}
