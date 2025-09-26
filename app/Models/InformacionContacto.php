<?php
// app/Models/InformacionContacto.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InformacionContacto extends Model
{
    use SoftDeletes;

    protected $table = 'informacion_contacto';

    protected $fillable = [
        'telefono_principal',
        'whatsapp',
        'correo',
        'emergencia',
        'direccion',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
