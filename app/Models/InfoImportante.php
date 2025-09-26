<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoImportante extends Model
{
    protected $table = 'info_importante';
    public $timestamps = false; // activa si tu tabla tiene created_at/updated_at

    protected $fillable = [
        'titulo',
        'descripcion',
    ];
}
