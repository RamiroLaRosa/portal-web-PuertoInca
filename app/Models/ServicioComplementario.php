<?php
// app/Models/ServicioComplementario.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicioComplementario extends Model
{
    use SoftDeletes;

    protected $table = 'servicios_complementarios';

    protected $fillable = [
        'nombre',        // Ej: "Servicio de Tópico - Atención de Salud Escolar"
        'descripcion',
        'ubicacion',
        'personal',
        'imagen',        // ruta relativa: "./images/archivo.png"
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Helpers para mostrar nombre y subnombre separados (sin cambiar la BD)
    public function getNombreSoloAttribute()
    {
        [$nom] = array_pad(explode(' - ', (string)$this->nombre, 2), 2, '');
        return $nom;
    }

    public function getSubnombreSoloAttribute()
    {
        [, $sub] = array_pad(explode(' - ', (string)$this->nombre, 2), 2, '');
        return $sub;
    }
}
