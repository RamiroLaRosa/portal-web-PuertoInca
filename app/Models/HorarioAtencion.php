<?php
// app/Models/HorarioAtencion.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HorarioAtencion extends Model
{
    use SoftDeletes;

    protected $table = 'horario_atencion';

    protected $fillable = [
        'servicio_complementario_id',
        'lunes_viernes',
        'sabados',
        'domingos',
        'contacto',
        'is_active',
    ];

    public function servicio()
    {
        return $this->belongsTo(ServicioComplementario::class, 'servicio_complementario_id');
    }
}
