{{-- resources/views/otros/noticias.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias - Silfer Academia</title>
    @vite('resources/css/css_colores_administrables/css_colores_administrables.css')
    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Lucide --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    {{-- Estilos propios --}}
    <link rel="stylesheet" href="/css/web/noticias.css">
</head>

<body class="min-h-screen bg-[#f8f9fa] text-[#212529] font-sans">
    {{-- Sidebar --}}
    <div class="fixed top-0 left-0 h-full w-20 text-white z-50 hidden md:flex flex-col items-center py-8"
        style="background: var(--color-primario-p1);">
        <div class="mb-12">
            <a href="{{ url('/') }}">
                <div class="text-white p-2 rounded-full" style="background: var(--color-secundario-s1);">
                    <i data-lucide="graduation-cap" class="h-6 w-6"></i>
                </div>
            </a>
        </div>

        <nav class="flex flex-col items-center space-y-8 flex-grow" id="sidebar-nav"></nav>

        <div class="mt-auto">
            <button class="w-12 h-12 flex items-center justify-center rounded-full transition-colors"
                onmouseenter="this.style.background='var(--color-primario-p2)'"
                onmouseleave="this.style.background='transparent'">
                <i data-lucide="newspaper" class="h-5 w-5"></i>
            </button>
        </div>
    </div>

    @include('header')

    <main class="md:pl-20 pt-16">

        {{-- Hero --}}
        <section class="py-20 relative overflow-hidden">
            <div class="absolute inset-0 z-0">
                <!-- GRADIENTE -->
                <div class="absolute top-0 left-0 w-full h-full"
                    style="background-image: linear-gradient(135deg,
                        color-mix(in srgb, var(--color-primario-p2) 10%, transparent),
                        color-mix(in srgb, var(--color-primario-p3) 10%, transparent)
                    );">
                </div>

                <!-- CÍRCULO AZUL (20%) -->
                <div class="absolute top-1/4 right-1/4 w-64 h-64 rounded-full"
                    style="background: color-mix(in srgb, var(--color-primario-p3) 20%, transparent);">
                </div>

                <!-- CÍRCULO NARANJA (20%) -->
                <div class="absolute bottom-1/3 left-1/3 w-80 h-80 rounded-full"
                    style="background: color-mix(in srgb, var(--color-secundario-s1) 20%, transparent);">
                </div>
            </div>

            <div class="container mx-auto px-4 md:px-12 z-10 relative">
                <div class="max-w-4xl mx-auto text-center">
                    <h1 class="text-5xl md:text-7xl font-bold leading-tight mb-6">
                        Noticias y
                        <span style="color: var(--color-primario-p2);">Eventos</span>
                    </h1>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto mb-8">
                        Descubre las últimas novedades, logros y eventos de nuestra comunidad educativa.
                    </p>
                </div>
            </div>
        </section>

        {{-- Noticias Destacadas --}}
        <section id="noticias-destacadas" class="py-20 bg-white">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold mt-2">Noticias Destacadas</h2>
                </div>

                {{-- Noticia principal (la más reciente) --}}
                @php
                    use Illuminate\Support\Str;

                    $featuredImg = $featured
                        ? asset(
                            ltrim(
                                str_starts_with($featured->imagen ?? '', '/')
                                    ? $featured->imagen
                                    : '/' . ltrim($featured->imagen ?? 'images/no-photo.jpg', '/'),
                                '/',
                            ),
                        )
                        : asset('images/no-photo.jpg');

                    $featuredDate = $featured?->fecha
                        ? $featured->fecha->locale('es')->translatedFormat('j \\d\\e F, Y')
                        : null;
                @endphp

                @if ($featured)
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                        <div class="lg:col-span-2">
                            <div class="relative rounded-3xl overflow-hidden h-96 lg:h-[500px]">
                                <img src="{{ $featuredImg }}" alt="{{ $featured->titulo }}"
                                    class="w-full h-full object-cover">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex flex-col justify-end p-8">
                                    @if ($featuredDate)
                                        <div class="flex items-center gap-4 mb-4 text-white/80 text-sm">
                                            <i data-lucide="calendar" class="h-4 w-4 mr-2"></i>{{ $featuredDate }}
                                        </div>
                                    @endif
                                    <h3 class="text-3xl lg:text-4xl font-bold text-white mb-4">{{ $featured->titulo }}
                                    </h3>
                                    <p class="text-white/90 text-lg mb-6 max-w-3xl text-justify">
                                        {{ Str::limit($featured->descripcion, 240) }}
                                    </p>
                                    <a href="{{ route('noticias.show', $featured) }}">
                                        <button
                                            class="bg-white hover:bg-white/90 rounded-full px-6 py-3 font-medium transition-colors self-start flex items-center"
                                            style="color: var(--color-primario-p1);">
                                            Leer más <i data-lucide="arrow-right" class="ml-2 h-4 w-4"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Noticias secundarias (resto) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($others as $item)
                        @php
                            $img = asset(
                                ltrim(
                                    str_starts_with($item->imagen ?? '', '/')
                                        ? $item->imagen
                                        : '/' . ltrim($item->imagen ?? 'images/no-photo.jpg', '/'),
                                    '/',
                                ),
                            );
                            $date = $item->fecha?->locale('es')->translatedFormat('j \\d\\e F, Y');
                        @endphp

                        <div
                            class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow fade-in">
                            <div class="relative h-48">
                                <img src="{{ $img }}" alt="{{ $item->titulo }}"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold mb-2">{{ $item->titulo }}</h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3 text-justify">
                                    {{ Str::limit($item->descripcion, 220) }}
                                </p>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center text-gray-500 text-sm">
                                        <i data-lucide="calendar" class="h-4 w-4 mr-2"></i>
                                        <span>{{ $date }}</span>
                                    </div>
                                    <a href="{{ route('noticias.show', $item) }}"
                                        class="font-medium text-sm flex items-center transition-colors"
                                        style="color: var(--color-primario-p2);"
                                        onmouseenter="this.style.color='var(--color-primario-p1)'"
                                        onmouseleave="this.style.color='var(--color-primario-p2)'">
                                        Leer más <i data-lucide="arrow-right" class="ml-1 h-3 w-3"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="rounded-2xl p-10 text-center text-gray-600"
                                style="background: var(--color-neutral);">
                                Aún no hay noticias para mostrar.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </main>

    @include('footer')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.lucide?.createIcons?.();
        });
    </script>
    <script src="/js/web/main.js" defer></script>
</body>

</html>
