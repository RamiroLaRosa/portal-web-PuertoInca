<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrícula - Silfer Academia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="matricula.css">
    <link rel="stylesheet" href="/css/web/matricula.css">
</head>

<body
    class="min-h-screen bg-gradient-to-br from-[#DDE3E8] via-white to-[#4A84F7]/20 text-[#212529] font-sans scroll-smooth">
    <!-- Navegación lateral -->
    <div class="fixed top-0 left-0 h-full w-20 bg-[#00264B] text-white z-50 hidden md:flex flex-col items-center py-8">
        <div class="mb-12">
            <div class="bg-[#E27227] text-white p-2 rounded-full">
                <i data-lucide="graduation-cap" class="h-6 w-6"></i>
            </div>
        </div>
        <nav class="flex flex-col items-center space-y-8 flex-grow" id="sidebar-nav">
            <button onclick="scrollToSection('hero')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-[#0F3B73] rounded-full"
                data-section="hero" title="Hero">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('tipos')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-[#0F3B73] rounded-full"
                data-section="tipos" title="Tipos">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('requisitos')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-[#0F3B73] rounded-full"
                data-section="requisitos" title="Requisitos">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('proceso')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-[#0F3B73] rounded-full"
                data-section="proceso" title="Proceso">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('costos')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-[#0F3B73] rounded-full"
                data-section="costos" title="Costos">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('cronograma')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-[#0F3B73] rounded-full"
                data-section="cronograma" title="Cronograma">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
        </nav>
    </div>

    @include('header')

    <main class="md:pl-20 pt-16">
        <!-- Hero Section -->
        <section id="hero"
            class="relative min-h-screen flex items-center overflow-hidden bg-gradient-to-br from-[#DDE3E8] via-white to-[#4A84F7]/30">
            <!-- Elementos flotantes decorativos -->
            <div class="absolute top-20 left-10 w-20 h-20 bg-[#1A4FD3]/20 rounded-full opacity-20 animate-float"></div>
            <div
                class="absolute top-40 right-20 w-32 h-32 bg-[#4A84F7]/30 rounded-full opacity-20 animate-float-delayed">
            </div>
            <div class="absolute bottom-20 left-1/4 w-16 h-16 bg-[#E27227]/20 rounded-full opacity-20 animate-float">
            </div>

            <div class="container mx-auto px-4 md:px-12 z-10 relative">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h1 class="text-5xl md:text-6xl font-black leading-tight mb-6">
                            Tu matrícula en
                            <span class="gradient-text">3 simples pasos</span>
                        </h1>
                        <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                            Proceso 100% digital, rápido y seguro. Matricúlate desde cualquier lugar
                            y en cualquier momento con nuestra plataforma inteligente.
                        </p>
                    </div>

                    <div class="relative">
                        <div
                            class="bg-white rounded-3xl shadow-2xl p-8 transform rotate-3 hover:rotate-0 transition-transform duration-500">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-bold">Progreso de Matrícula</h3>
                                <span
                                    class="bg-[#DDE3E8] text-[#00264B] px-3 py-1 rounded-full text-sm font-medium">75%</span>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-[#4A84F7] rounded-full flex items-center justify-center">
                                        <i data-lucide="check" class="h-4 w-4 text-white"></i>
                                    </div>
                                    <span class="text-gray-700">Datos personales</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-[#4A84F7] rounded-full flex items-center justify-center">
                                        <i data-lucide="check" class="h-4 w-4 text-white"></i>
                                    </div>
                                    <span class="text-gray-700">Selección de cursos</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-[#E27227] rounded-full flex items-center justify-center">
                                        <i data-lucide="clock" class="h-4 w-4 text-white"></i>
                                    </div>
                                    <span class="text-gray-700">Pago de matrícula</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-[#DDE3E8] rounded-full flex items-center justify-center">
                                        <i data-lucide="circle" class="h-4 w-4 text-white"></i>
                                    </div>
                                    <span class="text-gray-400">Confirmación</span>
                                </div>
                            </div>
                            <div class="mt-6">
                                <div class="bg-[#DDE3E8] rounded-full h-2">
                                    <div class="progress-bar w-3/4 rounded-full"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tipos de Matrícula -->
        <section id="tipos" class="py-20 bg-gradient-to-br from-white to-[#DDE3E8]/40">
            <div class="container mx-auto px-4 md:px-12">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-black mb-4">
                        Tipos de <span class="gradient-text">Matrícula</span>
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Encuentra el tipo de matrícula que se adapte a tu situación académica
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($tipos as $tipo)
                        <div class="card-hover bg-white rounded-2xl p-8 shadow-lg border-l-4 border-[#1A4FD3]">
                            <div class="flex items-center justify-between mb-6">
                                <div class="bg-[#DDE3E8] p-3 rounded-xl">
                                    <i
                                        class="{{ $tipo->icono ?: 'fa-solid fa-circle-info' }} text-[#1A4FD3] text-2xl"></i>
                                </div>
                            </div>
                            <h3 class="text-2xl font-bold mb-3">{{ $tipo->titulo }}</h3>
                            <p class="text-gray-600 mb-6 text-justify">{{ $tipo->descripcion }}</p>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="bg-white rounded-2xl p-8 shadow text-center text-gray-600">
                                No hay tipos de matrícula activos por ahora.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Requisitos Detallados -->
        <section id="requisitos" class="py-20 bg-white">
            <div class="container mx-auto px-4 md:px-12">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-black mb-4">
                        <span class="gradient-text">Requisitos</span> Para Matrícula
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Toda la información que necesitas para completar tu proceso de matrícula
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    @foreach ($requisitos as $req)
                        <div
                            class="bg-gradient-to-br from-[#DDE3E8] to-white rounded-2xl p-8 shadow-lg border border-[#DDE3E8]">
                            <div class="flex items-center mb-6">
                                <div class="bg-[#1A4FD3] text-white p-3 rounded-xl mr-4">
                                    {{-- Icono desde BD (Font Awesome) --}}
                                    <i class="{{ $req->icono ?: 'fa-solid fa-circle-info' }} text-xl"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-[#00264B]">
                                    {{ $req->titulo }}
                                </h3>
                            </div>

                            <div class="space-y-4">
                                @forelse($req->detalles as $det)
                                    <div class="flex items-start gap-3">
                                        <span
                                            class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-[#4A84F7] text-white shrink-0 mt-1">
                                            <i class="fa-solid fa-check text-[10px] leading-none"></i>
                                        </span>
                                        <span class="text-gray-700 text-justify">{{ $det->descripcion }}</span>
                                    </div>
                                @empty
                                    <div class="text-gray-500 text-sm">— Sin ítems —</div>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Proceso de Matrícula -->
        <section id="proceso" class="py-20 bg-gradient-to-r from-[#00264B] to-[#1A4FD3] text-white">
            <div class="container mx-auto px-4 md:px-12">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-black mb-4">
                        Proceso <span class="text-[#DDE3E8]">súper fácil</span>
                    </h2>
                    <p class="text-xl text-[#DDE3E8] max-w-2xl mx-auto">
                        Solo {{ $pasos->count() }} pasos para completar tu matrícula de forma digital
                    </p>
                </div>

                @if ($pasos->isNotEmpty())
                    <div class="max-w-6xl mx-auto">
                        <div class="grid grid-cols-1 md:grid-cols-{{ max(1, min(6, $pasos->count())) }} gap-8">
                            @foreach ($pasos as $paso)
                                <div class="text-center relative">
                                    <div class="relative mb-6">
                                        {{-- número dentro del círculo --}}
                                        <div
                                            class="w-20 h-20 bg-gradient-to-br from-[#4A84F7] to-[#1A4FD3] rounded-full
                                      flex items-center justify-center mx-auto shadow-lg">
                                            <span class="text-2xl font-black text-white">
                                                {{ $paso->numero_paso ?? $loop->iteration }}
                                            </span>
                                        </div>

                                        {{-- conector (solo si NO es el último) --}}
                                        @if (!$loop->last)
                                            <div
                                                class="hidden md:block absolute top-10 left-full w-full h-0.5
                                        bg-gradient-to-r from-[#4A84F7] to-[#DDE3E8]">
                                            </div>
                                        @endif
                                    </div>

                                    {{-- título y descripción --}}
                                    <h3 class="text-xl font-bold mb-3">{{ $paso->titulo }}</h3>
                                    @if (!empty($paso->descripcion))
                                        <p class="text-[#DDE3E8] text-justify">{{ $paso->descripcion }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <p class="text-center text-[#DDE3E8]">Pronto publicaremos los pasos del proceso.</p>
                @endif
            </div>
        </section>

        <!-- Cronograma -->
        <section id="cronograma" class="py-20 bg-gradient-to-br from-white to-[#DDE3E8]/40">
            <div class="container mx-auto px-4 md:px-12">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-black mb-4">
                        <span class="gradient-text">Cronograma</span> 2025
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Fechas importantes que no puedes perderte
                    </p>
                </div>

                <div class="max-w-4xl mx-auto flex justify-center">
                    <div class="w-full max-w-md">
                        <div class="bg-white rounded-3xl p-8 shadow-xl">
                            <div class="text-center mb-8">
                                <h3 class="text-3xl font-black text-[#1A4FD3] mb-2">Semestre 2025-I</h3>
                                <p class="text-gray-600">Marzo - Julio 2025</p>
                            </div>

                            <div class="space-y-6">
                                @forelse($cronograma as $item)
                                    <div class="flex items-start gap-4">
                                        <div class="bg-[#1A4FD3] text-white p-3 rounded-full flex-shrink-0">
                                            <i class="{{ $item->icono ?: 'fa-solid fa-calendar' }} text-base"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-[#0f2e5a]">{{ $item->titulo }}</h4>

                                            @if ($item->fecha)
                                                <p class="text-[#1A4FD3] font-medium text-sm">
                                                    {{ \Carbon\Carbon::parse($item->fecha)->locale('es')->isoFormat('D [de] MMMM') }}
                                                </p>
                                            @endif

                                            @if ($item->descripcion)
                                                <p class="text-gray-600 text-sm text-justify">{{ $item->descripcion }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-gray-500">Sin eventos por ahora.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Final 
        <section class="py-20 bg-gradient-to-r from-[#1A4FD3] to-[#4A84F7] text-white">
            <div class="container mx-auto px-4 md:px-12">
                <div class="max-w-4xl mx-auto text-center">
                    <h2 class="text-4xl md:text-6xl font-black mb-6">¡Tu futuro te espera!</h2>
                    <p class="text-xl text-[#DDE3E8] mb-8 max-w-2xl mx-auto">
                        No esperes más. Inicia tu matrícula ahora y asegura tu lugar en la universidad líder en
                        innovación educativa.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                        <button
                            class="bg-white text-[#1A4FD3] hover:bg-[#DDE3E8] rounded-xl px-12 py-4 text-lg font-bold transition-all transform hover:scale-105 shadow-lg">
                            Matricularme Ahora
                        </button>
                        <button
                            class="border-2 border-white text-white hover:bg-white hover:text-[#1A4FD3] rounded-xl px-12 py-4 text-lg font-bold transition-all">
                            Hablar con Asesor
                        </button>
                    </div>
                </div>
            </div>
        </section> -->
    </main>

    @include('footer')

    @vite('resources/js/admision/matricula.js')
    <script src="/js/web/main.js" defer></script>
</body>

</html>
