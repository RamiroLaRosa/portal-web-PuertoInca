<!-- Header principal -->
<header class="fixed top-0 left-0 right-0 bg-white shadow-md z-40 md:pl-20">
    <div class="container mx-auto">
        <div class="flex items-center justify-between h-16 px-4">
            <!-- Logo del instituto (Imagen) visible en móvil y escritorio -->
            <div class="flex items-center space-x-2">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/Logo Puerto Inca.PNG') }}" alt="Logo Puerto Inca" class="h-14 w-auto">
                </a>
            </div>

            <!-- Botón de menú móvil -->
            <button onclick="toggleMobileMenu()" class="p-2 md:hidden" id="mobile-menu-button">
                <i data-lucide="menu" class="h-6 w-6" id="menu-icon"></i>
                <i data-lucide="x" class="h-6 w-6 hidden" id="close-icon"></i>
            </button>

            <!-- Navegación desktop -->
            <nav class="hidden md:flex items-center space-x-1 text-sm">

                <a href="{{ url('/') }}"><button
                        class="px-3 py-2 rounded-md hover:bg-gray-100 font-medium">Inicio</button></a>

                <div class="relative group">
                    <button class="px-3 py-2 rounded-md hover:bg-gray-100 font-medium flex items-center">
                        Nosotros
                        <i data-lucide="chevron-down" class="ml-1 h-4 w-4"></i>
                    </button>
                    <div
                        class="absolute left-0 mt-1 w-64 bg-white rounded-md shadow-lg overflow-hidden z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                        <div class="py-2">
                            <a href="{{ url('/presentacion') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">Presentación
                                y reseña histórica</a>
                            <a href="{{ url('/mision') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">Misión,
                                visión y valores</a>
                            <a href="{{ url('/organigrama') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">Organización
                                institucional</a>
                            <a href="{{ url('/jerarquica') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">Plana
                                jerárquica</a>
                            <a href="{{ url('/docente') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">Plana
                                docente</a>
                            <a href="{{ url('/locales') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">Locales</a>
                        </div>
                    </div>
                </div>
                <div class="relative group">
                    <button class="px-3 py-2 rounded-md hover:bg-gray-100 font-medium flex items-center">
                        Programas de estudio
                        <i data-lucide="chevron-down" class="ml-1 h-4 w-4"></i>
                    </button>
                    <div
                        class="absolute left-0 mt-1 w-64 bg-white rounded-md shadow-lg overflow-hidden z-50
                                opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                        <div class="py-2">
                            @foreach ($programasMenu ?? [] as $p)
                                <a href="{{ route('programas.show.id', $p->id) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">
                                    {{ $p->nombre }}
                                </a>
                            @endforeach
                            <a href="{{ url('/efsrt') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">
                                EFSRT
                            </a>
                        </div>
                    </div>
                </div>
                <div class="relative group">
                    <button class="px-3 py-2 rounded-md hover:bg-gray-100 font-medium flex items-center">
                        Admisión y matrícula
                        <i data-lucide="chevron-down" class="ml-1 h-4 w-4"></i>
                    </button>
                    <div
                        class="absolute left-0 mt-1 w-64 bg-white rounded-md shadow-lg overflow-hidden z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                        <div class="py-2">
                            <a href="{{ url('/admisión') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">Admisión
                                2025</a>
                            <a href="{{ url('/matricula') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">Matrícula</a>
                            <a href="{{ url('/becas') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">Becas
                                y Créditos</a>
                        </div>
                    </div>
                </div>
                <div class="relative group">
                    <button class="px-3 py-2 rounded-md hover:bg-gray-100 font-medium flex items-center">
                        Transparencia
                        <i data-lucide="chevron-down" class="ml-1 h-4 w-4"></i>
                    </button>
                    <div
                        class="absolute left-0 mt-1 w-64 bg-white rounded-md shadow-lg overflow-hidden z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                        <div class="py-2">
                            <a href="{{ url('/documentos') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">Documentos
                                de gestión</a>
                            <a href="{{ url('/inversiones') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">Inversiones
                                y recursos económicos</a>
                            <a href="{{ url('/libro_reclamaciones') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">Libro
                                de reclamaciones</a>
                            <a href="{{ url('/licenciamiento') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">Licenciamiento</a>
                            <a href="{{ url('/estadisticas') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">Estadística</a>
                        </div>
                    </div>
                </div>
                <div class="relative group">
                    <button class="px-3 py-2 rounded-md hover:bg-gray-100 font-medium flex items-center">
                        Trámite
                        <i data-lucide="chevron-down" class="ml-1 h-4 w-4"></i>
                    </button>
                    <div
                        class="absolute left-0 mt-1 w-64 bg-white rounded-md shadow-lg overflow-hidden z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                        <div class="py-2">
                            <a href="{{ url('/tupa') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">TUPA</a>
                            <a href="{{ asset('/assets/procesos.pdf') }}" target="_blank"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">
                                Procesos Académicos
                            </a>
                            <a href="{{ url('/servicios-tramites') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">Servicios
                                de trámite</a>
                        </div>
                    </div>
                </div>
                <div class="relative group">
                    <button class="px-3 py-2 rounded-md hover:bg-gray-100 font-medium flex items-center">
                        Servicios
                        <i data-lucide="chevron-down" class="ml-1 h-4 w-4"></i>
                    </button>
                    <div
                        class="absolute left-0 mt-1 w-64 bg-white rounded-md shadow-lg overflow-hidden z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                        <div class="py-2">
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">Biblioteca
                                virtual</a>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">Relación
                                de libros</a>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">Sistema
                                de registro de información académica</a>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">Bolsa
                                laboral</a>
                            <a href="{{ url('/servicios_complementarios') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">Servicios
                                complementarios</a>
                        </div>
                    </div>
                </div>
                <div class="relative group">
                    <button class="px-3 py-2 rounded-md hover:bg-gray-100 font-medium flex items-center">
                        Otras páginas
                        <i data-lucide="chevron-down" class="ml-1 h-4 w-4"></i>
                    </button>

                    <div
                        class="absolute left-0 mt-1 w-64 bg-white rounded-md shadow-lg overflow-hidden z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                        <div class="py-2">
                            @forelse($linksInstitucionales ?? collect() as $link)
                                <a href="{{ $link->enlace }}" target="_blank" rel="noopener"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">
                                    {{ $link->nombre }}
                                </a>
                            @empty
                                <span class="block px-4 py-2 text-sm text-gray-400">Sin enlaces</span>
                            @endforelse

                            <a href="{{ url('/noticias') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">
                                Noticias
                            </a>
                            <a href="{{ url('/galeria') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">
                                Galería
                            </a>
                        </div>
                    </div>
                </div>
                <a href="{{ url('/contacto') }}"><button
                        class="px-3 py-2 rounded-md hover:bg-gray-100 font-medium">Contáctanos</button></a>
            </nav>
        </div>
    </div>
