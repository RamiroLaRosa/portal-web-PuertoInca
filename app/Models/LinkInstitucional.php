<?php

// app/Models/LinkInstitucional.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LinkInstitucional extends Model
{
    use SoftDeletes;

    protected $table = 'links_institucionales';

    protected $fillable = [
        'nombre',
        'enlace',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($q)
    {
        return $q->where('is_active', 1);
    }
}
