<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MatriculaRequisito extends Model
{
    use SoftDeletes;

    protected $table = 'matricula_requisitos';

    protected $fillable = ['titulo', 'icono', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    // Scope para combos
    public function scopeActivos($q)
    {
        return $q->where('is_active', 1);
    }

    public function detalles()
    {
        return $this->hasMany(MatriculaDetalleRequisito::class, 'matricula_requisitos_id');
    }
}
