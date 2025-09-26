<?php

// app/Http/Controllers/GaleriaController.php
namespace App\Http\Controllers;

use App\Models\ProgramasEstudio;

class GaleriaController extends Controller
{
    public function index()
    {
        $programas = ProgramasEstudio::activos()
            ->with([
                'galerias' => fn ($q) => $q->active()->orderByDesc('id') 
            ])
            ->orderBy('id')
            ->get();

        return view('otros.galeria', compact('programas'));
    }
}
