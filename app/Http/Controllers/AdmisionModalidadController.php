<?php

namespace App\Http\Controllers;

use App\Models\AdmisionModalidad;
use Illuminate\Http\Request;

class AdmisionModalidadController extends Controller
{
    public function index()
    {
        // listado ASC como pediste (1 → último)
        $items = AdmisionModalidad::orderBy('id', 'asc')->get();

        // opciones de icono para el combobox (puedes ampliar la lista)
        $iconOptions = [
            ['label' => 'Archivo',           'value' => 'fa-solid fa-file'],
            ['label' => 'Trofeo',            'value' => 'fa-solid fa-trophy'],
            ['label' => 'Usuarios',          'value' => 'fa-solid fa-users'],
            ['label' => 'Birrete',           'value' => 'fa-solid fa-graduation-cap'],
            ['label' => 'Estrella',          'value' => 'fa-solid fa-star'],
            ['label' => 'Medalla',           'value' => 'fa-solid fa-medal'],
            ['label' => 'Libro',             'value' => 'fa-solid fa-book'],
            ['label' => 'Beca',              'value' => 'fa-solid fa-hand-holding-dollar'],
            ['label' => 'Calendario',        'value' => 'fa-solid fa-calendar-days'],
            ['label' => 'Certificado',       'value' => 'fa-solid fa-award'],
            ['label' => 'Reloj',             'value' => 'fa-solid fa-clock'],
            ['label' => 'Escuela',           'value' => 'fa-solid fa-school'],
            ['label' => 'Banderín',          'value' => 'fa-solid fa-flag'],
            ['label' => 'Marco diplomas',    'value' => 'fa-solid fa-certificate'],
            ['label' => 'Insignia',          'value' => 'fa-solid fa-shield'],
        ];

        return view('admin.admision_matricula.admision.modalidades.index', compact('items','iconOptions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'      => ['required', 'string', 'max:200'],
            'descripcion' => ['required', 'string'],
            'icono'       => ['required', 'string', 'max:100'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        AdmisionModalidad::create([
            'titulo'      => $data['titulo'],
            'descripcion' => $data['descripcion'],
            'icono'       => $data['icono'],                 // guarda "fa-solid fa-trophy"
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin-modalidades.index')->with('success','Registro creado.');
    }

    public function update(Request $request, AdmisionModalidad $admision_modalidade)
    {
        $data = $request->validate([
            'titulo'      => ['required', 'string', 'max:200'],
            'descripcion' => ['required', 'string'],
            'icono'       => ['required', 'string', 'max:100'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $admision_modalidade->update([
            'titulo'      => $data['titulo'],
            'descripcion' => $data['descripcion'],
            'icono'       => $data['icono'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin-modalidades.index')->with('success','Registro actualizado.');
    }

    public function destroy(AdmisionModalidad $admision_modalidade)
    {
        $admision_modalidade->delete(); // Soft delete
        return redirect()->route('admin-modalidades.index')->with('success','Registro eliminado.');
    }
}
