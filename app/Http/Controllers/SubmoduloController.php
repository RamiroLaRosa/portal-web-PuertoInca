<?php

namespace App\Http\Controllers;

use App\Models\Submodulo;
use App\Models\Header;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SubmoduloController extends Controller
{
    public function index(Request $request)
    {
        $submodulos = \App\Models\Submodulo::with('header:id,nombre')
            ->orderBy('header_id')
            ->orderBy('id')
            ->get(); 

        $modulos = \App\Models\Header::orderBy('nombre')->get(['id', 'nombre']);

        return view('admin.seguridad.submodulos.index', compact('submodulos', 'modulos'));
    }

    public function show(Submodulo $submodulo)
    {
        $submodulo->load('header:id,nombre');
        return response()->json([
            'id'        => $submodulo->id,
            'nombre'    => $submodulo->nombre,
            'is_active' => (bool) $submodulo->is_active,
            'header'    => $submodulo->header?->nombre,
            'header_id' => $submodulo->header_id,
        ]);
    }

    public function updateVisibility(Request $request, Submodulo $submodulo)
    {
        $data = $request->validate([
            'is_active' => ['required', 'boolean'],
        ]);

        $submodulo->is_active = $data['is_active'];
        $submodulo->save();

        // Limpiar caché usada por los helpers del header público
        Cache::forget('header_subs_vis_map');

        return response()->json([
            'ok'        => true,
            'id'        => $submodulo->id,
            'is_active' => (bool) $submodulo->is_active,
        ]);
    }
}
