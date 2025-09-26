<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BecaProceso extends Model
{
    use SoftDeletes;

    protected $table = 'becas_proceso';

    protected $fillable = [
        'nro_paso',
        'titulo',
        'descripcion',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'nro_paso'  => 'integer',
    ];
}
