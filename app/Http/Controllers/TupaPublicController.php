<?php

namespace App\Http\Controllers;

use App\Models\Tupa;
use Illuminate\Http\Request;

class TupaPublicController extends Controller
{
    public function index(Request $request)
    {
        // Solo activos, orden por id y paginación (15 por página; ajusta a gusto)
        $items = Tupa::where('is_active', true)
            ->orderBy('id')
            ->paginate(15)
            ->withQueryString();

        return view('transparencia.tupa', compact('items'));
    }
}
