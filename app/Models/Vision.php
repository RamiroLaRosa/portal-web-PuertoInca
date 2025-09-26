<?php

// app/Models/Vision.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vision extends Model {
    use SoftDeletes;
    protected $table = 'vision';
    protected $fillable = ['descripcion'];
}
