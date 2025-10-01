<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Silfer Academia - Plana Docente</title>

    <!-- Variables administrables -->
    <link rel="stylesheet" href="{{ asset('css/css_colores_administrables/css_colores_administrables.css') }}">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            navy: "var(--color-primario-p1)",
                            blue: "var(--color-primario-p2)",
                            sky: "var(--color-primario-p3)",
                            orange: "var(--color-secundario-s1)",
                            gray: "var(--color-neutral)",
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
    style="background-color: var(--color-neutral); color: var(--color-primario-p1);"
    data-personal-url-template="{{ route('web.docente.personal', ['id' => 'DOC_ID']) }}"
    data-docente-base-url="{{ url('/docente') }}">

    <!-- Barra lateral -->
    <aside
        class="fixed top-0 left-0 h-full w-20 bg-brand-navy text-white z-50 hidden md:flex flex-col items-center py-8"
        style="background-color: var(--color-primario-p1); color: #ffffff;">
        <div class="mb-12">
            <a href="{{ url('/') }}" aria-label="Inicio">
                <div class="bg-brand-orange text-white p-2 rounded-full"
                    style="background-color: var(--color-secundario-s1); color: #ffffff;">
                    <i data-lucide="graduation-cap" class="h-6 w-6"></i>
                </div>
            </a>
        </div>

        <nav id="sidebar-nav" class="flex flex-col items-center space-y-8 flex-grow">
            @foreach ($programas as $p)
                <button onclick="scrollToSection('programa-{{ $p->id }}')"
                    class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-brand-blue/90 rounded-full"
                    data-section="programa-{{ $p->id }}" title="{{ $p->nombre }}"
                    style="/* hover se mantiene por Tailwind; base sin color explícito */">
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
                <!-- Degradado: naranja 10% -> celeste 10% -->
                <div class="absolute top-0 left-0 w-full h-full"
                    style="background-image: linear-gradient(to bottom right,
                            color-mix(in srgb, var(--color-secundario-s1) 10%, transparent),
                            color-mix(in srgb, var(--color-primario-p3) 10%, transparent));">
                </div>

                <div class="floating-element absolute top-1/4 right-1/4 w-64 h-64 rounded-full"
                    style="background-color: color-mix(in srgb, var(--color-secundario-s1) 20%, transparent);">
                </div>
                <div class="floating-element absolute bottom-1/3 left-1/3 w-80 h-80 rounded-full"
                    style="background-color: color-mix(in srgb, var(--color-primario-p3) 20%, transparent); animation-delay:-3s;">
                </div>
                <div class="floating-element absolute top-1/2 right-1/3 w-32 h-32 rounded-full"
                    style="background-color: color-mix(in srgb, var(--color-primario-p2) 30%, transparent); animation-delay:-1.5s;">
                </div>
            </div>

            <div class="container mx-auto px-4 md:px-12 z-10 relative text-center">
                <h1 class="text-5xl md:text-7xl font-bold leading-tight mb-6">
                    Nuestra <span class="gradient-text">Plana Docente</span>
                </h1>
                <p class="text-xl text-brand-navy/70 max-w-4xl mx-auto mb-8"
                    style="color: var(--color-primario-p1); opacity: .7;">
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
                class="py-20 {{ $isDark ? 'bg-brand-navy text-white' : 'bg-brand-gray text-brand-navy' }}"
                style="{{ $isDark
                    ? 'background-color: var(--color-primario-p1); color: #ffffff;'
                    : 'background-color: var(--color-neutral); color: var(--color-primario-p1);' }}">
                <div class="container mx-auto px-4 md:px-12">
                    <div class="mb-12">
                        <h2 class="text-4xl md:text-5xl font-bold mt-2">{{ $programa->nombre }}</h2>
                    </div>

                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse($programa->docentes as $d)
                            @php $img = $d->foto ? $normalize($d->foto) : asset('images/no-photo.jpg'); @endphp

                            <div class="teacher-card rounded-3xl p-8 shadow-lg hover:shadow-xl transition-all
                                        {{ $isDark ? 'bg-white/5 backdrop-blur border border-white/10 text-white' : 'bg-white border border-brand-gray/40' }}"
                                style="{{ $isDark
                                    ? 'border-color: rgba(255,255,255,.1); color:#ffffff; background: color-mix(in srgb, #ffffff 5%, transparent);'
                                    : 'border-color: color-mix(in srgb, var(--color-neutral) 40%, transparent);' }}">
                                <div class="text-center mb-6">
                                    <div class="w-80 h-80 mx-auto rounded-2xl overflow-hidden mb-6 shadow-lg
                                                bg-gradient-to-br {{ $isDark ? 'from-brand-orange to-brand-sky' : 'from-brand-blue to-brand-sky' }}"
                                        style="background-image: linear-gradient(to bottom right,
                                               {{ $isDark ? 'var(--color-secundario-s1), var(--color-primario-p3)' : 'var(--color-primario-p2), var(--color-primario-p3)' }} );">
                                        <img src="{{ $img }}" alt="{{ $d->nombre }}"
                                            class="w-full h-full object-cover teacher-image">
                                    </div>

                                    <h3 class="text-2xl font-bold mb-2 {{ $isDark ? 'text-white' : 'text-brand-navy' }}"
                                        style="{{ $isDark ? 'color:#ffffff;' : 'color: var(--color-primario-p1);' }}">
                                        {{ $d->nombre }}
                                    </h3>

                                    <p class="text-lg font-medium mb-4 {{ $isDark ? 'text-brand-gray/90' : 'text-brand-navy/70' }}"
                                        style="{{ $isDark
                                            ? 'color: color-mix(in srgb, var(--color-neutral) 90%, transparent);'
                                            : 'color: color-mix(in srgb, var(--color-primario-p1) 70%, transparent);' }}">
                                        {{ $d->cargo }}
                                    </p>
                                </div>

                                <div class="mt-4 pt-4 {{ $isDark ? 'border-t border-white/20' : 'border-t border-brand-gray/40' }}"
                                    style="{{ $isDark
                                        ? 'border-top-color: rgba(255,255,255,.2);'
                                        : 'border-top-color: color-mix(in srgb, var(--color-neutral) 40%, transparent);' }}">
                                    <div class="flex items-center justify-center text-sm mb-4 {{ $isDark ? 'text-brand-gray/90' : 'text-brand-navy/70' }}"
                                        style="{{ $isDark
                                            ? 'color: color-mix(in srgb, var(--color-neutral) 90%, transparent);'
                                            : 'color: color-mix(in srgb, var(--color-primario-p1) 70%, transparent);' }}">
                                        <i data-lucide="mail" class="h-4 w-4 mr-2"></i> {{ $d->correo }}
                                    </div>

                                    <div class="flex justify-center gap-3">
                                        <!-- Botón: Info Personal -->
                                        <button
                                            class="info-button p-3 rounded-xl {{ $isDark ? 'bg-brand-blue hover:bg-brand-blue/90 text-white' : 'bg-brand-orange/10 hover:bg-brand-orange/20 text-brand-orange' }}"
                                            title="Información Personal" onclick="openPersonal({{ $d->id }})"
                                            style="{{ $isDark
                                                ? 'background-color: var(--color-primario-p2); color:#ffffff;'
                                                : 'background-color: color-mix(in srgb, var(--color-secundario-s1) 10%, transparent); color: var(--color-secundario-s1);' }}">
                                            <i data-lucide="user" class="h-5 w-5"></i>
                                        </button>

                                        <!-- Botón: Formación Académica -->
                                        <button onclick="openAcademic({{ $d->id }})"
                                            class="info-button p-3 rounded-xl {{ $isDark ? 'bg-brand-blue hover:bg-brand-blue/90 text-white' : 'bg-brand-orange/10 hover:bg-brand-orange/20 text-brand-orange' }}"
                                            title="Formación Académica"
                                            style="{{ $isDark
                                                ? 'background-color: var(--color-primario-p2); color:#ffffff;'
                                                : 'background-color: color-mix(in srgb, var(--color-secundario-s1) 10%, transparent); color: var(--color-secundario-s1);' }}">
                                            <i data-lucide="graduation-cap" class="h-5 w-5"></i>
                                        </button>

                                        <!-- Botón: Experiencia Laboral -->
                                        <button onclick="openLaboral({{ $d->id }})"
                                            class="info-button p-3 rounded-xl {{ $isDark ? 'bg-brand-blue hover:bg-brand-blue/90 text-white' : 'bg-brand-orange/10 hover:bg-brand-orange/20 text-brand-orange' }}"
                                            title="Experiencia Laboral"
                                            style="{{ $isDark
                                                ? 'background-color: var(--color-primario-p2); color:#ffffff;'
                                                : 'background-color: color-mix(in srgb, var(--color-secundario-s1) 10%, transparent); color: var(--color-secundario-s1);' }}">
                                            <i data-lucide="briefcase" class="h-5 w-5"></i>
                                        </button>

                                        <!-- Botón: Unidades Didácticas -->
                                        <button onclick="openUD({{ $d->id }})"
                                            class="info-button p-3 rounded-xl {{ $isDark ? 'bg-brand-blue hover:bg-brand-blue/90 text-white' : 'bg-brand-orange/10 hover:bg-brand-orange/20 text-brand-orange' }}"
                                            title="Unidades Didácticas"
                                            style="{{ $isDark
                                                ? 'background-color: var(--color-primario-p2); color:#ffffff;'
                                                : 'background-color: color-mix(in srgb, var(--color-secundario-s1) 10%, transparent); color: var(--color-secundario-s1);' }}">
                                            <i data-lucide="book-open" class="h-5 w-5"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full">
                                <div class="rounded-2xl p-6 text-center {{ $isDark ? 'bg-white/5 border border-white/10 text-white/90' : 'bg-white border border-brand-gray/40 text-brand-navy/80' }}"
                                    style="{{ $isDark
                                        ? 'border-color: rgba(255,255,255,.1); color: rgba(255,255,255,.9); background: color-mix(in srgb, #ffffff 5%, transparent);'
                                        : 'border-color: color-mix(in srgb, var(--color-neutral) 40%, transparent); color: color-mix(in srgb, var(--color-primario-p1) 80%, transparent);' }}">
                                    Aún no se han registrado docentes para este programa.
                                </div>
                            </div>
                        @endforelse
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
                <button onclick="closeTeacherModal()" class="p-2 hover:bg-brand-gray rounded-full"
                    style="/* hover tailwind */">
                    <i data-lucide="x" class="h-6 w-6"></i>
                </button>
            </div>
            <div id="modalContent" class="space-y-6"></div>
        </div>
    </div>

    <script src="/js/web/docente.js?v=2"></script>
    <script src="/js/web/main.js" defer></script>
    <script>
        // Modal estático de Unidades Didácticas
        async function openUD(teacherId) {
            const modal = document.getElementById('teacherModal');
            const title = document.getElementById('modalTitle');
            const titleEl = document.getElementById('modalTitle');
            const content = document.getElementById('modalContent');
        
            title.textContent = 'Unidades Didácticas';
        
            // Contenido estático de ejemplo: organiza por ciclos/módulos y muestra UD con horas/créditos
            titleEl.textContent = 'Unidades Didácticas';
            content.innerHTML = `
                <div class="space-y-6">
                    <!-- Módulo I -->
                    <div class="rounded-3xl border border-brand-gray/40 bg-white overflow-hidden">
                        <div class="bg-brand-blue/10 px-6 py-4 flex items-center">
                            <i data-lucide="folder" class="h-4 w-4 mr-2 text-brand-blue"></i>
                            <h4 class="text-lg font-bold text-brand-navy">Módulo I - Fundamentos y Didáctica</h4>
                        </div>
                        <div class="p-6 overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="text-left text-sm text-brand-navy/60 uppercase">
                                        <th class="py-2 pr-6">Código</th>
                                        <th class="py-2 pr-6">Unidad Didáctica</th>
                                        <th class="py-2 pr-6">Horas</th>
                                        <th class="py-2">Créditos</th>
                                    </tr>
                                </thead>
                                <tbody class="text-brand-navy/90">
                                    <tr class="border-t">
                                        <td class="py-3 pr-6 font-mono">UD-101</td>
                                        <td class="py-3 pr-6">Didáctica General</td>
                                        <td class="py-3 pr-6">64</td>
                                        <td class="py-3">4</td>
                                    </tr>
                                    <tr class="border-t">
                                        <td class="py-3 pr-6 font-mono">UD-102</td>
                                        <td class="py-3 pr-6">Planificación Curricular</td>
                                        <td class="py-3 pr-6">64</td>
                                        <td class="py-3">4</td>
                                    </tr>
                                    <tr class="border-t">
                                        <td class="py-3 pr-6 font-mono">UD-103</td>
                                        <td class="py-3 pr-6">Evaluación por Competencias</td>
                                        <td class="py-3 pr-6">48</td>
                                        <td class="py-3">3</td>
                                    </tr>
                                    <tr class="border-t">
                                        <td class="py-3 pr-6 font-mono">UD-104</td>
                                        <td class="py-3 pr-6">Tecnologías Aplicadas a la Enseñanza</td>
                                        <td class="py-3 pr-6">48</td>
                                        <td class="py-3">3</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        
                <div class="flex items-center gap-2 text-brand-navy/70">
                    <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    Cargando...
                </div>
            `;
        
            const base = document.body.dataset.docenteBaseUrl; // "/docente"
            try {
                const res = await fetch(`${base}/${teacherId}/unidades`, {
                    headers: {
                        'Accept': 'application/json'
                    },
                });
                if (!res.ok) throw new Error();
                const data = await res.json();
        
                // Sin cursos
                if (!data.grupos || data.grupos.length === 0) {
                    content.innerHTML = `
                        <div class="rounded-2xl border border-brand-gray/40 bg-white p-6 text-center text-brand-navy/80">
                            Este docente aún no tiene unidades didácticas registradas.
                        </div>
                    `;
                    modal.classList.remove('hidden');
                    window.lucide && lucide.createIcons();
                    return;
                }
        
                // Render
                const blocks = data.grupos.map(g => {
                    const sems = g.semestres.map(s => {
                        const lis = s.cursos.map(c => `
                            <li class="flex items-center justify-between py-2 border-t first:border-t-0">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="book-open" class="h-4 w-4 text-brand-blue"></i>
                                    <span class="font-medium">${c.nombre}</span>
                                </div>
                                <div class="text-xs text-brand-navy/60">
                                    <span class="px-2 py-0.5 rounded bg-brand-gray/60 mr-1">${c.creditos} cr.</span>
                                    <span class="px-2 py-0.5 rounded bg-brand-gray/60">${c.horas} h</span>
                                </div>
                            </li>
                        `).join('');
        
                        return `
                            <div class="mb-4">
                                <div class="text-brand-blue font-semibold mb-2">${s.semestre}</div>
                                <ul class="divide-y">${lis}</ul>
                            </div>
                        `;
                    }).join('');
        
                    return `
                        <div class="rounded-3xl border border-brand-gray/40 bg-white overflow-hidden">
                            <div class="bg-brand-blue/10 px-6 py-4 flex items-center">
                                <i data-lucide="folder" class="h-4 w-4 mr-2 text-brand-blue"></i>
                                <h4 class="text-lg font-bold text-brand-navy">${g.modulo}</h4>
                            </div>
                            <div class="p-6">${sems}</div>
                        </div>
                    `;
                }).join('');
        
                content.innerHTML = `<div class="space-y-6">${blocks}</div>`;
            } catch (_) {
                content.innerHTML = `
                    <div class="rounded-2xl border border-red-200 bg-red-50 p-6 text-center text-red-700">
                        No se pudo cargar la información. Intenta nuevamente.
                    </div>
                `;
            }
        
            modal.classList.remove('hidden');
            window.lucide && lucide.createIcons();
        }
        </script>        
</body>

</html>
