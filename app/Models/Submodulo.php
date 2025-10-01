<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Submodulo extends Model
{
    use SoftDeletes;

    protected $table = 'submodulos';

    protected $fillable = [
        'header_id',
        'nombre',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function header()
    {
        return $this->belongsTo(\App\Models\Header::class, 'header_id');
    }
}
