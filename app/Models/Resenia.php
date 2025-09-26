<?php

// app/Models/Resenia.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resenia extends Model
{
    use SoftDeletes;

    protected $table = 'resenia'; // tu tabla
    protected $fillable = ['titulo', 'descripcion', 'imagen', 'is_active'];
}
