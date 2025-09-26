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

<body class="min-h-screen bg-[#f8f9fa] text-[#212529] font-sans scroll-smooth">

    {{-- Sidebar mínimo (opcional) --}}
    <div class="fixed top-0 left-0 h-full w-20 bg-[#00264B] text-white z-50 hidden md:flex flex-col items-center py-8">
        <div class="mb-12">
            <a href="{{ url('/') }}">
                <div class="bg-[#E27227] p-2 rounded-full"><i data-lucide="graduation-cap" class="h-6 w-6"></i></div>
            </a>
        </div>
        <nav class="flex flex-col items-center space-y-8 flex-grow">
            <button onclick="document.getElementById('servicios').scrollIntoView({behavior:'smooth'})"
                class="w-12 h-12 flex items-center justify-center hover:bg-[#1A4FD3] rounded-full">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="document.getElementById('horarios').scrollIntoView({behavior:'smooth'})"
                class="w-12 h-12 flex items-center justify-center hover:bg-[#1A4FD3] rounded-full">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
        </nav>
    </div>

    @include('header')

    <main class="md:pl-20 pt-16">
        {{-- Hero --}}
        <section class="py-20 relative overflow-hidden">
            <div class="absolute inset-0 z-0">
                <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-[#1A4FD3]/10 to-[#4A84F7]/10">
                </div>
                <div class="absolute top-1/4 right-1/4 w-64 h-64 rounded-full bg-[#4A84F7]/20"></div>
                <div class="absolute bottom-1/3 left-1/3 w-80 h-80 rounded-full bg-[#E27227]/20"></div>
            </div>
            <div class="container mx-auto px-4 md:px-12 relative z-10">
                <div class="max-w-4xl mx-auto text-center">
                    <h1 class="text-5xl md:text-7xl font-bold leading-tight mb-6">
                        Servicios <span class="text-[#1A4FD3]">Complementarios</span>
                    </h1>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-8">
                        Brindamos apoyo integral a nuestra comunidad educativa mediante servicios especializados que
                        complementan la formación y promueven el bienestar de nuestros estudiantes.
                    </p>
                </div>
            </div>
        </section>

        {{-- Servicios (tarjetas) --}}
        <section id="servicios" class="py-20 bg-white">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold mt-2">Nuestros Servicios</h2>
                </div>

                @if ($servicios->isEmpty())
                    <div class="rounded-3xl border border-gray-200 bg-white p-10 text-center text-gray-600">
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
                                $grad =
                                    $i % 4 === 0
                                        ? 'from-[#E27227]/10 to-[#E27227]/5'
                                        : ($i % 4 === 1
                                            ? 'from-[#1A4FD3]/10 to-[#4A84F7]/10'
                                            : ($i % 4 === 2
                                                ? 'from-[#4A84F7]/10 to-[#4A84F7]/5'
                                                : 'from-[#00264B]/10 to-[#00264B]/5'));
                            @endphp

                            <div
                                class="service-card bg-gradient-to-r {{ $grad }} rounded-3xl overflow-hidden shadow-lg fade-in">
                                <div class="grid md:grid-cols-2 gap-8 items-center">
                                    @if ($even)
                                        <div class="p-8 md:p-12 order-1">
                                            <h3 class="text-3xl font-bold text-gray-900">{{ $nom ?: 'Servicio' }}</h3>
                                            @if ($sub)
                                                <p class="text-[#1A4FD3] font-medium">{{ $sub }}</p>
                                            @endif

                                            @if ($s->descripcion)
                                                <p class="text-gray-700 mt-4 mb-6 text-lg text-justify">{{ $s->descripcion }}</p>
                                            @endif

                                            <div class="space-y-4">
                                                @if ($s->ubicacion)
                                                    <div class="flex items-start">
                                                        <i data-lucide="map-pin"
                                                            class="h-5 w-5 text-[#E27227] mr-3 mt-1"></i>
                                                        <div>
                                                            <p class="font-semibold">Ubicación:</p>
                                                            <p class="text-gray-600">{{ $s->ubicacion }}</p>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($s->personal)
                                                    <div class="flex items-start">
                                                        <i data-lucide="user-check"
                                                            class="h-5 w-5 text-[#E27227] mr-3 mt-1"></i>
                                                        <div>
                                                            <p class="font-semibold">Personal a cargo:</p>
                                                            <p class="text-gray-600 whitespace-pre-line">
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
                                            <h3 class="text-3xl font-bold text-gray-900">{{ $nom ?: 'Servicio' }}</h3>
                                            @if ($sub)
                                                <p class="text-[#1A4FD3] font-medium">{{ $sub }}</p>
                                            @endif

                                            @if ($s->descripcion)
                                                <p class="text-gray-700 mt-4 mb-6 text-lg text-justify">{{ $s->descripcion }}</p>
                                            @endif

                                            <div class="space-y-4">
                                                @if ($s->ubicacion)
                                                    <div class="flex items-start">
                                                        <i data-lucide="map-pin"
                                                            class="h-5 w-5 text-[#1A4FD3] mr-3 mt-1"></i>
                                                        <div>
                                                            <p class="font-semibold">Ubicación:</p>
                                                            <p class="text-gray-600">{{ $s->ubicacion }}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if ($s->personal)
                                                    <div class="flex items-start">
                                                        <i data-lucide="user-check"
                                                            class="h-5 w-5 text-[#1A4FD3] mr-3 mt-1"></i>
                                                        <div>
                                                            <p class="font-semibold">Personal a cargo:</p>
                                                            <p class="text-gray-600 whitespace-pre-line">
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
        <section id="horarios" class="py-20 bg-[#f8f9fa]">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold mt-2">Horarios de Atención</h2>
                </div>

                <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
                    @if ($horarios->isEmpty())
                        <div class="p-10 text-center text-gray-600">Sin horarios registrados.</div>
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
