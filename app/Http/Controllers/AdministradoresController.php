<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\TipoDocumento;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdministradoresController extends Controller
{
    public function index()
    {
        // $administradores = Usuario::orderBy('id')->get();
        $administradores = Usuario::with(['rol', 'tipo_documento'])
            ->orderBy('id')
            ->get();

        $roles = Role::orderBy('id')->get();
        $tipos_documentos = TipoDocumento::orderBy('id')->get();

        return view('admin.seguridad.administradores.index', compact('administradores', 'roles', 'tipos_documentos'));
    }

    // AGREGAR PASSWORD FALTA
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => ['string', 'max:255'],
            'apellidos' => ['string', 'max:255'],
            'nombres' => ['string', 'max:255'],
            'correo' => ['string', 'max:255'],
            'celular' => ['string', 'max:255'],
            'rol_id' => ['required', 'exists:roles,id'],
            'id_documento' => ['required', 'exists:tipo_documentos,id'],
            'is_active' => ['required', 'boolean'],
            'password' => ['required', 'string', 'min:5'],
        ]);

        Usuario::create($validated);

        return redirect()->route('administradores.index')->with('success', 'Administrador creado correctamente.');
    }

    public function updatePassword(Request $request, $id)
    {
        $administrador = Usuario::findOrFail($id);

        $validated = $request->validate([
            'password' => ['required', 'string', 'min:6'],
        ]);

        $administrador->password = $validated['password'];
        $administrador->save();

        return redirect()->route('administradores.index')->with('success', 'Contraseña actualizada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $administrador = Usuario::findOrFail($id);

        $validated = $request->validate([
            'codigo' => ['string', 'max:255'],
            'apellidos' => ['string', 'max:255'],
            'nombres' => ['string', 'max:255'],
            'correo' => ['string', 'max:255'],
            'celular' => ['string', 'max:255'],
            'rol_id' => ['required', 'exists:roles,id'],
            'id_documento' => ['required', 'exists:tipo_documentos,id'],
            'is_active' => ['required', 'boolean'],
        ]);

        $administrador->update($validated);

        return redirect()->route('administradores.index')->with('success', "Administrador actualizado correctamente.");
    }

    public function destroy($id)
    {
        $administrador = Usuario::findOrFail($id);
        $administrador->delete(); // Soft delete: setea delete_at
        return redirect()->route('administradores.index')->with('success', 'Administrador eliminado correctamente.');
    }
}
