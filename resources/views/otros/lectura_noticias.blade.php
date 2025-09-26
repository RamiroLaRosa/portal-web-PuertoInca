{{-- resources/views/noticias/show.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $noticia->titulo }} - Silfer Academia</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/css/web/lectura.css">

    {{-- Scrollbar sutil para el panel lateral --}}
    <style>
        /* WebKit */
        .nice-scroll::-webkit-scrollbar {
            width: 10px;
        }

        .nice-scroll::-webkit-scrollbar-track {
            background: #eef2f7;
            border-radius: 8px;
        }

        .nice-scroll::-webkit-scrollbar-thumb {
            background: #cfd8e3;
            border-radius: 8px;
        }

        .nice-scroll::-webkit-scrollbar-thumb:hover {
            background: #b8c4d6;
        }

        /* Firefox */
        .nice-scroll {
            scrollbar-width: thin;
            scrollbar-color: #cfd8e3 #eef2f7;
        }
    </style>
</head>

<body class="bg-[#DDE3E8] font-body">
    <!-- Navegación lateral -->
    <div class="fixed top-0 left-0 h-full w-20 bg-[#00264B] text-white z-50 hidden md:flex flex-col items-center py-8">
        <div class="mb-12">
            <a href="{{ url('/') }}">
                <div class="bg-[#1A4FD3] text-white p-2 rounded-full">
                    <i data-lucide="graduation-cap" class="w-6 h-6"></i>
                </div>
            </a>
        </div>
    </div>

    @include('header')

    @php
        use Illuminate\Support\Str;
        use Illuminate\Support\Facades\Storage;

        $img = $noticia->imagen ?: 'images/no-photo.jpg';
        $img = asset(ltrim(str_starts_with($img, '/') ? $img : '/' . ltrim($img, '/'), '/'));

        $fecha = $noticia->fecha?->locale('es')->translatedFormat('j \\d\\e F, Y');
        $lead = Str::limit(strip_tags($noticia->descripcion ?? ''), 260);

        // Documento PDF
        $docRaw = $noticia->documento ?? null;
        $docUrl = null;
        if ($docRaw) {
            if (Str::startsWith($docRaw, ['http://', 'https://'])) {
                $docUrl = $docRaw;
            } elseif (Str::startsWith($docRaw, ['public/', 'storage/'])) {
                $docUrl = Str::startsWith($docRaw, 'storage/') ? asset($docRaw) : asset(Storage::url($docRaw));
            } else {
                $docUrl = asset(ltrim($docRaw, '/'));
            }
        }
        $docExists = true;
        if ($docUrl && !Str::startsWith($docUrl, ['http://', 'https://'])) {
            $localPath = public_path(parse_url($docUrl, PHP_URL_PATH));
            $docExists = file_exists($localPath);
        }
    @endphp

    <main class="pl-20 pt-20 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <a href="{{ route('noticias.index') }}">
                <button
                    class="mb-8 text-[#1A4FD3] hover:text-[#4A84F7] flex items-center space-x-2 transition-all duration-200 hover:translate-x-1">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    <span class="font-medium">Volver a noticias</span>
                </button>
            </a>

            <div class="grid lg:grid-cols-3 gap-12">
                <div class="lg:col-span-2">
                    <div class="mb-8">
                        <h1 class="text-5xl font-display font-bold text-gray-900 mb-6 leading-tight">
                            {{ $noticia->titulo }}
                        </h1>

                        @if ($lead)
                            <p class="text-xl text-gray-600 leading-relaxed mb-8 font-medium text-justify">
                                {{ $lead }}
                            </p>
                        @endif

                        <div class="flex items-center justify-between pb-8 border-b" style="border-color:#DDE3E8">
                            <div class="flex items-center space-x-6">
                                <div class="flex items-center space-x-4 text-sm text-gray-600">
                                    @if ($fecha)
                                        <div class="flex items-center space-x-1">
                                            <i data-lucide="calendar" class="w-4 h-4"></i>
                                            <span>{{ $fecha }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-10">
                        <img src="{{ $img }}" alt="{{ $noticia->titulo }}"
                            class="w-full h-96 object-cover rounded-2xl shadow-2xl" />
                    </div>

                    {{-- Documento (PDF) --}}
                    <div class="mt-16 bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-[#1A4FD3] to-[#4A84F7] text-white p-6">
                            <h3 class="text-xl font-bold flex items-center">
                                <i data-lucide="file-text" class="w-6 h-6 mr-3"></i>
                                Documento
                            </h3>
                        </div>

                        <div class="p-6">
                            @if ($docUrl && $docExists)
                                <div class="mb-6">
                                    <div class="bg-gray-50 rounded-lg p-4 border-2 border-dashed border-gray-300">
                                        <iframe src="{{ $docUrl }}#toolbar=1&navpanes=1&scrollbar=1"
                                            class="w-full h-96 rounded-lg border border-gray-200"
                                            type="application/pdf"></iframe>
                                    </div>
                                </div>

                                <div class="flex flex-wrap items-center justify-center gap-3">
                                    <a href="{{ $docUrl }}" target="_blank"
                                        class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all">
                                        <i data-lucide="eye" class="w-5 h-5 mr-2"></i>
                                        Ver en pestaña nueva
                                    </a>
                                    <a href="{{ $docUrl }}" download
                                        class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-[#1A4FD3] to-[#4A84F7] text-white font-semibold rounded-xl hover:from-[#0F1F3D] hover:to-[#1A4FD3] transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                        <i data-lucide="download" class="w-5 h-5 mr-3"></i>
                                        Descargar PDF
                                    </a>
                                </div>
                            @else
                                <div
                                    class="bg-gray-50 rounded-lg p-12 border-2 border-dashed border-gray-300 text-center text-gray-600">
                                    <div class="flex items-center justify-center gap-2 mb-2">
                                        <i data-lucide="alert-circle" class="w-5 h-5"></i>
                                        <span class="font-semibold">404 | NO ENCONTRADO</span>
                                    </div>
                                    <p class="text-sm">No se pudo localizar el documento asociado a esta noticia.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- ========= OTRAS NOTICIAS (scrollable) ========= --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-32">
                        <div class="bg-gradient-to-r from-[#1A4FD3] to-[#4A84F7] text-white p-4 rounded-t-2xl">
                            <h3 class="text-lg font-bold flex items-center">
                                <i data-lucide="newspaper" class="w-5 h-5 mr-2"></i>
                                Otras Noticias
                            </h3>
                        </div>

                        {{-- Contenedor con altura limitada (~3 tarjetas) + scroll --}}
                        <div
                            class="bg-white rounded-b-2xl shadow-lg p-4 space-y-6 overflow-y-auto nice-scroll max-h-[540px]">
                            @forelse($others as $item)
                                @php
                                    $oImg = $item->imagen ?: 'images/no-photo.jpg';
                                    $oImg = asset(
                                        ltrim(str_starts_with($oImg, '/') ? $oImg : '/' . ltrim($oImg, '/'), '/'),
                                    );
                                    $oDate = $item->fecha?->locale('es')->translatedFormat('j \\d\\e F, Y');
                                @endphp
                                <a href="{{ route('noticias.show', $item) }}" class="group block">
                                    <div class="bg-white rounded-lg p-4 shadow-sm border hover:shadow-md transition-shadow"
                                        style="border-color:#DDE3E8">
                                        <img src="{{ $oImg }}" alt="{{ $item->titulo }}"
                                            class="w-full h-24 object-cover rounded-lg mb-3" />
                                        <h4
                                            class="font-semibold text-gray-900 mb-2 group-hover:text-[#1A4FD3] transition-colors">
                                            {{ $item->titulo }}
                                        </h4>
                                        <p class="text-gray-600 text-sm mb-3 line-clamp-2 text-justify">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($item->descripcion ?? ''), 120) }}
                                        </p>
                                        <div class="flex items-center justify-between text-xs text-gray-500">
                                            <span>{{ $oDate }}</span>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-gray-500 text-sm">No hay más noticias.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
                {{-- ======== /OTRAS NOTICIAS ========= --}}
            </div>
        </div>
    </main>

    @include('footer')

    <script>
        lucide.createIcons();
    </script>
    <script src="/js/web/main.js" defer></script>
</body>

</html>
