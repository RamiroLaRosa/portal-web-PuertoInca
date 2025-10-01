<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Silfer Academia - Educación para el futuro</title>
    
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

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js" defer></script>

    <!-- Your CSS (kept) -->
    <link rel="stylesheet" href="/css/web/main.css" />
    <style>
        /* ---------- Componentes & helpers del landing ---------- */
        .group:hover .group-hover\:opacity-100 {
            opacity: 1;
        }

        .group:hover .group-hover\:visible {
            visibility: visible;
        }

        .program-card {
            transition: all .3s ease;
        }

        .program-card:hover {
            transform: translateY(-8px);
        }

        .carousel-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .carousel-slide.active {
            opacity: 1;
        }

        .carousel-dot.active {
            background-color: white !important;
            transform: scale(1.2);
        }

        #hero-carousel:hover #prev-btn,
        #hero-carousel:hover #next-btn {
            opacity: 1;
        }

        button[title] {
            position: relative;
        }

        button[title]:hover::after {
            content: attr(title);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: #fff;
            padding: 5px 8px;
            border-radius: 6px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 10;
            opacity: 1;
            transition: opacity .3s;
        }
    </style>


    <style>
        /* Fondo del aside */
        #sidebar {
            background-color: rgba(255, 255, 255, 0.8);
        }

        /* mobile: blanco translúcido */
        @media (min-width: 768px) {
            #sidebar {
                background-color: var(--color-primario-p1);
            }

            /* desktop: azul primario */
        }
    </style>

    <style>
        /* Punto interior (mobile: P1; desktop: blanco) */
        #sidebar-nav .nav-dot>span {
            background-color: var(--color-primario-p1);
        }

        @media (min-width: 768px) {
            #sidebar-nav .nav-dot>span {
                background-color: #ffffff;
            }

            /* blanco manual */
        }

        /* Hover del botón (círculo exterior) usando tu P2 */
        #sidebar-nav .nav-dot {
            transition: background-color .2s ease;
        }

        #sidebar-nav .nav-dot:hover {
            background-color: var(--color-primario-p2);
        }

        /* Accesibilidad: focus visible con P2 (reemplazo de focus:ring-brand-blue) */
        #sidebar-nav .nav-dot:focus-visible {
            outline: 2px solid var(--color-primario-p2);
            outline-offset: 2px;
            border-radius: 9999px;
        }
    </style>

</head>

