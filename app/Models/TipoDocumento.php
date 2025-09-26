<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $table = 'tipo_documentos';

    protected $primaryKey = 'id';
    protected $fillable = ['nombre_corto', 'nombre','is_active'];

    public $timestamps = true;
}
