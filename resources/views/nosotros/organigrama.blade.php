<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Silfer Academia - Organización Institucional</title>

    {{-- Tailwind --}}
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

    {{-- Lucide (iconos) --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    {{-- (opcional) tus estilos extra --}}
    <link rel="stylesheet" href="{{ asset('organizacion.css') }}">
    <link rel="stylesheet" href="/css/web/organigrama.css">
</head>

<body class="min-h-screen bg-[#f8f9fa] text-[#212529] font-sans scroll-smooth">
    {{-- Barra lateral fija --}}
    <aside
        class="fixed top-0 left-0 h-full w-20 bg-brand-navy text-white z-50 hidden md:flex flex-col items-center py-8">
        <div class="mb-12">
            <a href="{{ url('/') }}">
                <div class="bg-brand-orange text-white p-2 rounded-full">
                    <i data-lucide="graduation-cap" class="h-6 w-6"></i>
                </div>
            </a>
        </div>
        <nav class="flex flex-col items-center space-y-8 flex-grow">
            <button onclick="scrollToSection('organigrama')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-brand-blue/90 rounded-full"
                data-section="organigrama" title="Organigrama">
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
                    Nuestra <span class="gradient-text">Organización</span>
                </h1>
                <p class="text-xl text-brand-navy/70 max-w-4xl mx-auto mb-8">
                    Conoce la estructura jerárquica que guía el funcionamiento de nuestra institución.
                </p>
            </div>
        </section>

        {{-- ORGANIGRAMA --}}
        <section id="organigrama" class="py-20 bg-white">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold mt-2">Organigrama Institucional</h2>
                </div>

                {{-- Controles + Iframe (sin loader) --}}
                <div class="pdf-embed-container relative" id="pdfContainer">
                    <div class="pdf-embed-inner">

                        {{-- Controles (opcionales) --}}
                        <div class="pdf-controls px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <i data-lucide="file-text" class="h-5 w-5"></i>
                                <h3 class="font-semibold">Organigrama Institucional</h3>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button onclick="zoomOut()" class="pdf-control-btn p-2 rounded-lg" title="Reducir zoom"
                                    data-hide-on-mobile>
                                    <i data-lucide="zoom-out" class="h-4 w-4"></i>
                                </button>
                                <span id="zoomLevel" class="text-sm font-medium px-2" data-hide-on-mobile>100%</span>
                                <button onclick="zoomIn()" class="pdf-control-btn p-2 rounded-lg" title="Aumentar zoom"
                                    data-hide-on-mobile>
                                    <i data-lucide="zoom-in" class="h-4 w-4"></i>
                                </button>
                                <button onclick="downloadPDF()" class="pdf-control-btn p-2 rounded-lg"
                                    title="Descargar PDF">
                                    <i data-lucide="download" class="h-4 w-4"></i>
                                </button>
                                <button onclick="toggleFullscreen()" class="pdf-control-btn p-2 rounded-lg"
                                    title="Pantalla completa">
                                    <i data-lucide="maximize" class="h-4 w-4" id="fullscreenIcon"></i>
                                </button>
                            </div>
                        </div>

                        @php $pdfUrl = $documentUrl; @endphp

                        {{-- IFRAME DIRECTO --}}
                        @if ($pdfUrl)
                            <div class="pdf-frame-wrapper">
                                <iframe id="pdfIframe" src="{{ $pdfUrl }}" class="pdf-iframe"
                                    frameborder="0"></iframe>
                            </div>
                        @else
                            <div class="h-96 flex items-center justify-center text-brand-navy/70">
                                Documento no disponible.
                            </div>
                        @endif

                        {{-- Pie de documento --}}
                        <div
                            class="bg-brand-gray/30 px-6 py-3 border-t flex items-center justify-between text-sm text-brand-navy/70">
                            <div class="flex items-center space-x-2">
                                <i data-lucide="info" class="h-4 w-4"></i>
                                <span>Documento actualizado:
                                    {{ optional($row?->updated_at)->translatedFormat('F Y') ?? '—' }}</span>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="flex items-center space-x-1">
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    <span>Cargado correctamente</span>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('footer')



    <script src="/js/web/organigrama.js"></script>
    <script src="/js/web/main.js" defer></script>
</body>

</html>
