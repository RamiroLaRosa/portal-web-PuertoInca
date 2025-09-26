<?php

// app/Models/InicioBeneficio.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InicioBeneficio extends Model
{
    use SoftDeletes;

    protected $table = 'inicio_beneficios';
    protected $fillable = ['nombre','descripcion','icono','is_active'];
}
