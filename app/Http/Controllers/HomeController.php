<?php

// app/Http/Controllers/InicioHeroController.php
namespace App\Http\Controllers;

use App\Models\InicioHero;
use App\Models\InicioServicio;
use App\Models\InicioEstadistica;
use App\Models\ProgramasEstudio;
use App\Models\Noticia;
use App\Models\PlanaJerarquica;
use App\Models\InicioBeneficio;
use App\Models\InicioTestimonio;

class HomeController extends Controller
{
    public function index()
    {
        $hero = InicioHero::where('is_active', 1)->orderByDesc('id')->first();

        $servicios = InicioServicio::where('is_active', 1)
            ->orderBy('id')
            ->get(['nombre', 'descripcion', 'icono']);

        $estadisticas = InicioEstadistica::active()->orderBy('id')->get();

        $programas    = ProgramasEstudio::active()->orderBy('id')->get();

        $noticias = Noticia::active()
            ->orderByDesc('fecha')
            ->orderByDesc('id')
            ->take(3)
            ->get();

        $coordinadores = PlanaJerarquica::active()
            ->orderBy('id')
            ->get(['nombre', 'cargo', 'imagen']);

        $beneficios   = InicioBeneficio::where('is_active', 1)
            ->orderBy('id')->get(['nombre', 'descripcion', 'icono']);

        $testimonios  = InicioTestimonio::active()
            ->orderBy('id')
            ->get(['nombre', 'descripcion', 'imagen', 'puntuacion']);

        return view('welcome', compact(
            'hero',
            'servicios',
            'estadisticas',
            'programas',
            'noticias',
            'coordinadores',
            'beneficios',
            'testimonios'
        ));
    }
}
