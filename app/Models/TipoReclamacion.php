<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoReclamacion extends Model
{
    protected $table = 'tipo_reclamacion';
    public $timestamps = true;

    protected $fillable = ['nombre', 'descripcion'];
}
