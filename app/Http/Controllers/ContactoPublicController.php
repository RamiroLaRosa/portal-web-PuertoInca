<?php

namespace App\Http\Controllers;

use App\Models\InformacionContacto;
use App\Models\RedSocial;

class ContactoPublicController extends Controller
{
    public function index()
    {
        // Un solo registro activo con los datos de contacto
        $info = InformacionContacto::where('is_active', 1)
            ->orderByDesc('id')
            ->first();

        // Redes activas con nombre, enlace e icono FA
        $redes = RedSocial::where('is_active', 1)
            ->orderBy('id')
            ->get(['nombre','enlace','icono']);

        return view('contacto.contactanos', compact('info','redes'));
    }
}
