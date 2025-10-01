<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Logo extends Model
{
    use SoftDeletes;

    protected $table = 'logo'; // la tabla ya existe con nombre singular
    protected $fillable = ['imagen', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    // Alias para compatibilidad con la vista (usa $record->foto)
    public function getFotoAttribute(): ?string
    {
        return $this->imagen;
    }
}
