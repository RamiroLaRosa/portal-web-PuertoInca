<?php

namespace App\Http\Controllers;

use App\Models\AdmisionCronograma;
use Illuminate\Http\Request;

class AdmisionCronogramaController extends Controller
{
    public function index()
    {
        $items = AdmisionCronograma::orderBy('id', 'asc')->get();

        $iconOptions = [
            ['label' => 'Calendario',            'value' => 'fa-solid fa-calendar'],
            ['label' => 'Calendario (semana)',   'value' => 'fa-solid fa-calendar-week'],
            ['label' => 'Calendario (día)',      'value' => 'fa-solid fa-calendar-day'],
            ['label' => 'Calendario (días)',     'value' => 'fa-solid fa-calendar-days'],
            ['label' => 'Libro abierto',         'value' => 'fa-solid fa-book-open'],
            ['label' => 'Lista',                 'value' => 'fa-solid fa-list'],
            ['label' => 'Carnet/ID',             'value' => 'fa-solid fa-id-card'],
            ['label' => 'Reloj',                 'value' => 'fa-solid fa-clock'],
            ['label' => 'Megáfono',              'value' => 'fa-solid fa-bullhorn'],
            ['label' => 'Play',                  'value' => 'fa-solid fa-play'],
            ['label' => 'Check',                 'value' => 'fa-solid fa-check'],
        ];

        return view('admin.admision_matricula.admision.cronograma.index', compact('items', 'iconOptions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'      => ['required', 'string', 'max:200'],
            'fecha'       => ['required', 'string', 'max:200'],      // usa string para permitir rangos tipo "15 Ene - 28 Feb"
            'descripcion' => ['required', 'string'],
            'icono'       => ['required', 'string', 'max:100'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        AdmisionCronograma::create([
            'titulo'      => $data['titulo'],
            'fecha'       => $data['fecha'],
            'descripcion' => $data['descripcion'],
            'icono'       => $data['icono'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin-cronograma.index')->with('success', 'Registro creado.');
    }

    public function update(Request $request, AdmisionCronograma $cronograma)
    {
        $data = $request->validate([
            'titulo'      => ['required', 'string', 'max:200'],
            'fecha'       => ['required', 'string', 'max:200'],
            'descripcion' => ['required', 'string'],
            'icono'       => ['required', 'string', 'max:100'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $cronograma->update([
            'titulo'      => $data['titulo'],
            'fecha'       => $data['fecha'],
            'descripcion' => $data['descripcion'],
            'icono'       => $data['icono'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin-cronograma.index')->with('success', 'Registro actualizado.');
    }

    public function destroy(AdmisionCronograma $cronograma)
    {
        $cronograma->delete(); // Soft delete (usa forceDelete() si quieres hard delete)
        return redirect()->route('admin-cronograma.index')->with('success', 'Registro eliminado.');
    }
}
