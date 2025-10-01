{{-- resources/views/nosotros/locales.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Silfer Academia - Nuestros Locales</title>
    @vite('resources/css/css_colores_administrables/css_colores_administrables.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            navy: 'var(--color-primario-p1)',
                            blue: 'var(--color-primario-p2)',
                            sky: 'var(--color-primario-p3)',
                            orange: 'var(--color-secundario-s1)',
                            gray: 'var(--color-neutral)',
                        }
                    }
                }
            }
        }
    </script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    {{-- estilos opcionales propios --}}
    <link rel="stylesheet" href="/css/web/locales.css">
</head>

<body class="min-h-screen bg-brand-gray text-brand-navy font-sans scroll-smooth"
    style="background-color: var(--color-neutral); color: var(--color-primario-p1);">

    {{-- Variables a partir de la 1.ª fila activa (sede principal) --}}
    @php
        $direccion = $principal->direccion ?? '—';
        $telefono = $principal->telefono ?? '—';
        $correo = $principal->correo ?? '—';
        $horario = $principal->horario ?? '—';
        $fotoUrl = !empty($principal?->foto) ? asset($principal->foto) : null;

        // Extrae solo el SRC del iframe guardado para controlar el tamaño con Tailwind
        $iframeSrc = null;
        if (!empty($principal?->link) && preg_match('/src="([^"]+)"/', $principal->link, $m)) {
            $iframeSrc = $m[1];
        }
    @endphp

    {{-- Sidebar de puntos (decorativo) --}}
    <aside
        class="fixed top-0 left-0 h-full w-20 bg-brand-navy text-white z-50 hidden md:flex flex-col items-center py-8"
        style="background-color: var(--color-primario-p1); color: #ffffff;">
        <div class="mb-12">
            <a href="{{ url('/') }}" aria-label="Inicio">
                <div class="bg-brand-orange text-white p-2 rounded-full"
                    style="background-color: var(--color-secundario-s1); color: #ffffff;">
                    <i data-lucide="graduation-cap" class="h-6 w-6"></i>
                </div>
            </a>
        </div>
        <nav class="flex flex-col items-center space-y-8 flex-grow" id="sidebar-nav">
            <button onclick="scrollToSection('sede-principal')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-brand-blue/70 rounded-full"
                data-section="sede-principal" title="Sede Principal"
                style="/* color base controlado por hover de Tailwind */">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('sedes-secundarias')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-brand-blue/70 rounded-full"
                data-section="sedes-secundarias" title="Sedes Secundarias">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
        </nav>
    </aside>

    {{-- Header público del sitio (tu include habitual) --}}
    @include('header')

    <main class="md:pl-20 pt-16">
        {{-- Hero --}}
        <section class="py-20 relative overflow-hidden">
            <div class="absolute inset-0 z-0">
                <!-- Gradiente suave con variables -->
                <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-brand-orange/10 to-brand-sky/10"
                    style="
                        background-image:
                          linear-gradient(
                            to bottom right,
                            color-mix(in srgb, var(--color-secundario-s1) 10%, transparent),
                            color-mix(in srgb, var(--color-primario-p3) 10%, transparent)
                          );
                     ">
                </div>

                <!-- Burbujas flotantes con transparencias de marca -->
                <div class="floating-element absolute top-1/4 right-1/4 w-64 h-64 rounded-full bg-brand-orange/20"
                    style="
                        background-color: color-mix(in srgb, var(--color-secundario-s1) 20%, transparent);
                     ">
                </div>
                <div class="floating-element absolute bottom-1/3 left-1/3 w-80 h-80 rounded-full bg-brand-sky/20"
                    style="animation-delay:-3s; background-color: color-mix(in srgb, var(--color-primario-p3) 20%, transparent);">
                </div>
                <div class="floating-element absolute top-1/2 right-1/3 w-32 h-32 rounded-full bg-brand-blue/30"
                    style="animation-delay:-1.5s; background-color: color-mix(in srgb, var(--color-primario-p2) 30%, transparent);">
                </div>
            </div>
            <div class="container mx-auto px-4 md:px-12 z-10 relative text-center">
                <h1 class="text-5xl md:text-7xl font-bold leading-tight mb-6">
                    Nuestros <span
                        class="bg-clip-text text-transparent bg-gradient-to-r from-brand-orange to-brand-blue">Locales</span>
                </h1>
                <p class="text-xl text-brand-navy/70 max-w-4xl mx-auto mb-8">
                    Conoce los espacios físicos donde formamos a nuestros estudiantes con seguridad, comodidad y
                    calidad.
                </p>
            </div>
        </section>

        {{-- Si no hay locales activos mostramos un aviso y terminamos --}}
        @if (!$principal)
            <section class="py-20 bg-white">
                <div class="container mx-auto px-4 md:px-12">
                    <div class="bg-white rounded-xl p-8 text-center text-brand-navy/70 shadow-sm">
                        Aún no hay locales activos para mostrar.
                    </div>
                </div>
            </section>
        @else
            {{-- Sede principal (1.ª fila activa) --}}
            <section id="sede-principal" class="py-20 bg-white">
                <div class="container mx-auto px-4 md:px-12">
                    <div class="mb-12">
                        <h2 class="text-4xl md:text-5xl font-bold mt-2">Sede Principal</h2>
                    </div>

                    @if ($fotoUrl)
                        <div class="mb-16">
                            <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                                <img src="{{ $fotoUrl }}" alt="Foto de la Sede Principal - Silfer Academia"
                                    class="w-full h-[400px] md:h-[500px] lg:h-[600px] object-cover">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-brand-navy/60 via-transparent to-transparent">
                                </div>
                                <div class="absolute bottom-8 left-8 text-white">
                                    <h3 class="text-2xl md:text-3xl font-bold mb-2">Nuestra Sede Principal</h3>
                                    <p class="text-lg opacity-90">Un espacio diseñado para tu formación profesional</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="grid lg:grid-cols-2 gap-12 mb-16">
                        <div class="space-y-6">
                            <div class="bg-gradient-to-br from-brand-sky/10 to-brand-orange/10 rounded-3xl p-8">
                                <div class="flex items-start gap-4 mb-6">
                                    <div class="bg-brand-orange p-3 rounded-full">
                                        <i data-lucide="map-pin" class="h-8 w-8 text-white"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold mb-2">Dirección Oficial</h3>
                                        <p class="text-brand-orange font-medium">Según Partida Registral</p>
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

                        <div class="space-y-6">
                            <div
                                class="relative h-[300px] md:h-[360px] lg:h-[420px] rounded-2xl overflow-hidden border border-brand-gray">
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

                <br><br><br>

                <div class="container mx-auto px-4 md:px-12" id="sedes-secundarias">
                    <div class="mb-12 text-center">
                        <h2 class="text-4xl md:text-5xl font-bold mb-4">Sedes Secundarias</h2>
                        <p class="text-xl text-brand-navy/70 max-w-3xl mx-auto">
                            Contamos con múltiples sedes estratégicamente ubicadas para brindarte acceso cercano a
                            educación de calidad.
                        </p>
                    </div>

                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse ($secundarias as $sede)
                            @php
                                $secFoto = $sede->foto ? asset($sede->foto) : asset('images/no-photo.jpg');
                            @endphp
                            <div
                                class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-300">
                                <div class="relative h-64 overflow-hidden">
                                    <img src="{{ $secFoto }}"
                                        class="w-full h-full object-cover transition-transform duration-300 hover:scale-110"
                                        alt="Foto sede secundaria">
                                </div>

                                <div class="p-6 space-y-4">
                                    <div class="flex items-start gap-3">
                                        <div class="bg-brand-orange/10 p-2 rounded-lg flex-shrink-0">
                                            <i data-lucide="map-pin" class="h-5 w-5 text-brand-orange"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-sm mb-1">Dirección</h4>
                                            <p class="text-brand-navy/70 text-sm">{{ $sede->direccion }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-3">
                                        <div class="bg-brand-sky/10 p-2 rounded-lg flex-shrink-0">
                                            <i data-lucide="phone" class="h-5 w-5 text-brand-blue"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-sm mb-1">Teléfono</h4>
                                            <p class="text-brand-navy/70 text-sm">{{ $sede->telefono }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-3">
                                        <div class="bg-brand-sky/10 p-2 rounded-lg flex-shrink-0">
                                            <i data-lucide="mail" class="h-5 w-5 text-brand-blue"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-sm mb-1">Correo</h4>
                                            <p class="text-brand-navy/70 text-sm break-all">{{ $sede->correo }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-3">
                                        <div class="bg-green-50 p-2 rounded-lg flex-shrink-0">
                                            <i data-lucide="clock" class="h-5 w-5 text-brand-blue"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-sm mb-1">Horario</h4>
                                            <p class="text-brand-navy/70 text-sm">{{ $sede->horario }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center text-brand-navy/60">
                                No hay sedes secundarias registradas.
                            </div>
                        @endforelse
            </section>
        @endif
    </main>

    {{-- Footer público del sitio (tu include habitual) --}}
    @include('footer')

    {{-- JS propio --}}
    <script src="/js/web/locales.js"></script>
    <script src="/js/web/main.js" defer></script>
</body>

</html>
