<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Silfer Academia - Plana Docente</title>

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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="stylesheet" href="/css/web/docente.css">
</head>

<body class="min-h-screen bg-brand-gray text-brand-navy font-sans scroll-smooth"
    data-personal-url-template="{{ route('web.docente.personal', ['id' => 'DOC_ID']) }}"
    data-docente-base-url="{{ url('/docente') }}">
    <!-- Barra lateral -->
    <aside
        class="fixed top-0 left-0 h-full w-20 bg-brand-navy text-white z-50 hidden md:flex flex-col items-center py-8">
        <div class="mb-12">
            <a href="{{ url('/') }}" aria-label="Inicio">
                <div class="bg-brand-orange text-white p-2 rounded-full">
                    <i data-lucide="graduation-cap" class="h-6 w-6"></i>
                </div>
            </a>
        </div>

        <nav id="sidebar-nav" class="flex flex-col items-center space-y-8 flex-grow">
            @foreach ($programas as $p)
                <button onclick="scrollToSection('programa-{{ $p->id }}')"
                    class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-brand-blue/90 rounded-full"
                    data-section="programa-{{ $p->id }}" title="{{ $p->nombre }}">
                    <div class="h-3 w-3 rounded-full bg-white"></div>
                </button>
            @endforeach
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
                    Nuestra <span class="gradient-text">Plana Docente</span>
                </h1>
                <p class="text-xl text-brand-navy/70 max-w-4xl mx-auto mb-8">
                    Conoce al equipo de profesionales que guía el aprendizaje con vocación, experiencia y compromiso.
                </p>
            </div>
        </section>

        @php
            // normaliza posibles rutas como "./images/no-photo.jpg"
            $normalize = function ($path) {
                if (blank($path)) {
                    return asset('images/no-photo.jpg');
                }
                $p = ltrim(preg_replace('#^\./#', '', $path), '/');
                return asset($p);
            };
        @endphp

        @foreach ($programas as $index => $programa)
            @php $isDark = $index % 2 === 1; @endphp

            <section id="programa-{{ $programa->id }}"
                class="py-20 {{ $isDark ? 'bg-brand-navy text-white' : 'bg-brand-gray text-brand-navy' }}">
                <div class="container mx-auto px-4 md:px-12">
                    <div class="mb-12">
                        <h2 class="text-4xl md:text-5xl font-bold mt-2">{{ $programa->nombre }}</h2>
                    </div>

                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse($programa->docentes as $d)
                            @php $img = $d->foto ? $normalize($d->foto) : asset('images/no-photo.jpg'); @endphp

                            <div
                                class="teacher-card rounded-3xl p-8 shadow-lg hover:shadow-xl transition-all
                                        {{ $isDark ? 'bg-white/5 backdrop-blur border border-white/10 text-white' : 'bg-white border border-brand-gray/40' }}">
                                <div class="text-center mb-6">
                                    <div
                                        class="w-80 h-80 mx-auto rounded-2xl overflow-hidden
                                                bg-gradient-to-br {{ $isDark ? 'from-brand-orange to-brand-sky' : 'from-brand-blue to-brand-sky' }} mb-6 shadow-lg">
                                        <img src="{{ $img }}" alt="{{ $d->nombre }}"
                                            class="w-full h-full object-cover teacher-image">
                                    </div>

                                    <h3
                                        class="text-2xl font-bold mb-2 {{ $isDark ? 'text-white' : 'text-brand-navy' }}">
                                        {{ $d->nombre }}</h3>
                                    <p
                                        class="text-lg font-medium mb-4 {{ $isDark ? 'text-brand-gray/90' : 'text-brand-navy/70' }}">
                                        {{ $d->cargo }}</p>
                                </div>

                                <div
                                    class="mt-4 pt-4 {{ $isDark ? 'border-t border-white/20' : 'border-t border-brand-gray/40' }}">
                                    <div
                                        class="flex items-center justify-center text-sm mb-4 {{ $isDark ? 'text-brand-gray/90' : 'text-brand-navy/70' }}">
                                        <i data-lucide="mail" class="h-4 w-4 mr-2"></i> {{ $d->correo }}
                                    </div>

                                    <div class="flex justify-center gap-3">
                                        <button
                                            class="info-button p-3 rounded-xl {{ $isDark ? 'bg-brand-blue hover:bg-brand-blue/90 text-white' : 'bg-brand-orange/10 hover:bg-brand-orange/20 text-brand-orange' }}"
                                            title="Información Personal" onclick="openPersonal({{ $d->id }})">
                                            <i data-lucide="user" class="h-5 w-5"></i>
                                        </button>
                                        <button onclick="openAcademic({{ $d->id }})"
                                            class="info-button p-3 rounded-xl {{ $isDark ? 'bg-brand-blue hover:bg-brand-blue/90 text-white' : 'bg-brand-orange/10 hover:bg-brand-orange/20 text-brand-orange' }}"
                                            title="Formación Académica">
                                            <i data-lucide="graduation-cap" class="h-5 w-5"></i>
                                        </button>
                                        <button onclick="openLaboral({{ $d->id }})"
                                            class="info-button p-3 rounded-xl {{ $isDark ? 'bg-brand-blue hover:bg-brand-blue/90 text-white' : 'bg-brand-orange/10 hover:bg-brand-orange/20 text-brand-orange' }}"
                                            title="Experiencia Laboral">
                                            <i data-lucide="briefcase" class="h-5 w-5"></i>
                                        </button>
                                        <button onclick="openUD({{ $d->id }})"
                                            class="info-button p-3 rounded-xl {{ $isDark ? 'bg-brand-blue hover:bg-brand-blue/90 text-white' : 'bg-brand-orange/10 hover:bg-brand-orange/20 text-brand-orange' }}"
                                            title="Unidades Didácticas">
                                            <i data-lucide="book-open" class="h-5 w-5"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full">
                                <div
                                    class="rounded-2xl p-6 text-center {{ $isDark ? 'bg-white/5 border border-white/10 text-white/90' : 'bg-white border border-brand-gray/40 text-brand-navy/80' }}">
                                    Aún no se han registrado docentes para este programa.
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
                </div>
            </section>
        @endforeach
    </main>

    <footer>
        <div>
            @include('footer')
        </div>
    </footer>

    <!-- Modal -->
    <div id="teacherModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-2 sm:p-4">
        <div
            class="modal-panel bg-white rounded-3xl p-4 sm:p-8 w-full sm:max-w-2xl md:max-w-4xl max-h-[90dvh] overflow-y-auto">
            <div class="flex justify-between items-start mb-4 sm:mb-6">
                <h3 id="modalTitle" class="text-2xl sm:text-3xl font-bold"></h3>
                <button onclick="closeTeacherModal()" class="p-2 hover:bg-brand-gray rounded-full">
                    <i data-lucide="x" class="h-6 w-6"></i>
                </button>
            </div>
            <div id="modalContent" class="space-y-6"></div>
        </div>
    </div>


    <script src="/js/web/docente.js?v=2"></script>
    <script src="/js/web/main.js" defer></script>
</body>

</html>
