<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramasEstudio;
use App\Models\ProgramasPerfil;
use Illuminate\Http\Request;

class ProgramasPerfilController extends Controller
{
    // GET: devolver perfil del programa (si existe)
    public function show($programaId)
    {
        $programa = ProgramasEstudio::findOrFail($programaId);

        $perfil = ProgramasPerfil::where('programa_id', $programa->id)
            ->where('is_active', 1)
            ->first();

        return response()->json([
            'programa' => ['id' => $programa->id, 'nombre' => $programa->nombre],
            'perfil'   => $perfil ? [
                'id'          => $perfil->id,
                'descripcion' => $perfil->descripcion,
            ] : null,
        ]);
    }

    // POST: crear/actualizar perfil del programa
    public function save(Request $request, $programaId)
    {
        $programa = ProgramasEstudio::findOrFail($programaId);

        $data = $request->validate([
            'descripcion' => ['required','string'],
        ]);

        $perfil = ProgramasPerfil::firstOrNew(['programa_id' => $programa->id]);
        $perfil->descripcion = $data['descripcion'];
        $perfil->is_active   = 1;
        $perfil->save();

        return response()->json([
            'ok'     => true,
            'perfil' => [
                'id'          => $perfil->id,
                'descripcion' => $perfil->descripcion,
            ],
        ]);
    }
}
