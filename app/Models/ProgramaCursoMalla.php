<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramaCursoMalla extends Model
{
    protected $table = 'programa_cursos_malla';
    protected $fillable = ['semestre_malla_id','nombre','creditos','horas','is_active'];

    public function scopeActive($q){ return $q->where('is_active', 1); }

    public function semestre()
    {
        return $this->belongsTo(ProgramaSemestreMalla::class, 'semestre_malla_id');
    }

    public function unidades()
    {
        return $this->hasMany(UnidadDidactica::class, 'programa_curso_id');
    }
}
