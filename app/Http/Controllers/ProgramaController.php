<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\ProgramasEstudio;

class ProgramaController extends Controller
{
    public function show(?int $programaId = null)
    {
        $base = ProgramasEstudio::activos()
            ->with([
                'info',
                'perfil',
                'coordinadores' => fn($q) => $q->where('is_active', 1)->orderBy('id'),
                'areas'         => fn($q) => $q->where('is_active', 1)->orderBy('id'),
                'egresados'     => fn($q) => $q->where('is_active', 1)->orderBy('id'),
                'modulosMalla'  => fn($q) => $q->active()->orderBy('id'),
                'modulosMalla.semestres' => fn($q) => $q->active()->orderBy('id'),
                'modulosMalla.semestres.cursos' => fn($q) => $q->active()->orderBy('id'),
                'convenios'     => fn($q) => $q->active()->orderBy('id'),
                'galerias'      => fn($q) => $q->active()->latest('id')->take(6),
            ])
            ->orderBy('id');

        $programa = $programaId ? $base->findOrFail($programaId) : $base->firstOrFail();

        return view('programas.programas_estudio', compact('programa'));
    }

    public function mallaPdf(int $programaId)
    {
        $programa = ProgramasEstudio::activos()
            ->with([
                'info',
                'modulosMalla'  => fn($q) => $q->active()->orderBy('id'),
                'modulosMalla.semestres' => fn($q) => $q->active()->orderBy('id'),
                'modulosMalla.semestres.cursos' => fn($q) => $q->active()->orderBy('id'),
            ])->findOrFail($programaId);

        $semestres = collect();
        foreach ($programa->modulosMalla ?? [] as $mod) {
            foreach ($mod->semestres ?? [] as $sem) $semestres->push($sem);
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('programas.pdf.malla', compact('programa', 'semestres'))
            ->setPaper('a4', 'portrait');

        // ✅ construir nombre correctamente
        $slug = $programa->slug ?? \Illuminate\Support\Str::slug($programa->nombre);
        $filename = "Malla_{$slug}.pdf";

        return $pdf->download($filename);
    }
}
