<?php

// app/Models/ProgramasCoordinador.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProgramasCoordinador extends Model
{
    use SoftDeletes;

    protected $table = 'programa_coordinador';

    protected $fillable = [
        'programa_id',
        'nombres',
        'apellidos',
        'cargo',
        'foto',
        'palabras',   // (tu columna de “mensaje”)
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'bool',
    ];

    public function programa()
    {
        return $this->belongsTo(ProgramasEstudio::class, 'programa_id');
    }

    // URL segura para la foto
    public function getFotoUrlAttribute(): string
    {
        $p = $this->foto ?: '/images/no-photo.jpg';
        $p = ltrim($p, './');
        if (Str::startsWith($p, ['http://','https://'])) return $p;
        return asset($p);
    }

    // Nombre completo
    public function getNombreCompletoAttribute(): string
    {
        return trim($this->nombres.' '.$this->apellidos);
    }
}
