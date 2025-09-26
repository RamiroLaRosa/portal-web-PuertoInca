<?php
// app/Models/AdmisionPaso.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdmisionPaso extends Model
{
    use SoftDeletes;

    protected $table = 'admision_pasos';

    protected $fillable = [
        'paso',       // texto del paso (ej. "Paso 1: Inscripción")
        'icono',      // clase fontawesome (ej. "fa-solid fa-user-plus")
        'is_active',  // tinyint/bool
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function procesos()
    {
        return $this->hasMany(AdmisionProceso::class, 'admision_paso_id');
    }
}
