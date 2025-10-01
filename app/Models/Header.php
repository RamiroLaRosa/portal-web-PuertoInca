<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Header extends Model
{
    use SoftDeletes;

    protected $table = 'header';

    protected $fillable = ['nombre', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];
}
