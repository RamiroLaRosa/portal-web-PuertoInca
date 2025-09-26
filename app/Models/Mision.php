<?php

// app/Models/Mision.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mision extends Model {
    use SoftDeletes;
    protected $table = 'mision';
    protected $fillable = ['descripcion'];
}
