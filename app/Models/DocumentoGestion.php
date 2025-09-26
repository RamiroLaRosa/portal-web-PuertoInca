<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class DocumentoGestion extends Model
{
    use SoftDeletes;

    protected $table = 'documentos_gestion';

    protected $fillable = [
        'nombre',
        'descripcion',
        'documento',   // ruta del PDF
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getUrlAttribute(): ?string
    {
        return $this->documento ? \Storage::url($this->documento) : null;
    }
}
