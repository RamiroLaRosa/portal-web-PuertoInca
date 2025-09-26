<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramaSemestreMalla extends Model
{
    protected $table = 'programa_semestres_malla';
    protected $fillable = ['modulo_malla_id','nombre','is_active'];

    public function scopeActive($q){ return $q->where('is_active', 1); }

    public function modulo()
    {
        return $this->belongsTo(ProgramaModuloMalla::class, 'modulo_malla_id');
    }

    public function cursos()
    {
        return $this->hasMany(ProgramaCursoMalla::class, 'semestre_malla_id');
    }
}
