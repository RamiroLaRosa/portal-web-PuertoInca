<?php
// app/Http/Controllers/ContactanosController.php
namespace App\Http\Controllers;

use App\Models\InformacionContacto;
use Illuminate\Http\Request;

class ContactanosController extends Controller
{
    public function index()
    {
        $items = InformacionContacto::orderBy('id')->get();
        return view('admin.contactanos.informacion.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'telefono_principal' => ['required','string','max:50'],
            'whatsapp'           => ['required','string','max:50'],
            'correo'             => ['required','email','max:120'],
            'emergencia'         => ['required','string','max:50'],
            'direccion'          => ['required','string','max:255'],
            'is_active'          => ['nullable','boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        InformacionContacto::create($data);

        return back()->with('success', 'Contacto creado correctamente.');
    }

    public function update(Request $request, InformacionContacto $contacto)
    {
        $data = $request->validate([
            'telefono_principal' => ['required','string','max:50'],
            'whatsapp'           => ['required','string','max:50'],
            'correo'             => ['required','email','max:120'],
            'emergencia'         => ['required','string','max:50'],
            'direccion'          => ['required','string','max:255'],
            'is_active'          => ['nullable','boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        $contacto->update($data);

        return back()->with('success', 'Contacto actualizado.');
    }

    public function destroy(InformacionContacto $contacto)
    {
        $contacto->delete();
        return back()->with('success', 'Contacto eliminado.');
    }
}
