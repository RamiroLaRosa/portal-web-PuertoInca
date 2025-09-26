<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Misión, Visión y Valores - Silfer Academia</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkfFTOJL2C76qE3T9cf0qvjYQ9r5V5YxYFQki71R+xVQ1BM8DtYbKX2eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            navy: '#00264B',
                            blue: '#1A4FD3',
                            sky: '#4A84F7',
                            orange: '#E27227',
                            gray: '#DDE3E8',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Lucide (iconos) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="stylesheet" href="/css/web/mision.css">
</head>

<body class="min-h-screen bg-brand-gray text-brand-navy font-sans scroll-smooth">

    <!-- Navegación lateral -->
    <aside
        class="fixed top-0 left-0 h-full w-20 bg-brand-navy text-white z-50 hidden md:flex flex-col items-center py-8">
        <div class="mb-12">
            <a href="/">
                <div class="bg-brand-orange text-white p-2 rounded-full">
                    <i data-lucide="graduation-cap" class="h-6 w-6"></i>
                </div>
            </a>
        </div>

        <nav class="flex flex-col items-center space-y-8 flex-grow">
            <button onclick="scrollToSection('mision')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-brand-blue/90 rounded-full"
                data-section="mision" title="Misión">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('vision')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-brand-blue/90 rounded-full"
                data-section="vision" title="Visión">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('valores')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-brand-blue/90 rounded-full"
                data-section="valores" title="Valores">
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
                <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-brand-orange/10 to-brand-sky/10">
                </div>
                <div class="floating-element absolute top-1/4 right-1/4 w-64 h-64 rounded-full bg-brand-orange/20">
                </div>
                <div class="floating-element absolute bottom-1/3 left-1/3 w-80 h-80 rounded-full bg-brand-sky/20"
                    style="animation-delay:-3s"></div>
                <div class="floating-element absolute top-1/2 right-1/3 w-32 h-32 rounded-full bg-brand-blue/30"
                    style="animation-delay:-1.5s"></div>
            </div>
            <div class="container mx-auto px-4 md:px-12 z-10 relative text-center">
                <h1 class="text-5xl md:text-7xl font-bold leading-tight mb-6">
                    Nuestra <span class="gradient-text">Identidad</span>
                </h1>
                <p class="text-xl text-brand-navy/70 max-w-4xl mx-auto mb-8">
                    Explora nuestra <strong>Misión</strong>, <strong>Visión</strong> y los <strong>Valores</strong> que
                    nos definen.
                </p>
            </div>
        </section>

        <!-- MISIÓN -->
        <section id="mision" class="py-20 bg-white">
            <div class="container mx-auto px-4 md:px-12">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div class="order-2 lg:order-1">
                        <div class="relative">
                            <div
                                class="absolute -top-4 -left-4 w-24 h-24 bg-brand-orange/20 rounded-full flex items-center justify-center">
                                <div class="pulse-ring absolute inset-0 bg-brand-orange rounded-full opacity-20"></div>
                                <i data-lucide="target" class="h-12 w-12 text-brand-orange relative z-10"></i>
                            </div>
                            <div class="bg-gradient-to-br from-brand-gray to-white rounded-3xl p-8 md:p-12 ml-8 mt-8">
                                {{-- Mantén tu imagen/tamaño tal cual --}}
                                <img src="{{ asset('images/mision.jpeg') }}" alt="Misión"
                                    class="w-full h-64 object-cover rounded-2xl mb-6">
                            </div>
                        </div>
                    </div>

                    <div class="order-1 lg:order-2">
                        <h2 class="text-4xl md:text-6xl font-bold mt-2 mb-8">Nuestra Misión</h2>

                        <div
                            class="bg-gradient-to-r from-brand-orange to-brand-sky rounded-3xl p-8 md:p-12 text-white mb-8">
                            <div class="flex items-start mb-6">
                                <div class="bg-white/20 p-3 rounded-2xl mr-4 flex-shrink-0">
                                    <i data-lucide="graduation-cap" class="h-8 w-8 text-white"></i>
                                </div>
                                <div>
                                    <p class="text-lg leading-relaxed text-justify">
                                        {!! nl2br(e($mision->descripcion)) !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- VISIÓN -->
        <section id="vision" class="py-20 bg-brand-gray">
            <div class="container mx-auto px-4 md:px-12">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div>
                        <h2 class="text-4xl md:text-6xl font-bold mt-2 mb-8">Nuestra Visión</h2>

                        <div
                            class="bg-gradient-to-r from-brand-orange to-brand-sky rounded-3xl p-8 md:p-12 text-white mb-8">
                            <div class="flex items-start mb-6">
                                <div class="bg-white/20 p-3 rounded-2xl mr-4 flex-shrink-0">
                                    <i data-lucide="eye" class="h-8 w-8 text-white"></i>
                                </div>
                                <div>
                                    <p class="text-lg leading-relaxed text-justify">
                                        {!! nl2br(e($vision->descripcion)) !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="relative">
                            <div
                                class="absolute -top-4 -right-4 w-24 h-24 bg-brand-orange/20 rounded-full flex items-center justify-center">
                                <div class="pulse-ring absolute inset-0 bg-brand-orange rounded-full opacity-20"></div>
                                <i data-lucide="telescope" class="h-12 w-12 text-brand-orange relative z-10"></i>
                            </div>
                            <div class="bg-gradient-to-br from-brand-gray to-white rounded-3xl p-8 md:p-12 ml-8 mt-8">
                                {{-- Mantén tu imagen/tamaño tal cual --}}
                                <img src="{{ asset('images/vision.png') }}" alt="Visión"
                                    class="w-full h-64 object-cover rounded-2xl mb-6">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- VALORES -->
        <section id="valores" class="py-20 bg-white">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-16 text-center">
                    <h2 class="text-4xl md:text-6xl font-bold mt-2 mb-8">Nuestros Valores</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                    @forelse($valores as $v)
                        @php
                            $icono = trim($v->icono ?? '');
                            $isFA = str_contains($icono, 'fa-'); // Font Awesome?
                        @endphp

                        <div
                            class="value-card bg-white rounded-3xl p-8 text-center shadow-lg border border-brand-gray">
                            <div
                                class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 bg-brand-orange">
                                @if ($isFA)
                                    {{-- Font Awesome --}}
                                    <i class="{{ $icono }} text-white fa-2xl leading-none"></i>
                                @else
                                    {{-- Lucide: guarda en BD el nombre del icono (ej. "star", "shield-check", "zap", "heart-handshake", "balance-scale", "users") --}}
                                    <i data-lucide="{{ $icono !== '' ? $icono : 'star' }}"
                                        class="h-8 w-8 text-white"></i>
                                @endif
                            </div>

                            <h3 class="text-2xl font-bold text-brand-navy mb-4">{{ $v->nombre }}</h3>
                            <p class="text-brand-navy/70 text-justify">{!! nl2br(e($v->descripcion)) !!}</p>
                        </div>
                    @empty
                        <div class="col-span-full rounded-xl bg-white p-6 shadow-sm text-brand-navy/70 text-center">
                            Aún no hay valores publicados.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

    </main>

    @include('footer')
    <!-- Scripts -->
    <script src="/js/web/mision.js"></script>
    @php
        $usaFA = $valores->contains(fn($v) => str_starts_with($v->icono, 'fa-') || str_contains($v->icono, 'fa-'));
    @endphp

    @if ($usaFA)
        {{-- CDN mínimo de Font Awesome (solo si algún valor tiene fa-*) --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
            integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkfFTOJL2C76qE3T9cf0qvjYQ9r5V5YxYFQki71R+xVQ1BM8DtYbKX2eQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
    @endif
    <script src="/js/web/main.js" defer></script>
</body>

</html>
