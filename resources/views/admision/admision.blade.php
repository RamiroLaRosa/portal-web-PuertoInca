<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admisión - Silfer Academia</title>
    @vite('resources/css/css_colores_administrables/css_colores_administrables.css')
    <!-- Variables administrables -->
    <link rel="stylesheet" href="{{ asset('css/css_colores_administrables/css_colores_administrables.css') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            navy: "var(--color-primario-p1)",
                            blue: "var(--color-primario-p2)",
                            sky: "var(--color-primario-p3)",
                            orange: "var(--color-secundario-s1)",
                            gray: "var(--color-neutral)",
                        }
                    }
                }
            }
        }
    </script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="stylesheet" href="/css/web/admision.css">
</head>

<body class="min-h-screen bg-brand-gray text-brand-navy font-sans scroll-smooth"
    style="color: var(--color-primario-p1);">
    <!-- Navegación lateral -->
    <div class="fixed top-0 left-0 h-full w-20 bg-brand-navy text-white z-50 hidden md:flex flex-col items-center py-8"
        style="background-color: var(--color-primario-p1); color: #ffffff;">
        <div class="mb-12">
            <div class="bg-brand-orange text-white p-2 rounded-full"
                style="background-color: var(--color-secundario-s1); color: #ffffff;">
                <i data-lucide="graduation-cap" class="h-6 w-6"></i>
            </div>
        </div>

        <nav class="flex flex-col items-center space-y-8 flex-grow" id="sidebar-nav">
            <button onclick="scrollToSection('resultados')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-brand-blue/70 rounded-full"
                data-section="resultados" title="Resultados">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('modalidades')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-brand-blue/70 rounded-full"
                data-section="modalidades" title="Modalidades">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('requisitos')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-brand-blue/70 rounded-full"
                data-section="requisitos" title="Requisitos">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('cronograma')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-brand-blue/70 rounded-full"
                data-section="cronograma" title="Cronograma">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('costos')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-brand-blue/70 rounded-full"
                data-section="costos" title="Costos">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('exonerados')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-brand-blue/70 rounded-full"
                data-section="exonerados" title="Exonerados">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('vacantes')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-brand-blue/70 rounded-full"
                data-section="vacantes" title="Vacantes">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('proceso')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-brand-blue/70 rounded-full"
                data-section="proceso" title="Proceso">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
        </nav>
    </div>

    @include('header')

    <main class="md:pl-20 pt-16">
        <!-- HERO -->
        <section class="py-20 relative overflow-hidden">
            <div class="absolute inset-0 z-0">
                <div class="absolute top-0 left-0 w-full h-full"
                    style="background-image: linear-gradient(
                         to bottom right,
                         color-mix(in srgb, var(--color-secundario-s1) 10%, transparent),
                         color-mix(in srgb, var(--color-primario-p3) 10%, transparent)
                     );">
                </div>
                <div class="floating-element absolute top-1/4 right-1/4 w-64 h-64 rounded-full"
                    style="background-color: color-mix(in srgb, var(--color-secundario-s1) 20%, transparent);">
                </div>
                <div class="floating-element absolute bottom-1/3 left-1/3 w-80 h-80 rounded-full"
                    style="background-color: color-mix(in srgb, var(--color-primario-p3) 20%, transparent); animation-delay:-3s;">
                </div>
                <div class="floating-element absolute top-1/2 right-1/3 w-32 h-32 rounded-full"
                    style="background-color: color-mix(in srgb, var(--color-primario-p2) 30%, transparent); animation-delay:-1.5s;">
                </div>
            </div>
            <div class="container mx-auto px-4 md:px-12 z-10 relative text-center">
                <h1 class="text-5xl md:text-7xl font-bold leading-tight mb-6">
                    Proceso de<span class="gradient-text"> Admisión</span>
                </h1>
                <p class="text-xl text-brand-navy/70 max-w-4xl mx-auto mb-8"
                    style="color: var(--color-primario-p1); opacity:.7;">
                    Infórmate sobre los requisitos, etapas y fechas clave para ser parte de nuestra comunidad educativa.
                </p>
            </div>
        </section>

        <!-- Resultados de Admisión -->
        <section id="resultados" class="py-20 bg-white">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold mt-2 text-brand-navy"
                        style="color: var(--color-primario-p1);">Resultados de Admisión</h2>
                </div>

                <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-brand-orange to-brand-blue text-white p-6"
                        style="background-image: linear-gradient(to right, var(--color-secundario-s1), var(--color-primario-p2)); color:#ffffff;">
                        <h3 class="text-2xl font-bold mb-2">Proceso de Admisión 2025-I</h3>
                        <p class="text-white/90">Resultados publicados el 20 de Marzo de 2025</p>
                    </div>

                    <!-- Tabla Desktop -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-brand-gray">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-brand-navy border-b"
                                        style="color: var(--color-primario-p1);">Programas de Estudios</th>
                                    <th class="px-6 py-4 text-center text-sm font-semibold text-brand-navy border-b"
                                        style="color: var(--color-primario-p1);">Turno Diurno</th>
                                    <th class="px-6 py-4 text-center text-sm font-semibold text-brand-navy border-b"
                                        style="color: var(--color-primario-p1);">Turno Nocturno</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-brand-gray">
                                @foreach ($filas as $row)
                                    <tr class="hover:bg-brand-gray transition-colors">
                                        <td class="px-6 py-4 text-sm font-medium text-brand-navy"
                                            style="color: var(--color-primario-p1);">
                                            {{ $row['p']->nombre }}</td>

                                        {{-- DIURNO --}}
                                        <td class="px-6 py-4 text-center">
                                            @if ($row['diurno'])
                                                <a href="{{ $row['diurno']->documento_url }}" target="_blank"
                                                    rel="noopener"
                                                    class="inline-flex items-center justify-center bg-brand-sky/10 hover:bg-brand-sky/20 p-3 rounded-lg transition-all"
                                                    title="Ver PDF (Diurno)">
                                                    <i data-lucide="file-text" class="h-6 w-6 text-brand-blue"
                                                        style="color: var(--color-primario-p2);"></i>
                                                </a>
                                            @else
                                                <span
                                                    class="inline-flex items-center justify-center p-3 rounded-lg opacity-30 cursor-not-allowed">
                                                    <i data-lucide="file-text" class="h-6 w-6"></i>
                                                </span>
                                            @endif
                                        </td>

                                        {{-- NOCTURNO --}}
                                        <td class="px-6 py-4 text-center">
                                            @if ($row['nocturno'])
                                                <a href="{{ $row['nocturno']->documento_url }}" target="_blank"
                                                    rel="noopener"
                                                    class="inline-flex items-center justify-center bg-brand-sky/10 hover:bg-brand-sky/20 p-3 rounded-lg transition-all"
                                                    title="Ver PDF (Nocturno)">
                                                    <i data-lucide="file-text" class="h-6 w-6 text-brand-blue"
                                                        style="color: var(--color-primario-p2);"></i>
                                                </a>
                                            @else
                                                <span
                                                    class="inline-flex items-center justify-center p-3 rounded-lg opacity-30 cursor-not-allowed">
                                                    <i data-lucide="file-text" class="h-6 w-6"></i>
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Tabla Mobile -->
                    <div class="md:hidden">
                        <div class="space-y-4 p-4">
                            @foreach ($filas as $row)
                                <div class="bg-brand-gray rounded-lg p-4">
                                    <h4 class="font-semibold text-brand-navy mb-4"
                                        style="color: var(--color-primario-p1);">{{ $row['p']->nombre }}</h4>
                                    <div class="flex justify-between">
                                        <div class="text-center">
                                            <p class="text-sm text-brand-navy/70 mb-2"
                                                style="color: var(--color-primario-p1); opacity:.7;">Turno Diurno</p>
                                            @if ($row['diurno'])
                                                <a href="{{ $row['diurno']->documento_url }}" target="_blank"
                                                    rel="noopener"
                                                    class="inline-flex items-center justify-center bg-brand-sky/10 hover:bg-brand-sky/20 p-2 rounded-lg">
                                                    <i data-lucide="file-text" class="h-5 w-5 text-brand-blue"
                                                        style="color: var(--color-primario-p2);"></i>
                                                </a>
                                            @else
                                                <span
                                                    class="inline-flex items-center justify-center p-2 rounded-lg opacity-30">
                                                    <i data-lucide="file-text" class="h-5 w-5"></i>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="text-center">
                                            <p class="text-sm text-brand-navy/70 mb-2"
                                                style="color: var(--color-primario-p1); opacity:.7;">Turno Nocturno</p>
                                            @if ($row['nocturno'])
                                                <a href="{{ $row['nocturno']->documento_url }}" target="_blank"
                                                    rel="noopener"
                                                    class="inline-flex items-center justify-center bg-brand-sky/10 hover:bg-brand-sky/20 p-2 rounded-lg">
                                                    <i data-lucide="file-text" class="h-5 w-5 text-brand-blue"
                                                        style="color: var(--color-primario-p2);"></i>
                                                </a>
                                            @else
                                                <span
                                                    class="inline-flex items-center justify-center p-2 rounded-lg opacity-30">
                                                    <i data-lucide="file-text" class="h-5 w-5"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modalidades de Admisión -->
        <section id="modalidades" class="py-20 bg-brand-gray">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold mt-2 text-brand-navy"
                        style="color: var(--color-primario-p1);">Modalidades de Admisión</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($modalidades as $m)
                        <div class="bg-white rounded-3xl p-8 hover:shadow-lg transition-shadow">
                            <div class="bg-brand-orange/10 p-3 rounded-2xl w-fit mb-6">
                                <i class="{{ $m->icono }} text-brand-orange text-3xl"
                                    style="color: var(--color-secundario-s1);"></i>
                            </div>

                            <h3 class="text-2xl font-bold mb-4 text-brand-navy"
                                style="color: var(--color-primario-p1);">{{ $m->titulo }}</h3>
                            <p class="text-brand-navy/70 mb-6 text-justify"
                                style="color: var(--color-primario-p1); opacity:.7;">{{ $m->descripcion }}</p>
                        </div>
                    @empty
                        <div class="col-span-full text-brand-navy/60"
                            style="color: var(--color-primario-p1); opacity:.6;">No hay modalidades disponibles por
                            ahora.</div>
                    @endforelse
                </div>
            </div>
        </section>

        @php
            $docOblig = $documentos->firstWhere('nombre', 'Documentos Obligatorios') ?? $documentos->first();
            $docAdic = $documentos->firstWhere('nombre', 'Documentos Adicionales') ?? $documentos->skip(1)->first();
        @endphp

        <!-- Requisitos -->
        <section id="requisitos" class="py-20 bg-white">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold mt-2 text-brand-navy"
                        style="color: var(--color-primario-p1);">Requisitos de Admisión</h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Documentos Obligatorios -->
                    <div class="bg-brand-gray rounded-3xl p-8 shadow-lg">
                        <h3 class="text-2xl font-bold mb-6 flex items-center text-brand-navy"
                            style="color: var(--color-primario-p1);">
                            <i data-lucide="file-text" class="h-6 w-6 text-brand-orange mr-3"
                                style="color: var(--color-secundario-s1);"></i>
                            {{ $docOblig->nombre ?? 'Documentos Obligatorios' }}
                        </h3>

                        <div class="space-y-4">
                            @forelse(($docOblig->requisitos ?? collect()) as $req)
                                <div class="flex items-start gap-3">
                                    <div class="bg-brand-orange/10 p-1 rounded-full mt-1">
                                        <i data-lucide="check" class="h-4 w-4 text-brand-orange"
                                            style="color: var(--color-secundario-s1);"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-brand-navy"
                                            style="color: var(--color-primario-p1);">{{ $req->titulo }}</h4>
                                        <p class="text-brand-navy/70 text-sm"
                                            style="color: var(--color-primario-p1); opacity:.7;">
                                            {{ $req->descripcion }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-brand-navy/60" style="color: var(--color-primario-p1); opacity:.6;">Sin
                                    registros.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Documentos Adicionales -->
                    <div class="bg-brand-gray rounded-3xl p-8 shadow-lg">
                        <h3 class="text-2xl font-bold mb-6 flex items-center text-brand-navy"
                            style="color: var(--color-primario-p1);">
                            <i data-lucide="plus-circle" class="h-6 w-6 text-brand-orange mr-3"
                                style="color: var(--color-secundario-s1);"></i>
                            {{ $docAdic->nombre ?? 'Documentos Adicionales' }}
                        </h3>

                        <div class="space-y-4">
                            @forelse(($docAdic->requisitos ?? collect()) as $req)
                                <div class="flex items-start gap-3">
                                    <div class="bg-brand-orange/10 p-1 rounded-full mt-1">
                                        <i data-lucide="info" class="h-4 w-4 text-brand-orange"
                                            style="color: var(--color-secundario-s1);"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-brand-navy"
                                            style="color: var(--color-primario-p1);">{{ $req->titulo }}</h4>
                                        <p class="text-brand-navy/70 text-sm"
                                            style="color: var(--color-primario-p1); opacity:.7;">
                                            {{ $req->descripcion }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-brand-navy/60" style="color: var(--color-primario-p1); opacity:.6;">Sin
                                    registros.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Cronograma -->
        <section id="cronograma" class="py-20 bg-brand-gray">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-12 text-center">
                    <h2 class="text-4xl md:text-5xl font-bold mt-2 text-brand-navy"
                        style="color: var(--color-primario-p1);">
                        Cronograma de Admisión 2025
                    </h2>
                </div>

                <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-brand-orange to-brand-blue text-white p-8 text-center"
                        style="background-image: linear-gradient(to right, var(--color-secundario-s1), var(--color-primario-p2)); color:#ffffff;">
                        <h3 class="text-2xl font-bold mb-0">Proceso de Admisión I</h3>
                    </div>

                    <div class="p-8 space-y-8">
                        @forelse($cronograma as $step)
                            <div class="flex items-start gap-6 p-6 bg-brand-gray/50 rounded-2xl">
                                <div class="bg-brand-orange text-white p-3 rounded-full flex-shrink-0"
                                    style="background-color: var(--color-secundario-s1); color:#ffffff;">
                                    <i class="{{ $step->icono ?: 'fa-solid fa-circle-info' }} text-lg"></i>
                                </div>
                                <div class="flex-grow">
                                    <h4 class="font-bold text-xl text-brand-navy mb-1"
                                        style="color: var(--color-primario-p1);">{{ $step->titulo }}</h4>

                                    @if (!empty($step->fecha))
                                        <p class="text-brand-blue font-medium mb-2"
                                            style="color: var(--color-primario-p2);">{{ $step->fecha }}</p>
                                    @endif

                                    @if (!empty($step->descripcion))
                                        <p class="text-brand-navy/70"
                                            style="color: var(--color-primario-p1); opacity:.7;">
                                            {{ $step->descripcion }}</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-brand-navy/60"
                                style="color: var(--color-primario-p1); opacity:.6;">No hay fechas publicadas por
                                ahora.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <!-- Exonerados -->
        <section id="exonerados" class="py-20 bg-brand-gray">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold mt-2 text-brand-navy"
                        style="color: var(--color-primario-p1);">
                        Exonerados del Examen
                    </h2>
                </div>

                @if ($exonerados->isEmpty())
                    <div class="bg-white rounded-3xl p-8 shadow-sm text-brand-navy/70"
                        style="color: var(--color-primario-p1); opacity:.7;">
                        Aún no hay exonerados registrados.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach ($exonerados as $item)
                            <div class="bg-white rounded-3xl p-8 shadow-lg">
                                <div class="bg-brand-orange/10 p-3 rounded-2xl w-fit mb-6">
                                    <i class="{{ $item->icono ?: 'fa-solid fa-circle-info' }} text-2xl text-brand-orange"
                                        style="color: var(--color-secundario-s1);"></i>
                                </div>

                                <h3 class="text-2xl font-bold mb-3 text-brand-navy"
                                    style="color: var(--color-primario-p1);">
                                    {{ $item->titulo }}
                                </h3>

                                @if ($item->descripcion)
                                    <p class="text-brand-navy/70 text-justify"
                                        style="color: var(--color-primario-p1); opacity:.7;">
                                        {{ $item->descripcion }}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <!-- Vacantes -->
        <section class="vacancy-section" id="vacantes">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title" style="color: var(--color-primario-p1);">Número de Vacantes</h2>
                </div>

                <div class="vacancy-card-container">
                    <div class="vacancy-card">
                        <h3 class="card-title" style="color: var(--color-primario-p1);">Vacantes Disponibles</h3>

                        @if ($vacantes->isEmpty())
                            <div class="text-center text-brand-navy/60 py-6"
                                style="color: var(--color-primario-p1); opacity:.6;">
                                Próximamente publicaremos el número de vacantes.
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach ($vacantes as $row)
                                    <div
                                        class="flex items-center justify-between bg-white px-6 py-5 rounded-2xl shadow-sm ring-1 ring-brand-orange/20">
                                        <span class="program-name" style="color: var(--color-primario-p1);">
                                            {{ $row->programa->nombre ?? 'Programa' }}
                                        </span>
                                        <span class="program-vacancies" style="color: var(--color-primario-p2);">
                                            {{ number_format($row->vacantes) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Proceso de Admisión -->
        <section id="proceso" class="py-20 bg-brand-gray">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold mt-2 text-brand-navy"
                        style="color: var(--color-primario-p1);">Proceso Paso a Paso</h2>
                </div>

                <div class="relative">
                    <!-- línea vertical (desktop) -->
                    <div class="hidden md:block absolute left-8 top-0 bottom-0 w-0.5 bg-brand-orange/30"
                        style="background-color: color-mix(in srgb, var(--color-secundario-s1) 30%, transparent);">
                    </div>

                    <div class="space-y-10">
                        @forelse($pasos as $paso)
                            <div class="flex items-start gap-6">
                                <!-- Icono -->
                                <div class="flex-shrink-0">
                                    <div class="bg-brand-orange text-white p-4 rounded-full shadow-md"
                                        style="background-color: var(--color-secundario-s1); color:#ffffff;">
                                        <i class="{{ $paso->icono ?: 'fa-solid fa-circle-info' }} text-lg"></i>
                                    </div>
                                </div>

                                <!-- Contenido -->
                                <div class="flex-grow">
                                    <h3 class="text-xl md:text-2xl font-bold text-brand-navy mb-3"
                                        style="color: var(--color-primario-p1);">
                                        {{ $paso->paso }}
                                    </h3>

                                    <div class="bg-white rounded-2xl p-6 shadow-sm">
                                        <ul class="space-y-2">
                                            @forelse($paso->procesos as $item)
                                                <li class="flex items-start gap-3">
                                                    <i data-lucide="check"
                                                        class="h-5 w-5 text-emerald-600 mt-0.5"></i>
                                                    <span class="text-brand-navy/90"
                                                        style="color: var(--color-primario-p1); opacity:.9;">
                                                        {{ $item->descripcion }}
                                                    </span>
                                                </li>
                                            @empty
                                                <li class="text-brand-navy/60"
                                                    style="color: var(--color-primario-p1); opacity:.6;">
                                                    Sin elementos para este paso.
                                                </li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-brand-navy/60" style="color: var(--color-primario-p1); opacity:.6;">
                                No hay pasos publicados por ahora.
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        @include('footer')
    </main>

    @vite(['resources/css/app.css','resources/js/app.js'])
    <script src="/js/web/main.js" defer></script>
</body>

</html>
