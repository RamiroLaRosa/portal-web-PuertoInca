{{-- Variables CSS dinámicas --}}
<style>
    :root {
        --color-primario-p1: {{ $colores['color-primario-p1'] ?? '#00264B' }};
        --color-primario-p2: {{ $colores['color-primario-p2'] ?? '#1A4FD3' }};
        --color-primario-p3: {{ $colores['color-primario-p3'] ?? '#4A84F7' }};
        --color-secundario-s1: {{ $colores['color-secundario-s1'] ?? '#E27227' }};
        --color-neutral: {{ $colores['color-neutral'] ?? '#DDE3E8' }};
    }
</style>

<style>
    /* Hover botones de barra desktop con tu neutral */
    .hdr-btn {
        transition: background-color .2s ease, color .2s ease;
    }

    .hdr-btn:hover {
        background-color: var(--color-neutral);
    }

    /* Panel desplegable */
    .menu-panel {
        background-color: #ffffff;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, .1), 0 4px 6px -2px rgba(0, 0, 0, .05);
        border-radius: .375rem;
    }

    /* Links del panel: base gris 700; hover naranja corporativo */
    .menu-link {
        color: #374151;
        transition: background-color .15s ease, color .15s ease;
    }

    .menu-link:hover {
        background-color: color-mix(in srgb, var(--color-secundario-s1) 10%, #ffffff);
        color: var(--color-secundario-s1);
    }
</style>

<style>
    .link-institucional {
        color: var(--color-neutral);
        transition: color 0.2s;
    }
    .link-institucional:hover {
        color: var(--color-secundario-s1);
    }

</style>



<!-- Header principal -->
<header id="site-header" class="fixed top-0 left-0 right-0 shadow-md z-40 md:pl-20" style="background-color:#ffffff;">
    <div class="container mx-auto">
        <div class="flex items-center justify-between h-16 px-4">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <a href="{{ url('/') }}">
                    <img src="{{ $siteLogoUrl }}" alt="Logo NOVA" class="h-14 w-auto">
                </a>
            </div>

            <!-- Botón menú móvil -->
            <button onclick="toggleMobileMenu()" class="p-2 md:hidden" id="mobile-menu-button">
                <i data-lucide="menu" class="h-6 w-6" id="menu-icon"></i>
                <i data-lucide="x" class="h-6 w-6 hidden" id="close-icon"></i>
            </button>

            <!-- Navegación desktop -->
            <nav class="hidden md:flex items-center space-x-1 text-sm">

                {{-- Inicio --}}
                @if (header_on('Inicio'))
                    <a href="{{ url('/') }}">
                        <button class="px-3 py-2 rounded-md font-medium hdr-btn">Inicio</button>
                    </a>
                @endif

                {{-- Nosotros --}}
                @if (header_on('Nosotros'))
                    <div class="relative group">
                        <button class="px-3 py-2 rounded-md font-medium flex items-center hdr-btn">
                            Nosotros <i data-lucide="chevron-down" class="ml-1 h-4 w-4"></i>
                        </button>
                        <div
                            class="absolute left-0 mt-1 w-64 rounded-md overflow-hidden z-50 opacity-0 invisible
                        group-hover:opacity-100 group-hover:visible transition-all duration-300 menu-panel">
                            <div class="py-2">
                                @foreach (submodulos_activos_de('Nosotros') as $s)
                                    @php
                                        $href = sub_url('Nosotros', $s['nombre']);
                                        $blank = sub_blank('Nosotros', $s['nombre']);
                                    @endphp
                                    <a href="{{ $href }}"
                                        @if ($blank) target="_blank" @endif
                                        class="block px-4 py-2 text-sm menu-link">
                                        {{ $s['nombre'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Programas de estudio --}}
                @if (header_on('Programas de estudio'))
                    <div class="relative group">
                        <button class="px-3 py-2 rounded-md font-medium flex items-center hdr-btn">
                            Programas de estudio <i data-lucide="chevron-down" class="ml-1 h-4 w-4"></i>
                        </button>
                        <div
                            class="absolute left-0 mt-1 w-64 rounded-md overflow-hidden z-50 opacity-0 invisible
                        group-hover:opacity-100 group-hover:visible transition-all duration-300 menu-panel">
                            <div class="py-2">
                                @foreach ($programasMenu ?? [] as $p)
                                    <a href="{{ route('programas.show.id', $p->id) }}"
                                        class="block px-4 py-2 text-sm menu-link">
                                        {{ $p->nombre }}
                                    </a>
                                @endforeach
                                @foreach (submodulos_activos_de('Programas de estudio') as $s)
                                    @php
                                        $href = sub_url('Programas de estudio', $s['nombre']);
                                        $blank = sub_blank('Programas de estudio', $s['nombre']);
                                    @endphp
                                    <a href="{{ $href }}"
                                        @if ($blank) target="_blank" @endif
                                        class="block px-4 py-2 text-sm menu-link">
                                        {{ $s['nombre'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Admisión y matrícula --}}
                @if (header_on('Admisión y matrícula'))
                    <div class="relative group">
                        <button class="px-3 py-2 rounded-md font-medium flex items-center hdr-btn">
                            Admisión y matrícula <i data-lucide="chevron-down" class="ml-1 h-4 w-4"></i>
                        </button>
                        <div
                            class="absolute left-0 mt-1 w-64 rounded-md overflow-hidden z-50 opacity-0 invisible
                        group-hover:opacity-100 group-hover:visible transition-all duration-300 menu-panel">
                            <div class="py-2">
                                @foreach (submodulos_activos_de('Admisión y matrícula') as $s)
                                    @php
                                        $href = sub_url('Admisión y matrícula', $s['nombre']);
                                        $blank = sub_blank('Admisión y matrícula', $s['nombre']);
                                    @endphp
                                    <a href="{{ $href }}"
                                        @if ($blank) target="_blank" @endif
                                        class="block px-4 py-2 text-sm menu-link">
                                        {{ $s['nombre'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Transparencia --}}
                @if (header_on('Transparencia'))
                    <div class="relative group">
                        <button class="px-3 py-2 rounded-md font-medium flex items-center hdr-btn">
                            Transparencia <i data-lucide="chevron-down" class="ml-1 h-4 w-4"></i>
                        </button>
                        <div
                            class="absolute left-0 mt-1 w-64 rounded-md overflow-hidden z-50 opacity-0 invisible
                        group-hover:opacity-100 group-hover:visible transition-all duration-300 menu-panel">
                            <div class="py-2">
                                @foreach (submodulos_activos_de('Transparencia') as $s)
                                    @php
                                        $href = sub_url('Transparencia', $s['nombre']);
                                        $blank = sub_blank('Transparencia', $s['nombre']);
                                    @endphp
                                    <a href="{{ $href }}"
                                        @if ($blank) target="_blank" @endif
                                        class="block px-4 py-2 text-sm menu-link">
                                        {{ $s['nombre'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Trámite --}}
                @if (header_on('Trámite'))
                    <div class="relative group">
                        <button class="px-3 py-2 rounded-md font-medium flex items-center hdr-btn">
                            Trámite <i data-lucide="chevron-down" class="ml-1 h-4 w-4"></i>
                        </button>
                        <div
                            class="absolute left-0 mt-1 w-64 rounded-md overflow-hidden z-50 opacity-0 invisible
                        group-hover:opacity-100 group-hover:visible transition-all duration-300 menu-panel">
                            <div class="py-2">
                                @foreach (submodulos_activos_de('Trámite') as $s)
                                    @php
                                        $href = sub_url('Trámite', $s['nombre']);
                                        $blank = sub_blank('Trámite', $s['nombre']);
                                    @endphp
                                    <a href="{{ $href }}"
                                        @if ($blank) target="_blank" @endif
                                        class="block px-4 py-2 text-sm menu-link">
                                        {{ $s['nombre'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Servicios --}}
                @if (header_on('Servicios'))
                    <div class="relative group">
                        <button class="px-3 py-2 rounded-md font-medium flex items-center hdr-btn">
                            Servicios <i data-lucide="chevron-down" class="ml-1 h-4 w-4"></i>
                        </button>
                        <div
                            class="absolute left-0 mt-1 w-64 rounded-md overflow-hidden z-50 opacity-0 invisible
                        group-hover:opacity-100 group-hover:visible transition-all duration-300 menu-panel">
                            <div class="py-2">
                                @foreach (submodulos_activos_de('Servicios') as $s)
                                    @php
                                        $href = sub_url('Servicios', $s['nombre']);
                                        $blank = sub_blank('Servicios', $s['nombre']);
                                    @endphp
                                    <a href="{{ $href }}"
                                        @if ($blank) target="_blank" @endif
                                        class="block px-4 py-2 text-sm menu-link">
                                        {{ $s['nombre'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Otras páginas --}}
                @if (header_on('Otras páginas'))
                    @php
                        $ya = [];
                        $norm = function ($s) {
                            return \Illuminate\Support\Str::of($s ?? '')
                                ->lower()
                                ->ascii()
                                ->squish()
                                ->__toString();
                        };
                    @endphp
                    <div class="relative group">
                        <button class="px-3 py-2 rounded-md font-medium flex items-center hdr-btn">
                            Otras páginas <i data-lucide="chevron-down" class="ml-1 h-4 w-4"></i>
                        </button>
                        <div
                            class="absolute left-0 mt-1 w-64 rounded-md overflow-hidden z-50 opacity-0 invisible
                        group-hover:opacity-100 group-hover:visible transition-all duration-300 menu-panel">
                            <div class="py-2">
                                {{-- Submódulos --}}
                                @foreach (submodulos_activos_de('Otras páginas') as $s)
                                    @php
                                        $key = $norm($s['nombre']);
                                        if (isset($ya[$key])) {
                                            continue;
                                        }
                                        $ya[$key] = true;
                                        $href = sub_url('Otras páginas', $s['nombre']);
                                        $blank = sub_blank('Otras páginas', $s['nombre']);
                                    @endphp
                                    <a href="{{ $href }}"
                                        @if ($blank) target="_blank" @endif
                                        class="block px-4 py-2 text-sm menu-link">
                                        {{ $s['nombre'] }}
                                    </a>
                                @endforeach

                                {{-- Links institucionales (sin duplicar nombres) --}}
                                @forelse(($linksInstitucionales ?? collect()) as $link)
                                    @php
                                        $key = $norm($link->nombre);
                                        if (isset($ya[$key])) {
                                            continue;
                                        }
                                        $ya[$key] = true;
                                    @endphp
                                    <a href="{{ $link->enlace }}" target="_blank" rel="noopener"
                                        class="block px-4 py-2 text-sm menu-link">
                                        {{ $link->nombre }}
                                    </a>
                                @empty
                                    <span class="block px-4 py-2 text-sm" style="color:var(--color-neutral);">Sin enlaces</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Contáctanos --}}
                @if (header_on('Contáctanos'))
                    <a href="{{ url('/contacto') }}">
                        <button class="px-3 py-2 rounded-md font-medium hdr-btn">Contáctanos</button>
                    </a>
                @endif
            </nav>
        </div>
    </div>
</header>

<!-- Menú móvil -->
<div id="mobile-menu" class="fixed inset-0 z-30 pt-16 md:hidden overflow-y-auto hidden"
    style="background-color:#ffffff;">
    <div class="p-4">
        <nav class="flex flex-col">

            {{-- Inicio --}}
            @if (header_on('Inicio'))
                <div class="border-b" style="border-color: var(--color-neutral);">
                    <button class="flex items-center justify-between w-full py-4 text-left">
                        <a href="{{ url('/') }}"><span class="font-medium">Inicio</span></a>
                    </button>
                </div>
            @endif

            {{-- Nosotros --}}
            @if (header_on('Nosotros'))
                <div class="border-b" style="border-color: var(--color-neutral);">
                    <button onclick="toggleSubmenu('nosotros')"
                        class="flex items-center justify-between w-full py-4 text-left">
                        <span class="font-medium">Nosotros</span>
                        <i data-lucide="chevron-down" class="h-5 w-5 transition-transform" id="nosotros-chevron"></i>
                    </button>
                    <div id="nosotros-submenu" class="pl-4 pb-2 hidden">
                        @foreach (submodulos_activos_de('Nosotros') as $s)
                            @php
                                $href = sub_url('Nosotros', $s['nombre']);
                                $blank = sub_blank('Nosotros', $s['nombre']);
                            @endphp
                            <a href="{{ $href }}" @if ($blank) target="_blank" @endif
                                class="block py-2 text-sm" style="color:var(--color-neutral);">{{ $s['nombre'] }}</a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Programas de estudio --}}
            @if (header_on('Programas de estudio'))
                <div class="border-b" style="border-color: var(--color-neutral);">
                    <button onclick="toggleSubmenu('programas')"
                        class="flex items-center justify-between w-full py-4 text-left">
                        <span class="font-medium">Programas de estudio</span>
                        <i data-lucide="chevron-down" class="h-5 w-5 transition-transform"
                            id="programas-chevron"></i>
                    </button>
                    <div id="programas-submenu" class="pl-4 pb-2 hidden">
                        @foreach ($programasMenu ?? [] as $p)
                            <a href="{{ route('programas.show.id', $p->id) }}" class="block py-2 text-sm"
                                style="color:#4b5563;">{{ $p->nombre }}</a>
                        @endforeach
                        @foreach (submodulos_activos_de('Programas de estudio') as $s)
                            @php
                                $href = sub_url('Programas de estudio', $s['nombre']);
                                $blank = sub_blank('Programas de estudio', $s['nombre']);
                            @endphp
                            <a href="{{ $href }}" @if ($blank) target="_blank" @endif
                                class="block py-2 text-sm" style="color:var(--color-neutral);">{{ $s['nombre'] }}</a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Admisión y matrícula --}}
            @if (header_on('Admisión y matrícula'))
                <div class="border-b" style="border-color: var(--color-neutral);">
                    <button onclick="toggleSubmenu('admision')"
                        class="flex items-center justify-between w-full py-4 text-left">
                        <span class="font-medium">Admisión y matrícula</span>
                        <i data-lucide="chevron-down" class="h-5 w-5 transition-transform" id="admision-chevron"></i>
                    </button>
                    <div id="admision-submenu" class="pl-4 pb-2 hidden">
                        @foreach (submodulos_activos_de('Admisión y matrícula') as $s)
                            @php
                                $href = sub_url('Admisión y matrícula', $s['nombre']);
                                $blank = sub_blank('Admisión y matrícula', $s['nombre']);
                            @endphp
                            <a href="{{ $href }}" @if ($blank) target="_blank" @endif
                                class="block py-2 text-sm" style="color:var(--color-neutral);">{{ $s['nombre'] }}</a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Transparencia --}}
            @if (header_on('Transparencia'))
                <div class="border-b" style="border-color: var(--color-neutral);">
                    <button onclick="toggleSubmenu('transparencia')"
                        class="flex items-center justify-between w-full py-4 text-left">
                        <span class="font-medium">Transparencia</span>
                        <i data-lucide="chevron-down" class="h-5 w-5 transition-transform"
                            id="transparencia-chevron"></i>
                    </button>
                    <div id="transparencia-submenu" class="pl-4 pb-2 hidden">
                        @foreach (submodulos_activos_de('Transparencia') as $s)
                            @php
                                $href = sub_url('Transparencia', $s['nombre']);
                                $blank = sub_blank('Transparencia', $s['nombre']);
                            @endphp
                            <a href="{{ $href }}" @if ($blank) target="_blank" @endif
                                class="block py-2 text-sm" style="color:var(--color-neutral);">{{ $s['nombre'] }}</a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Servicios --}}
            @if (header_on('Servicios'))
                <div class="border-b" style="border-color: var(--color-neutral);">
                    <button onclick="toggleSubmenu('servicios')"
                        class="flex items-center justify-between w-full py-4 text-left">
                        <span class="font-medium">Servicios</span>
                        <i data-lucide="chevron-down" class="h-5 w-5 transition-transform"
                            id="servicios-chevron"></i>
                    </button>
                    <div id="servicios-submenu" class="pl-4 pb-2 hidden">
                        @foreach (submodulos_activos_de('Servicios') as $s)
                            @php
                                $href = sub_url('Servicios', $s['nombre']);
                                $blank = sub_blank('Servicios', $s['nombre']);
                            @endphp
                            <a href="{{ $href }}" @if ($blank) target="_blank" @endif
                                class="block py-2 text-sm" style="color:var(--color-neutral);">{{ $s['nombre'] }}</a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Otras páginas --}}
            @if (header_on('Otras páginas'))
                @php
                    $ya = [];
                    $norm = function ($s) {
                        return \Illuminate\Support\Str::of($s ?? '')
                            ->lower()
                            ->ascii()
                            ->squish()
                            ->__toString();
                    };
                @endphp
                <div class="border-b" style="border-color: var(--color-neutral);">
                    <button onclick="toggleSubmenu('otras')"
                        class="flex items-center justify-between w-full py-4 text-left">
                        <span class="font-medium">Otras páginas</span>
                        <i data-lucide="chevron-down" class="h-5 w-5 transition-transform" id="otras-chevron"></i>
                    </button>
                    <div id="otras-submenu" class="pl-4 pb-2 hidden">
                        {{-- Submódulos --}}
                        @foreach (submodulos_activos_de('Otras páginas') as $s)
                            @php
                                $key = $norm($s['nombre']);
                                if (isset($ya[$key])) {
                                    continue;
                                }
                                $ya[$key] = true;
                                $href = sub_url('Otras páginas', $s['nombre']);
                                $blank = sub_blank('Otras páginas', $s['nombre']);
                            @endphp
                            <a href="{{ $href }}" @if ($blank) target="_blank" @endif
                                class="block py-2 text-sm" style="color:var(--color-neutral);">{{ $s['nombre'] }}</a>
                        @endforeach

                        {{-- Links institucionales --}}
                        @forelse(($linksInstitucionales ?? collect()) as $link)
                            @php
                                $key = $norm($link->nombre);
                                if (isset($ya[$key])) {
                                    continue;
                                }
                                $ya[$key] = true;
                            @endphp

                            <a href="{{ $link->enlace }}" target="_blank" rel="noopener"
                                class="block py-2 text-sm link-institucional">
                                {{ $link->nombre }}
                            </a>

                        @empty
                            <span class="block py-2 text-sm" style="color:var(--color-neutral);">Sin enlaces</span>
                        @endforelse
                    </div>
                </div>
            @endif

            {{-- Contáctanos --}}
            @if (header_on('Contáctanos'))
                <div class="border-b" style="border-color: var(--color-neutral);">
                    <button class="flex items-center justify-between w-full py-4 text-left">
                        <a href="{{ url('/contacto') }}"><span class="font-medium">Contáctanos</span></a>
                    </button>
                </div>
            @endif

        </nav>

        <div class="mt-8 pt-8" style="border-top:1px solid var(--color-neutral);">
            <h3 class="font-medium mb-4">Secciones principales</h3>
            <div class="grid grid-cols-2 gap-2">
                <button onclick="scrollToSection('home')" class="py-2 px-3 text-sm rounded-md transition-colors"
                    style="background-color:#f9fafb;"
                    onmouseover="this.style.backgroundColor='color-mix(in srgb, var(--color-secundario-s1) 10%, #fff)'; this.style.color='var(--color-secundario-s1)'"
                    onmouseout="this.style.backgroundColor='#f9fafb'; this.style.color=''">Inicio</button>

                <button onclick="scrollToSection('servicios')" class="py-2 px-3 text-sm rounded-md transition-colors"
                    style="background-color:#f9fafb;"
                    onmouseover="this.style.backgroundColor='color-mix(in srgb, var(--color-secundario-s1) 10%, #fff)'; this.style.color='var(--color-secundario-s1)'"
                    onmouseout="this.style.backgroundColor='#f9fafb'; this.style.color=''">Servicios</button>

                <button onclick="scrollToSection('estadisticas')"
                    class="py-2 px-3 text-sm rounded-md transition-colors" style="background-color:#f9fafb;"
                    onmouseover="this.style.backgroundColor='color-mix(in srgb, var(--color-secundario-s1) 10%, #fff)'; this.style.color='var(--color-secundario-s1)'"
                    onmouseout="this.style.backgroundColor='#f9fafb'; this.style.color=''">Estadísticas</button>

                <button onclick="scrollToSection('programas')" class="py-2 px-3 text-sm rounded-md transition-colors"
                    style="background-color:#f9fafb;"
                    onmouseover="this.style.backgroundColor='color-mix(in srgb, var(--color-secundario-s1) 10%, #fff)'; this.style.color='var(--color-secundario-s1)'"
                    onmouseout="this.style.backgroundColor='#f9fafb'; this.style.color=''">Programas</button>

                <button onclick="scrollToSection('noticias')" class="py-2 px-3 text-sm rounded-md transition-colors"
                    style="background-color:#f9fafb;"
                    onmouseover="this.style.backgroundColor='color-mix(in srgb, var(--color-secundario-s1) 10%, #fff)'; this.style.color='var(--color-secundario-s1)'"
                    onmouseout="this.style.backgroundColor='#f9fafb'; this.style.color=''">Noticias</button>

                <button onclick="scrollToSection('coordinadores')"
                    class="py-2 px-3 text-sm rounded-md transition-colors" style="background-color:#f9fafb;"
                    onmouseover="this.style.backgroundColor='color-mix(in srgb, var(--color-secundario-s1) 10%, #fff)'; this.style.color='var(--color-secundario-s1)'"
                    onmouseout="this.style.backgroundColor='#f9fafb'; this.style.color=''">Coordinadores</button>

                <button onclick="scrollToSection('porque')" class="py-2 px-3 text-sm rounded-md transition-colors"
                    style="background-color:#f9fafb;"
                    onmouseover="this.style.backgroundColor='color-mix(in srgb, var(--color-secundario-s1) 10%, #fff)'; this.style.color='var(--color-secundario-s1)'"
                    onmouseout="this.style.backgroundColor='#f9fafb'; this.style.color=''">¿Por qué elegirnos?</button>

                <button onclick="scrollToSection('testimonios')"
                    class="py-2 px-3 text-sm rounded-md transition-colors" style="background-color:#f9fafb;"
                    onmouseover="this.style.backgroundColor='color-mix(in srgb, var(--color-secundario-s1) 10%, #fff)'; this.style.color='var(--color-secundario-s1)'"
                    onmouseout="this.style.backgroundColor='#f9fafb'; this.style.color=''">Testimonios</button>
            </div>
        </div>

    </div>
</div>
