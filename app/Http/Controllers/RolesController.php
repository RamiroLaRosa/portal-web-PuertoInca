<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('id')->get();
        return view('admin.seguridad.roles.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:150',
                Rule::unique('roles', 'nombre')->whereNull('delete_at'),
            ],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ]);

        Role::create($validated);

        return redirect()->route('roles.index')->with('success', 'Rol creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:150',
                Rule::unique('roles', 'nombre')
                    ->ignore($role->id)
                    ->whereNull('delete_at'),
            ],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ]);

        $role->update($validated);

        return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete(); // Soft delete: setea delete_at
        return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente.');
    }
}
