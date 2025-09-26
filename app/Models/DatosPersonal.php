<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatosPersonal extends Model
{
    protected $table = 'datos_personales';
    protected $fillable = ['docente_id','nombres','apellidos','correo','telefono','is_active'];

    public function docente()
    {
        return $this->belongsTo(PlanaDocente::class, 'docente_id');
    }
}
