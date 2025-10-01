<?php

namespace App\Http\Controllers;

use App\Models\Local;

class LocalPublicController extends Controller
{
    public function index()
    {
        // Trae SOLO locales activos ordenados por id asc
        $activos = Local::where('is_active', true)
            ->orderBy('id')
            ->get();

        $principal    = $activos->first();     // ← 1ra fila = sede principal
        $secundarias  = $activos->skip(1);     // ← resto = cards

        return view('nosotros.locales', compact('principal', 'secundarias'));
    }
}
