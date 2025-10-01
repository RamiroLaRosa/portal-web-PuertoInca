<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Libro de Reclamaciones - Silfer Academia</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/css/web/libro.css">
</head>

<body class="min-h-screen bg-gray-50 text-[#212529] font-sans scroll-smooth">
    <!-- Navegación lateral -->
    <div class="fixed top-0 left-0 h-full w-20 bg-[#00264B] text-white z-50 hidden md:flex flex-col items-center py-8"
        style="background-color: var(--color-primario-p1); color:#fff;">
        <div class="mb-12">
            <div class="bg-[#E27227] text-white p-2 rounded-full"
                style="background-color: var(--color-secundario-s1); color:#fff;">
                <i data-lucide="graduation-cap" class="h-6 w-6"></i>
            </div>
        </div>
        <nav class="flex flex-col items-center space-y-8 flex-grow" id="sidebar-nav">
            <button onclick="scrollToSection('informacion')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-[#1A4FD3]/20 rounded-full"
                data-section="informacion" title="Información">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('formulario')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-[#1A4FD3]/20 rounded-full"
                data-section="formulario" title="Formulario">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('proceso')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-[#1A4FD3]/20 rounded-full"
                data-section="proceso" title="Proceso">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('seguimiento')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-[#1A4FD3]/20 rounded-full"
                data-section="seguimiento" title="Seguimiento">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('derechos')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-[#1A4FD3]/20 rounded-full"
                data-section="derechos" title="Derechos">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
        </nav>
    </div>

    @include('header')

    <!-- Menú móvil -->
    <div id="mobile-menu" class="fixed inset-0 bg-white z-30 pt-16 md:hidden overflow-y-auto hidden">
        <div class="p-4">
            <nav class="flex flex-col space-y-4">
                <button onclick="scrollToSection('hero')"
                    class="py-2 px-3 text-sm bg-gray-50 rounded-md hover:bg-[#DDE3E8] hover:text-[#1A4FD3] transition-colors text-left">
                    Inicio</button>
                <button onclick="scrollToSection('informacion')"
                    class="py-2 px-3 text-sm bg-gray-50 rounded-md hover:bg-[#DDE3E8] hover:text-[#1A4FD3] transition-colors text-left">
                    Información</button>
                <button onclick="scrollToSection('formulario')"
                    class="py-2 px-3 text-sm bg-gray-50 rounded-md hover:bg-[#DDE3E8] hover:text-[#1A4FD3] transition-colors text-left">
                    Formulario</button>
                <button onclick="scrollToSection('proceso')"
                    class="py-2 px-3 text-sm bg-gray-50 rounded-md hover:bg-[#DDE3E8] hover:text-[#1A4FD3] transition-colors text-left">
                    Proceso</button>
                <button onclick="scrollToSection('seguimiento')"
                    class="py-2 px-3 text-sm bg-gray-50 rounded-md hover:bg-[#DDE3E8] hover:text-[#1A4FD3] transition-colors text-left">
                    Seguimiento</button>
                <button onclick="scrollToSection('derechos')"
                    class="py-2 px-3 text-sm bg-gray-50 rounded-md hover:bg-[#DDE3E8] hover:text-[#1A4FD3] transition-colors text-left">
                    Derechos</button>
            </nav>
        </div>
    </div>

    <main class="md:pl-20 pt-16">
        <!-- Hero Section -->
        <section id="hero" class="py-20 gradient-bg text-white"
            style="background-image:linear-gradient(to bottom right, var(--color-primario-p1), var(--color-primario-p2), var(--color-primario-p3)); color:#fff;">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto text-center">
                    <h1 class="text-5xl md:text-7xl font-black mb-6">Libro de Reclamaciones</h1>
                    <p class="text-xl md:text-2xl text-white/90 mb-12 max-w-3xl mx-auto">
                        Tu opinión es importante para nosotros. Presenta tus reclamaciones y sugerencias de manera
                        fácil, rápida y segura.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center mb-16">
                        <button onclick="scrollToSection('formulario')"
                            class="bg-white text-[#E27227] hover:bg-gray-100 rounded-full px-8 py-4 text-lg font-semibold transition-all transform hover:scale-105 shadow-lg"
                            style="color: var(--color-secundario-s1);">
                            Presentar Reclamación
                        </button>
                        <button onclick="scrollToSection('seguimiento')"
                            class="border-2 border-white text-white hover:bg-white hover:text-[#E27227] rounded-full px-8 py-4 text-lg font-semibold transition-all">
                            Seguir mi Caso
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Información General -->
        <section id="informacion" class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <div class="max-w-6xl mx-auto">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl md:text-5xl font-black mb-4">
                            ¿Qué es el <span class="text-[#E27227]" style="color: var(--color-secundario-s1);">Libro de
                                Reclamaciones</span>?
                        </h2>
                        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                            Es un instrumento de protección al consumidor que permite registrar quejas y reclamos sobre
                            nuestros servicios educativos.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
                        <!-- Información principal -->
                        <div class="form-card rounded-2xl p-8 shadow-lg">
                            <div class="bg-[#E27227]/15 p-3 rounded-xl w-fit mb-6">
                                <i data-lucide="info" class="h-8 w-8 text-[#E27227]"
                                    style="color: var(--color-secundario-s1);"></i>
                            </div>

                            <h3 class="text-2xl font-bold mb-6">Información Importante</h3>

                            <div class="space-y-4">
                                @forelse($info as $item)
                                    <div class="flex items-start gap-3">
                                        <div class="bg-[#1A4FD3]/10 p-1 rounded-full mt-1">
                                            <i data-lucide="check" class="h-4 w-4 text-[#1A4FD3]"
                                                style="color: var(--color-primario-p2);"></i>
                                        </div>
                                        <div>
                                            <div class="font-semibold">{{ $item->titulo }}</div>
                                            <div class="text-sm text-gray-600">{!! nl2br(e($item->descripcion)) !!}</div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-gray-500 text-sm">Aún no hay información registrada.</div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Tipos de reclamaciones -->
                        <div class="form-card rounded-2xl p-8 shadow-lg">
                            <div class="bg-[#E27227]/15 p-3 rounded-xl w-fit mb-6">
                                <i data-lucide="list" class="h-8 w-8 text-[#E27227]"
                                    style="color: var(--color-secundario-s1);"></i>
                            </div>

                            <h3 class="text-2xl font-bold mb-6">Tipos de Reclamaciones</h3>

                            <div class="space-y-4">
                                @forelse ($tipos as $t)
                                    @php
                                        $name = strtolower($t->nombre);
                                        $color = match ($name) {
                                            'reclamo' => 'text-[#E27227]',
                                            'queja' => 'text-[#1A4FD3]',
                                            'sugerencia' => 'text-[#00264B]',
                                            default => 'text-[#00264B]',
                                        };
                                        $styleColor = match ($name) {
                                            'reclamo' => 'color: var(--color-secundario-s1);',
                                            'queja' => 'color: var(--color-primario-p2);',
                                            default => 'color: var(--color-primario-p1);',
                                        };
                                    @endphp

                                    <div class="p-4 border border-gray-200 rounded-lg">
                                        <div class="{{ $color }} mb-2" style="{{ $styleColor }}">
                                            {{ $t->nombre }}</div>
                                        <div class="text-sm text-gray-600">{{ $t->descripcion }}</div>
                                    </div>
                                @empty
                                    <div class="text-gray-500 text-sm">No hay tipos de reclamación configurados.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Marco legal -->
                    <div class="form-card rounded-2xl p-8 shadow-lg">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="bg-[#1A4FD3]/15 p-3 rounded-xl">
                                <i data-lucide="scale" class="h-8 w-8 text-[#1A4FD3]"
                                    style="color: var(--color-primario-p2);"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold">Marco Legal</h3>
                                <p class="text-gray-600">Normativa que respalda el Libro de Reclamaciones</p>
                            </div>
                        </div>

                        @if ($marco->isEmpty())
                            <div class="text-gray-500 text-sm">No hay normativa registrada.</div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach ($marco as $m)
                                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                                        <div class="font-semibold text-[#1A4FD3] mb-2"
                                            style="color: var(--color-primario-p2);">{{ $m->titulo }}</div>
                                        <div class="text-sm text-gray-600">{{ $m->descripcion }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Formulario de Reclamación -->
        <section id="formulario" class="py-20 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto">
                    <div class="text-center mb-12">
                        <h2 class="text-4xl md:text-5xl font-black mb-4">
                            Presenta tu <span class="text-[#E27227]"
                                style="color: var(--color-secundario-s1);">Reclamación</span>
                        </h2>
                        <p class="text-xl text-gray-600">Completa el formulario con todos los datos requeridos</p>
                    </div>

                    <!-- Progreso del formulario -->
                    <div class="mb-12">
                        <div class="flex items-center justify-center space-x-4 mb-4">
                            <div
                                class="progress-step active flex items-center justify-center w-10 h-10 rounded-full font-bold">
                                1</div>
                            <div class="w-16 h-1 bg-gray-300"></div>
                            <div
                                class="progress-step flex items-center justify-center w-10 h-10 rounded-full bg-gray-300 font-bold">
                                2</div>
                            <div class="w-16 h-1 bg-gray-300"></div>
                            <div
                                class="progress-step flex items-center justify-center w-10 h-10 rounded-full bg-gray-300 font-bold">
                                3</div>
                        </div>
                        <div class="text-center text-sm text-gray-600">
                            <span id="step-text">Paso 1: Información Personal</span>
                        </div>
                    </div>

                    <div class="form-card rounded-2xl p-8 shadow-lg">
                        <form id="complaintForm" class="space-y-8">
                            <!-- Paso 1 -->
                            <div id="step1" class="step-content">
                                <h3 class="text-2xl font-bold mb-6 flex items-center gap-3">
                                    <div class="bg-[#E27227]/15 p-2 rounded-lg">
                                        <i data-lucide="user" class="h-6 w-6 text-[#E27227]"
                                            style="color: var(--color-secundario-s1);"></i>
                                    </div>
                                    Información Personal
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nombres *</label>
                                        <input type="text" id="nombres" required
                                            class="form-input w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1A4FD3] focus:border-transparent"
                                            style="--tw-ring-color: var(--color-primario-p2);"
                                            placeholder="Ingresa tus nombres">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Apellidos
                                            *</label>
                                        <input type="text" id="apellidos" required
                                            class="form-input w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1A4FD3] focus:border-transparent"
                                            style="--tw-ring-color: var(--color-primario-p2);"
                                            placeholder="Ingresa tus apellidos">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tipo de Documento
                                            *</label>
                                        <select id="tipoDocumento" required
                                            class="form-input w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1A4FD3] focus:border-transparent"
                                            style="--tw-ring-color: var(--color-primario-p2);">
                                            <option value="">Selecciona tipo</option>
                                            @foreach ($tiposDoc as $td)
                                                <option value="{{ $td->id }}">
                                                    {{ $td->nombre_corto ?? $td->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Número de
                                            Documento *</label>
                                        <input type="text" id="numeroDocumento" required
                                            class="form-input w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1A4FD3] focus:border-transparent"
                                            style="--tw-ring-color: var(--color-primario-p2);"
                                            placeholder="Número de documento">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Teléfono
                                            *</label>
                                        <input type="tel" id="telefono" required
                                            class="form-input w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1A4FD3] focus:border-transparent"
                                            style="--tw-ring-color: var(--color-primario-p2);"
                                            placeholder="Número de teléfono">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                                        <input type="email" id="email" required
                                            class="form-input w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1A4FD3] focus:border-transparent"
                                            style="--tw-ring-color: var(--color-primario-p2);"
                                            placeholder="correo@ejemplo.com">
                                    </div>
                                </div>
                            </div>

                            <!-- Paso 2 -->
                            <div id="step2" class="step-content hidden">
                                <h3 class="text-2xl font-bold mb-6 flex items-center gap-3">
                                    <div class="bg-[#E27227]/15 p-2 rounded-lg">
                                        <i data-lucide="clipboard-list" class="h-6 w-6 text-[#E27227]"
                                            style="color: var(--color-secundario-s1);"></i>
                                    </div>
                                    Tipo de Reclamación
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                                    @foreach ($tipos as $t)
                                        @php
                                            $name = strtolower($t->nombre);
                                            $tone = match ($name) {
                                                'reclamo' => [
                                                    'wrap' => 'bg-[#E27227]/15',
                                                    'icon' => 'text-[#E27227]',
                                                    'style' => 'color: var(--color-secundario-s1);',
                                                    'iconName' => 'alert-circle',
                                                ],
                                                'queja' => [
                                                    'wrap' => 'bg-[#1A4FD3]/15',
                                                    'icon' => 'text-[#1A4FD3]',
                                                    'style' => 'color: var(--color-primario-p2);',
                                                    'iconName' => 'frown',
                                                ],
                                                default => [
                                                    'wrap' => 'bg-[#00264B]/10',
                                                    'icon' => 'text-[#00264B]',
                                                    'style' => 'color: var(--color-primario-p1);',
                                                    'iconName' => 'lightbulb',
                                                ],
                                            };
                                        @endphp

                                        <div class="complaint-type-card p-6 border-2 border-gray-200 rounded-xl text-center cursor-pointer hover:shadow"
                                            data-id="{{ $t->id }}" onclick="selectComplaintType(this)">
                                            <div class="{{ $tone['wrap'] }} p-3 rounded-full w-fit mx-auto mb-4">
                                                <i data-lucide="{{ $tone['iconName'] }}"
                                                    class="h-8 w-8 {{ $tone['icon'] }}"
                                                    style="{{ $tone['style'] }}"></i>
                                            </div>
                                            <div class="font-bold text-lg mb-2">{{ $t->nombre }}</div>
                                            <div class="text-sm text-gray-600">{{ $t->descripcion }}</div>
                                        </div>
                                    @endforeach
                                </div>

                                <input type="hidden" id="tipoReclamacion" required>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Área Relacionada
                                            *</label>
                                        <select id="area" required
                                            class="form-input w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1A4FD3] focus:border-transparent"
                                            style="--tw-ring-color: var(--color-primario-p2);">
                                            <option value="">Selecciona área</option>
                                            <option value="academica">Área Académica</option>
                                            <option value="administrativa">Área Administrativa</option>
                                            <option value="financiera">Área Financiera</option>
                                            <option value="biblioteca">Biblioteca</option>
                                            <option value="laboratorios">Laboratorios</option>
                                            <option value="bienestar">Bienestar Estudiantil</option>
                                            <option value="admision">Admisión</option>
                                            <option value="matricula">Matrícula</option>
                                            <option value="grados">Grados y Títulos</option>
                                            <option value="otros">Otros</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Fecha del
                                            Incidente</label>
                                        <input type="date" id="fechaIncidente"
                                            class="form-input w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1A4FD3] focus:border-transparent"
                                            style="--tw-ring-color: var(--color-primario-p2);">
                                    </div>
                                </div>
                            </div>

                            <!-- Paso 3 -->
                            <div id="step3" class="step-content hidden">
                                <h3 class="text-2xl font-bold mb-6 flex items-center gap-3">
                                    <div class="bg-[#E27227]/15 p-2 rounded-lg">
                                        <i data-lucide="file-text" class="h-6 w-6 text-[#E27227]"
                                            style="color: var(--color-secundario-s1);"></i>
                                    </div>
                                    Detalle de la Reclamación
                                </h3>

                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Asunto *</label>
                                        <input type="text" id="asunto" required
                                            class="form-input w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1A4FD3] focus:border-transparent"
                                            style="--tw-ring-color: var(--color-primario-p2);"
                                            placeholder="Resumen breve del motivo">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Descripción
                                            Detallada *</label>
                                        <textarea id="descripcion" required rows="6"
                                            class="form-input w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1A4FD3] focus:border-transparent"
                                            style="--tw-ring-color: var(--color-primario-p2);" placeholder="Describe detalladamente los hechos..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="flex justify-between pt-8 border-t border-gray-200">
                                <button type="button" id="prevBtn" onclick="changeStep(-1)"
                                    class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors hidden">
                                    <i data-lucide="chevron-left" class="h-4 w-4 inline mr-2"></i>
                                    Anterior
                                </button>

                                <div class="ml-auto flex gap-4">
                                    <button type="button" id="nextBtn" onclick="changeStep(1)"
                                        class="bg-[#E27227] hover:bg-[#c56120] text-white px-6 py-3 rounded-lg font-medium transition-colors"
                                        style="background-color: var(--color-secundario-s1);"
                                        onmouseover="this.style.backgroundColor='#c56120'"
                                        onmouseout="this.style.backgroundColor=getComputedStyle(document.documentElement).getPropertyValue('--color-secundario-s1')">
                                        Siguiente
                                        <i data-lucide="chevron-right" class="h-4 w-4 inline ml-2"></i>
                                    </button>

                                    <button type="submit" id="submitBtn"
                                        class="bg-[#1A4FD3] hover:bg-[#173fb0] text-white px-6 py-3 rounded-lg font-medium transition-colors hidden"
                                        style="background-color: var(--color-primario-p2);"
                                        onmouseover="this.style.backgroundColor='#173fb0'"
                                        onmouseout="this.style.backgroundColor=getComputedStyle(document.documentElement).getPropertyValue('--color-primario-p2')">
                                        <i data-lucide="send" class="h-4 w-4 inline mr-2"></i>
                                        Enviar Reclamación
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Proceso de Atención -->
        <section id="proceso" class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <div class="max-w-6xl mx-auto">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl md:text-5xl font-black mb-4">
                            Proceso de <span class="text-[#E27227]"
                                style="color: var(--color-secundario-s1);">Atención</span>
                        </h2>
                        <p class="text-xl text-gray-600 max-w-3xl mx-auto">Conoce cómo procesamos tu reclamación paso a
                            paso</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        <!-- Paso 1 -->
                        <div class="step-card text-center p-6 bg-[#E27227]/10 rounded-2xl">
                            <div class="bg-[#E27227] text-white p-4 rounded-full w-fit mx-auto mb-6"
                                style="background-color: var(--color-secundario-s1); color:#fff;">
                                <i data-lucide="file-plus" class="h-8 w-8"></i>
                            </div>
                            <div class="bg-[#E27227] text-white px-3 py-1 rounded-full text-sm font-medium mb-4 inline-block"
                                style="background-color: var(--color-secundario-s1); color:#fff;">
                                Paso 1</div>
                            <h3 class="text-xl font-bold mb-3">Recepción</h3>
                            <p class="text-gray-600 text-sm">Tu reclamación es recibida y registrada en nuestro
                                sistema.</p>
                        </div>

                        <!-- Paso 2 -->
                        <div class="step-card text-center p-6 bg-[#E27227]/10 rounded-2xl">
                            <div class="bg-[#E27227] text-white p-4 rounded-full w-fit mx-auto mb-6"
                                style="background-color: var(--color-secundario-s1); color:#fff;">
                                <i data-lucide="search" class="h-8 w-8"></i>
                            </div>
                            <div class="bg-[#E27227] text-white px-3 py-1 rounded-full text-sm font-medium mb-4 inline-block"
                                style="background-color: var(--color-secundario-s1); color:#fff;">
                                Paso 2</div>
                            <h3 class="text-xl font-bold mb-3">Evaluación</h3>
                            <p class="text-gray-600 text-sm">Nuestro equipo especializado analiza tu caso y recopila la
                                información necesaria.</p>
                        </div>

                        <!-- Paso 3 -->
                        <div class="step-card text-center p-6 bg-[#DDE3E8] rounded-2xl"
                            style="background-color: var(--color-neutral);">
                            <div class="bg-[#1A4FD3] text-white p-4 rounded-full w-fit mx-auto mb-6"
                                style="background-color: var(--color-primario-p2); color:#fff;">
                                <i data-lucide="users" class="h-8 w-8"></i>
                            </div>
                            <div class="bg-[#1A4FD3] text-white px-3 py-1 rounded-full text-sm font-medium mb-4 inline-block"
                                style="background-color: var(--color-primario-p2); color:#fff;">
                                Paso 3</div>
                            <h3 class="text-xl font-bold mb-3">Investigación</h3>
                            <p class="text-gray-600 text-sm">Se coordina con las áreas involucradas para investigar los
                                hechos reportados.</p>
                        </div>

                        <!-- Paso 4 -->
                        <div class="step-card text-center p-6 bg-[#1A4FD3]/10 rounded-2xl">
                            <div class="bg-[#4A84F7] text-white p-4 rounded-full w-fit mx-auto mb-6"
                                style="background-color: var(--color-primario-p3); color:#fff;">
                                <i data-lucide="check-circle" class="h-8 w-8"></i>
                            </div>
                            <div class="bg-[#4A84F7] text-white px-3 py-1 rounded-full text-sm font-medium mb-4 inline-block"
                                style="background-color: var(--color-primario-p3); color:#fff;">
                                Paso 4</div>
                            <h3 class="text-xl font-bold mb-3">Respuesta</h3>
                            <p class="text-gray-600 text-sm">Te enviamos la respuesta oficial con las acciones tomadas
                                y/o soluciones propuestas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Seguimiento -->
        <section id="seguimiento" class="py-20 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl md:text-5xl font-black mb-4">
                            Seguimiento de <span class="text-[#E27227]"
                                style="color: var(--color-secundario-s1);">Reclamaciones</span>
                        </h2>
                        <p class="text-xl text-gray-600">Consulta el estado de tu reclamación en tiempo real</p>
                    </div>

                    <div class="form-card rounded-2xl p-8 shadow-lg">
                        <div class="text-center mb-8">
                            <div class="bg-[#E27227]/15 p-4 rounded-full w-fit mx-auto mb-6">
                                <i data-lucide="search" class="h-12 w-12 text-[#E27227]"
                                    style="color: var(--color-secundario-s1);"></i>
                            </div>
                            <h3 class="text-2xl font-bold mb-4">Buscar mi Reclamación</h3>
                            <p class="text-gray-600">Ingresa tu código de seguimiento o número de documento</p>
                        </div>

                        <div class="max-w-md mx-auto">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Número de
                                        Documento</label>
                                    <input type="text" id="documentoBusqueda"
                                        class="form-input w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1A4FD3] focus:border-transparent"
                                        style="--tw-ring-color: var(--color-primario-p2);"
                                        placeholder="Número de DNI, CE o Pasaporte">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Código de
                                        Reclamo</label>
                                    <input type="text" id="codigoBusqueda"
                                        class="form-input w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1A4FD3] focus:border-transparent"
                                        style="--tw-ring-color: var(--color-primario-p2);"
                                        placeholder="Ejemplo: LR-12345678">
                                </div>

                                <button onclick="buscarReclamacion()"
                                    class="w-full bg-[#E27227] hover:bg-[#c56120] text-white py-3 rounded-xl font-semibold transition-colors"
                                    style="background-color: var(--color-secundario-s1);"
                                    onmouseover="this.style.backgroundColor='#c56120'"
                                    onmouseout="this.style.backgroundColor=getComputedStyle(document.documentElement).getPropertyValue('--color-secundario-s1')">
                                    <i data-lucide="search" class="h-4 w-4 inline mr-2"></i>
                                    Buscar Reclamación
                                </button>
                            </div>
                        </div>

                        <!-- Resultado -->
                        <div id="resultadoBusqueda" class="mt-12 hidden">
                            <div class="border-t border-gray-200 pt-8">
                                <div class="bg-[#E27227]/10 rounded-xl p-6 mb-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <div class="font-bold text-lg">Reclamación #REC-2025-001234</div>
                                            <div class="text-sm text-gray-600">Presentada el 15 de Enero, 2025</div>
                                        </div>
                                        <div class="bg-[#DDE3E8] text-[#00264B] px-3 py-1 rounded-full text-sm font-medium"
                                            style="background-color: var(--color-neutral); color: var(--color-primario-p1);">
                                            En Proceso</div>
                                    </div>
                                    <div class="text-gray-700"><strong>Asunto:</strong> Problema con el sistema de
                                        matrícula online</div>
                                </div>

                                <!-- Timeline -->
                                <div class="space-y-4">
                                    <div class="flex items-start gap-4">
                                        <div class="bg-[#1A4FD3] p-2 rounded-full"
                                            style="background-color: var(--color-primario-p2);">
                                            <i data-lucide="check" class="h-4 w-4 text-white"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-semibold">Reclamación Recibida</div>
                                            <div class="text-sm text-gray-600">15 Ene 2025, 10:30 AM</div>
                                            <div class="text-sm text-gray-500">Tu reclamación ha sido registrada
                                                exitosamente</div>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-4">
                                        <div class="bg-[#1A4FD3] p-2 rounded-full"
                                            style="background-color: var(--color-primario-p2);">
                                            <i data-lucide="check" class="h-4 w-4 text-white"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-semibold">Asignación de Caso</div>
                                            <div class="text-sm text-gray-600">15 Ene 2025, 2:15 PM</div>
                                            <div class="text-sm text-gray-500">Caso asignado al Área de Sistemas
                                                Académicos</div>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-4">
                                        <div class="bg-[#E27227] p-2 rounded-full"
                                            style="background-color: var(--color-secundario-s1);">
                                            <i data-lucide="clock" class="h-4 w-4 text-white"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-semibold">En Investigación</div>
                                            <div class="text-sm text-gray-600">16 Ene 2025, 9:00 AM</div>
                                            <div class="text-sm text-gray-500">Nuestro equipo está investigando el
                                                problema reportado</div>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-4">
                                        <div class="bg-gray-300 p-2 rounded-full">
                                            <i data-lucide="circle" class="h-4 w-4 text-white"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-semibold text-gray-400">Respuesta Final</div>
                                            <div class="text-sm text-gray-400">Pendiente</div>
                                            <div class="text-sm text-gray-400">Estimado: 20 Ene 2025</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-8 p-4 bg-[#DDE3E8] rounded-xl"
                                    style="background-color: var(--color-neutral);">
                                    <div class="flex items-center gap-2 mb-2">
                                        <i data-lucide="info" class="h-5 w-5 text-[#00264B]"
                                            style="color: var(--color-primario-p1);"></i>
                                        <span class="font-semibold text-[#00264B]"
                                            style="color: var(--color-primario-p1);">Información Adicional</span>
                                    </div>
                                    <p class="text-sm text-[#00264B]" style="color: var(--color-primario-p1);">
                                        Si tienes información adicional que pueda ayudar con tu caso,
                                        puedes contactarnos al correo: reclamaciones@novaacademia.edu
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Derechos del Consumidor -->
        <section id="derechos" class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <div class="max-w-6xl mx-auto">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl md:text-5xl font-black mb-4">
                            Tus <span class="text-[#E27227]"
                                style="color: var(--color-secundario-s1);">Derechos</span>
                        </h2>
                        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                            Conoce tus derechos como consumidor de servicios educativos
                        </p>
                    </div>

                    @php
                        $palette = [
                            ['bg' => 'bg-orange-100', 'icon' => 'text-orange-500'],
                            ['bg' => 'bg-blue-100', 'icon' => 'text-blue-500'],
                            ['bg' => 'bg-indigo-100', 'icon' => 'text-indigo-500'],
                            ['bg' => 'bg-amber-100', 'icon' => 'text-amber-500'],
                            ['bg' => 'bg-sky-100', 'icon' => 'text-sky-500'],
                            ['bg' => 'bg-teal-100', 'icon' => 'text-teal-500'],
                        ];
                    @endphp

                    @if ($derechos->isEmpty())
                        <div class="text-gray-500 text-center">No hay derechos registrados.</div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach ($derechos as $i => $d)
                                @php $c = $palette[$i % count($palette)]; @endphp
                                <div class="form-card rounded-2xl p-6 shadow-lg">
                                    <div class="{{ $c['bg'] }} p-3 rounded-xl w-fit mb-4">
                                        <i class="{{ $d->icono }} {{ $c['icon'] }} text-2xl"></i>
                                    </div>
                                    <h3 class="text-xl font-bold mb-3">{{ $d->titulo }}</h3>
                                    <p class="text-gray-600 text-sm">{{ $d->descripcion }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 gradient-bg text-white"
            style="background-image:linear-gradient(to bottom right, var(--color-primario-p1), var(--color-primario-p2), var(--color-primario-p3)); color:#fff;">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto text-center">
                    <h2 class="text-4xl md:text-5xl font-black mb-6">Tu Voz es Importante</h2>
                    <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                        Ayúdanos a mejorar nuestros servicios. Tu opinión nos permite crecer y brindar una mejor
                        experiencia educativa.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                        <button onclick="scrollToSection('formulario')"
                            class="bg-white text-[#E27227] hover:bg-gray-100 rounded-full px-8 py-4 text-lg font-semibold transition-all transform hover:scale-105 shadow-lg"
                            style="color: var(--color-secundario-s1);">
                            Presentar Nueva Reclamación
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('footer')

    <!-- Modal de éxito -->
    <div id="successModal" class="fixed inset-0 z-[100] hidden">
        <div id="successOverlay" class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

        <div id="successPanel"
            class="relative mx-auto my-10 w-[95%] max-w-md bg-white rounded-2xl shadow-2xl p-6 transition-all duration-200 opacity-0 scale-95">
            <button id="sm-close" class="absolute right-3 top-3 p-2 rounded-full hover:bg-gray-100"
                aria-label="Cerrar">
                <i data-lucide="x" class="w-5 h-5 text-gray-500"></i>
            </button>

            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-green-100 flex items-center justify-center">
                <i data-lucide="check" class="w-8 h-8 text-green-600"></i>
            </div>

            <h3 class="text-2xl font-black text-center">¡Tu reclamación fue enviada!</h3>
            <p class="text-center text-gray-600 mt-1">
                La estaremos revisando en unos instantes. Gracias por confiar en nosotros.
            </p>

            <div class="mt-5 bg-gray-50 rounded-xl p-4 text-sm">
                <div class="grid grid-cols-1 gap-1">
                    <div><span class="text-gray-500">ID:</span> <span id="sm-id" class="font-semibold">—</span>
                    </div>
                    <div><span class="text-gray-500">Asunto:</span> <span id="sm-asunto"
                            class="font-semibold">—</span></div>
                    <div><span class="text-gray-500">Correo:</span> <span id="sm-email"
                            class="font-semibold">—</span></div>
                    <div><span class="text-gray-500">Código:</span> <span id="sm-codigo"
                            class="font-semibold">—</span></div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3">
                <button id="sm-track"
                    class="w-full py-2.5 rounded-xl font-semibold bg-[#1A4FD3] text-white hover:bg-[#173fb0] transition"
                    style="background-color: var(--color-primario-p2);"
                    onmouseover="this.style.backgroundColor='#173fb0'"
                    onmouseout="this.style.backgroundColor=getComputedStyle(document.documentElement).getPropertyValue('--color-primario-p2')">
                    Ver estado
                </button>
                <button id="sm-new"
                    class="w-full py-2.5 rounded-xl font-semibold bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
                    Registrar otro
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Detalle de Reclamación -->
    <div id="detailModal"
        class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div id="detailOverlay" class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

        <div id="detailPanel"
            class="relative w-[95%] max-w-2xl bg-white rounded-2xl shadow-2xl p-6 transition-all duration-200 opacity-0 scale-95">
            <button id="dm-close" class="absolute right-3 top-3 p-2 rounded-full hover:bg-gray-100"
                aria-label="Cerrar">
                <i data-lucide="x" class="h-5 w-5 text-gray-500"></i>
            </button>

            <div class="flex items-center gap-3 mb-4">
                <div class="bg-[#E27227]/15 p-2 rounded-xl">
                    <i data-lucide="file-text" class="w-6 h-6 text-[#E27227]"
                        style="color: var(--color-secundario-s1);"></i>
                </div>
                <h3 class="text-2xl font-black">Detalle de la Reclamación</h3>
            </div>

            <div class="grid sm:grid-cols-2 gap-4 mb-4 text-sm">
                <div><span class="text-gray-500">ID:</span> <span id="dm-id" class="font-semibold">—</span></div>
                <div><span class="text-gray-500">Fecha:</span> <span id="dm-fecha" class="font-semibold">—</span>
                </div>
                <div><span class="text-gray-500">Estado:</span>
                    <span id="dm-estado"
                        class="px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">—</span>
                </div>
                <div><span class="text-gray-500">Tipo:</span> <span id="dm-tipo" class="font-semibold">—</span>
                </div>
                <div class="sm:col-span-2">
                    <span class="text-gray-500">Área:</span> <span id="dm-area" class="font-semibold">—</span>
                </div>
            </div>

            <div class="mb-3">
                <div class="text-gray-500 text-sm">Asunto</div>
                <div id="dm-asunto" class="font-semibold text-lg">—</div>
            </div>

            <div>
                <div class="text-gray-500 text-sm">Descripción</div>
                <div class="mt-2 max-h-[60vh] overflow-y-auto pr-1">
                    <p id="dm-descripcion" class="text-gray-700 whitespace-pre-wrap break-words break-all"></p>
                </div>
            </div>

            <hr class="my-6 border-gray-200">

            <div id="dm-respuesta-wrap" class="space-y-3 hidden">
                <div>
                    <div class="text-gray-500 text-sm">Fecha de respuesta</div>
                    <div id="dm-fecha-respuesta" class="font-semibold">—</div>
                </div>

                <div>
                    <div class="text-gray-500 text-sm">Respuesta</div>
                    <p id="dm-respuesta" class="text-gray-700 whitespace-pre-wrap break-words"></p>
                </div>

                <div>
                    <button id="dm-ver-doc"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#1A4FD3] text-white hover:bg-[#173fb0]"
                        style="background-color: var(--color-primario-p2);"
                        onmouseover="this.style.backgroundColor='#173fb0'"
                        onmouseout="this.style.backgroundColor=getComputedStyle(document.documentElement).getPropertyValue('--color-primario-p2')">
                        <i data-lucide="file-text" class="w-4 h-4"></i>
                        Ver documento
                    </button>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button id="dm-ok"
                    class="px-5 py-2 rounded-xl bg-[#1A4FD3] text-white hover:bg-[#173fb0] font-semibold"
                    style="background-color: var(--color-primario-p2);"
                    onmouseover="this.style.backgroundColor='#173fb0'"
                    onmouseout="this.style.backgroundColor=getComputedStyle(document.documentElement).getPropertyValue('--color-primario-p2')">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    <script src="/js/web/libro.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.LIBRO_CFG = {
            storeUrl: "{{ route('libro.store') }}",
            searchUrl: "{{ route('libro.search') }}",
            estadoInicialId: {{ $estadoInicialId ?? 'null' }}
        };
    </script>
    <script src="/js/web/main.js" defer></script>
</body>

</html>
