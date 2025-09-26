<?php

namespace App\Http\Controllers;

use App\Models\PlanaDocente;
use App\Models\ProgramasEstudio;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DocenteController extends Controller
{
    // Página principal: carga combo de programas
    public function index()
    {
        $programas = ProgramasEstudio::activos()
            ->orderBy('nombre')
            ->get(['id', 'nombre']);

        return view('admin.nosotros.docente.gestion.index', compact('programas'));
    }

    // Lista docentes por programa (JSON)
    public function list(Request $request)
    {
        $programaId = (int) $request->query('programa', 0);
        if ($programaId <= 0) {
            return response()->json(['data' => []]);
        }

        $data = PlanaDocente::where('programa_estudio_id', $programaId)
            ->orderBy('id')
            ->get(['id', 'programa_estudio_id', 'nombre', 'cargo', 'correo', 'foto']);

        $data->transform(function ($d) {
            $d->foto_url = $this->assetFromDb($d->foto);
            return $d;
        });

        return response()->json(['data' => $data]);
    }

    // Obtener un docente por ID (para el modal de edición)
    public function show($id)
    {
        $d = PlanaDocente::findOrFail($id);
        $d->foto_url = $this->assetFromDb($d->foto);

        return response()->json($d);
    }

    // Crear nuevo docente (desde modal "Nuevo registro")
    public function store(Request $request)
    {
        $validated = $request->validate([
            'programa_estudio_id' => 'required|exists:programas_estudios,id',
            'nombre'              => 'required|string|max:255',
            'cargo'               => 'required|string|max:255',
            'correo'              => 'required|email|max:255',
            'foto'                => 'nullable|image|max:2048',
        ]);

        $path = $this->handleUpload($request);

        $doc = PlanaDocente::create([
            'programa_estudio_id' => $validated['programa_estudio_id'],
            'nombre'              => $validated['nombre'],
            'cargo'               => $validated['cargo'],
            'correo'              => $validated['correo'],
            'foto'                => $path ?: ($request->input('foto') ?? '/images/no-photo.jpg'),
            'is_active'           => 1, // por defecto activo (no se pide en el form)
        ]);

        $doc->foto_url = $this->assetFromDb($doc->foto);

        return response()->json(['ok' => true, 'docente' => $doc]);
    }

    // Actualizar docente por ID (desde modal de edición)
    public function update(Request $request, $id)
    {
        $doc = PlanaDocente::findOrFail($id);

        $validated = $request->validate([
            'programa_estudio_id' => 'required|exists:programas_estudios,id',
            'nombre'              => 'required|string|max:255',
            'cargo'               => 'required|string|max:255',
            'correo'              => 'required|email|max:255',
            'foto'                => 'nullable|image|max:2048',
        ]);

        $path = $this->handleUpload($request) ?: $doc->foto;

        $doc->update([
            'programa_estudio_id' => $validated['programa_estudio_id'],
            'nombre'              => $validated['nombre'],
            'cargo'               => $validated['cargo'],
            'correo'              => $validated['correo'],
            'foto'                => $path,
        ]);

        $doc->foto_url = $this->assetFromDb($doc->foto);

        return response()->json(['ok' => true, 'docente' => $doc]);
    }

    // (Opcional) Eliminar docente
    public function destroy($id)
    {
        $doc = PlanaDocente::findOrFail($id);
        $doc->delete();
        return response()->json(['ok' => true]);
    }

    /* ================= Helpers ================= */

    private function handleUpload(Request $request): ?string
    {
        if (!$request->hasFile('foto')) {
            return null;
        }

        $file = $request->file('foto');
        $name = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
            . '.' . $file->extension();

        // Guarda en /public/images/docentes
        $file->move(public_path('images/docentes'), $name);

        // Lo que va a BD (coincide con asset())
        return '/images/docentes/' . $name;
    }

    private function assetFromDb(?string $path): string
    {
        if (!$path) {
            return asset('images/no-photo.jpg');
        }
        $p = trim($path);

        // Si viene absoluta o con slash inicial, normaliza contra asset()
        if (Str::startsWith($p, ['http://', 'https://', '/'])) {
            return asset(ltrim($p, '/'));
        }

        // Casos como "./images/no-photo.jpg"
        $p = ltrim($p, './');
        return asset($p);
    }
}
