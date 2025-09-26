<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Licenciamiento extends Model
{
    use SoftDeletes;

    protected $table = 'licenciamiento';

    protected $fillable = [
        'nombre',
        'descripcion',
        'documento',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
