<?php

// app/Models/AdmisionDocumento.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdmisionDocumento extends Model
{
    use SoftDeletes;

    protected $table = 'admision_documentos';
    protected $fillable = ['nombre', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function requisitos()
    {
        return $this->hasMany(AdmisionRequisito::class, 'admision_documentos_id');
    }

    public function scopeActivos($q)
    {
        return $q->where('is_active', 1);
    }
}
