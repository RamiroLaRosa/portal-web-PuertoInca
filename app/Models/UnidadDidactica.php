<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnidadDidactica extends Model
{
    protected $table = 'unidades_didacticas';

    public function docente()
    {
        return $this->belongsTo(PlanaDocente::class, 'plana_docente_id');
    }

    public function curso()
    {
        return $this->belongsTo(ProgramaCursoMalla::class, 'programa_curso_id');
    }
}
