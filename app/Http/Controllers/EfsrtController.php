<?php

// app/Http/Controllers/EfsrtController.php
namespace App\Http\Controllers;

use App\Models\ProgramasEstudio;

class EfsrtController extends Controller
{
    public function index()
    {
        $programas = ProgramasEstudio::activos()
            ->with(['convenios' => fn($q) => $q->active()->orderBy('id')])
            ->orderBy('id')
            ->get();

        return view('programas.efsrt', compact('programas'));
    }
}
