<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdmisionProceso extends Model
{
    use SoftDeletes;

    protected $table = 'admision_proceso';

    protected $fillable = [
        'admision_paso_id',
        'descripcion',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function paso()
    {
        return $this->belongsTo(\App\Models\AdmisionPaso::class, 'admision_paso_id');
    }
}
