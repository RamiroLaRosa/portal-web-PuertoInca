<?php
// app/Http/Controllers/ServiciosComplementariosController.php
namespace App\Http\Controllers;

use App\Models\ServicioComplementario;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiciosComplementariosController extends Controller
{
    public function index()
    {
        $items = ServicioComplementario::orderBy('id')->get();
        return view('admin.servicios_complementario.gestionar.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'      => ['required','string','max:200'],    // parte izquierda
            'subnombre'   => ['nullable','string','max:200'],    // parte derecha (opcional)
            'descripcion' => ['required','string'],
            'ubicacion'   => ['nullable','string','max:255'],
            'personal'    => ['nullable','string','max:255'],
            'imagen'      => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'is_active'   => ['nullable','boolean'],
        ]);

        $fullName = trim($data['nombre'] . (empty($data['subnombre']) ? '' : ' - ' . $data['subnombre']));

        $path = './images/no-photo.jpg';
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = 'SERV_IMG_' . Str::random(10) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $path = './images/' . $filename; // guardamos relativo a public/
        }

        ServicioComplementario::create([
            'nombre'      => $fullName,
            'descripcion' => $data['descripcion'],
            'ubicacion'   => $data['ubicacion'] ?? '',
            'personal'    => $data['personal'] ?? '',
            'imagen'      => $path,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('servicios.index')->with('success', 'Servicio registrado correctamente.');
    }

    public function update(Request $request, ServicioComplementario $servicio)
    {
        $data = $request->validate([
            'nombre'      => ['required','string','max:200'],
            'subnombre'   => ['nullable','string','max:200'],
            'descripcion' => ['required','string'],
            'ubicacion'   => ['nullable','string','max:255'],
            'personal'    => ['nullable','string','max:255'],
            'imagen'      => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'is_active'   => ['nullable','boolean'],
        ]);

        $fullName = trim($data['nombre'] . (empty($data['subnombre']) ? '' : ' - ' . $data['subnombre']));

        $servicio->nombre      = $fullName;
        $servicio->descripcion = $data['descripcion'];
        $servicio->ubicacion   = $data['ubicacion'] ?? '';
        $servicio->personal    = $data['personal'] ?? '';
        $servicio->is_active   = $request->boolean('is_active', true);

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = 'SERV_IMG_' . Str::random(10) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $servicio->imagen = './images/' . $filename;
        }

        $servicio->save();

        return redirect()->route('servicios.index')->with('success', 'Servicio actualizado correctamente.');
    }

    public function destroy(ServicioComplementario $servicio)
    {
        $servicio->delete();
        return redirect()->route('servicios.index')->with('success', 'Servicio eliminado.');
    }
}
