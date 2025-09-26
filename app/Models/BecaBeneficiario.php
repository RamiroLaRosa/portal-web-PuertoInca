<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BecaBeneficiario extends Model
{
    use SoftDeletes;

    protected $table = 'becas_beneficiario';

    protected $fillable = [
        'programa_id',
        'tipo_beca_id',
        'nombre',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relaciones
    public function programa()
    {
        return $this->belongsTo(\App\Models\ProgramasEstudio::class, 'programa_id');
    }

    public function tipo()
    {
        return $this->belongsTo(\App\Models\BecaTipo::class, 'tipo_beca_id');
    }

    public function scopeActivos($q)
    {
        return $q->where('is_active', 1);
    }
}
