<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Misión, Visión y Valores - Silfer Academia</title>

    <!-- Variables administrables -->
    <link rel="stylesheet" href="{{ asset('css/css_colores_administrables/css_colores_administrables.css') }}">

    <!-- Iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <!-- Tailwind -->
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

    <!-- Lucide (iconos) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <link rel="stylesheet" href="/css/web/mision.css">
</head>

<body class="min-h-screen bg-brand-gray text-brand-navy font-sans scroll-smooth"
    style="background-color: var(--color-neutral); color: var(--color-primario-p1);">

    <!-- Navegación lateral -->
    <aside
        class="fixed top-0 left-0 h-full w-20 bg-brand-navy text-white z-50 hidden md:flex flex-col items-center py-8"
        style="background-color: var(--color-primario-p1); color:#fff;">
        <div class="mb-12">
            <a href="/">
                <div class="bg-brand-orange text-white p-2 rounded-full"
                    style="background-color: var(--color-secundario-s1); color:#fff;">
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
                <!-- gradiente naranja -> celeste -->
                <div class="absolute top-0 left-0 w-full h-full"
                    style="background-image: linear-gradient(to bottom right,
                           color-mix(in srgb, var(--color-secundario-s1) 10%, transparent),
                           color-mix(in srgb, var(--color-primario-p3) 10%, transparent));">
                </div>
                <div class="floating-element absolute top-1/4 right-1/4 w-64 h-64 rounded-full"
                    style="background-color: color-mix(in srgb, var(--color-secundario-s1) 20%, transparent);">
                </div>
                <div class="floating-element absolute bottom-1/3 left-1/3 w-80 h-80 rounded-full"
                    style="background-color: color-mix(in srgb, var(--color-primario-p3) 20%, transparent); animation-delay:-3s">
                </div>
                <div class="floating-element absolute top-1/2 right-1/3 w-32 h-32 rounded-full"
                    style="background-color: color-mix(in srgb, var(--color-primario-p2) 30%, transparent); animation-delay:-1.5s">
                </div>
            </div>
            <div class="container mx-auto px-4 md:px-12 z-10 relative text-center">
                <h1 class="text-5xl md:text-7xl font-bold leading-tight mb-6">
                    Nuestra <span class="gradient-text">Identidad</span>
                </h1>
                <p class="text-xl text-brand-navy/70 max-w-4xl mx-auto mb-8"
                    style="color: var(--color-primario-p1); opacity:.7;">
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
                            <div class="absolute -top-4 -left-4 w-24 h-24 rounded-full flex items-center justify-center"
                                style="background-color: color-mix(in srgb, var(--color-secundario-s1) 20%, transparent);">
                                <div class="pulse-ring absolute inset-0 rounded-full opacity-20"
                                    style="background-color: var(--color-secundario-s1);"></div>
                                <i data-lucide="target" class="h-12 w-12 relative z-10"
                                    style="color: var(--color-secundario-s1);"></i>
                            </div>
                            <div class="rounded-3xl p-8 md:p-12 ml-8 mt-8"
                                style="background-image: linear-gradient(135deg, var(--color-neutral), #ffffff);">
                                <img src="{{ asset('images/mision.jpeg') }}" alt="Misión"
                                    class="w-full h-64 object-cover rounded-2xl mb-6">
                            </div>
                        </div>
                    </div>

                    <div class="order-1 lg:order-2">
                        <h2 class="text-4xl md:text-6xl font-bold mt-2 mb-8">Nuestra Misión</h2>

                        <div class="rounded-3xl p-8 md:p-12 text-white mb-8"
                            style="background: linear-gradient(90deg, var(--color-secundario-s1), var(--color-primario-p3)); color:#fff;">
                            <div class="flex items-start mb-6">
                                <div class="p-3 rounded-2xl mr-4 flex-shrink-0"
                                    style="background-color: color-mix(in srgb, #ffffff 20%, transparent);">
                                    <i data-lucide="graduation-cap" class="h-8 w-8" style="color:#ffffff;"></i>
                                </div>
                                <div>
                                    <p class="text-lg leading-relaxed text-justify" style="color:#ffffff;">
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
        <section id="vision" class="py-20 bg-brand-gray" style="background-color: var(--color-neutral);">
            <div class="container mx-auto px-4 md:px-12">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div>
                        <h2 class="text-4xl md:text-6xl font-bold mt-2 mb-8">Nuestra Visión</h2>

                        <div class="rounded-3xl p-8 md:p-12 text-white mb-8"
                            style="background: linear-gradient(90deg, var(--color-secundario-s1), var(--color-primario-p3)); color:#fff;">
                            <div class="flex items-start mb-6">
                                <div class="p-3 rounded-2xl mr-4 flex-shrink-0"
                                    style="background-color: color-mix(in srgb, #ffffff 20%, transparent);">
                                    <i data-lucide="eye" class="h-8 w-8" style="color:#ffffff;"></i>
                                </div>
                                <div>
                                    <p class="text-lg leading-relaxed text-justify" style="color:#ffffff;">
                                        {!! nl2br(e($vision->descripcion)) !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="relative">
                            <div class="absolute -top-4 -right-4 w-24 h-24 rounded-full flex items-center justify-center"
                                style="background-color: color-mix(in srgb, var(--color-secundario-s1) 20%, transparent);">
                                <div class="pulse-ring absolute inset-0 rounded-full opacity-20"
                                    style="background-color: var(--color-secundario-s1);"></div>
                                <i data-lucide="telescope" class="h-12 w-12 relative z-10"
                                    style="color: var(--color-secundario-s1);"></i>
                            </div>
                            <div class="rounded-3xl p-8 md:p-12 ml-8 mt-8"
                                style="background-image: linear-gradient(135deg, var(--color-neutral), #ffffff);">
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
                            $isFA = str_contains($icono, 'fa-');
                        @endphp

                        <div class="value-card bg-white rounded-3xl p-8 text-center shadow-lg border"
                            style="border-color: var(--color-neutral);">
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6"
                                style="background-color: var(--color-secundario-s1);">
                                @if ($isFA)
                                    <i class="{{ $icono }} text-white fa-2xl leading-none"
                                        style="color:#ffffff;"></i>
                                @else
                                    <i data-lucide="{{ $icono !== '' ? $icono : 'star' }}" class="h-8 w-8"
                                        style="color:#ffffff;"></i>
                                @endif
                            </div>

                            <h3 class="text-2xl font-bold text-brand-navy mb-4"
                                style="color: var(--color-primario-p1);">{{ $v->nombre }}</h3>
                            <p class="text-brand-navy/70 text-justify"
                                style="color: var(--color-primario-p1); opacity:.7;">
                                {!! nl2br(e($v->descripcion)) !!}
                            </p>
                        </div>
                    @empty
                        <div class="col-span-full rounded-xl bg-white p-6 shadow-sm text-center"
                            style="color: var(--color-primario-p1); opacity:.7;">
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
            integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkfFTOJL2C76qE3T9cf0qvjYQ9r5V5YxYFQki71R+xVQ1BM8DtYbKX2eQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
    @endif
    <script src="/js/web/main.js" defer></script>
</body>

</html>
