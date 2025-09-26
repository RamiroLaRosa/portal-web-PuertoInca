{{-- resources/views/transparencia/licenciamiento.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Silfer Academia - Licenciamiento</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    {{-- Estilos propios opcionales --}}
    <link rel="stylesheet" href="/css/web/licenciamiento.css">
</head>

<body class="min-h-screen bg-[#f8f9fa] text-[#212529] font-sans scroll-smooth">

    {{-- Sidebar mínimo (desktop) --}}
    <div class="fixed top-0 left-0 h-full w-20 bg-[#00264B] text-white z-50 hidden md:flex flex-col items-center py-8">
        <div class="mb-12">
            <div class="bg-[#E27227] text-white p-2 rounded-full">
                <i data-lucide="graduation-cap" class="h-6 w-6"></i>
            </div>
        </div>
    </div>

    @include('header')

    <main class="md:pl-20 pt-16">

        {{-- ENCABEZADO --}}
        <section class="py-10">
            <div class="container mx-auto px-4 md:px-12 max-w-6xl">
                <div class="text-center">
                    <h1 class="text-4xl md:text-6xl font-extrabold leading-tight">
                        <span class="text-[#E27227]">{{ $lic->nombre ?? 'Licenciamiento Institucional' }}</span>
                    </h1>

                    <p class="text-lg md:text-xl text-gray-600 max-w-3xl mt-4 mx-auto">
                        {{ $lic->descripcion ?? 'Consulta nuestra documentación oficial de licenciamiento y acreditación institucional.' }}
                    </p>

                    @if (!empty($lic))
                        <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                            <a href="{{ route('web.lic.file', $lic) }}" target="_blank" rel="noopener"
                                class="px-4 py-2 rounded-md bg-[#1A4FD3] text-white hover:bg-[#00264B] transition">
                                Abrir en pestaña nueva
                            </a>
                            <a href="{{ route('web.lic.file', $lic) }}" download
                                class="px-4 py-2 rounded-md bg-[#E27227] text-white hover:bg-[#c65b1f] transition">
                                Descargar PDF
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        {{-- CONTENIDO --}}
        <section class="pb-14">
            <div class="container mx-auto px-4 md:px-12 max-w-6xl">
                @if (!empty($lic))
                    {{-- Visor del PDF cuando sí existe un licenciamiento activo --}}
                    <div class="pdf-container bg-white" style="height: 820px;">
                        <iframe src="{{ route('web.lic.file', $lic) }}" title="{{ $lic->nombre }}"></iframe>
                        {{-- Alternativa con pdf.js (si lo usas):
                        <iframe
                           src="{{ asset('pdfjs/web/viewer.html') }}?file={{ urlencode(route('web.lic.file', $lic)) }}"
                           title="{{ $lic->nombre }}"></iframe>
                        --}}
                    </div>
                @else
                    {{-- Diseño mejorado para estado sin licenciamiento --}}
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                        
                        {{-- Hero section con gradiente sutil --}}
                        <div class="relative bg-gradient-to-br from-[#f8f9fa] via-white to-[#E8F6F9] py-16 md:py-20">
                            {{-- Decorative elements --}}
                            <div class="absolute top-0 left-0 w-full h-full overflow-hidden">
                                <div class="absolute top-10 left-10 w-20 h-20 bg-[#E27227] opacity-5 rounded-full"></div>
                                <div class="absolute bottom-10 right-10 w-32 h-32 bg-[#1A4FD3] opacity-5 rounded-full"></div>
                            </div>
                            
                            <div class="relative z-10 text-center px-6">
                                {{-- Logo con mejor presentación --}}
                                <div class="mb-8">
                                    <div class="inline-block p-6 bg-white rounded-2xl shadow-md">
                                        <img src="{{ asset('/images/Logo_Silfer.png') }}" alt="Silfer Academia" 
                                            class="w-32 h-auto md:w-40 object-contain select-none mx-auto"
                                            onerror="this.style.display='none';">
                                    </div>
                                </div>

                                {{-- Título principal --}}
                                <h2 class="text-3xl md:text-4xl font-bold text-[#00264B] mb-4">
                                    Licenciamiento Institucional
                                </h2>
                                
                                {{-- Subtítulo descriptivo --}}
                                <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto mb-8 leading-relaxed">
                                    Estamos trabajando en obtener nuestro licenciamiento institucional para brindarte la mejor calidad educativa
                                </p>

                                {{-- Estado actual con icono --}}
                                <div class="inline-flex items-center gap-3 bg-amber-50 text-amber-800 px-6 py-3 rounded-full border border-amber-200">
                                    <i data-lucide="clock" class="h-5 w-5"></i>
                                    <span class="font-semibold">En proceso de licenciamiento</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main>

    @include('footer')

    <script>
        if (window.lucide) {
            lucide.createIcons();
        }
    </script>
    <script src="/js/web/main.js" defer></script>
</body>

</html>
