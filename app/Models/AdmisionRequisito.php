<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdmisionRequisito extends Model
{
    use SoftDeletes;

    protected $table = 'admision_requisitos';

    protected $fillable = [
        'admision_documentos_id', // FK a admision_documentos
        'titulo',
        'descripcion',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function documento()
    {
        return $this->belongsTo(AdmisionDocumento::class, 'admision_documentos_id');
    }

    public function scopeActivos($q)
    {
        return $q->where('is_active', 1);
    }

}
