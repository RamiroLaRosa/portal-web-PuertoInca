<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reclamo extends Model
{
    protected $table = 'reclamos';
    public $timestamps = true;

    protected $fillable = [
        'nombres',
        'apellidos',
        'tipo_documento_id',
        'numero_documento',
        'telefono',
        'email',
        'tipo_reclamacion_id',
        'area_relacionada',
        'fecha_incidente',
        'asunto',
        'descripcion',
        'estado_id',
        'is_active',
        'codigo',
        'respuesta',
        'documento_respuesta',
        'fecha_respuesta'
    ];

    // Exponer URLs útiles al frontend
    protected $appends = ['documento_url', 'documento_ver_url'];

    // Si existe symlink /storage, esta URL funcionará; si no, usa documento_ver_url
    public function getDocumentoUrlAttribute()
    {
        return $this->documento_respuesta
            ? asset('storage/' . ltrim($this->documento_respuesta, '/'))
            : null;
    }

    // Ruta que SIEMPRE funciona (render inline por controlador)
    public function getDocumentoVerUrlAttribute()
    {
        return $this->documento_respuesta
            ? route('reclamos.respuesta.view', ['reclamo' => $this->id])
            : null;
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id');
    }
    public function tipoReclamacion()
    {
        return $this->belongsTo(TipoReclamacion::class, 'tipo_reclamacion_id');
    }
    public function estado()
    {
        return $this->belongsTo(EstadoReclamo::class, 'estado_id');
    }
}
