<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramaModuloMalla extends Model
{
    protected $table = 'programa_modulos_malla';
    protected $fillable = ['programa_id','nombre','is_active'];

    /* Scopes */
    public function scopeActive($q){ return $q->where('is_active', 1); }

    /* Relaciones */
    public function programa()
    {
        return $this->belongsTo(ProgramasEstudio::class, 'programa_id');
    }

    public function semestres()
    {
        return $this->hasMany(ProgramaSemestreMalla::class, 'modulo_malla_id');
    }
}
