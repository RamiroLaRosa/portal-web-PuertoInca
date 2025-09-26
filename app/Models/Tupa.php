<?php
// app/Models/Tupa.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tupa extends Model
{
    use SoftDeletes;

    protected $table = 'tupa';

    protected $fillable = [
        'concepto',
        'monto',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'monto'     => 'decimal:2',
    ];
}
