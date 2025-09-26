<?php

namespace App\Http\Controllers;

use App\Models\RedSocial;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RedesController extends Controller
{
    /** Lista blanca de clases Font Awesome permitidas (values del select) */
    private function iconWhitelist(): array
    {
        return [
            'fa-brands fa-facebook-f',
            'fa-brands fa-instagram',
            'fa-brands fa-youtube',
            'fa-brands fa-x-twitter',
            'fa-brands fa-linkedin-in',
            'fa-brands fa-whatsapp',
            'fa-brands fa-tiktok',
            'fa-brands fa-telegram',
            'fa-solid fa-globe',
            'fa-solid fa-envelope',
        ];
    }

    public function index()
    {
        $items = RedSocial::orderBy('id')->get();
        return view('admin.contactanos.Redes.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'    => ['required', 'string', 'max:100'],
            'enlace'    => ['required', 'url', 'max:255'],
            'icono'     => ['required', 'string', Rule::in($this->iconWhitelist())],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        RedSocial::create($data);

        return back()->with('success', 'Red social creada correctamente.');
    }

    public function update(Request $request, RedSocial $red)
    {
        $data = $request->validate([
            'nombre'    => ['required', 'string', 'max:100'],
            'enlace'    => ['required', 'url', 'max:255'],
            'icono'     => ['required', 'string', Rule::in($this->iconWhitelist())],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        $red->update($data);

        return back()->with('success', 'Red social actualizada.');
    }

    public function destroy(RedSocial $red)
    {
        $red->delete();
        return back()->with('success', 'Red social eliminada.');
    }
}
