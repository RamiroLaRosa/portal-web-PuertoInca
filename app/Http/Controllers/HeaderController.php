<?php

namespace App\Http\Controllers;

use App\Models\Header;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HeaderController extends Controller
{
    public function index()
    {
        $headers = Header::orderBy('id')->paginate(15);
        return view('admin.seguridad.modulos.index', compact('headers'));
    }

    public function show(Header $header)
    {
        return response()->json([
            'id'        => $header->id,
            'nombre'    => $header->nombre,
            'is_active' => (bool) $header->is_active,
        ]);
    }

    public function updateVisibility(Request $request, Header $header)
    {
        $data = $request->validate(['is_active' => ['required','boolean']]);
        $header->is_active = $data['is_active'];
        $header->save();

        // Limpia caché para que el header público refleje el cambio al instante
        Cache::forget('header_vis_map');

        return response()->json([
            'ok'        => true,
            'id'        => $header->id,
            'is_active' => (bool) $header->is_active,
        ]);
    }
}
