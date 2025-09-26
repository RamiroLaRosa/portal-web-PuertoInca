<?php
// app/Models/Estadistica.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estadistica extends Model
{
    use SoftDeletes;

    protected $table = 'estadistica';
    protected $fillable = [
        'tema_estadistico_id',
        'programa_estudio_id',
        'anio_estadistico_id',
        'cantidad',
        'is_active',
    ];

    public function tema()
    {
        return $this->belongsTo(TemaEstadistico::class, 'tema_estadistico_id');
    }

    public function programa()
    {
        // 👈 Asegúrate de tener este modelo con ese nombre de clase
        return $this->belongsTo(ProgramasEstudio::class, 'programa_estudio_id');
    }

    public function anio()
    {
        return $this->belongsTo(AnioEstadistico::class, 'anio_estadistico_id');
    }
}
