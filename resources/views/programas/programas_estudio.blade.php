<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ingeniería de Sistemas - Silfer Academia</title>
    @vite('resources/css/css_colores_administrables/css_colores_administrables.css')
    <!-- Variables administrables -->
    <link rel="stylesheet" href="{{ asset('css/css_colores_administrables/css_colores_administrables.css') }}">
    <!-- Tailwind CDN -->
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

    <!-- Lucide Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="stylesheet" href="/css/web/programas.css">
</head>

<body class="min-h-screen bg-brand-gray text-brand-navy font-sans scroll-smooth"
    style="background-color: var(--color-neutral); color: var(--color-primario-p1);">
    <!-- Sidebar de navegación (estático) -->
    <aside
        class="fixed top-0 left-0 h-full w-20 bg-brand-navy text-white z-50 hidden md:flex flex-col items-center py-8"
        style="background-color: var(--color-primario-p1); color:#fff;">
        <div class="mb-12">
            <a href="#">
                <div class="bg-brand-orange text-white p-2 rounded-full"
                    style="background-color: var(--color-secundario-s1); color:#fff;">
                    <i data-lucide="graduation-cap" class="h-6 w-6"></i>
                </div>
            </a>
        </div>

        <nav class="flex flex-col items-center space-y-8 flex-grow" id="sidebar-nav">
            <button onclick="scrollToSection('hero')"
                class="nav-dot w-12 h-12 flex items-center justify-center rounded-full transition-all hover:bg-brand-blue/70 hover:scale-110"
                data-section="hero" title="Inicio" style="/* hover usando tailwind; punto interno blanco sin cambio */">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('informacion')"
                class="nav-dot w-12 h-12 flex items-center justify-center rounded-full transition-all hover:bg-brand-blue/70 hover:scale-110"
                data-section="informacion" title="Información">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('coordinador')"
                class="nav-dot w-12 h-12 flex items-center justify-center rounded-full transition-all hover:bg-brand-blue/70 hover:scale-110"
                data-section="coordinador" title="Coordinador">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('perfil')"
                class="nav-dot w-12 h-12 flex items-center justify-center rounded-full transition-all hover:bg-brand-blue/70 hover:scale-110"
                data-section="perfil" title="Perfil de egreso">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('especializaciones')"
                class="nav-dot w-12 h-12 flex items-center justify-center rounded-full transition-all hover:bg-brand-blue/70 hover:scale-110"
                data-section="especializaciones" title="Áreas de especialización">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('egresados')"
                class="nav-dot w-12 h-12 flex items-center justify-center rounded-full transition-all hover:bg-brand-blue/70 hover:scale-110"
                data-section="egresados" title="Egresados">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('malla')"
                class="nav-dot w-12 h-12 flex items-center justify-center rounded-full transition-all hover:bg-brand-blue/70 hover:scale-110"
                data-section="malla" title="Malla curricular">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('convenios')"
                class="nav-dot w-12 h-12 flex items-center justify-center rounded-full transition-all hover:bg-brand-blue/70 hover:scale-110"
                data-section="convenios" title="Convenios">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('galeria')"
                class="nav-dot w-12 h-12 flex items-center justify-center rounded-full transition-all hover:bg-brand-blue/70 hover:scale-110"
                data-section="galeria" title="Galería">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
        </nav>
    </aside>

    @include('header')

    <main class="md:pl-20 pt-0 md:pt-16">

        <!-- HERO -->
        <section id="hero" class="relative min-h-[80vh] md:min-h-screen flex items-center overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img src="{{ $programa->imagen_url }}" alt="{{ $programa->nombre }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-brand-navy/90 to-brand-blue/60"
                    style="background-image: linear-gradient(to right, rgba(0,38,75,0.90), rgba(26,79,211,0.60));">
                </div>
            </div>

            <div class="container mx-auto px-4 md:px-12 z-10 relative">
                @php
                    $parts = preg_split('/\s+/', trim($programa->nombre));
                    $last = array_pop($parts);
                    $first = implode(' ', $parts);
                @endphp
                <div class="max-w-4xl py-16 md:py-0">
                    <h1 class="text-5xl md:text-7xl font-bold leading-tight text-white mb-6">
                        {{ $first }} <span class="text-brand-orange"
                            style="color: var(--color-secundario-s1);">{{ $last }}</span>
                    </h1>
                    <p class="text-xl text-white/90 max-w-2xl">{{ $programa->descripcion }}</p>
                </div>
            </div>
        </section>

        <!-- INFORMACIÓN DEL PROGRAMA -->
        <section id="informacion" class="py-20 bg-white">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold mt-2">Información del Programa</h2>
                </div>

                @php $info = $programa->info; @endphp

                <div class="max-w-7xl mx-auto">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">

                        <div class="bg-brand-gray rounded-3xl p-8 hover-raise h-full flex flex-col items-center text-center"
                            style="background-color: var(--color-neutral);">
                            <div class="bg-brand-blue/10 p-4 rounded-2xl w-fit mb-6"
                                style="background-color: rgba(26,79,211,0.10);">
                                <i data-lucide="clock" class="h-8 w-8 text-brand-blue"
                                    style="color: var(--color-primario-p2);"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-3">Duración</h3>
                            <p class="text-brand-navy/70" style="color: rgba(0,38,75,0.70);">
                                {{ $info->duracion ?? '—' }}</p>
                        </div>

                        <div class="bg-brand-gray rounded-3xl p-8 hover-raise h-full flex flex-col items-center text-center"
                            style="background-color: var(--color-neutral);">
                            <div class="bg-brand-blue/10 p-4 rounded-2xl w-fit mb-6"
                                style="background-color: rgba(26,79,211,0.10);">
                                <i data-lucide="book-open" class="h-8 w-8 text-brand-blue"
                                    style="color: var(--color-primario-p2);"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-3">Modalidad</h3>
                            <p class="text-brand-navy/70" style="color: rgba(0,38,75,0.70);">
                                {{ $info->modalidad ?? '—' }}</p>
                        </div>

                        <div class="bg-brand-gray rounded-3xl p-8 hover-raise h-full flex flex-col items-center text-center"
                            style="background-color: var(--color-neutral);">
                            <div class="bg-brand-blue/10 p-4 rounded-2xl w-fit mb-6"
                                style="background-color: rgba(26,79,211,0.10);">
                                <i data-lucide="calendar" class="h-8 w-8 text-brand-blue"
                                    style="color: var(--color-primario-p2);"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-3">Turno</h3>
                            <p class="text-brand-navy/70" style="color: rgba(0,38,75,0.70);">{{ $info->turno ?? '—' }}
                            </p>
                        </div>

                        <div class="bg-brand-gray rounded-3xl p-8 hover-raise h-full flex flex-col items-center text-center"
                            style="background-color: var(--color-neutral);">
                            <div class="bg-brand-blue/10 p-4 rounded-2xl w-fit mb-6"
                                style="background-color: rgba(26,79,211,0.10);">
                                <i data-lucide="users" class="h-8 w-8 text-brand-blue"
                                    style="color: var(--color-primario-p2);"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-3">Horario</h3>
                            <p class="text-brand-navy/70" style="color: rgba(0,38,75,0.70);">
                                {{ $info->horario ?? '—' }}</p>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- COORDINADOR ACADÉMICO -->
        <section id="coordinador" class="py-20 bg-brand-gray" style="background-color: var(--color-neutral);">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold mt-2">Coordinador Académico</h2>
                </div>

                @forelse($programa->coordinadores as $c)
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-16">
                        @if ($loop->odd)
                            {{-- Perfil izquierda / Mensaje derecha --}}
                            {{-- PERFIL --}}
                            <div class="relative hover-raise">
                                <div class="relative bg-white rounded-[30px] p-8 shadow-2xl">
                                    <div class="flex flex-col items-center text-center mb-6">
                                        <div class="relative mb-6">
                                            <div
                                                class="relative h-64 w-64 border-8 border-white shadow-2xl rounded-full overflow-hidden">
                                                <img src="{{ $c->foto_url }}" alt="{{ $c->nombre_completo }}"
                                                    class="w-full h-full object-cover">
                                            </div>
                                        </div>
                                        <div>
                                            <h3 class="text-3xl font-bold mb-2">{{ $c->nombre_completo }}</h3>
                                            <p class="text-xl font-medium text-brand-blue"
                                                style="color: var(--color-primario-p2);">{{ $c->cargo }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- MENSAJE --}}
                            <div class="hover-raise">
                                <div class="bg-white rounded-3xl p-8 shadow-lg">
                                    <div class="mb-6">
                                        <svg class="h-10 w-10 text-brand-blue mb-4"
                                            style="color: var(--color-primario-p2);" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z">
                                            </path>
                                        </svg>
                                        <h3 class="text-2xl font-bold mb-4">Mensaje del Coordinador</h3>
                                    </div>
                                    <p class="text-brand-navy/80 text-lg leading-relaxed text-justify"
                                        style="color: rgba(0,38,75,0.80);">
                                        {{ $c->palabras }}
                                    </p>
                                </div>
                            </div>
                        @else
                            {{-- Mensaje izquierda / Perfil derecha (invertido para variar) --}}
                            <div class="hover-raise">
                                <div class="bg-white rounded-3xl p-8 shadow-lg">
                                    <div class="mb-6">
                                        <svg class="h-10 w-10 text-brand-blue mb-4"
                                            style="color: var(--color-primario-p2);" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z">
                                            </path>
                                        </svg>
                                        <h3 class="text-2xl font-bold mb-4">Mensaje del Coordinador</h3>
                                    </div>
                                    <p class="text-brand-navy/80 text-lg leading-relaxed text-justify"
                                        style="color: rgba(0,38,75,0.80);">
                                        {{ $c->palabras }}
                                    </p>
                                </div>
                            </div>

                            <div class="relative hover-raise">
                                <div class="relative bg-white rounded-[30px] p-8 shadow-2xl">
                                    <div class="flex flex-col items-center text-center mb-6">
                                        <div class="relative mb-6">
                                            <div
                                                class="relative h-64 w-64 border-8 border-white shadow-2xl rounded-full overflow-hidden">
                                                <img src="{{ $c->foto_url }}" alt="{{ $c->nombre_completo }}"
                                                    class="w-full h-full object-cover">
                                            </div>
                                        </div>
                                        <div>
                                            <h3 class="text-3xl font-bold mb-2">{{ $c->nombre_completo }}</h3>
                                            <p class="text-xl font-medium text-brand-blue"
                                                style="color: var(--color-primario-p2);">{{ $c->cargo }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="bg-white rounded-3xl p-8 shadow text-brand-navy/70"
                        style="color: rgba(0,38,75,0.70);">
                        Próximamente publicaremos la coordinación académica de este programa.
                    </div>
                @endforelse
            </div>
        </section>

        <!-- PERFIL DE EGRESO -->
        <section id="perfil" class="py-20 bg-white">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold mt-2">Perfil de Egreso</h2>
                </div>

                <div class="mb-16">
                    <div class="relative bg-gradient-to-br from-brand-sky/10 to-brand-orange/10 rounded-3xl p-12 overflow-hidden hover-raise"
                        style="background-image: linear-gradient(to bottom right, rgba(74,132,247,0.10), rgba(226,114,39,0.10));">
                        {{-- adornos … --}}

                        <div class="relative z-10 text-center max-w-4xl mx-auto">
                            <div class="bg-brand-orange text-white p-4 rounded-2xl w-fit mx-auto mb-6"
                                style="background-color: var(--color-secundario-s1); color:#fff;">
                                <i data-lucide="graduation-cap" class="h-12 w-12"></i>
                            </div>

                            @php $perfil = optional($programa->perfil)->descripcion; @endphp

                            @if ($perfil)
                                <p class="text-lg text-brand-navy/80 leading-relaxed text-justify"
                                    style="color: rgba(0,38,75,0.80);">
                                    {!! nl2br(e($perfil)) !!}
                                </p>
                            @else
                                <p class="text-lg text-brand-navy/60 italic" style="color: rgba(0,38,75,0.60);">
                                    Próximamente publicaremos el perfil de egreso de este programa.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ÁREAS DE ESPECIALIZACIÓN -->
        <section id="especializaciones" class="py-20 bg-brand-navy text-white"
            style="background-color: var(--color-primario-p1); color:#fff;">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold mt-2">Áreas de Especialización</h2>
                </div>

                @if ($programa->areas->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach ($programa->areas as $area)
                            <article
                                class="group relative hover-raise rounded-3xl overflow-hidden ring-1 ring-white/10 bg-white/5">
                                <div class="h-48 overflow-hidden relative">
                                    <img src="{{ $area->imagen_url }}" alt="{{ $area->nombre }}"
                                        class="w-full h-full object-cover img-zoom">
                                    <div class="fade-overlay absolute inset-0 bg-gradient-to-t from-brand-navy/50 to-transparent"
                                        style="background-image: linear-gradient(to top, rgba(0,38,75,0.50), transparent);">
                                    </div>
                                </div>
                                <div class="p-8">
                                    <h3 class="text-2xl font-bold mb-4">{{ $area->nombre }}</h3>
                                    <p class="text-white/80 text-justify">{{ $area->descripcion }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white/5 rounded-3xl p-8 ring-1 ring-white/10">
                        <p class="text-white/70">Próximamente publicaremos las áreas de especialización de este
                            programa.</p>
                    </div>
                @endif
            </div>
        </section>

        <!-- EGRESADOS DESTACADOS -->
        <section id="egresados" class="py-20 bg-white">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold mt-2">Egresados Destacados</h2>
                </div>

                @php
                    // Muestra hasta 6 tarjetas (ajusta si quieres más)
                    $egresados = $programa->egresados->take(6);
                @endphp

                @if ($egresados->isEmpty())
                    <div class="bg-brand-gray rounded-3xl p-8 text-center text-brand-navy/70"
                        style="background-color: var(--color-neutral); color: rgba(0,38,75,0.70);">
                        Aún no hay egresados destacados publicados para este programa.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($egresados as $e)
                            <div class="group hover-raise bg-white rounded-3xl overflow-hidden shadow-xl">
                                <div class="relative h-64 overflow-hidden">
                                    <img src="{{ $e->imagen_url }}" alt="{{ $e->nombre }}"
                                        class="w-full h-full object-cover img-zoom">
                                    <div class="fade-overlay absolute inset-0 bg-gradient-to-t from-brand-navy/60 via-transparent to-transparent"
                                        style="background-image: linear-gradient(to top, rgba(0,38,75,0.60), transparent);">
                                    </div>
                                </div>
                                <div class="p-8 text-center">
                                    <h3 class="text-2xl font-bold mb-2">{{ $e->nombre }}</h3>
                                    <p class="text-lg text-brand-navy/80" style="color: rgba(0,38,75,0.80);">
                                        {{ $e->cargo }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <!-- MALLA CURRICULAR -->
        <section id="malla" class="py-20 bg-brand-gray" style="background-color: var(--color-neutral);">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold mt-2">Malla Curricular</h2>
                </div>

                @php
                    // Aplanamos semestres respetando el orden por módulo y por semestre
                    $semestres = collect();
                    foreach ($programa->modulosMalla ?? [] as $mod) {
                        foreach ($mod->semestres ?? [] as $sem) {
                            $semestres->push($sem);
                        }
                    }
                @endphp

                @if ($semestres->isEmpty())
                    <div class="bg-white rounded-3xl p-8 shadow-lg">
                        <p class="text-brand-navy/70" style="color: rgba(0,38,75,0.70);">
                            La malla curricular de este programa será publicada próximamente.
                        </p>
                    </div>
                @else
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                        @foreach ($semestres as $sem)
                            @php
                                $cursos = $sem->cursos ?? collect();
                                $totalCreditos = $cursos->sum('creditos');
                                $totalHoras = $cursos->sum('horas');
                            @endphp

                            <div class="bg-white rounded-3xl p-8 shadow-lg hover-raise">
                                <div class="flex items-center justify-between gap-4 mb-6">
                                    <h3 class="text-2xl font-bold">{{ $sem->nombre }}</h3>

                                    {{-- Totales del semestre --}}
                                    @if ($cursos->isNotEmpty())
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="px-3 py-1 rounded-full bg-brand-sky/10 text-brand-blue text-xs font-semibold"
                                                style="color: var(--color-primario-p2);">
                                                {{ $totalCreditos }} cr
                                            </span>
                                            <span
                                                class="px-3 py-1 rounded-full bg-brand-orange/10 text-brand-orange text-xs font-semibold"
                                                style="color: var(--color-secundario-s1);">
                                                {{ $totalHoras }} h
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                @if ($cursos->isNotEmpty())
                                    <ul class="space-y-3">
                                        @foreach ($cursos as $curso)
                                            <li class="flex items-start justify-between gap-3">
                                                <div class="flex items-start">
                                                    <span class="w-2 h-2 bg-brand-orange rounded-full mt-2 mr-3"
                                                        style="background-color: var(--color-secundario-s1);"></span>
                                                    <span class="text-brand-navy/90"
                                                        style="color: rgba(0,38,75,0.90);">
                                                        {{ $curso->nombre }}
                                                    </span>
                                                </div>

                                                {{-- Créditos y horas por curso --}}
                                                <div class="shrink-0 flex items-center gap-2">
                                                    <span
                                                        class="px-2 py-1 rounded-full bg-brand-sky/10 text-brand-blue text-[11px] font-semibold"
                                                        style="color: var(--color-primario-p2);">
                                                        {{ (int) ($curso->creditos ?? 0) }} cr
                                                    </span>
                                                    <span
                                                        class="px-2 py-1 rounded-full bg-brand-orange/10 text-brand-orange text-[11px] font-semibold"
                                                        style="color: var(--color-secundario-s1);">
                                                        {{ (int) ($curso->horas ?? 0) }} h
                                                    </span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-brand-navy/70 italic" style="color: rgba(0,38,75,0.70);">
                                        Cursos especializados en este semestre serán publicados próximamente.
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="text-center">
                    <a href="{{ route('programas.malla.pdf', $programa->id) }}"
                        class="bg-brand-orange hover:bg-[#cf651f] text-white rounded-full px-8 py-4 font-medium inline-flex items-center shadow-lg hover:shadow-xl transform hover:scale-105 transition-all"
                        style="background-color: var(--color-secundario-s1); color:#fff;">
                        <i data-lucide="download" class="mr-2 h-5 w-5"></i>
                        Descargar Malla Completa
                    </a>
                </div>
            </div>
        </section>


        <!-- CONVENIOS -->
        <section id="convenios" class="py-20 bg-white">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold mt-2">Convenios</h2>
                </div>

                @php $convenios = $programa->convenios; @endphp

                @if ($convenios->isEmpty())
                    <p class="text-brand-navy/60" style="color: rgba(0,38,75,0.60);">Sin convenios registrados para
                        este programa.</p>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 mb-12">
                        @foreach ($convenios as $c)
                            <div class="bg-brand-gray rounded-2xl p-6 text-center ring-1 ring-brand-blue/10 hover-raise hover:ring-brand-blue/30"
                                style="background-color: var(--color-neutral);">
                                <div class="bg-white rounded-xl p-4 mb-4 shadow-sm">
                                    <img src="{{ $c->imagen_url }}" alt="{{ $c->entidad }}"
                                        class="h-12 mx-auto object-contain">
                                </div>
                                <h3 class="font-semibold">{{ $c->entidad }}</h3>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <!-- GALERÍA -->
        <section id="galeria" class="py-20 bg-brand-gray" style="background-color: var(--color-neutral);">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold mt-2">Galería</h2>
                </div>

                @php $fotos = $programa->galerias; @endphp

                @if ($fotos->isEmpty())
                    <div class="bg-white rounded-2xl p-8 shadow text-brand-navy/70"
                        style="color: rgba(0,38,75,0.70);">
                        Aún no hay fotos publicadas para este programa.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($fotos as $g)
                            <div class="group relative overflow-hidden rounded-3xl shadow-lg hover-raise">
                                <img src="{{ $g->imagen_url }}" alt="{{ $g->nombre }}"
                                    class="w-full h-64 object-cover img-zoom" loading="lazy">
                                <div class="fade-overlay absolute inset-0 bg-gradient-to-t from-brand-navy/70 to-transparent"
                                    style="background-image: linear-gradient(to top, rgba(0,38,75,0.70), transparent);">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center mt-12">
                        <a href="{{ url('/galeria') }}"
                            class="bg-brand-orange hover:bg-[#cf651f] text-white rounded-full px-8 py-4 font-medium inline-flex items-center hover-raise"
                            style="background-color: var(--color-secundario-s1); color:#fff;">
                            Ver más fotos
                            <i data-lucide="external-link" class="ml-2 h-5 w-5"></i>
                        </a>
                    </div>
                @endif
            </div>
        </section>

    </main>

    @include('footer')

    <script src="/js/web/programa.js"></script>
    <script src="/js/web/main.js" defer></script>
</body>

</html>
