<?php
// app/Http/Controllers/HorarioController.php
namespace App\Http\Controllers;

use App\Models\HorarioAtencion;
use App\Models\ServicioComplementario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index()
    {
        $items = HorarioAtencion::with(['servicio:id,nombre'])
            ->orderBy('id')
            ->get();

        $servicios = ServicioComplementario::where('is_active', 1)
            ->orderBy('nombre')
            ->get(['id','nombre']);

        return view('admin.servicios_complementario.horarios.index', compact('items','servicios'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'servicio_complementario_id' => ['required','integer','exists:servicios_complementarios,id'],
            'lunes_viernes'              => ['required','string','max:100'],
            'sabados'                    => ['required','string','max:100'],
            'domingos'                   => ['required','string','max:100'],
            'contacto'                   => ['nullable','string','max:100'],
            'is_active'                  => ['nullable','boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        HorarioAtencion::create($data);

        return back()->with('success', 'Horario creado correctamente.');
    }

    public function update(Request $request, HorarioAtencion $horario)
    {
        $data = $request->validate([
            'servicio_complementario_id' => ['required','integer','exists:servicios_complementarios,id'],
            'lunes_viernes'              => ['required','string','max:100'],
            'sabados'                    => ['required','string','max:100'],
            'domingos'                   => ['required','string','max:100'],
            'contacto'                   => ['nullable','string','max:100'],
            'is_active'                  => ['nullable','boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        $horario->update($data);

        return back()->with('success', 'Horario actualizado.');
    }

    public function destroy(HorarioAtencion $horario)
    {
        $horario->delete();
        return back()->with('success', 'Horario eliminado.');
    }
}