</header>

<!-- Menú móvil -->
<div id="mobile-menu" class="fixed inset-0 bg-white z-30 pt-16 md:hidden overflow-y-auto hidden">
    <div class="p-4">
        <nav class="flex flex-col">
            <div class="border-b border-gray-100">
                <button class="flex items-center justify-between w-full py-4 text-left">
                    <a href="{{ url('/') }}"><span class="font-medium">Inicio</span></a>
                </button>
            </div>
            <div class="border-b border-gray-100">
                <button onclick="toggleSubmenu('nosotros')"
                    class="flex items-center justify-between w-full py-4 text-left">
                    <span class="font-medium">Nosotros</span>
                    <i data-lucide="chevron-down" class="h-5 w-5 transition-transform" id="nosotros-chevron"></i>
                </button>
                <div id="nosotros-submenu" class="pl-4 pb-2 hidden">
                    <a href="{{ url('/presentacion') }}"
                        class="block py-2 text-sm text-gray-600 hover:text-orange-500">Presentación y reseña
                        histórica</a>
                    <a href="{{ url('/mision') }}"
                        class="block py-2 text-sm text-gray-600 hover:text-orange-500">Misión, visión y valores</a>
                    <a href="{{ url('/organigrama') }}"
                        class="block py-2 text-sm text-gray-600 hover:text-orange-500">Organización institucional</a>
                    <a href="{{ url('/jerarquica') }}"
                        class="block py-2 text-sm text-gray-600 hover:text-orange-500">Plana jerárquica</a>
                    <a href="{{ url('/docente') }}"
                        class="block py-2 text-sm text-gray-600 hover:text-orange-500">Plana docente</a>
                    <a href="{{ url('/locales') }}"
                        class="block py-2 text-sm text-gray-600 hover:text-orange-500">Locales</a>
                </div>
            </div>
            <div class="border-b border-gray-100">
                <button onclick="toggleSubmenu('programas')"
                    class="flex items-center justify-between w-full py-4 text-left">
                    <span class="font-medium">Programas de estudio</span>
                    <i data-lucide="chevron-down" class="h-5 w-5 transition-transform" id="programas-chevron"></i>
                </button>
                <div id="programas-submenu" class="pl-4 pb-2 hidden">
                    @foreach ($programasMenu ?? [] as $p)
                        <a href="{{ route('programas.show.id', $p->id) }}"
                            class="block py-2 text-sm text-gray-600 hover:text-orange-500">
                            {{ $p->nombre }}
                        </a>
                    @endforeach
                    <a href="{{ url('/efsrt') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">
                        EFSRT
                    </a>
                </div>
            </div>
            <div class="border-b border-gray-100">
                <button onclick="toggleSubmenu('admision')"
                    class="flex items-center justify-between w-full py-4 text-left">
                    <span class="font-medium">Admisión y matrícula</span>
                    <i data-lucide="chevron-down" class="h-5 w-5 transition-transform" id="admision-chevron"></i>
                </button>
                <div id="admision-submenu" class="pl-4 pb-2 hidden">
                    <a href="{{ url('/admisión') }}"
                        class="block py-2 text-sm text-gray-600 hover:text-orange-500">Admisión 2025</a>
                    <a href="{{ url('/matricula') }}"
                        class="block py-2 text-sm text-gray-600 hover:text-orange-500">Matrícula</a>
                    <a href="{{ url('/becas') }}"
                        class="block py-2 text-sm text-gray-600 hover:text-orange-500">Becas y Créditos</a>
                </div>
            </div>
            <div class="border-b border-gray-100">
                <button onclick="toggleSubmenu('transparencia')"
                    class="flex items-center justify-between w-full py-4 text-left">
                    <span class="font-medium">Transparencia</span>
                    <i data-lucide="chevron-down" class="h-5 w-5 transition-transform"
                        id="transparencia-chevron"></i>
                </button>
                <div id="transparencia-submenu" class="pl-4 pb-2 hidden">
                    <a href="{{ url('/documentos') }}"
                        class="block py-2 text-sm text-gray-600 hover:text-orange-500">Documentos de gestión</a>
                    <a href="{{ url('/tupa') }}"
                        class="block py-2 text-sm text-gray-600 hover:text-orange-500">TUPA</a>
                    <a href="{{ url('/inversiones') }}"
                        class="block py-2 text-sm text-gray-600 hover:text-orange-500">Inversiones y recursos
                        económicos</a>
                    <a href="{{ url('/libro_reclamaciones') }}"
                        class="block py-2 text-sm text-gray-600 hover:text-orange-500">Libro de reclamaciones</a>
                    <a href="{{ url('/licenciamiento') }}"
                        class="block py-2 text-sm text-gray-600 hover:text-orange-500">Licenciamiento</a>
                    <a href="{{ url('/estadisticas') }}"
                        class="block py-2 text-sm text-gray-600 hover:text-orange-500">Estadística</a>
                </div>
            </div>
            <div class="border-b border-gray-100">
                <button onclick="toggleSubmenu('servicios')"
                    class="flex items-center justify-between w-full py-4 text-left">
                    <span class="font-medium">Servicios</span>
                    <i data-lucide="chevron-down" class="h-5 w-5 transition-transform" id="servicios-chevron"></i>
                </button>
                <div id="servicios-submenu" class="pl-4 pb-2 hidden">
                    <a href="#" class="block py-2 text-sm text-gray-600 hover:text-orange-500">Biblioteca
                        virtual</a>
                    <a href="#" class="block py-2 text-sm text-gray-600 hover:text-orange-500">Relación de
                        libros</a>
                    <a href="#" class="block py-2 text-sm text-gray-600 hover:text-orange-500">Sistema de
                        registro de información académica</a>
                    <a href="#" class="block py-2 text-sm text-gray-600 hover:text-orange-500">Bolsa laboral</a>
                    <a href="{{ url('/servicios_complementarios') }}"
                        class="block py-2 text-sm text-gray-600 hover:text-orange-500">Servicios complementarios</a>
                </div>
            </div>
            <div class="border-b border-gray-100">
                <button onclick="toggleSubmenu('otras')"
                    class="flex items-center justify-between w-full py-4 text-left">
                    <span class="font-medium">Otras páginas</span>
                    <i data-lucide="chevron-down" class="h-5 w-5 transition-transform" id="otras-chevron"></i>
                </button>
                <div id="otras-submenu" class="pl-4 pb-2 hidden">
                    @forelse($linksInstitucionales ?? collect() as $link)
                        <a href="{{ $link->enlace }}" target="_blank" rel="noopener"
                            class="block py-2 text-sm text-gray-600 hover:text-orange-500">
                            {{ $link->nombre }}
                        </a>
                    @empty
                        <span class="block py-2 text-sm text-gray-400">Sin enlaces</span>
                    @endforelse

                    {{-- Fijo: Noticias --}}
                    <a href="{{ url('/noticias') }}" class="block py-2 text-sm text-gray-600 hover:text-orange-500">
                        Noticias
                    </a>
                    <a href="{{ url('/galeria') }}" class="block py-2 text-sm text-gray-600 hover:text-orange-500">
                        Galería
                    </a>
                </div>
            </div>
            <div class="border-b border-gray-100">
                <button class="flex items-center justify-between w-full py-4 text-left">
                    <a href="{{ url('/contacto') }}"><span class="font-medium">Contáctanos</span></a>
                </button>
            </div>
        </nav>
        <div class="mt-8 pt-8 border-t border-gray-100">
            <h3 class="font-medium mb-4">Secciones principales</h3>
            <div class="grid grid-cols-2 gap-2">
                <button onclick="scrollToSection('home')"
                    class="py-2 px-3 text-sm bg-gray-50 rounded-md hover:bg-orange-50 hover:text-orange-500 transition-colors">Inicio</button>
                <button onclick="scrollToSection('servicios')"
                    class="py-2 px-3 text-sm bg-gray-50 rounded-md hover:bg-orange-50 hover:text-orange-500 transition-colors">Servicios</button>
                <button onclick="scrollToSection('estadisticas')"
                    class="py-2 px-3 text-sm bg-gray-50 rounded-md hover:bg-orange-50 hover:text-orange-500 transition-colors">Estadísticas</button>
                <button onclick="scrollToSection('programas')"
                    class="py-2 px-3 text-sm bg-gray-50 rounded-md hover:bg-orange-50 hover:text-orange-500 transition-colors">Programas</button>
                <button onclick="scrollToSection('noticias')"
                    class="py-2 px-3 text-sm bg-gray-50 rounded-md hover:bg-orange-50 hover:text-orange-500 transition-colors">Noticias</button>
                <button onclick="scrollToSection('coordinadores')"
                    class="py-2 px-3 text-sm bg-gray-50 rounded-md hover:bg-orange-50 hover:text-orange-500 transition-colors">Coordinadores</button>
                <button onclick="scrollToSection('porque')"
                    class="py-2 px-3 text-sm bg-gray-50 rounded-md hover:bg-orange-50 hover:text-orange-500 transition-colors">¿Por
                    qué elegirnos?</button>
                <button onclick="scrollToSection('testimonios')"
                    class="py-2 px-3 text-sm bg-gray-50 rounded-md hover:bg-orange-50 hover:text-orange-500 transition-colors">Testimonios</button>
            </div>
        </div>
    </div>
</div>
