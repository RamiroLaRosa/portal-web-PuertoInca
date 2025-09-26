<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PermisosController extends Controller
{
    public function index()
    {
        // $permisos = Permiso::orderBy('id')->get();
        $permisos = Permiso::with(['rol', 'modulo'])
            ->orderBy('id')
            ->get();
        return view('admin.seguridad.permisos.index', compact('permisos'));
    }

    public function update(Request $request, $id)
    {
        $permiso = Permiso::findOrFail($id);

        $new_is_active = $request->input('newpermiso');

        $permiso->is_active = $new_is_active;
        $permiso->save();


        // if ($request->ajax()) {
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Permiso actualizado correctamente',
            //     'permiso' => $permiso,
            //     'redirect' => route('permisos.index'),
            // ]);
        // }

        return redirect()->route('permisos.index')->with('success', 'Permiso actualizado correctamente.');
    }
}
