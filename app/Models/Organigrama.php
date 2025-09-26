<?php

// app/Models/Organigrama.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organigrama extends Model
{
    protected $table = 'organigrama';
    protected $fillable = ['documento', 'is_active'];
    public $timestamps = true;
}
