<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Documentos de Gestión - Silfer Academia</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Lucide Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js" defer></script>

    <link rel="stylesheet" href="/css/web/documentos.css">
</head>

<body
    class="min-h-screen bg-gradient-to-br from-[#DDE3E8] to-white text-[#212529] font-sans scroll-smooth overflow-x-hidden">
    <!-- Sidebar minimal -->
    <div class="fixed top-0 left-0 h-full w-20 bg-[#00264B] text-white z-50 hidden md:flex flex-col items-center py-8">
        <div class="mb-12">
            <div class="bg-[#E27227] text-white p-2 rounded-full">
                <i data-lucide="graduation-cap" class="h-6 w-6"></i>
            </div>
        </div>
        <nav class="flex flex-col items-center space-y-8 flex-grow" id="sidebar-nav">
            <button onclick="scrollToSection('lista')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-[#1A4FD3]/20 rounded-full"
                title="Documentos">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
        </nav>
    </div>

    @include('header')

    <main class="md:pl-20">
        <!-- HERO -->
        <section id="hero" class="py-20 bg-gradient-to-br from-[#00264B] via-[#1A4FD3] to-[#4A84F7] text-white">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto text-center">
                    <h1 class="text-5xl md:text-7xl font-black leading-tight mb-6">
                        Documentos
                        <span class="block md:inline">Institucionales</span>
                    </h1>
                    <p class="text-xl md:text-2xl text-white/90 mb-12 max-w-3xl mx-auto">
                        Estatutos, reglamentos generales y documentos fundacionales
                    </p>
                </div>
            </div>
        </section>

        <!-- LISTA -->
        <section id="lista" class="py-16 bg-white">
            <div class="container mx-auto px-4">
                <div class="mb-8">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="bg-[#DDE3E8] p-3 rounded-xl">
                            <i data-lucide="building" class="h-8 w-8 text-[#1A4FD3]"></i>
                        </div>
                        <h2 class="text-4xl font-black">Documentos Institucionales</h2>
                    </div>

                    {{-- BÚSQUEDA --}}
                    <form method="GET" action="{{ route('web.documentos') }}">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <!-- ✅ min-w-0 para que el input pueda encogerse en móvil -->
                            <div class="relative flex-1 min-w-0">
                                <input type="text" name="q" value="{{ $q ?? '' }}"
                                    placeholder="Buscar documento por nombre o descripción…"
                                    class="w-full rounded-xl border border-gray-300 bg-white/90 px-4 py-3 pr-10 focus:outline-none focus:ring-2 focus:ring-[#1A4FD3] focus:border-transparent">
                                <i data-lucide="search"
                                    class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400"></i>
                            </div>

                            <button
                                class="rounded-xl bg-[#1A4FD3] hover:bg-[#00264B] text-white px-5 py-3 font-medium transition-colors">
                                Buscar
                            </button>

                            @if (!empty($q))
                                <a href="{{ route('web.documentos') }}"
                                    class="rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-3 font-medium transition-colors">
                                    Limpiar
                                </a>
                            @endif
                        </div>

                        <div class="mt-2 text-sm text-gray-600">
                            @if (!empty($q))
                                Mostrando {{ $documentos->total() }} resultado(s) para <span
                                    class="font-semibold">"{{ $q }}"</span>.
                            @else
                                Total de documentos: {{ $documentos->total() }}
                            @endif
                        </div>
                    </form>
                </div>

                {{-- GRID / VACÍO --}}
                @if ($documentos->isEmpty())
                    <div class="rounded-2xl border border-gray-200 bg-white p-8 text-center text-gray-600">
                        @if (!empty($q))
                            No se encontraron documentos para “{{ $q }}”.
                        @else
                            Aún no hay documentos publicados.
                        @endif
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($documentos as $doc)
                            <div
                                class="document-card bg-white border border-gray-200 rounded-2xl p-6 hover:border-[#1A4FD3]">
                                <h3 class="text-xl font-bold mb-2 break-words">{{ $doc->nombre }}</h3>
                                <p class="text-gray-600 text-sm mb-5 text-justify break-words">{{ $doc->descripcion }}
                                </p>

                                {{-- Abre en pestaña nueva usando la ruta al stream --}}
                                <a href="{{ route('web.documentos.file', $doc) }}" target="_blank" rel="noopener"
                                    class="w-full bg-[#1A4FD3] hover:bg-[#00264B] text-white py-3 rounded-xl font-medium transition-colors flex items-center justify-center gap-2">
                                    <i data-lucide="eye" class="h-4 w-4"></i> Ver PDF
                                </a>
                            </div>
                        @endforeach
                    </div>

                    {{-- PAGINACIÓN --}}
                    <div class="mt-10 overflow-x-auto">
                        {{ $documentos->onEachSide(1)->links() }}
                    </div>
                @endif
            </div>
        </section>
    </main>

    @include('footer')

    <script>
        // Activa iconos y helper de scroll
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) window.lucide.createIcons();
        });

        function scrollToSection(id) {
            const el = document.getElementById(id);
            if (!el) return;
            const y = el.getBoundingClientRect().top + window.pageYOffset - 80;
            window.scrollTo({
                top: y,
                behavior: 'smooth'
            });
        }
        window.scrollToSection = scrollToSection;
    </script>

    <script src="/js/web/main.js" defer></script>
    <script src="/js/web/documentos.js"></script>

</body>

</html>
