<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Presentación & Reseña Histórica</title>
    <!-- Variables administrables -->
    <link rel="stylesheet" href="{{ asset('css/css_colores_administrables/css_colores_administrables.css') }}">
    @vite('resources/css/css_colores_administrables/css_colores_administrables.css')
    <!-- Tailwind vía CDN (seguirá funcionando; añadimos style inline solo para colores) -->
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
                        },
                    },
                    container: {
                        center: true,
                        padding: {
                            DEFAULT: '1rem',
                            sm: '1.25rem',
                            lg: '2rem',
                            xl: '2.5rem'
                        }
                    },
                },
            },
        };
    </script>
    <!-- Lucide (iconos) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>

<body class="min-h-screen bg-brand-gray text-brand-navy font-sans scroll-smooth"
    style="background-color: var(--color-neutral); color: var(--color-primario-p1);">
    <!-- Navegación lateral (estática) -->
    <aside
        class="fixed top-0 left-0 h-full w-20 bg-brand-navy text-white z-50 hidden md:flex flex-col items-center py-8"
        style="background-color: var(--color-primario-p1); color: #ffffff;">
        <div class="mb-12">
            <a href="#">
                <div class="bg-brand-orange text-white p-2 rounded-full"
                    style="background-color: var(--color-secundario-s1); color: #ffffff;">
                    <i data-lucide="graduation-cap" class="h-6 w-6"></i>
                </div>
            </a>
        </div>

        <nav class="flex flex-col items-center space-y-8 flex-grow" id="sidebar-nav">
            <button onclick="scrollToSection('presentacion')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-brand-blue/90 rounded-full"
                data-section="presentacion" title="Presentación">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('historia')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-brand-blue/90 rounded-full"
                data-section="historia" title="Historia">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('hitos')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-brand-blue/90 rounded-full"
                data-section="hitos" title="Hitos">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
        </nav>
    </aside>

    @include('header')

    <!-- Contenido -->
    <main class="md:pl-20 pt-16">

        <!-- HERO -->
        <section class="py-20 relative overflow-hidden">
            <div class="absolute inset-0 z-0">
                <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-brand-orange/10 to-brand-sky/10"
                    style="background-image: linear-gradient(to bottom right,
                               color-mix(in srgb, var(--color-secundario-s1) 10%, transparent),
                               color-mix(in srgb, var(--color-primario-p3) 10%, transparent));">
                </div>
                <div class="floating-element absolute top-1/4 right-1/4 w-64 h-64 rounded-full bg-brand-orange/20"
                    style="background-color: color-mix(in srgb, var(--color-secundario-s1) 20%, transparent);">
                </div>
                <div class="floating-element absolute bottom-1/3 left-1/3 w-80 h-80 rounded-full bg-brand-sky/20"
                    style="background-color: color-mix(in srgb, var(--color-primario-p3) 20%, transparent); animation-delay:-3s">
                </div>
                <div class="floating-element absolute top-1/2 right-1/3 w-32 h-32 rounded-full bg-brand-blue/30"
                    style="background-color: color-mix(in srgb, var(--color-primario-p2) 30%, transparent); animation-delay:-1.5s">
                </div>
            </div>
            <div class="container mx-auto px-4 md:px-12 z-10 relative text-center">
                <h1 class="text-5xl md:text-7xl font-bold leading-tight mb-6">
                    Nuestra <span class="gradient-text">Identidad</span>
                </h1>
                <p class="text-xl text-brand-navy/70 max-w-4xl mx-auto mb-8"
                    style="color: var(--color-primario-p1); opacity:.7;">
                    Conoce nuestra historia, el propósito que nos guía y las palabras que definen quiénes somos.
                </p>
            </div>
        </section>

        <!-- PRESENTACIÓN (texto + imagen) -->
        <section id="historia" class="py-20 bg-white">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold mt-2">Presentación</h2>
                </div>

                @if ($presentacion && $presentacion->is_active)
                    <div class="grid md:grid-cols-2 gap-12 items-center mb-16">
                        <div class="space-y-6">
                            {{-- Título desde BD --}}
                            <h3 class="text-3xl font-bold">
                                {{ $presentacion->titulo }}
                            </h3>

                            {{-- Nombre del director desde BD --}}
                            <p class="text-brand-blue font-semibold text-lg" style="color: var(--color-primario-p2);">
                                {{ $presentacion->nombre_director }}
                            </p>

                            {{-- Palabras del director con saltos de línea preservados --}}
                            <p class="text-brand-navy/70 text-lg leading-relaxed text-justify"
                                style="color: var(--color-primario-p1); opacity:.7;">
                                {!! nl2br(e($presentacion->palabras_director)) !!}
                            </p>
                        </div>

                        <div class="relative">
                            <div class="relative overflow-hidden rounded-3xl shadow-xl">
                                {{-- Foto con fallback --}}
                                <img src="{{ asset($presentacion->foto_director ?: 'images/no-photo.jpg') }}"
                                    alt="Palabras del director - {{ $presentacion->nombre_director }}"
                                    class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Si está inactiva, puedes ocultar o mostrar un aviso --}}
                    <div class="rounded-xl bg-brand-gray/40 p-6 text-brand-navy/70"
                        style="background-color: color-mix(in srgb, var(--color-neutral) 40%, transparent); color: var(--color-primario-p1); opacity:.7;">
                        <p>La sección de Presentación no está disponible por el momento.</p>
                    </div>
                @endif
            </div>
        </section>

        <!-- RESEÑA HISTÓRICA / TIMELINE -->
        <section id="hitos" class="py-20 bg-brand-gray" style="background-color: var(--color-neutral);">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold mt-2">Reseña Histórica</h2>
                </div>

                <div class="relative">
                    <div class="absolute left-1/2 -translate-x-1/2 w-1 bg-brand-orange/30 h-full hidden md:block"
                        style="background-color: color-mix(in srgb, var(--color-secundario-s1) 30%, transparent);">
                    </div>

                    <div class="space-y-12">
                        @forelse ($resenias as $resenia)
                            @php
                                $odd = $loop->iteration % 2 === 1; // alternar lados
                                $textColClass = $odd ? 'md:text-right' : 'md:order-2';
                                $imageColClass = $odd ? '' : 'md:order-1';
                                $imageMargin = $odd ? 'md:ml-8' : 'md:mr-8';
                                $src = asset($resenia->imagen ?: 'images/no-photo.jpg');
                            @endphp

                            <div class="timeline-item relative">
                                <div class="grid md:grid-cols-2 gap-8 items-center">
                                    {{-- Columna de texto --}}
                                    <div class="{{ $textColClass }}">
                                        <div class="bg-white rounded-3xl p-8 shadow-lg">
                                            <h3 class="text-2xl font-bold mb-4">
                                                {{ $resenia->titulo }}
                                            </h3>
                                            <p class="text-brand-navy/70 text-justify"
                                                style="color: var(--color-primario-p1); opacity:.7;">
                                                {!! nl2br(e($resenia->descripcion)) !!}
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Columna de imagen --}}
                                    <div class="relative {{ $imageColClass }}">
                                        <div class="absolute left-1/2 -translate-x-1/2 w-4 h-4 bg-brand-orange rounded-full z-10 hidden md:block"
                                            style="background-color: var(--color-secundario-s1);">
                                        </div>
                                        <img src="{{ $src }}" alt="{{ $resenia->titulo }}"
                                            class="w-full h-64 object-cover rounded-2xl shadow-lg {{ $imageMargin }}">
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-xl bg-white p-6 shadow-sm text-brand-navy/70"
                                style="color: var(--color-primario-p1); opacity:.7;">
                                Aún no hay reseñas históricas publicadas.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

    </main>

    @include('footer')

    <script src="/js/web/presentacion.js"></script>
    <script src="/js/web/main.js" defer></script>
    
</body>

</html>
