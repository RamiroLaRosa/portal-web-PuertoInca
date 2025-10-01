<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TUPA 2025 - Silfer Academia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js" defer></script>
    <link rel="stylesheet" href="/css/web/tupa.css">
</head>

<body class="min-h-screen bg-gradient-to-br from-[#DDE3E8] to-white text-[#212529] font-sans"
    style="background-image: linear-gradient(to bottom right, var(--color-neutral), white);">

    <!-- Sidebar mínimo -->
    <div class="fixed top-0 left-0 h-full w-20 bg-[#00264B] text-white z-50 hidden md:flex flex-col items-center py-8"
        style="background-color: var(--color-primario-p1);">
        <div class="mb-12">
            <a href="#">
                <div class="bg-[#E27227] text-white p-2 rounded-full"
                    style="background-color: var(--color-secundario-s1);">
                    <i data-lucide="graduation-cap" class="h-6 w-6"></i>
                </div>
            </a>
        </div>
    </div>

    @include('header')

    <!-- MAIN -->
    <main class="md:pl-20">
        <!-- HERO -->
        <br>
        <section class="py-20 relative overflow-hidden">
            <div class="absolute inset-0 z-0">
                <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-[#4A84F7]/10 to-[#1A4FD3]/10"
                    style="background-image: linear-gradient(
                        to bottom right,
                        color-mix(in srgb, var(--color-primario-p3) 10%, transparent),
                        color-mix(in srgb, var(--color-primario-p2) 10%, transparent)
                     );">
                </div>
                <div class="absolute top-1/4 right-1/4 w-64 h-64 rounded-full bg-[#1A4FD3]/20"
                    style="background-color: color-mix(in srgb, var(--color-primario-p2) 20%, transparent);"></div>
                <div class="absolute bottom-1/3 left-1/3 w-80 h-80 rounded-full bg-[#4A84F7]/20"
                    style="background-color: color-mix(in srgb, var(--color-primario-p3) 20%, transparent);"></div>
                <div class="absolute bottom-10 right-1/5 w-56 h-56 rounded-full bg-[#E27227]/15"
                    style="background-color: color-mix(in srgb, var(--color-secundario-s1) 15%, transparent);"></div>
            </div>
            <div class="container mx-auto px-4 md:px-12 z-10 relative">
                <div class="max-w-4xl mx-auto text-center">
                    <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-6">TUPA</h1>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-8">
                        Encuentra información detallada sobre los procedimientos administrativos, sus costos y
                        requisitos.
                    </p>
                </div>
            </div>
        </section>

        <!-- TABLA -->
        <section class="py-20 bg-white">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-12">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                        <div></div>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="#"
                                class="bg-[#1A4FD3] hover:bg-[#00264B] text-white rounded-full px-6 py-3 font-medium transition-colors flex items-center justify-center"
                                style="background-color: var(--color-primario-p2);">
                                <i data-lucide="download" class="h-5 w-5 mr-2"></i> Descargar PDF
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-lg overflow-hidden border border-gray-100">
                    <div class="overflow-x-auto">
                        <table class="w-full tupa-table" id="tupa-table">
                            <thead class="bg-[#00264B] text-white" style="background-color: var(--color-primario-p1);">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">N°
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                        Concepto</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Monto
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200" id="table-body">
                                @forelse($items as $item)
                                    @php
                                        // Numeración correcta por página
                                        $num = ($items->firstItem() ?? 1) + $loop->index;
                                    @endphp
                                    <tr
                                        class="table-row hover:transition-colors {{ $loop->odd ? 'bg-gray-50' : 'bg-white' }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="bg-[#E27227] text-white text-sm font-medium px-3 py-1 rounded-full"
                                                style="background-color: var(--color-secundario-s1);">
                                                {{ str_pad($num, 3, '0', STR_PAD_LEFT) }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900 concepto-cell">
                                                {{ $item->concepto }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-[#1A4FD3] monto-cell"
                                                style="color: var(--color-primario-p2);">
                                                S/ {{ number_format($item->monto, 2, '.', ',') }}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-10 text-center text-gray-600">
                                            No hay procedimientos publicados.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div id="no-results" class="text-center py-12 hidden">
                        <i data-lucide="file-text" class="h-12 w-12 text-gray-400 mx-auto mb-4"></i>
                        <p class="text-gray-500 text-lg">No se encontraron procedimientos que coincidan con tu búsqueda.
                        </p>
                    </div>
                </div>

                {{-- PAGINACIÓN --}}
                @if (method_exists($items, 'links'))
                    <div class="mt-8">
                        {{ $items->onEachSide(1)->links() }}
                        {{-- o explícito con Tailwind:
                        {{ $items->onEachSide(1)->links('pagination::tailwind') }} --}}
                    </div>
                @endif

                <!-- Bloques informativos -->
                <div class="mt-12 bg-[#DDE3E8] rounded-3xl p-8" style="background-color: var(--color-neutral);">
                    <h3 class="text-2xl font-bold mb-6">Información Importante</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-lg font-semibold mb-3 text-[#1A4FD3]"
                                style="color: var(--color-primario-p2);">Formas de Pago</h4>
                            <ul class="space-y-2 text-gray-700">
                                <li>• Efectivo en caja de la institución</li>
                                <li>• Transferencia bancaria</li>
                                <li>• Tarjeta de débito o crédito</li>
                                <li>• Pago en línea a través del portal web</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold mb-3 text-[#1A4FD3]"
                                style="color: var(--color-primario-p2);">Horarios de Atención</h4>
                            <ul class="space-y-2 text-gray-700">
                                <li>• Lunes a Viernes: 8:00 AM - 6:00 PM</li>
                                <li>• Sábados: 8:00 AM - 1:00 PM</li>
                                <li>• Atención virtual: 24/7</li>
                                <li>• Mesa de partes: Lunes a Viernes 8:00 AM - 5:00 PM</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('footer')

    <script src="{{ asset('js/web/tupa.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) window.lucide.createIcons();
        });
    </script>
    <script src="/js/web/tupa.js"></script>
    <script src="/js/web/main.js" defer></script>
</body>

</html>
