<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramaInformacion extends Model
{
    use HasFactory;

    protected $table = 'programa_informacion';

    protected $fillable = [
        'programa_id',
        'duracion',
        'modalidad',
        'turno',
        'horario',
        'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function programaEstudio()
    {
        return $this->belongsTo(ProgramasEstudio::class, 'programa_id');
    }

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public $timestamps = true;
}
