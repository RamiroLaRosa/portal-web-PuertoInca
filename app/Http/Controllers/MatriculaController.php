<?php

namespace App\Http\Controllers;

use App\Models\MatriculaTipo;
use App\Models\MatriculaRequisito;
use App\Models\MatriculaPaso;
use App\Models\MatriculaCronograma;

class MatriculaController extends Controller
{
    public function index()
    {
        // Tipos activos ordenados por id
        $tipos = MatriculaTipo::where('is_active', 1)
            ->orderBy('id')
            ->get(['id', 'titulo', 'descripcion', 'icono']);

        // Requisitos + sus detalles (solo activos), en el orden de la BD
        $requisitos = MatriculaRequisito::where('is_active', 1)
            ->with(['detalles' => fn($q) => $q->where('is_active', 1)->orderBy('id')])
            ->orderBy('id')
            ->get();

        // 👇 NUEVO: pasos del proceso
        $pasos = MatriculaPaso::where('is_active', 1)
            ->orderBy('numero_paso')
            ->get();

        $cronograma = MatriculaCronograma::where('is_active', 1)
            ->orderBy('id')
            ->get(['titulo', 'fecha', 'descripcion', 'icono']);

        return view('admision.matricula', compact('tipos', 'requisitos', 'pasos', 'cronograma'));
    }
}
