<?php

// app/Models/Role.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre', 'descripcion'];

    // Si tu columna es delete_at (no "deleted_at"), agrega esto:
    const DELETED_AT = 'delete_at';
}
