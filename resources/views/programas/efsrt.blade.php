{{-- resources/views/programas/efsrt.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EFSRT - Escuela de Formación Superior en Rehabilitación y Terapia</title>

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
                            gray: '#DDE3E8'
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
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js" defer></script>
    <link rel="stylesheet" href="/css/web/efsrt.css">
</head>

<body class="min-h-screen bg-brand-gray text-brand-navy font-sans scroll-smooth">
    <!-- Sidebar -->
    <aside
        class="fixed inset-x-0 bottom-0 md:inset-auto md:top-0 md:left-0 md:h-full md:w-20 z-50 flex md:flex-col items-center justify-center md:justify-start bg-white/80 md:bg-brand-navy/100 backdrop-blur md:backdrop-blur-0 border-t md:border-none">
        <div class="hidden md:block mb-8 mt-8">
            <div class="bg-brand-orange text-white p-2 rounded-full">
                <i data-lucide="heart-pulse" class="h-6 w-6"></i>
            </div>
        </div>
        <nav id="sidebar-nav"
            class="w-full md:w-auto flex md:flex-col items-center justify-between md:justify-start gap-2 md:gap-6 px-3 py-2 md:py-0">
            @foreach ($programas as $p)
                @php $sid = \Illuminate\Support\Str::slug($p->nombre); @endphp
                <button onclick="scrollToSection('{{ $sid }}')"
                    class="nav-dot relative w-10 h-10 md:w-12 md:h-12 flex items-center justify-center transition-all hover:bg-brand-blue/90 rounded-full focus:outline-none focus:ring-2 focus:ring-brand-blue"
                    data-section="{{ $sid }}" title="{{ $p->nombre }}">
                    <span class="h-2.5 w-2.5 rounded-full bg-brand-navy md:bg-white"></span>
                </button>
            @endforeach
        </nav>
    </aside>

    @include('header')

    <main class="pt-16 md:pt-0 md:pl-20">

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
                    Nuestros<span class="gradient-text"> Convenios</span>
                </h1>
                <p class="text-xl text-brand-navy/70 max-w-4xl mx-auto mb-8">
                    Conoce las alianzas estratégicas que fortalecen nuestra formación académica y profesional, acercándonos a empresas líderes a nivel mundial.
                </p>
            </div>
        </section>

        @foreach ($programas as $p)
            @php
                $sid = \Illuminate\Support\Str::slug($p->nombre);
                $isGray = $loop->iteration % 2 === 0;
            @endphp

            <section id="{{ $sid }}" class="py-16 md:py-20 {{ $isGray ? 'bg-brand-gray' : 'bg-white' }}">
                <div class="container">
                    <div class="text-center mb-12">
                        <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-brand-navy mb-8">{{ $p->nombre }}
                        </h2>
                    </div>

                    @if ($p->convenios->isEmpty())
                        <div
                            class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 text-center text-brand-navy">
                            Aún no se han registrado <strong>convenios</strong> para este programa.
                        </div>
                    @else
                        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                            @foreach ($p->convenios as $c)
                                <div
                                    class="program-card bg-white rounded-3xl shadow-lg overflow-hidden border border-gray-100">
                                    <div class="p-8 flex flex-col items-center">
                                        <img src="{{ $c->imagen_url }}?height=120&width=200" alt="{{ $c->entidad }}"
                                            class="w-full h-24 object-contain mb-6" />

                                        {{-- NOMBRE DEL CONVENIO / ENTIDAD --}}
                                        <p class="w-full text-center font-semibold text-brand-navy mb-4 px-2 truncate"
                                            title="{{ $c->entidad }}">
                                            {{ $c->entidad }}
                                        </p>

                                        @if ($c->documento_url)
                                            <a href="{{ $c->documento_url }}" target="_blank" rel="noopener"
                                                class="bg-brand-orange text-white px-6 py-2 rounded-full hover:bg-brand-orange/90 transition-colors flex items-center gap-2"
                                                title="Descargar documento del convenio">
                                                <i data-lucide="download" class="h-4 w-4"></i>
                                                Descargar
                                            </a>
                                        @else
                                            <button type="button"
                                                class="bg-gray-300 text-gray-600 px-6 py-2 rounded-full cursor-not-allowed flex items-center gap-2"
                                                title="Documento no disponible">
                                                <i data-lucide="file-x" class="h-4 w-4"></i>
                                                No disponible
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        @endforeach
    </main>

    @include('footer')

    <script src="/js/web/efsrt.js"></script>
    <script src="/js/web/main.js" defer></script>
</body>

</html>
