<?php
// app/Models/Color.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'colores';
    protected $fillable = ['clave', 'valor'];
    public $timestamps = true;
}