<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios Complementarios - Silfer Academia</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="stylesheet" href="/css/web/servicios-complementarios.css">
</head>

@php use Illuminate\Support\Str; @endphp

<body class="min-h-screen font-sans scroll-smooth" style="background-color:#f8f9fa; color:#212529;">

    {{-- Sidebar mínimo (opcional) --}}
    <div class="fixed top-0 left-0 h-full w-20 z-50 hidden md:flex flex-col items-center py-8"
        style="background-color: var(--color-primario-p1); color: #ffffff;">
        <div class="mb-12">
            <a href="{{ url('/') }}">
                <div class="p-2 rounded-full" style="background-color: var(--color-secundario-s1); color:#ffffff;">
                    <i data-lucide="graduation-cap" class="h-6 w-6"></i>
                </div>
            </a>
        </div>
        <nav class="flex flex-col items-center space-y-8 flex-grow">
            <button onclick="document.getElementById('servicios').scrollIntoView({behavior:'smooth'})"
                class="w-12 h-12 flex items-center justify-center rounded-full" style="background-color: transparent;"
                onmouseover="this.style.backgroundColor='var(--color-primario-p2)';"
                onmouseout="this.style.backgroundColor='transparent';">
                <div class="h-3 w-3 rounded-full" style="background-color:#ffffff;"></div>
            </button>
            <button onclick="document.getElementById('horarios').scrollIntoView({behavior:'smooth'})"
                class="w-12 h-12 flex items-center justify-center rounded-full" style="background-color: transparent;"
                onmouseover="this.style.backgroundColor='var(--color-primario-p2)';"
                onmouseout="this.style.backgroundColor='transparent';">
                <div class="h-3 w-3 rounded-full" style="background-color:#ffffff;"></div>
            </button>
        </nav>
    </div>

    @include('header')

    <main class="md:pl-20 pt-16">
        {{-- Hero --}}
        <section class="py-20 relative overflow-hidden">
            <div class="absolute inset-0 z-0">
                <!-- Gradiente principal (de p2 10% a p3 10%) -->
                <div class="absolute top-0 left-0 w-full h-full"
                    style="background: linear-gradient(to bottom right,
                       rgba(26,79,211,0.10), rgba(74,132,247,0.10));">
                </div>
                <!-- Círculos decorativos -->
                <div class="absolute top-1/4 right-1/4 w-64 h-64 rounded-full"
                    style="background-color: rgba(74,132,247,0.20);"></div>
                <div class="absolute bottom-1/3 left-1/3 w-80 h-80 rounded-full"
                    style="background-color: rgba(226,114,39,0.20);"></div>
            </div>
            <div class="container mx-auto px-4 md:px-12 relative z-10">
                <div class="max-w-4xl mx-auto text-center">
                    <h1 class="text-5xl md:text-7xl font-bold leading-tight mb-6">
                        Servicios <span style="color: var(--color-primario-p2);">Complementarios</span>
                    </h1>
                    <p class="text-xl max-w-3xl mx-auto mb-8" style="color:#4b5563;">
                        Brindamos apoyo integral a nuestra comunidad educativa mediante servicios especializados que
                        complementan la formación y promueven el bienestar de nuestros estudiantes.
                    </p>
                </div>
            </div>
        </section>

        {{-- Servicios (tarjetas) --}}
        <section id="servicios" class="py-20" style="background-color:#ffffff;">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold mt-2">Nuestros Servicios</h2>
                </div>

                @if ($servicios->isEmpty())
                    <div class="rounded-3xl border p-10 text-center"
                        style="border-color:#e5e7eb; background-color:#ffffff; color:#4b5563;">
                        Aún no hay servicios registrados.
                    </div>
                @else
                    <div class="space-y-16">
                        @foreach ($servicios as $i => $s)
                            @php
                                // Imagen segura (acepta rutas absolutas o relativas a /public)
                                $img = $s->imagen ?: './images/no-photo.jpg';
                                $img = Str::startsWith($img, ['http://', 'https://']) ? $img : asset(ltrim($img, './'));
                                // Dividir nombre: "Principal - Subtítulo"
                                [$nom, $sub] = array_pad(explode(' - ', (string) $s->nombre, 2), 2, '');
                                // Alternar lado de la imagen
                                $even = $i % 2 === 0;
                                // Estilos de gradiente por índice (usando rgba para opacidad)
                                $gradients = [
                                    'linear-gradient(to right, rgba(226,114,39,0.10), rgba(226,114,39,0.05))', // s1 10%->5%
                                    'linear-gradient(to right, rgba(26,79,211,0.10), rgba(74,132,247,0.10))', // p2->p3 10%
                                    'linear-gradient(to right, rgba(74,132,247,0.10), rgba(74,132,247,0.05))', // p3 10%->5%
                                    'linear-gradient(to right, rgba(0,38,75,0.10), rgba(0,38,75,0.05))', // p1 10%->5%
                                ];
                                $grad = $gradients[$i % 4];
                            @endphp

                            <div class="service-card rounded-3xl overflow-hidden shadow-lg fade-in"
                                style="background: {{ $grad }};">
                                <div class="grid md:grid-cols-2 gap-8 items-center">
                                    @if ($even)
                                        <div class="p-8 md:p-12 order-1">
                                            <h3 class="text-3xl font-bold" style="color:#111827;">
                                                {{ $nom ?: 'Servicio' }}</h3>
                                            @if ($sub)
                                                <p class="font-medium" style="color: var(--color-primario-p2);">
                                                    {{ $sub }}</p>
                                            @endif

                                            @if ($s->descripcion)
                                                <p class="mt-4 mb-6 text-lg text-justify" style="color:#374151;">
                                                    {{ $s->descripcion }}</p>
                                            @endif

                                            <div class="space-y-4">
                                                @if ($s->ubicacion)
                                                    <div class="flex items-start">
                                                        <i data-lucide="map-pin" class="h-5 w-5 mr-3 mt-1"
                                                            style="color: var(--color-secundario-s1);"></i>
                                                        <div>
                                                            <p class="font-semibold">Ubicación:</p>
                                                            <p style="color:#4b5563;">{{ $s->ubicacion }}</p>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($s->personal)
                                                    <div class="flex items-start">
                                                        <i data-lucide="user-check" class="h-5 w-5 mr-3 mt-1"
                                                            style="color: var(--color-secundario-s1);"></i>
                                                        <div>
                                                            <p class="font-semibold">Personal a cargo:</p>
                                                            <p class="whitespace-pre-line" style="color:#4b5563;">
                                                                {{ $s->personal }}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="relative h-80 md:h-full order-2">
                                            <img src="{{ $img }}" alt="{{ $nom }}"
                                                class="w-full h-full object-cover {{ $even ? 'rounded-r-3xl' : 'rounded-l-3xl' }}">
                                        </div>
                                    @else
                                        <div class="relative h-80 md:h-full order-1 md:order-1">
                                            <img src="{{ $img }}" alt="{{ $nom }}"
                                                class="w-full h-full object-cover rounded-l-3xl">
                                        </div>
                                        <div class="p-8 md:p-12 order-2 md:order-2">
                                            <h3 class="text-3xl font-bold" style="color:#111827;">
                                                {{ $nom ?: 'Servicio' }}</h3>
                                            @if ($sub)
                                                <p class="font-medium" style="color: var(--color-primario-p2);">
                                                    {{ $sub }}</p>
                                            @endif

                                            @if ($s->descripcion)
                                                <p class="mt-4 mb-6 text-lg text-justify" style="color:#374151;">
                                                    {{ $s->descripcion }}</p>
                                            @endif

                                            <div class="space-y-4">
                                                @if ($s->ubicacion)
                                                    <div class="flex items-start">
                                                        <i data-lucide="map-pin" class="h-5 w-5 mr-3 mt-1"
                                                            style="color: var(--color-primario-p2);"></i>
                                                        <div>
                                                            <p class="font-semibold">Ubicación:</p>
                                                            <p style="color:#4b5563;">{{ $s->ubicacion }}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if ($s->personal)
                                                    <div class="flex items-start">
                                                        <i data-lucide="user-check" class="h-5 w-5 mr-3 mt-1"
                                                            style="color: var(--color-primario-p2);"></i>
                                                        <div>
                                                            <p class="font-semibold">Personal a cargo:</p>
                                                            <p class="whitespace-pre-line" style="color:#4b5563;">
                                                                {{ $s->personal }}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        {{-- Horarios --}}
        <section id="horarios" class="py-20" style="background-color:#f8f9fa;">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold mt-2">Horarios de Atención</h2>
                </div>

                <div class="rounded-3xl shadow-lg overflow-hidden" style="background-color:#ffffff;">
                    @if ($horarios->isEmpty())
                        <div class="p-10 text-center" style="color:#4b5563;">Sin horarios registrados.</div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="schedule-table w-full">
                                <thead>
                                    <tr>
                                        <th>Servicio</th>
                                        <th class="text-center">Lunes - Viernes</th>
                                        <th class="text-center">Sábados</th>
                                        <th class="text-center">Domingos</th>
                                        <th class="text-center">Contacto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($horarios as $h)
                                        @php
                                            [$hnom] = array_pad(
                                                explode(' - ', (string) $h->servicio->nombre, 2),
                                                2,
                                                '',
                                            );
                                        @endphp
                                        <tr>
                                            <td class="font-semibold">{{ $hnom ?: $h->servicio->nombre }}</td>
                                            <td class="text-center">{{ $h->lunes_viernes }}</td>
                                            <td class="text-center">{{ $h->sabados }}</td>
                                            <td class="text-center">{{ $h->domingos }}</td>
                                            <td class="text-center">{{ $h->contacto }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
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
