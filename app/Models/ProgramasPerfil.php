<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramasPerfil extends Model
{
    protected $table = 'programa_perfil';

    protected $fillable = [
        'programa_id',
        'descripcion',
        'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive($q)
    {
        return $q->where('is_active', 1);
    }
}
