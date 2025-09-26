<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modulo extends Model
{
    use SoftDeletes;

    protected $table = 'modulos';
    protected $primaryKey = 'id';
    protected $fillable = ['short_name','nombre', 'is_active'];

    // Si tu columna es delete_at (no "deleted_at"), agrega esto:
    // const DELETED_AT = 'delete_at';
}
