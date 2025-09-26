<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarcoLegal extends Model
{
    protected $table = 'marco_legal';
    public $timestamps = true; // tu tabla tiene created_at / updated_at

    protected $fillable = ['titulo', 'descripcion', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
