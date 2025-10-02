{{-- resources/views/otros/galeria.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Galerías - Silfer Academia</title>
    @vite('resources/css/css_colores_administrables/css_colores_administrables.css')
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
                            gray: "var(--color-neutral)"
                        },
                    },
                    container: {
                        center: true,
                        padding: {
                            DEFAULT: '1rem',
                            sm: '1.25rem',
                            lg: '2rem',
                            xl: '2.5rem'
                        }
                    },
                },
            },
        };
    </script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js" defer></script>

    <link rel="stylesheet" href="/css/web/galeria.css">

    {{-- Color responsive del aside (solo la parte que usa variable) --}}
    <style>
        @media (min-width: 768px) {
            #sidebar {
                background: var(--color-primario-p1) !important;
                /* md:bg-brand-navy */
            }
        }
    </style>
</head>

<body class="min-h-screen bg-brand-gray text-brand-navy font-sans scroll-smooth"
    style="background: var(--color-neutral); color: var(--color-primario-p1);">

    {{-- Sidebar con dots dinámicos --}}
    <aside id="sidebar"
        class="fixed inset-x-0 bottom-0 md:inset-auto md:top-0 md:left-0 md:h-full md:w-20 z-50 flex md:flex-col items-center justify-center md:justify-start bg-white/80 md:bg-brand-navy/100 backdrop-blur md:backdrop-blur-0 border-t md:border-none">
        <div class="hidden md:block mb-8 mt-8">
            <a href="/" class="inline-flex">
                <div class="text-white p-2 rounded-full" style="background: var(--color-secundario-s1);">
                    <i data-lucide="graduation-cap" class="h-6 w-6"></i>
                </div>
            </a>
        </div>

        <nav id="sidebar-nav"
            class="w-full md:w-auto flex md:flex-col items-center justify-between md:justify-start gap-2 md:gap-6 px-3 py-2 md:py-0">
            @foreach ($programas as $p)
                @php $sid = \Illuminate\Support\Str::slug($p->nombre); @endphp
                <button onclick="scrollToSection('{{ $sid }}')"
                    class="nav-dot relative w-10 h-10 md:w-12 md:h-12 flex items-center justify-center transition-all hover:bg-brand-blue/90 rounded-full focus:outline-none focus:ring-2 focus:ring-brand-blue"
                    data-section="{{ $sid }}" title="{{ $p->nombre }}"
                    onmouseenter="this.style.background='var(--color-primario-p2)'"
                    onmouseleave="this.style.background='transparent'"
                    style="--tw-ring-color: var(--color-primario-p2);">
                    <span class="h-2.5 w-2.5 rounded-full bg-brand-navy md:bg-white"
                        style="background: var(--color-primario-p1);"></span>
                </button>
            @endforeach
        </nav>

        <div class="hidden md:flex mt-auto mb-6">
            <a href="mailto:info@tusitio.com" title="Contacto"
                class="w-12 h-12 flex items-center justify-center hover:bg-brand-blue/90 rounded-full focus:outline-none focus:ring-2 focus:ring-brand-blue"
                onmouseenter="this.style.background='var(--color-primario-p2)'"
                onmouseleave="this.style.background='transparent'" style="--tw-ring-color: var(--color-primario-p2);">
                <i data-lucide="mail" class="h-5 w-5 text-white"></i>
            </a>
        </div>
    </aside>

    @include('header')

    <main class="pt-16 md:pt-0 md:pl-20">

        <section class="py-20 relative overflow-hidden">
            <div class="absolute inset-0 z-0">
                <!-- Gradiente (usa variables con 10%) -->
                <div class="absolute top-0 left-0 w-full h-full"
                    style="background-image: linear-gradient(135deg,
                        color-mix(in srgb, var(--color-secundario-s1) 10%, transparent),
                        color-mix(in srgb, var(--color-primario-p3) 10%, transparent)
                    );">
                </div>
                <!-- Elementos flotantes -->
                <div class="floating-element absolute top-1/4 right-1/4 w-64 h-64 rounded-full"
                    style="background: color-mix(in srgb, var(--color-secundario-s1) 20%, transparent);">
                </div>
                <div class="floating-element absolute bottom-1/3 left-1/3 w-80 h-80 rounded-full"
                    style="background: color-mix(in srgb, var(--color-primario-p3) 20%, transparent); animation-delay:-3s">
                </div>
                <div class="floating-element absolute top-1/2 right-1/3 w-32 h-32 rounded-full"
                    style="background: color-mix(in srgb, var(--color-primario-p2) 30%, transparent); animation-delay:-1.5s">
                </div>
            </div>
            <div class="container mx-auto px-4 md:px-12 z-10 relative text-center">
                <h1 class="text-5xl md:text-7xl font-bold leading-tight mb-6">
                    Nuestra<span class="gradient-text"> Galería</span>
                </h1>
                <p class="text-xl max-w-4xl mx-auto mb-8"
                    style="color: color-mix(in srgb, var(--color-primario-p1) 70%, transparent);">
                    Explora momentos destacados de nuestras actividades académicas, eventos y proyectos.
                    Esta galería captura la esencia de nuestra comunidad y muestra los logros de nuestros estudiantes y
                    docentes.
                </p>
            </div>
        </section>

        @foreach ($programas as $p)
            @php
                $sid = \Illuminate\Support\Str::slug($p->nombre);
                $isGray = $loop->iteration % 2 === 0;
            @endphp

            <section id="{{ $sid }}" class="py-16 md:py-20 {{ $isGray ? 'bg-brand-gray' : 'bg-white' }}"
                @if ($isGray) style="background: var(--color-neutral);" @endif>
                <div class="container">
                    <div class="mb-8 md:mb-12">
                        <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mt-2">{{ $p->nombre }}</h2>
                    </div>

                    @if ($p->galerias->isEmpty())
                        {{-- Mensaje cuando no hay imágenes --}}
                        <div class="rounded-lg text-center py-6 px-4 text-lg"
                            style="background: color-mix(in srgb, var(--color-neutral) 40%, transparent); color: var(--color-primario-p1);">
                            Aún no se han registrado <strong>imágenes</strong> para este programa.
                        </div>
                    @else
                        <div class="gallery-grid">
                            @foreach ($p->galerias as $g)
                                <div class="gallery-item group" tabindex="0"
                                    onclick="openModal('{{ $g->imagen_url }}')">
                                    <img src="{{ $g->imagen_url }}?height=300&width=400"
                                        alt="{{ $g->nombre ?? 'Imagen de ' . $p->nombre }}" />
                                    <div class="gi-overlay">
                                        <span class="gi-title">{{ $g->nombre ?? 'Sin nombre' }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        @endforeach
    </main>

    <div id="imageModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>

    @include('footer')

    <script src="/js/web/galeria.js"></script>
    <script src="/js/web/main.js" defer></script>
</body>

</html>
