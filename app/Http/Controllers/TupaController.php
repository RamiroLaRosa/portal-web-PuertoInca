<?php
// app/Http/Controllers/TupaController.php
namespace App\Http\Controllers;

use App\Models\Tupa;
use Illuminate\Http\Request;

class TupaController extends Controller
{
    public function index()
    {
        $items = Tupa::orderBy('id')->get();

        return view('admin.transparencia.tupa.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'concepto'  => ['required','string','max:255'],
            'monto'     => ['required','numeric','min:0','max:999999.99'],
            'is_active' => ['nullable','boolean'],
        ]);

        Tupa::create([
            'concepto'  => $data['concepto'],
            'monto'     => $data['monto'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('tupa.index')->with('success', 'Registro creado.');
    }

    public function update(Request $request, Tupa $tupa)
    {
        $data = $request->validate([
            'concepto'  => ['required','string','max:255'],
            'monto'     => ['required','numeric','min:0','max:999999.99'],
            'is_active' => ['nullable','boolean'],
        ]);

        $tupa->update([
            'concepto'  => $data['concepto'],
            'monto'     => $data['monto'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('tupa.index')->with('success', 'Registro actualizado.');
    }

    public function destroy(Tupa $tupa)
    {
        $tupa->delete(); // Soft delete
        return redirect()->route('tupa.index')->with('success', 'Registro eliminado.');
    }
}
