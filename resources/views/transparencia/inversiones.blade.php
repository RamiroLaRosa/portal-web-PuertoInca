{{-- resources/views/transparencia/inversiones.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inversiones y Recursos - Silfer Academia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="stylesheet" href="/css/web/inversiones.css">
</head>

<body class="min-h-screen bg-gradient-to-br from-[#DDE3E8] to-white text-gray-900 scroll-smooth"
    style="background-image: linear-gradient(to bottom right, var(--color-neutral), white);">

    <div class="fixed top-0 left-0 h-full w-20 bg-[#00264B] text-white z-50 hidden md:flex flex-col items-center py-8"
        style="background-color: var(--color-primario-p1);">
        <div class="mb-12">
            <div class="bg-[#E27227] text-white p-2 rounded-full" style="background-color: var(--color-secundario-s1);">
                <i data-lucide="graduation-cap" class="h-6 w-6"></i>
            </div>
        </div>

        <nav class="flex flex-col items-center space-y-8 flex-grow" id="sidebar-nav">
            <button onclick="scrollToSection('hero')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-[#1A4FD3]/20 rounded-full"
                data-section="hero" title="Inicio" style="/* color base manejado por hover de Tailwind */">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>

            <button onclick="scrollToSection('inversiones')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-[#1A4FD3]/20 rounded-full"
                data-section="inversiones" title="Inversiones y reinversiones" style="/* hover via Tailwind */">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>

            <button onclick="scrollToSection('infraestructura')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-[#1A4FD3]/20 rounded-full"
                data-section="infraestructura" title="Obras de infraestructura" style="/* hover via Tailwind */">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>

            <button onclick="scrollToSection('donaciones')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-[#1A4FD3]/20 rounded-full"
                data-section="donaciones" title="Donaciones y aportes" style="/* hover via Tailwind */">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
        </nav>
    </div>

    @include('header')

    @php
        // Normaliza imágenes guardadas como "./images/no-photo.jpg", "/assets/..", "assets/.."
        $img = function ($path) {
            if (blank($path)) {
                return asset('images/no-photo.jpg');
            }
            $p = ltrim($path, '/');
            $p = ltrim($p, './');
            return asset($p);
        };
        // helper para el link del PDF
        $pdf = fn($inv) => route('web.inversiones.file', $inv);
    @endphp

    <main class="md:pl-20">
        {{-- HERO --}}
        <section id="hero" class="py-20 bg-gradient-to-br from-[#00264B] via-[#1A4FD3] to-[#4A84F7] text-white"
            style="background-image: linear-gradient(to bottom right, var(--color-primario-p1), var(--color-primario-p2), var(--color-primario-p3));">
            <div class="container mx-auto px-4">
                <div class="max-w-6xl mx-auto text-center">
                    <h1 class="text-5xl md:text-7xl font-black mb-6">Inversiones y Recursos</h1>
                    <p class="text-xl md:text-2xl text-white/85 max-w-4xl mx-auto">
                        Información transparente sobre nuestras inversiones, recursos y rendición de cuentas.
                    </p>
                </div>
            </div>
        </section>

        {{-- SECCIÓN 1: Inversiones y Reinversiones (tipo 1) --}}
        <section id="inversiones" class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <div class="mb-12 flex items-center gap-4">
                    <div class="bg-[#4A84F7]/20 p-3 rounded-xl"
                        style="background-color: color-mix(in srgb, var(--color-primario-p3) 20%, transparent);">
                        <i data-lucide="trending-up" class="h-8 w-8 text-[#1A4FD3]"
                            style="color: var(--color-primario-p2);"></i>
                    </div>
                    <div>
                        <h2 class="text-4xl font-black text-[#00264B]" style="color: var(--color-primario-p1);">
                            Inversiones y Reinversiones
                        </h2>
                    </div>
                </div>

                @if ($groups[1]->isEmpty())
                    <div class="rounded-2xl border border-gray-200 bg-white p-8 text-center text-gray-600">
                        Aún no hay registros para esta sección.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach ($groups[1] as $inv)
                            <a href="{{ $pdf($inv) }}" target="_blank" rel="noopener"
                                class="card bg-white border border-gray-200 rounded-lg overflow-hidden transition-all">
                                <div class="aspect-video">
                                    <img src="{{ $img($inv->imagen) }}" alt="{{ $inv->nombre }}"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-[#00264B] mb-3"
                                        style="color: var(--color-primario-p1);">
                                        {{ $inv->nombre }}
                                    </h3>
                                    <p class="text-gray-600 text-justify">{{ $inv->descripcion }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        {{-- SECCIÓN 2: Obras de Infraestructura (tipo 2) --}}
        <section id="infraestructura" class="py-20 bg-[#DDE3E8]" style="background-color: var(--color-neutral);">
            <div class="container mx-auto px-4">
                <div class="mb-12 flex items-center gap-4">
                    <div class="bg-[#1A4FD3]/10 p-3 rounded-xl"
                        style="background-color: color-mix(in srgb, var(--color-primario-p2) 10%, transparent);">
                        <i data-lucide="building-2" class="h-8 w-8 text-[#1A4FD3]"
                            style="color: var(--color-primario-p2);"></i>
                    </div>
                    <div>
                        <h2 class="text-4xl font-black text-[#00264B]" style="color: var(--color-primario-p1);">
                            Obras de Infraestructura
                        </h2>
                    </div>
                </div>

                @if ($groups[2]->isEmpty())
                    <div class="rounded-2xl border border-gray-200 bg-white p-8 text-center text-gray-600">
                        Aún no hay registros para esta sección.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach ($groups[2] as $inv)
                            <a href="{{ $pdf($inv) }}" target="_blank" rel="noopener"
                                class="card bg-white border border-gray-200 rounded-lg overflow-hidden transition-all">
                                <div class="aspect-video">
                                    <img src="{{ $img($inv->imagen) }}" alt="{{ $inv->nombre }}"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-[#00264B] mb-3"
                                        style="color: var(--color-primario-p1);">
                                        {{ $inv->nombre }}
                                    </h3>
                                    <p class="text-gray-700 text-justify">{{ $inv->descripcion }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        {{-- SECCIÓN 3: Donaciones y Aportes (tipo 3) --}}
        <section id="donaciones" class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <div class="mb-12 flex items-center gap-4">
                    <div class="bg-[#E27227]/10 p-3 rounded-xl"
                        style="background-color: color-mix(in srgb, var(--color-secundario-s1) 10%, transparent);">
                        <i data-lucide="heart" class="h-8 w-8 text-[#E27227]"
                            style="color: var(--color-secundario-s1);"></i>
                    </div>
                    <div>
                        <h2 class="text-4xl font-black text-[#00264B]" style="color: var(--color-primario-p1);">
                            Donaciones y Aportes
                        </h2>
                    </div>
                </div>

                @if ($groups[3]->isEmpty())
                    <div class="rounded-2xl border border-gray-200 bg-white p-8 text-center text-gray-600">
                        Aún no hay registros para esta sección.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach ($groups[3] as $inv)
                            <a href="{{ $pdf($inv) }}" target="_blank" rel="noopener"
                                class="card bg-white border border-gray-200 rounded-lg overflow-hidden transition-all">
                                <div class="aspect-video">
                                    <img src="{{ $img($inv->imagen) }}" alt="{{ $inv->nombre }}"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-[#00264B] mb-3"
                                        style="color: var(--color-primario-p1);">
                                        {{ $inv->nombre }}
                                    </h3>
                                    <p class="text-gray-600 text-justify">{{ $inv->descripcion }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    </main>

    @include('footer')

    <script>
        lucide.createIcons();
    </script>
    <script src="/js/web/main.js" defer></script>
</body>

</html>
