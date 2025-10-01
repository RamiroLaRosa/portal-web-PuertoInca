<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $table = 'locales';

    protected $fillable = [
        'direccion',
        'telefono',
        'correo',
        'horario',
        'link',
        'is_active',
        'foto',        
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto ? asset($this->foto) : null;
    }
}