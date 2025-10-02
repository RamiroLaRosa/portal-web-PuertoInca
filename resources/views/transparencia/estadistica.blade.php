<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Estadísticas Académicas - Silfer Academia</title>
    @vite('resources/css/css_colores_administrables/css_colores_administrables.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="/css/web/estadistica.css">
</head>

<body class="min-h-screen bg-gray-50 text-[#212529] font-sans scroll-smooth" data-years='@json($years)'
    data-sections='@json($sections)'>

    {{-- Navegación lateral --}}
    <div class="fixed top-0 left-0 h-full w-20 bg-[#00264B] text-white z-50 hidden md:flex flex-col items-center py-8"
        style="background-color: var(--color-primario-p1);">
        <div class="mb-12">
            <div class="bg-[#E27227] text-white p-2 rounded-full" style="background-color: var(--color-secundario-s1);">
                <i data-lucide="graduation-cap" class="h-6 w-6"></i>
            </div>
        </div>

        <nav class="flex flex-col items-center space-y-6 flex-grow" id="sidebar-nav">
            @foreach ($sections as $sec)
                <button onclick="scrollToSection('{{ $sec['id'] }}')"
                    class="nav-dot w-12 h-12 flex items-center justify-center rounded-full transition-all hover:bg-[#1A4FD3]/20"
                    data-section="{{ $sec['id'] }}" title="{{ $sec['titulo'] }}"
                    style="/* hover via Tailwind; base sin color */">
                    <div class="h-3 w-3 rounded-full bg-white"></div>
                </button>
            @endforeach
        </nav>
    </div>

    @include('header')

    <main class="md:pl-20 pt-16">
        {{-- HERO --}}
        <section id="hero" class="py-20 gradient-bg text-white">
            <div class="container mx-auto px-4">
                <div class="max-w-6xl mx-auto text-center">
                    <h1 class="text-5xl md:text-7xl font-black mb-6">
                        Estadísticas <span
                            class="bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">Académicas</span>
                    </h1>
                    <p class="text-xl md:text-2xl text-white/85 max-w-4xl mx-auto">
                        Datos transparentes por tema estadístico, programa de estudio y año académico.
                    </p>
                </div>
            </div>
        </section>

        {{-- SECCIONES DINÁMICAS --}}
        @foreach ($sections as $sec)
            <section id="{{ $sec['id'] }}" class="py-20 {{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
                <div class="container mx-auto px-4">
                    {{-- Título + CTA --}}
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-10">
                        <div class="flex items-center gap-4">
                            <div class="bg-[#DDE3E8] p-3 rounded-xl" style="background-color: var(--color-neutral);">
                                <i data-lucide="{{ $sec['icon'] }}" class="h-8 w-8 text-[#1A4FD3]"
                                    style="color: var(--color-primario-p2);"></i>
                            </div>
                            <div>
                                <h2 class="text-4xl font-black">{{ $sec['titulo'] }}</h2>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button onclick="openAllDatasets('{{ $sec['id'] }}')"
                                class="bg-[#1A4FD3] hover:opacity-90 text-white px-4 py-2 rounded-lg font-medium transition"
                                style="background-color: var(--color-primario-p2);">
                                <i data-lucide="chart-bar" class="h-4 w-4 inline mr-2"></i>
                                Ver en gráfico
                            </button>
                            <button onclick="exportTable('{{ $sec['id'] }}')"
                                class="bg-[#E27227] hover:opacity-90 text-white px-4 py-2 rounded-lg font-medium transition"
                                style="background-color: var(--color-secundario-s1);">
                                <i data-lucide="download" class="h-4 w-4 inline mr-2"></i>
                                Exportar
                            </button>
                        </div>
                    </div>

                    {{-- Tabla dinámica --}}
                    <div class="stats-card rounded-2xl p-6 shadow-lg overflow-x-auto" id="table-{{ $sec['id'] }}">
                        <table class="w-full min-w-[720px]">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-4 px-2 font-semibold">Programa de Estudio</th>
                                    @foreach ($years as $y)
                                        <th class="text-center py-4 px-2 font-semibold">{{ $y }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($programs as $pid => $pname)
                                    <tr class="table-hover border-b border-gray-100">
                                        <td class="py-3 px-2 font-medium">{{ $pname }}</td>
                                        @foreach ($yearIds as $yid)
                                            <td class="py-3 px-2 text-center">
                                                {{ $sec['grid'][$pid][$yid] ?? 0 }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <br>

                    {{-- Gráfico --}}
                    <div class="mb-12">
                        <div class="stats-card rounded-2xl p-6 shadow-lg">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-2xl font-bold">Evolución por programa ({{ $sec['titulo'] }})</h3>
                            </div>
                            <div class="chart-container">
                                <canvas id="chart-{{ $sec['id'] }}"></canvas>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        @endforeach
    </main>

    @include('footer')

    <script src="/js/web/estadistica.js"></script>
    <script src="/js/web/main.js" defer></script>
</body>

</html>