<body class="min-h-screen font-sans scroll-smooth"
    style="background-color: var(--color-neutral); color: var(--color-primario-p1);">
    <!-- Sidebar desktop / Bottom dots mobile -->
    <aside id="sidebar"
        class="fixed inset-x-0 bottom-0 md:inset-auto md:top-0 md:left-0 md:h-full md:w-20 z-50 flex md:flex-col items-center justify-center md:justify-start backdrop-blur md:backdrop-blur-0 border-t md:border-none">

        <!-- Logo (desktop only) -->
        <div class="hidden md:block mb-8 mt-8">
            <a href="{{ url('/') }}" class="inline-flex">
                <div class="text-white p-2 rounded-full" style="background-color: var(--color-secundario-s1);">
                    <i data-lucide="graduation-cap" class="h-6 w-6"></i>
                </div>
            </a>
        </div>

        <!-- Nav dots -->
        <nav id="sidebar-nav"
            class="w-full md:w-auto flex md:flex-col items-center justify-between md:justify-start gap-2 md:gap-6 px-3 py-2 md:py-0">

            <button onclick="scrollToSection('home')"
                class="nav-dot relative w-10 h-10 md:w-12 md:h-12 flex items-center justify-center transition-all rounded-full"
                data-section="home" title="Inicio">
                <span class="h-2.5 w-2.5 rounded-full"></span>
            </button>

            <button onclick="scrollToSection('servicios')"
                class="nav-dot relative w-10 h-10 md:w-12 md:h-12 flex items-center justify-center transition-all rounded-full"
                data-section="servicios" title="Servicios">
                <span class="h-2.5 w-2.5 rounded-full"></span>
            </button>

            <button onclick="scrollToSection('estadisticas')"
                class="nav-dot relative w-10 h-10 md:w-12 md:h-12 flex items-center justify-center transition-all rounded-full"
                data-section="estadisticas" title="Estadísticas">
                <span class="h-2.5 w-2.5 rounded-full"></span>
            </button>

            <button onclick="scrollToSection('programas')"
                class="nav-dot relative w-10 h-10 md:w-12 md:h-12 flex items-center justify-center transition-all rounded-full"
                data-section="programas" title="Programas">
                <span class="h-2.5 w-2.5 rounded-full"></span>
            </button>

            <button onclick="scrollToSection('noticias')"
                class="nav-dot relative w-10 h-10 md:w-12 md:h-12 flex items-center justify-center transition-all rounded-full"
                data-section="noticias" title="Noticias">
                <span class="h-2.5 w-2.5 rounded-full"></span>
            </button>

            <button onclick="scrollToSection('coordinadores')"
                class="nav-dot relative w-10 h-10 md:w-12 md:h-12 flex items-center justify-center transition-all rounded-full"
                data-section="coordinadores" title="Coordinadores">
                <span class="h-2.5 w-2.5 rounded-full"></span>
            </button>

            <button onclick="scrollToSection('porque')"
                class="nav-dot relative w-10 h-10 md:w-12 md:h-12 flex items-center justify-center transition-all rounded-full"
                data-section="porque" title="¿Por qué?">
                <span class="h-2.5 w-2.5 rounded-full"></span>
            </button>

            <button onclick="scrollToSection('testimonios')"
                class="nav-dot relative w-10 h-10 md:w-12 md:h-12 flex items-center justify-center transition-all rounded-full"
                data-section="testimonios" title="Testimonios">
                <span class="h-2.5 w-2.5 rounded-full"></span>
            </button>
        </nav>

    </aside>

    @include('header')

    <main class="pt-16 md:pt-0 md:pl-20">
        <!-- Hero -->
        <section id="home" class="min-h-[80vh] md:min-h-screen flex items-center relative overflow-hidden">
            <div class="absolute inset-0 -z-10">
                <div class="absolute inset-0 bg-gradient-to-br from-brand-orange/10 to-brand-sky/10"
                    style="background-image: linear-gradient(to bottom right,
                        color-mix(in srgb, var(--color-secundario-s1) 10%, transparent),
                        color-mix(in srgb, var(--color-primario-p3) 10%, transparent));">
                </div>
                <div class="absolute top-10 right-1/4 w-40 h-40 md:w-64 md:h-64 rounded-full bg-brand-orange/20"
                    style="background-color: color-mix(in srgb, var(--color-secundario-s1) 20%, transparent);"></div>
                <div class="absolute bottom-10 left-1/3 w-56 h-56 md:w-80 md:h-80 rounded-full bg-yellow-500/20"></div>
            </div>

            <div class="container px-4 md:px-6">
                <div class="grid md:grid-cols-2 gap-8 md:gap-12 items-center py-10 md:py-0">
                    <div class="space-y-6 md:space-y-8">
                        @php
                            $titulo = $hero->titulo ?? 'Educación para el futuro';
                            $descripcion =
                                $hero->descripcion ??
                                'Formamos a los líderes del mañana con metodologías innovadoras, tecnología de vanguardia y un enfoque personalizado.';
                            $words = preg_split('/\s+/', trim($titulo)) ?: [];
                            $last = count($words) ? array_pop($words) : '';
                            $first = implode(' ', $words);
                        @endphp

                        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold leading-tight tracking-tight">
                            {{ $first }}
                            @if ($last !== '')
                                <span class="text-brand-orange"
                                    style="color: var(--color-secundario-s1);">{{ $last }}</span>
                            @endif
                        </h1>

                        <p class="text-base sm:text-lg md:text-xl text-gray-700 max-w-prose">
                            {{ $descripcion }}
                        </p>

                        <!-- CTA visible en mobile también -->
                        <div class="flex flex-wrap gap-3 pt-2">
                            <a href="#programas"
                                class="inline-flex items-center rounded-full bg-brand-orange text-white px-6 py-3 text-sm md:text-base font-medium hover:bg-brand-orange/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-orange"
                                style="background-color: var(--color-secundario-s1);">Explorar
                                programas<i data-lucide="arrow-right" class="ml-2 h-4 w-4"></i></a>
                            <a href="#servicios"
                                class="inline-flex items-center rounded-full bg-white text-brand-navy px-6 py-3 text-sm md:text-base font-medium shadow hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue"
                                style="color: var(--color-primario-p1);">Nuestros
                                servicios</a>
                        </div>
                    </div>

                    <div class="relative order-first md:order-none">
                        <div class="absolute -inset-3 md:-inset-4 bg-gradient-to-br from-brand-orange/20 to-brand-sky/20 rounded-[24px] md:rounded-[30px] blur-md md:blur-lg"
                            style="background-image: linear-gradient(to bottom right,
                                color-mix(in srgb, var(--color-secundario-s1) 20%, transparent),
                                color-mix(in srgb, var(--color-primario-p3) 20%, transparent));">
                        </div>
                        <div class="relative overflow-hidden rounded-[24px] md:rounded-[30px] shadow-2xl">
                            <img src="{{ asset($hero->foto ?? 'images/no-photo.jpg') }}"
                                alt="{{ $hero->titulo ?? 'Imagen de portada' }}"
                                class="w-full h-auto md:h-full object-cover aspect-[4/3] md:aspect-[16/12]" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Servicios -->
        <section id="servicios" class="py-16 md:py-20 relative">
            <div class="container">
                <div class="mb-8 md:mb-12">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mt-2">Nuestros Servicios</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-6">
                    @forelse($servicios ?? collect() as $s)
                        <article class="bg-white rounded-3xl p-6 md:p-8 shadow-lg hover:shadow-xl transition-shadow">
                            <div class="mb-5 md:mb-6 bg-brand-orange/15 p-4 rounded-2xl w-fit"
                                style="background-color: color-mix(in srgb, var(--color-secundario-s1) 15%, transparent);">
                                <i class="{{ $s->icono }} text-brand-orange text-2xl md:text-3xl fa-fw"
                                    style="color: var(--color-secundario-s1);"></i>
                            </div>
                            <h3 class="text-xl md:text-2xl font-bold mb-3 md:mb-4">{{ $s->nombre }}</h3>
                            <p class="text-gray-600; text-justify">{{ $s->descripcion }}</p>
                        </article>
                    @empty
                        <div class="col-span-full text-center text-gray-500">Próximamente publicaremos nuestros
                            servicios.</div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Estadísticas -->
        <section id="estadisticas" class="py-16 md:py-20 bg-brand-navy text-white"
            style="background-color: var(--color-primario-p1);">
            <div class="container">
                <div class="mb-8 md:mb-12">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mt-2">Estadística</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                    @foreach ($estadisticas as $item)
                        <div class="relative">
                            <div class="absolute -inset-2 bg-gradient-to-br from-brand-orange/20 to-brand-sky/20 rounded-3xl blur-lg"
                                style="background-image: linear-gradient(to bottom right,
                                    color-mix(in srgb, var(--color-secundario-s1) 20%, transparent),
                                    color-mix(in srgb, var(--color-primario-p3) 20%, transparent));">
                            </div>
                            <div class="relative bg-brand-blue rounded-3xl p-6 md:p-8 h-full"
                                style="background-color: var(--color-primario-p2);">
                                <div class="mb-5 md:mb-6 bg-brand-navy/60 p-4 rounded-2xl w-fit">
                                    <i class="{{ $item->icono }} text-brand-orange text-xl md:text-2xl"
                                        style="color: var(--color-secundario-s1);"></i>
                                </div>
                                <div class="text-4xl md:text-5xl lg:text-6xl font-bold animate-count"
                                    data-target="{{ (int) $item->cantidad }}"
                                    data-prefix="{{ $loop->last ? '' : '+' }}" data-format="es-PE">0</div>
                                <p class="text-base md:text-lg text-gray-300 mt-3 md:mt-4">{{ $item->descripcion }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Programas -->
        <section id="programas" class="py-16 md:py-20">
            <div class="container">
                <div class="mb-8 md:mb-12 text-center">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mt-2">Programas De Estudio</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                    @forelse($programas as $prog)
                        <article
                            class="program-card bg-white rounded-3xl overflow-hidden shadow-lg border border-gray-100 relative group cursor-pointer">
                            <div class="relative aspect-[16/10]">
                                <img src="{{ asset($prog->imagen ?: 'images/no-photo.jpg') }}"
                                    alt="{{ $prog->nombre }}" class="w-full h-full object-cover"
                                    onerror="this.src='{{ asset('images/no-photo.jpg') }}'">
                            </div>

                            <div class="p-6">
                                <h3
                                    class="text-lg md:text-xl font-bold mb-2 md:mb-3 group-hover:text-brand-blue transition-colors">
                                    {{ $prog->nombre }}
                                </h3>
                                <p class="text-gray-600 text-justify mb-4">{{ $prog->descripcion }}</p>

                                <!-- Added visible "VER EL PROGRAMA" button -->
                                <div class="mt-4">
                                    <a href="{{ route('programas.show.id', $prog->id) }}"
                                        class="inline-flex items-center bg-brand-orange hover:bg-brand-orange/90 text-white rounded-full px-6 py-2.5 text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-orange"
                                        style="background-color: var(--color-secundario-s1);">
                                        Ver el programa
                                        <i data-lucide="arrow-right" class="ml-2 h-4 w-4"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <p class="col-span-full text-center text-gray-500">Aún no hay programas activos para mostrar.
                        </p>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Noticias -->
        <section id="noticias" class="py-16 md:py-20 bg-brand-gray" style="background-color: var(--color-neutral);">
            <div class="container">
                <div class="mb-8 md:mb-12">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mt-2">Últimas Noticias</h2>
                </div>

                @php($principal = $noticias->first())
                @php($secundarias = $noticias->skip(1))

                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-8">
                    <div class="md:col-span-7 lg:col-span-8">
                        @if ($principal)
                            <article class="relative rounded-3xl overflow-hidden h-full min-h-[260px]">
                                <img src="{{ $principal->imagen_url }}" alt="{{ $principal->titulo }}"
                                    class="w-full h-full object-cover" />
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex flex-col justify-end p-5 md:p-8">
                                    <h3 class="text-2xl md:text-3xl font-bold text-white mb-2">
                                        {{ $principal->titulo }}</h3>
                                    <p class="text-white/80 mb-3 md:mb-4 line-clamp-2; text-justify">
                                        {{ $principal->descripcion }}
                                    </p>
                                    <div class="flex items-center text-white/70 text-xs md:text-sm"><i
                                            data-lucide="calendar"
                                            class="h-4 w-4 mr-2"></i><span>{{ $principal->fecha_human }}</span></div>
                                    <a href="{{ url('/noticias/' . $principal->id) }}" class="absolute inset-0"
                                        aria-label="Leer noticia"></a>
                                </div>
                            </article>
                        @else
                            <div class="bg-white rounded-3xl p-8 text-center shadow">
                                <p class="text-gray-500">Aún no hay noticias publicadas.</p>
                            </div>
                        @endif
                    </div>

                    <div class="md:col-span-5 lg:col-span-4 flex flex-col gap-6 md:gap-8">
                        @forelse($secundarias as $n)
                            <article
                                class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                                <div class="relative aspect-[16/9]">
                                    <img src="{{ $n->imagen_url }}" alt="{{ $n->titulo }}"
                                        class="w-full h-full object-cover" />
                                    <a href="{{ url('/noticias/' . $n->id) }}" class="absolute inset-0"
                                        aria-label="Leer noticia"></a>
                                </div>
                                <div class="p-5 md:p-6">
                                    <h3 class="text-lg md:text-xl font-bold mb-1 md:mb-2 hover:text-brand-blue">
                                        {{ $n->titulo }}</h3>
                                    <p class="text-gray-600 text-sm md:text-base mb-3 md:mb-4 line-clamp-2">
                                        {{ $n->descripcion }}</p>
                                    <div class="flex items-center text-gray-500 text-xs md:text-sm"><i
                                            data-lucide="calendar"
                                            class="h-4 w-4 mr-2"></i><span>{{ $n->fecha_human }}</span></div>
                                </div>
                            </article>
                        @empty
                        @endforelse
                    </div>
                </div>

                <div class="mt-8 md:mt-12 text-center">
                    <a href="{{ url('/noticias') }}"
                        class="inline-flex items-center bg-brand-orange hover:bg-brand-orange/90 text-white rounded-full px-6 md:px-8 py-3 font-medium transition-colors"
                        style="background-color: var(--color-secundario-s1);">
                        Ver todas las noticias <i data-lucide="arrow-right" class="ml-2 h-4 w-4"></i>
                    </a>
                </div>
            </div>
        </section>

        <!-- Coordinadores -->
        <section id="coordinadores" class="py-16 md:py-20 bg-white">
            <div class="container">
                <div class="mb-8 md:mb-12">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mt-2">Plana Jerarquica</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse($coordinadores as $c)
                        <article
                            class="bg-white rounded-3xl overflow-hidden shadow-lg border border-gray-100 hover:shadow-xl transition-shadow text-center p-6 md:p-8">
                            <div class="h-28 w-28 md:h-32 md:w-32 mx-auto border-4 border-white shadow-lg rounded-full overflow-hidden bg-brand-orange/15 flex items-center justify-center mb-4 md:mb-6"
                                style="background-color: color-mix(in srgb, var(--color-secundario-s1) 15%, transparent);">
                                <img src="{{ $c->imagen_url }}" alt="{{ $c->nombre }}"
                                    class="w-full h-full object-cover" />
                            </div>
                            <h3 class="text-lg md:text-xl font-bold mb-1">{{ $c->nombre }}</h3>
                            <p class="text-black font-medium text-sm md:text-base">{{ $c->cargo }}</p>
                        </article>
                    @empty
                        <div class="col-span-full">
                            <div class="bg-white rounded-3xl p-8 md:p-10 text-center shadow">
                                <p class="text-gray-500">Aún no hay coordinadores publicados.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Por qué -->
        <section id="porque" class="py-16 md:py-20 bg-brand-gray" style="background-color: var(--color-neutral);">
            <div class="container">
                <div class="mb-8 md:mb-12">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mt-2">¿Por qué estudiar en el IESTP?</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                    @forelse($beneficios as $b)
                        <article
                            class="bg-white rounded-3xl p-6 md:p-8 shadow-lg hover:shadow-xl transition-all duration-300 text-center">
                            <div class="bg-brand-orange/15 p-3 md:p-4 rounded-full w-14 h-14 md:w-16 md:h-16 mx-auto mb-4 md:mb-6 flex items-center justify-center"
                                style="background-color: color-mix(in srgb, var(--color-secundario-s1) 15%, transparent);">
                                <i class="{{ $b->icono }} text-brand-orange text-2xl md:text-3xl"
                                    style="color: var(--color-secundario-s1);"></i>
                            </div>
                            <h3 class="text-lg md:text-xl font-bold mb-3 md:mb-4">{{ $b->nombre }}</h3>
                            <p class="text-gray-600; text-justify">{{ $b->descripcion }}</p>
                        </article>
                    @empty
                        <div class="col-span-full">
                            <div class="bg-white rounded-3xl p-8 md:p-10 text-center shadow">
                                <p class="text-gray-500">Aún no hay beneficios publicados.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Testimonios -->
        <section id="testimonios" class="py-16 md:py-20 bg-white">
            <div class="container">
                <div class="mb-8 md:mb-12">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mt-2">¿Qué opinan nuestros estudiantes?</h2>
                </div>

                <!-- Updated layout to match reference image with larger centered images and horizontal layout -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                    @forelse($testimonios as $t)
                        <article
                            class="bg-white rounded-3xl shadow-lg hover:shadow-xl transition-shadow p-6 md:p-8 text-center border border-gray-100">

                            <!-- Larger centered image at the top -->
                            <div class="flex justify-center mb-6">
                                <div
                                    class="h-24 w-24 md:h-28 md:w-28 lg:h-32 lg:w-32 border-4 border-gray-200 shadow-lg rounded-full overflow-hidden bg-gray-100 flex items-center justify-center">
                                    <img src="{{ $t->imagen_url }}" alt="{{ $t->nombre }}"
                                        class="w-full h-full object-cover" />
                                </div>
                            </div>

                            <!-- Centered stars below image -->
                            <div class="flex items-center justify-center gap-1 mb-4">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i data-lucide="star"
                                        class="h-4 w-4 md:h-5 md:w-5 {{ $i <= (int) ($t->puntuacion ?? 0) ? 'fill-current text-yellow-400' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>

                            <!-- Large centered quote marks -->
                            <div class="mb-4">
                                <div class="flex justify-center mb-3">
                                    <svg class="h-8 w-8 md:h-10 md:w-10 text-brand-navy" fill="currentColor"
                                        viewBox="0 0 24 24" style="color: var(--color-primario-p1);">
                                        <path
                                            d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z">
                                        </path>
                                    </svg>
                                </div>
                                <!-- Centered testimonial text -->
                                <p class="text-gray-600 text-sm md:text-base leading-relaxed text-center px-2">
                                    {{ $t->descripcion }}</p>
                            </div>

                            <!-- Centered name at the bottom -->
                            <h4 class="font-bold text-base md:text-lg text-brand-navy mt-4"
                                style="color: var(--color-primario-p1);">{{ $t->nombre }}</h4>
                        </article>
                    @empty
                        <div class="col-span-full bg-white rounded-3xl p-8 shadow text-center text-gray-500">
                            Aún no hay testimonios publicados.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </main>

    @include('footer')

    <!-- Scripts -->
    <script>
        // Activar Lucide
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) window.lucide.createIcons();
        });

        // Smooth scroll (extra for iOS)
        function scrollToSection(id) {
            const el = document.getElementById(id);
            if (!el) return;
            const y = el.getBoundingClientRect().top + window.pageYOffset - (window.innerWidth >= 768 ? 12 : 72);
            window.scrollTo({
                top: y,
                behavior: 'smooth'
            });
        }
        window.scrollToSection = scrollToSection;

        // Marcar dot activo según sección visible
        const sections = Array.from(document.querySelectorAll('section[id]'));
        const dots = Array.from(document.querySelectorAll('.nav-dot'));
        const map = Object.fromEntries(dots.map(d => [d.dataset.section, d]));

        const io = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    const id = e.target.getAttribute('id');
                    dots.forEach(b => b.classList.remove('ring-2', 'ring-brand-orange'));
                    if (map[id]) map[id].classList.add('ring-2', 'ring-brand-orange');
                }
            });
        }, {
            rootMargin: '-40% 0px -55% 0px',
            threshold: 0.01
        });

        sections.forEach(s => io.observe(s));

        // Contadores animados
        const counters = document.querySelectorAll('.animate-count');
        const seen = new WeakSet();
        const cIo = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting || seen.has(entry.target)) return;
                seen.add(entry.target);
                const el = entry.target;
                const target = parseInt(el.dataset.target || '0', 10);
                const prefix = el.dataset.prefix || '';
                const duration = 1200;
                const start = performance.now();

                function tick(now) {
                    const p = Math.min(1, (now - start) / duration);
                    const val = Math.floor(target * (0.2 + 0.8 * p));
                    el.textContent = prefix + new Intl.NumberFormat(el.dataset.format || 'es-PE').format(
                        val);
                    if (p < 1) requestAnimationFrame(tick);
                }
                requestAnimationFrame(tick);
            });
        }, {
            threshold: 0.2
        });
        counters.forEach(c => cIo.observe(c));
    </script>

    <script src="/js/web/main.js" defer></script>


</body>

</html>
