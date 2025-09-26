<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProgramasEstudio extends Model
{
    protected $table = 'programas_estudios';

    protected $fillable = ['nombre', 'descripcion', 'imagen', 'is_active'];

    // created_at / updated_at existen en tu tabla ✔
    // public $timestamps = true; // (por defecto)

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActivos($q)
    {
        return $q->where('is_active', 1);
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', 1);
    }

    public function coordinadores()
    {
        return $this->hasMany(ProgramasCoordinador::class, 'programa_id');
    }

    public function perfil()
    {
        // Un perfil por programa (según tu tabla)
        return $this->hasOne(ProgramasPerfil::class, 'programa_id')
            ->where('is_active', 1);
    }

    public function areas()
    {
        return $this->hasMany(ProgramasArea::class, 'programa_id')
            ->where('is_active', 1)
            ->orderBy('id');
    }

    public function egresados()
    {
        return $this->hasMany(\App\Models\ProgramasEgresado::class, 'programa_id')
            ->where('is_active', 1)
            ->orderBy('id');
    }

    public function modulosMalla()
    {
        return $this->hasMany(ProgramaModuloMalla::class, 'programa_id');
    }

    public function convenios()
    {
        return $this->hasMany(ProgramasConvenio::class, 'programa_id')
            ->where('is_active', 1)
            ->orderBy('id');
    }

    public function galerias()
    {
        return $this->hasMany(ProgramasGaleria::class, 'programa_id');
    }

    public function resultadosAdmision()
    {
        return $this->hasMany(AdmisionResultado::class, 'programa_id')->where('is_active', 1);
    }

    /* Relaciones */
    public function docentes()
    {
        return $this->hasMany(PlanaDocente::class, 'programa_estudio_id');
    }

    public function info()
    {
        return $this->hasOne(ProgramaInformacion::class, 'programa_id')->where('is_active', 1);
    }

    public function getImagenUrlAttribute(): string
    {
        $p = $this->imagen ?: '/images/no-photo.jpg';
        $p = ltrim($p, './');
        if (Str::startsWith($p, ['http://', 'https://'])) return $p;
        return asset(ltrim($p, '/'));
    }
}
