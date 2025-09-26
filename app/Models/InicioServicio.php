<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InicioServicio extends Model
{
    use SoftDeletes;

    protected $table = 'inicio_servicios';
    protected $fillable = ['nombre', 'descripcion', 'icono', 'is_active'];
}
