<?php

// app/Models/TipoInversion.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoInversion extends Model
{
    use SoftDeletes;

    // Tu tabla real
    protected $table = 'tipo_inversiones';

    protected $fillable = [
        'nombre',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /** Relación inversa (opcional) */
    public function inversiones()
    {
        return $this->hasMany(\App\Models\Inversion::class, 'tipo_inversion_id');
    }
}
