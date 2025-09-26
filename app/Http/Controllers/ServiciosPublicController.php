<?php
// app/Http/Controllers/ServiciosPublicController.php

namespace App\Http\Controllers;

use App\Models\ServicioComplementario;
use App\Models\HorarioAtencion;

class ServiciosPublicController extends Controller
{
    public function index()
    {
        // Servicios activos (para las tarjetas)
        $servicios = ServicioComplementario::where('is_active', 1)
            ->orderBy('id')
            ->get();

        // Horarios activos (para la tabla)
        $horarios = HorarioAtencion::with(['servicio:id,nombre'])
            ->where('is_active', 1)
            ->orderBy('servicio_complementario_id')
            ->orderBy('id')
            ->get();

        return view('servicios.servicios_complementarios', compact('servicios', 'horarios'));
    }
}
