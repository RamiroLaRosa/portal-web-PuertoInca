<?php

// app/Models/Permiso.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permiso extends Model
{
    use SoftDeletes;

    protected $table = 'permisos';
    protected $primaryKey = 'id';
    protected $fillable = ['id_rol', 'id_modulo','is_active'];

    // Si tu columna es delete_at (no "deleted_at"), agrega esto:
    // const DELETED_AT = 'delete_at';
    public function rol()
    {
        return $this->belongsTo(Role::class, 'id_rol');
    }

    public function modulo()
    {
        return $this->belongsTo(Modulo::class, 'id_modulo');
    }
}
