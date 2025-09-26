<?php

// app/Models/Inversion.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inversion extends Model
{
    protected $table = 'inversiones';
    protected $fillable = [
        'nombre','descripcion','tipo_inversion_id','documento','imagen','is_active'
    ];
    protected $casts = ['is_active'=>'boolean'];

    public function tipo() {
        return $this->belongsTo(TipoInversion::class,'tipo_inversion_id');
    }
}

