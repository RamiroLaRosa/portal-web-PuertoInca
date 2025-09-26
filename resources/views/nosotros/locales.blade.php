{{-- resources/views/nosotros/locales.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Silfer Academia - Nuestros Locales</title>

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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="stylesheet" href="/css/web/locales.css">
</head>

<body class="min-h-screen bg-brand-gray text-brand-navy font-sans scroll-smooth">

    @php
        // Espera un $local inyectado desde el controlador público (LocalesPublicController)
        // Fallbacks para evitar romper la vista si no hay registro
        $direccion = $local->direccion ?? '—';
        $telefono = $local->telefono ?? '—';
        $correo = $local->correo ?? '—';
        $horario = $local->horario ?? '—';
        $iframeRaw = $local->link ?? null;

        // Extraemos sólo el SRC del iframe guardado en BD para que el tamaño lo controle Tailwind
        $iframeSrc = null;
        if (!empty($iframeRaw) && preg_match('/src="([^"]+)"/', $iframeRaw, $m)) {
            $iframeSrc = $m[1];
        }
    @endphp

    <!-- Navegación lateral -->
    <aside
        class="fixed top-0 left-0 h-full w-20 bg-brand-navy text-white z-50 hidden md:flex flex-col items-center py-8">
        <div class="mb-12">
            <a href="{{ url('/') }}" aria-label="Inicio">
                <div class="bg-brand-orange text-white p-2 rounded-full">
                    <i data-lucide="graduation-cap" class="h-6 w-6"></i>
                </div>
            </a>
        </div>

        <nav class="flex flex-col items-center space-y-8 flex-grow" id="sidebar-nav">
            <button onclick="scrollToSection('sede-principal')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-brand-blue/70 rounded-full"
                data-section="sede-principal" title="Sede Principal">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
        </nav>
    </aside>

    @include('header')

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
                    Nuestros<span class="gradient-text"> Locales</span>
                </h1>
                <p class="text-xl text-brand-navy/70 max-w-4xl mx-auto mb-8">
                    Conoce los espacios físicos donde formamos a nuestros estudiantes con seguridad, comodidad y calidad.
                </p>
            </div>
        </section>

        <!-- Sede Principal -->
        <section id="sede-principal" class="py-20 bg-white">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold mt-2">Sede Principal</h2>
                </div>

                <div class="grid lg:grid-cols-2 gap-12 mb-16">
                    <!-- Dirección -->
                    <div class="space-y-6">
                        <div class="bg-gradient-to-br from-brand-sky/10 to-brand-orange/10 rounded-3xl p-8">
                            <div class="flex items-start gap-4 mb-6">
                                <div class="bg-brand-orange p-3 rounded-full">
                                    <i data-lucide="map-pin" class="h-8 w-8 text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold mb-2">Dirección Oficial</h3>
                                    <p class="text-brand-orange font-medium">Según Partida Registral N° 11023456</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="bg-white rounded-2xl p-6 border border-brand-gray">
                                    <h4 class="font-bold mb-2">Dirección Completa</h4>
                                    <p class="text-brand-navy/80">{{ $direccion }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mapa -->
                    <div class="space-y-6">
                        <div
                            class="map-container relative h-[300px] md:h-[360px] lg:h-[420px] rounded-2xl overflow-hidden border border-brand-gray">
                            @if ($iframeSrc)
                                <iframe src="{{ $iframeSrc }}" class="absolute inset-0 w-full h-full"
                                    style="border:0" allowfullscreen loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                            @else
                                <div
                                    class="absolute inset-0 flex flex-col items-center justify-center text-brand-navy/60">
                                    <i data-lucide="map" class="h-16 w-16 mb-3"></i>
                                    <p class="text-sm">Mapa no disponible por el momento.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Información de Contacto -->
                <div class="bg-brand-gray rounded-3xl p-8">
                    <h3 class="text-2xl font-bold mb-6 text-center">Información de Contacto - Sede Principal</h3>
                    <div class="flex flex-col md:flex-row justify-center items-stretch gap-6">
                        <div class="text-center p-6 shadow-sm flex-1 max-w-xs">
                            <div class="bg-brand-orange/10 p-4 rounded-full w-fit mx-auto mb-4">
                                <i data-lucide="phone" class="h-8 w-8 text-brand-orange"></i>
                            </div>
                            <h4 class="font-bold mb-2">Teléfono</h4>
                            <p class="text-brand-navy/80 text-sm">{{ $telefono }}</p>
                        </div>

                        <div class="text-center p-6 shadow-sm flex-1 max-w-xs">
                            <div class="bg-brand-sky/10 p-4 rounded-full w-fit mx-auto mb-4">
                                <i data-lucide="mail" class="h-8 w-8 text-brand-blue"></i>
                            </div>
                            <h4 class="font-bold mb-2">Correo</h4>
                            <p class="text-brand-navy/80 text-sm">{{ $correo }}</p>
                        </div>

                        <div class="text-center p-6 shadow-sm flex-1 max-w-xs">
                            <div class="bg-green-50 p-4 rounded-full w-fit mx-auto mb-4">
                                <i data-lucide="clock" class="h-8 w-8 text-brand-blue"></i>
                            </div>
                            <h4 class="font-bold mb-2">Horario</h4>
                            <p class="text-brand-navy/80 text-sm">{{ $horario }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('footer')

    <script src="/js/web/locales.js"></script>
    <script src="/js/web/main.js" defer></script>
</body>

</html>
