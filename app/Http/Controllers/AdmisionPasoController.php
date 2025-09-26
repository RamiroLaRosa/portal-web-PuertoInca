<?php
// app/Http/Controllers/AdmisionPasoController.php
namespace App\Http\Controllers;

use App\Models\AdmisionPaso;
use Illuminate\Http\Request;

class AdmisionPasoController extends Controller
{
    /** Opciones de iconos para el combo (label => value) */
    private array $iconOptions = [
        'Usuario +'        => 'fa-solid fa-user-plus',
        'Tarjeta'          => 'fa-solid fa-credit-card',
        'Descargar'        => 'fa-solid fa-download',
        'Libro abierto'    => 'fa-solid fa-book-open',
        'Lista'            => 'fa-solid fa-list',
        'Birrete'          => 'fa-solid fa-graduation-cap',
        'Calendario'       => 'fa-solid fa-calendar',
        'Reloj'            => 'fa-solid fa-clock',
        'Check'            => 'fa-solid fa-check',
    ];

    public function index()
    {
        $items = AdmisionPaso::orderBy('id', 'asc')->get();
        $iconOptions = $this->iconOptions;

        return view('admin.admision_matricula.admision.pasos.index', compact('items','iconOptions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'paso'      => ['required','string','max:200'],
            'icono'     => ['required','string','max:100'],
            'is_active' => ['nullable','boolean'],
        ]);

        AdmisionPaso::create([
            'paso'      => $data['paso'],
            'icono'     => $data['icono'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin-pasos.index')->with('success','Registro creado.');
    }

    public function update(Request $request, AdmisionPaso $paso)
    {
        $data = $request->validate([
            'paso'      => ['required','string','max:200'],
            'icono'     => ['required','string','max:100'],
            'is_active' => ['nullable','boolean'],
        ]);

        $paso->update([
            'paso'      => $data['paso'],
            'icono'     => $data['icono'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin-pasos.index')->with('success','Registro actualizado.');
    }

    public function destroy(AdmisionPaso $paso)
    {
        $paso->delete();
        return redirect()->route('admin-pasos.index')->with('success','Registro eliminado.');
    }
}
