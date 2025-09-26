<?php

// app/Http/Controllers/LinksInstitucionalesController.php
namespace App\Http\Controllers;

use App\Models\LinkInstitucional;
use Illuminate\Http\Request;

class LinksInstitucionalesController extends Controller
{
    public function index()
    {
        $items = LinkInstitucional::orderBy('id')->get(); // muestra todos (activos y no activos)
        return view('admin.links_institucionales.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'    => ['required','string','max:150'],
            'enlace'    => ['required','url','max:255'],
            'is_active' => ['nullable','boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        LinkInstitucional::create($data);

        return back()->with('success', 'Link institucional creado correctamente.');
    }

    public function update(Request $request, LinkInstitucional $link)
    {
        $data = $request->validate([
            'nombre'    => ['required','string','max:150'],
            'enlace'    => ['required','url','max:255'],
            'is_active' => ['nullable','boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        $link->update($data);

        return back()->with('success', 'Link institucional actualizado.');
    }

    public function destroy(LinkInstitucional $link)
    {
        $link->delete(); // Soft delete
        return back()->with('success', 'Link institucional eliminado.');
    }
}
