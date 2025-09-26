<?php

// app/Http/Controllers/Admin/ProgramasSeccionController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramasEstudio;

class ProgramasSeccionController extends Controller
{
    public function index()
    {
        // La vista puede cargar el combo por AJAX, así que no es obligatorio pasar datos aquí.
        return view('admin.programas_estudios.gestionar_secciones.index');
    }

    public function listarEstudios()
    {
        $data = ProgramasEstudio::activos()
            ->select('id','nombre')
            ->orderBy('nombre')
            ->get();

        return response()->json($data);
    }
}
