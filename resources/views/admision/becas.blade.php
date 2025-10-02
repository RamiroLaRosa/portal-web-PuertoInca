<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Becas - Silfer Academia </title>
    @vite('resources/css/css_colores_administrables/css_colores_administrables.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="stylesheet" href="/css/web/becas.css">
</head>

<body
    class="min-h-screen bg-gradient-to-br from-[#DDE3E8] via-white to-[#DDE3E8] text-[#212529] font-sans scroll-smooth"
    style="background-image: linear-gradient(to bottom right, var(--color-neutral), white, var(--color-neutral));">

    <!-- Navegación lateral -->
    <div class="fixed top-0 left-0 h-full w-20 bg-[#00264B] text-white z-50 hidden md:flex flex-col items-center py-8"
        style="background-color: var(--color-primario-p1);">
        <div class="mb-12">
            <div class="bg-[#E27227] text-white p-2 rounded-full" style="background-color: var(--color-secundario-s1);">
                <i data-lucide="graduation-cap" class="h-6 w-6"></i>
            </div>
        </div>
        <nav class="flex flex-col items-center space-y-8 flex-grow" id="sidebar-nav">
            <button onclick="scrollToSection('becas')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-[#1A4FD3]/20 rounded-full"
                data-section="becas" title="Becas">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('historias')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-[#1A4FD3]/20 rounded-full"
                data-section="historias" title="Historias">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <!-- Añadiendo navegación para la nueva sección de beneficiarios -->
            <button onclick="scrollToSection('beneficiarios')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-[#1A4FD3]/20 rounded-full"
                data-section="beneficiarios" title="Beneficiarios">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('proceso')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-[#1A4FD3]/20 rounded-full"
                data-section="proceso" title="Proceso">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
        </nav>
    </div>

    @include('header')

    <main class="md:pl-20 pt-16">
        <!-- Hero Section con diseño único -->
        <section id="hero" class="relative min-h-screen flex items-center justify-center overflow-hidden">
            <!-- Elementos decorativos flotantes -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-20 left-10 w-20 h-20 bg-[#E27227]/20 rounded-full opacity-20 animate-float"
                    style="background-color: color-mix(in srgb, var(--color-secundario-s1) 20%, transparent);"></div>
                <div class="absolute top-40 right-20 w-32 h-32 bg-[#1A4FD3]/20 rounded-full opacity-20 animate-float-delay"
                    style="background-color: color-mix(in srgb, var(--color-primario-p2) 20%, transparent);"></div>
                <div class="absolute bottom-40 left-1/4 w-16 h-16 bg-[#4A84F7]/20 rounded-full opacity-20 animate-float"
                    style="background-color: color-mix(in srgb, var(--color-primario-p3) 20%, transparent);"></div>
                <div class="absolute bottom-20 right-1/3 w-24 h-24 bg-[#DDE3E8] rounded-full opacity-60 animate-float-delay"
                    style="background-color: var(--color-neutral);"></div>
            </div>

            <div class="container mx-auto px-4 text-center relative z-10">
                <div class="max-w-4xl mx-auto">
                    <div class="mb-8">
                        <h1 class="text-6xl md:text-8xl font-black mb-6">
                            Tu <span class="gradient-text"
                                style="background-image: linear-gradient(to right, var(--color-secundario-s1), var(--color-primario-p3)); -webkit-background-clip:text; background-clip:text; color: transparent;">talento</span><br>
                            merece una <span class="gradient-text"
                                style="background-image: linear-gradient(to right, var(--color-secundario-s1), var(--color-primario-p3)); -webkit-background-clip:text; background-clip:text; color: transparent;">beca</span>
                        </h1>
                        <p class="text-xl md:text-2xl text-gray-600 max-w-3xl mx-auto mb-12">
                            Descubre cómo podemos apoyar tu educación con nuestro programa integral de becas y
                            financiamiento
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección de Becas -->
        <section id="becas" class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-5xl md:text-6xl font-black mb-6">Encuentra tu <span class="gradient-text"
                            style="background-image: linear-gradient(to right, var(--color-secundario-s1), var(--color-primario-p3)); -webkit-background-clip:text; background-clip:text; color: transparent;">beca
                            ideal</span></h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Tenemos diferentes opciones diseñadas para reconocer tu talento y apoyar tus sueños académicos
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                    @forelse($becas as $b)
                        <div class="scholarship-card bg-gradient-to-br from-[#DDE3E8] to-white rounded-3xl p-8 border border-[#DDE3E8] relative overflow-hidden"
                            style="background-image: linear-gradient(to bottom right, var(--color-neutral), white); border-color: var(--color-neutral);">
                            <div class="bg-[#1A4FD3] text-white p-4 rounded-2xl w-fit mb-6"
                                style="background-color: var(--color-primario-p2);">
                                @php
                                    $isFa = is_string($b->icono) && str_contains($b->icono, 'fa-'); // ¿es Font Awesome?
                                @endphp

                                @if ($isFa)
                                    <i class="{{ $b->icono }} text-2xl"></i>
                                @else
                                    {{-- Si no es FA, asumimos Lucide (ej: "trophy", "heart", etc.) --}}
                                    <i data-lucide="{{ $b->icono ?: 'award' }}" class="h-8 w-8"></i>
                                @endif
                            </div>

                            <h3 class="text-2xl font-black mb-4">{{ $b->titulo }}</h3>

                            @if ($b->descripcion)
                                <p class="text-gray-700 mb-6 text-justify">{{ $b->descripcion }}</p>
                            @endif

                            @if ($b->requisito)
                                <div class="bg-[#E27227] text-white text-center py-3 rounded-xl font-bold"
                                    style="background-color: var(--color-secundario-s1);">
                                    {{ $b->requisito }}
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="col-span-3 text-center text-gray-500">Aún no hay becas registradas.</div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Beneficiarios -->
        <section id="beneficiarios" class="py-20 bg-gradient-to-br from-[#DDE3E8] to-white"
            style="background-image: linear-gradient(to bottom right, var(--color-neutral), white);">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-5xl font-black mb-6">
                        Nuestros <span class="gradient-text"
                            style="background-image: linear-gradient(to right, var(--color-secundario-s1), var(--color-primario-p3)); -webkit-background-clip:text; background-clip:text; color: transparent;">beneficiarios</span>
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Conoce a los estudiantes que han obtenido becas organizados por programa de estudio
                    </p>
                </div>

                @forelse($beneficiarios as $programaNombre => $items)
                    <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100 max-w-7xl mx-auto mb-12">
                        <h3 class="text-3xl font-black text-gray-800 mb-8">{{ $programaNombre }}</h3>

                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="bg-gradient-to-r from-[#1A4FD3] to-[#4A84F7] text-white"
                                        style="background-image: linear-gradient(to right, var(--color-primario-p2), var(--color-primario-p3));">
                                        <th class="text-left p-4 rounded-tl-xl font-bold">Beneficiario</th>
                                        <th class="text-left p-4 font-bold">Tipo de Beca</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $row)
                                        <tr class="border-b border-gray-100 hover:bg-[#4A84F7]/10 transition-colors"
                                            style="/* hover mantiene Tailwind */">
                                            <td class="p-4">
                                                <span
                                                    class="font-semibold text-gray-800 text-justify">{{ $row->nombre }}</span>
                                            </td>
                                            <td class="p-4 text-gray-800 font-medium text-justify">
                                                {{ optional($row->tipo)->titulo ?? '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @empty
                    <div class="max-w-4xl mx-auto text-center text-gray-600">
                        Aún no hay beneficiarios publicados.
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Proceso simplificado con timeline horizontal -->
        <section id="proceso" class="py-20 bg-gradient-to-br from-[#00264B] to-[#1A4FD3] text-white"
            style="background-image: linear-gradient(to bottom right, var(--color-primario-p1), var(--color-primario-p2));">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-5xl font-black mb-6">
                        Proceso <span class="text-[#E27227]" style="color: var(--color-secundario-s1);">súper
                            simple</span>
                    </h2>
                    <p class="text-xl text-[#DDE3E8] max-w-3xl mx-auto" style="color: var(--color-neutral);">
                        Solo {{ max(1, $procesos->count()) }} pasos para obtener tu beca y cambiar tu futuro
                    </p>
                </div>

                @if ($procesos->isEmpty())
                    <div class="max-w-4xl mx-auto text-center text-[#DDE3E8]" style="color: var(--color-neutral);">
                        Aún no hay pasos publicados.
                    </div>
                @else
                    <div class="max-w-6xl mx-auto">
                        {{-- Usamos 4 columnas como en el diseño original --}}
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                            @foreach ($procesos as $p)
                                <div class="text-center relative">
                                    <div class="bg-gradient-to-br from-[#1A4FD3] to-[#4A84F7] w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg"
                                        style="background-image: linear-gradient(to bottom right, var(--color-primario-p2), var(--color-primario-p3));">
                                        <span class="text-2xl font-black">{{ $p->nro_paso }}</span>
                                    </div>

                                    {{-- Conector entre bolitas (solo en desktop y si no es el último) --}}
                                    @if (!$loop->last)
                                        <div class="hidden md:block absolute top-10 left-full w-full h-0.5 bg-gradient-to-r from-[#4A84F7] to-[#DDE3E8]/40"
                                            style="background-image: linear-gradient(to right, var(--color-primario-p3), color-mix(in srgb, var(--color-neutral) 40%, transparent));">
                                        </div>
                                    @endif

                                    <h3 class="text-xl font-bold mb-3">{{ $p->titulo }}</h3>
                                    <p class="text-[#DDE3E8] text-sm text-justify"
                                        style="color: var(--color-neutral);">
                                        {{ $p->descripcion }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- CTA Final -->
        <section
            class="py-20 bg-gradient-to-r from-[#00264B] via-[#1A4FD3] to-[#4A84F7] text-white relative overflow-hidden"
            style="background-image: linear-gradient(to right, var(--color-primario-p1), var(--color-primario-p2), var(--color-primario-p3));">
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="container mx-auto px-4 relative z-10">
                <div class="max-w-4xl mx-auto text-center">
                    <h2 class="text-6xl md:text-8xl font-black mb-8">
                        Tu momento es <span class="text-[#E27227]"
                            style="color: var(--color-secundario-s1);">AHORA</span>
                    </h2>
                    <p class="text-2xl md:text-3xl font-medium mb-12 leading-relaxed">
                        No dejes que nada detenga tus sueños.<br>
                        Tu beca te está esperando.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-6 justify-center mb-16">
                        <button
                            class="bg-white text-[#E27227] hover:bg-gray-100 rounded-full px-12 py-5 text-xl font-black transition-all transform hover:scale-105 shadow-2xl"
                            style="color: var(--color-secundario-s1);">
                            POSTULAR AHORA
                        </button>
                        <button
                            class="border-3 border-white text-white hover:bg-white hover:text-[#E27227] rounded-full px-12 py-5 text-xl font-black transition-all">
                            HABLAR CON ASESOR
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('footer')

    @vite('resources/js/admision/beca.js')
    <script src="/js/web/main.js" defer></script>
</body>

</html>
