<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'codigo',
        'apellidos',
        'nombres',
        'correo',
        'celular',
        'rol_id',
        'id_documento',
        'is_active',
        'password',
        'estado',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function getAuthIdentifierName()
    {
        return 'codigo';
    }

    public function rol()
    {
        return $this->belongsTo(Role::class, 'rol_id');
    }

    public function tipo_documento()
    {
        return $this->belongsTo(TipoDocumento::class, 'id_documento');
    }
}