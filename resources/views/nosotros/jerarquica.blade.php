<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Silfer Academia - Plana Jerárquica</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Usamos las variables de tu hoja:
        // p1:#00264B, p2:#1A4FD3, p3:#4A84F7, s1:#E27227, s2:#f78132, s3:#f99a5b, neutral:#DDE3E8
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            navy: 'var(--color-primario-p1)', // #00264B
                            blue: 'var(--color-primario-p2)', // #1A4FD3
                            sky: 'var(--color-primario-p3)', // #4A84F7
                            orange: 'var(--color-secundario-s1)', // #E27227
                            gray: 'var(--color-neutral)', // #DDE3E8
                        }
                    }
                }
            }
        }
    </script>

    <!-- Lucide icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="stylesheet" href="/css/web/jerarquica.css">
</head>

<body class="min-h-screen bg-[#f8f9fa] text-[#0f172a] font-sans scroll-smooth">

    <!-- Barra lateral (decorativa) -->
    <aside class="fixed top-0 left-0 h-full w-20 bg-brand-navy text-white z-50 hidden md:flex flex-col items-center py-8"
        style="background-color: var(--color-primario-p1); color: #ffffff;">
        <div class="mb-12">
            <a href="index.html" aria-label="Inicio">
                <div class="bg-brand-orange text-white p-2 rounded-full"
                    style="background-color: var(--color-secundario-s1); color: #ffffff;">
                    <i data-lucide="graduation-cap" class="h-6 w-6"></i>
                </div>
            </a>
        </div>
        <nav class="flex flex-col items-center space-y-8 flex-grow" id="sidebar-nav">
            <button onclick="scrollToSection('departamentos')"
                class="nav-dot relative w-12 h-12 flex items-center justify-center transition-all hover:bg-brand-blue/90 rounded-full"
                data-section="departamentos" title="Plana Jerárquica"
                style="/* hover se mantiene con Tailwind; color base sin hover no requiere inline */">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
        </nav>
    </aside>


    @include('header')

    <main class="md:pl-20 pt-16">
        <!-- Plana jerárquica (estática) -->
        <section id="departamentos" class="py-20 bg-gradient-to-br from-brand-gray to-white" data-level="departamento"
            style="background-image: linear-gradient(to bottom right, var(--color-neutral), #ffffff);">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-12 text-center">
                    <h2 class="text-5xl md:text-6xl font-bold mt-2 bg-gradient-to-r from-brand-orange to-brand-sky bg-clip-text text-transparent"
                        style="background-image: linear-gradient(to right, var(--color-secundario-s1), var(--color-primario-p3));">
                        Plana Jerárquica
                    </h2>
                    <p class="text-xl text-brand-navy/70 mt-6 max-w-3xl mx-auto"
                        style="color: var(--color-primario-p1); opacity:.7;">
                        Conoce a nuestro equipo de líderes especializados que brindan soporte integral y guían cada área
                        estratégica de la institución.
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 mb-16">
                    @forelse ($items as $item)
                        @php
                            // Asegurar URL válida, aunque en BD venga con './'
                            $raw = $item->imagen ?: 'images/no-photo.jpg';
                            $img = asset(ltrim($raw, './'));
                        @endphp

                        <div class="group staff-card bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 border border-brand-gray hover:border-brand-orange"
                            data-name="{{ $item->nombre }}" data-position="{{ $item->cargo }}"
                            data-email="{{ $item->email ?? '' }}" data-description="{{ $item->descripcion ?? '' }}"
                            data-image="{{ $img }}" onclick="showStaffDetails(this)"
                            style="border-color: var(--color-neutral);">
                            <div class="staff-image-container aspect-square w-full bg-gradient-to-br from-brand-orange to-brand-sky"
                                style="background-image: linear-gradient(to bottom right, var(--color-secundario-s1), var(--color-primario-p3));">
                                <img src="{{ $img }}" alt="{{ $item->nombre }}"
                                    class="w-full h-full object-cover relative z-10">
                            </div>
                            <div class="p-6 text-center">
                                <h3 class="text-xl font-bold mb-2 text-brand-navy"
                                    style="color: var(--color-primario-p1);">{{ $item->nombre }}</h3>
                                <p class="text-brand-navy/60 font-semibold text-sm mb-3"
                                    style="color: var(--color-primario-p1); opacity:.6;">{{ $item->cargo }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full rounded-xl bg-white p-8 text-center text-brand-navy/70 shadow"
                            style="color: var(--color-primario-p1); opacity:.7;">
                            Aún no hay integrantes publicados.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div>
            @include('footer')
        </div>
    </footer>

    <script>
        lucide.createIcons();

        let activeSection = 'departamentos';

        function scrollToSection(id) {
            const el = document.getElementById(id);
            if (!el) return;
            const y = el.getBoundingClientRect().top + window.pageYOffset - 80;
            window.scrollTo({
                top: y,
                behavior: 'smooth'
            });
            closeMobileMenu();
        }

        function closeMobileMenu() {
            const mm = document.getElementById('mobile-menu');
            const mi = document.getElementById('menu-icon');
            const ci = document.getElementById('close-icon');
            if (!mm || !mi || !ci) return;
            mm.classList.add('hidden');
            mi.classList.remove('hidden');
            ci.classList.add('hidden');
        }

        function updateActiveNavigation() {
            const sections = document.querySelectorAll('section[id]');
            let current = 'departamentos';
            sections.forEach(s => {
                const top = s.offsetTop,
                    h = s.clientHeight;
                if (window.scrollY >= top - 200 && window.scrollY < top + h - 200) {
                    current = s.getAttribute('id') || 'departamentos';
                }
            });
            document.querySelectorAll('.nav-dot').forEach(b => {
                b.classList.remove('bg-brand-orange');
                b.classList.add('hover:bg-brand-blue/90');
            });
            const active = document.querySelector(`[data-section="${current}"]`);
            if (active) {
                active.classList.add('bg-brand-orange');
                active.classList.remove('hover:bg-brand-blue/90');
                // Inline para el activo
                active.style.backgroundColor = 'var(--color-secundario-s1)';
            }
        }
        window.addEventListener('scroll', updateActiveNavigation);
        window.addEventListener('load', updateActiveNavigation);

        // Modal
        function showStaffDetails(el) {
            const m = document.getElementById('staffModal');
            const title = document.getElementById('modalTitle');
            const body = document.getElementById('modalContent');

            const name = el.dataset.name || '';
            const pos = el.dataset.position || '';
            const email = el.dataset.email || '';
            const desc = (el.dataset.description || '').replace(/\n/g, '<br>');
            const img = el.dataset.image || `{{ asset('images/no-photo.jpg') }}`;

            title.textContent = name;
            body.innerHTML = `
                <div class="flex flex-col md:flex-row gap-6 mb-6">
                    <div class="w-32 h-32 md:w-40 md:h-40 rounded-2xl overflow-hidden bg-gradient-to-br from-brand-orange to-brand-sky shadow-lg flex-shrink-0"
                         style="background-image: linear-gradient(to bottom right, var(--color-secundario-s1), var(--color-primario-p3));">
                        <img src="${img}" alt="${name}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1">
                        <h4 class="text-2xl font-bold mb-2" style="color: var(--color-primario-p1);">${name}</h4>
                        <p class="font-medium text-lg mb-3" style="color: var(--color-secundario-s1);">${pos}</p>
                        ${email ? `<div class="flex items-center gap-2">
                                <i data-lucide="mail" class="h-4 w-4" style="color: var(--color-secundario-s1);"></i>
                                <a class="hover:underline" href="mailto:${email}" style="color: var(--color-secundario-s1);">${email}</a>
                            </div>` : ''}
                    </div>
                </div>
                ${desc ? `<div><h5 class="font-bold mb-2" style="color: var(--color-primario-p1);">Información</h5><p class="leading-relaxed" style="color:#475569;">${desc}</p></div>` : ''}
            `;
            m.classList.remove('hidden');
            m.classList.add('flex');
            lucide.createIcons();
        }

        function closeStaffModal() {
            const m = document.getElementById('staffModal');
            m.classList.add('hidden');
            m.classList.remove('flex');
        }
        document.getElementById('staffModal').addEventListener('click', e => {
            if (e.target.id === 'staffModal') closeStaffModal();
        });
    </script>
    <script src="/js/web/main.js" defer></script>
</body>

</html>
