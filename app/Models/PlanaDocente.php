<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PlanaDocente extends Model
{
    protected $table = 'plana_docente';

    protected $fillable = [
        'programa_estudio_id',
        'nombre',
        'cargo',
        'correo',
        'foto',
        'is_active',
    ];

    public function programa()
    {
        return $this->belongsTo(ProgramasEstudio::class, 'programa_estudio_id');
    }

    public function datosPersonal()
    {
        return $this->hasOne(DatosPersonal::class, 'docente_id');
    }

    public function academicos()
    {
        return $this->hasMany(DatoAcademico::class, 'docente_id');
    }

    public function getFotoUrlAttribute(): string
    {
        $p = $this->foto ?: '/images/no-photo.jpg';
        $p = ltrim($p, './');
        if (Str::startsWith($p, ['http://', 'https://'])) return $p;
        return asset(ltrim($p, '/'));
    }
}
