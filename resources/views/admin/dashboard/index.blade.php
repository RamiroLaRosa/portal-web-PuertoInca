{{-- resources/views/admin/dashboard/estatico.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Panel Administrativo</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Iconos --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>

    {{-- Tus estilos --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/dahsboard/dashboard.css') }}">
</head>

<body class="has-sidebar">
    @include('include.preloader')
    @include('include.header')

    <aside class="sidebar-fixed">
        @include('include.sidebar')
    </aside>

    <div class="layout">
        <main class="content-with-sidebar">
            <div class="page-main">

                {{-- HERO --}}
                <div class="row g-4">
                    <div class="col col-12 col-lg-6">
                        <div class="card hero">
                            <div class="card-header">
                                <div class="card-title text-white">BIENVENIDO AL PANEL ADMINISTRATIVO DEL PORTAL WEB
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row" style="display:flex;gap:16px;align-items:center;flex-wrap:wrap">
                                    <div style="flex:1 1 60%">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-user fa-2xl fs-1" style="color:white;"></i>
                                            <h1 class="text-white m-0">¡Bienvenido, Usuario!</h1>
                                        </div>
                                        <p class="text-white fs-5 mt-3 mb-2"><b>Usuario:</b> Panel Administrativo,
                                            Usuario</p>
                                        <p class="text-white fs-5 mt-0"><b>Rol:</b> Director General</p>
                                        <p class="text-white-50 mt-3 mb-3">
                                            En este panel gestionas noticias, documentos, programas, docentes y páginas
                                            informativas.
                                            Los cambios se publican solo cuando tú lo decidas.
                                        </p>
                                        <div
                                            class="mt-4 bg-white bg-opacity-10 border border-white border-opacity-25 rounded-3 p-3">
                                            <div class="text-white fw-semibold mb-2">
                                                <i class="fa-solid fa-lightbulb me-2"></i> Consejos rápidos
                                            </div>
                                            <ul class="text-white-50 small mb-0 ps-3">
                                                <li>Usa títulos claros y descripciones breves.</li>
                                                <li>Sube imágenes JPG/PNG optimizadas.</li>
                                                <li>Revisa la vista previa antes de publicar.</li>
                                                <li>Puedes editar o despublicar cuando quieras.</li>
                                            </ul>
                                        </div>
                                        <div class="small text-white-50 mt-3">
                                            ¿Ayuda? <a href="mailto:soporte@instituto.edu"
                                                class="text-white text-decoration-underline">soporte@instituto.edu</a>
                                        </div>
                                    </div>
                                    <div style="flex:1 1 35%">
                                        <img class="w-100" alt="bienvenida"
                                            src="https://png.pngtree.com/png-clipart/20220429/original/pngtree-man-search-for-hiring-job-online-from-laptop-human-resources-management-png-image_7579804.png">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                {{-- GESTOR DE COLORES --}}
                <div class="card mb-2 mt-2">
                    <div class="card-header fw-bold">
                        Gestor de Colores del Portal
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.colors.save') }}" class="d-flex flex-wrap gap-3 justify-content-between align-items-end">
                            @csrf
                            @foreach([
                                ['color-primario-p1', 'Primario P1'],
                                ['color-primario-p2', 'Primario P2'],
                                ['color-primario-p3', 'Primario P3'],
                                ['color-secundario-s1', 'Secundario S1'],
                                ['color-neutral', 'Neutral'],
                            ] as [$clave, $label])
                            <div class="d-flex flex-column align-items-center" style="min-width:140px;">
                                <label class="mb-1 fw-semibold small">{{ $label }}</label>
                                <input type="color" name="{{ $clave }}" value="{{ $colores[$clave] ?? '#ffffff' }}" class="form-control form-control-color" style="width: 2.5rem; height: 2.5rem;">
                                <input type="text" class="form-control mt-2 text-center" value="{{ $colores[$clave] ?? '' }}" readonly>
                            </div>
                            @endforeach
                            <button class="btn btn-primary ms-2" style="min-width:140px;">Guardar Cambios</button>
                        </form>
                    </div>
                </div>


                {{-- FILA 1: Programas (izq), Material (centro), Acceso (der) --}}
                <div class="row g-4 mt-1">
                    {{-- IZQUIERDA: Programas (base de altura) --}}
                    <div class="col col-12 col-lg-3">
                        <div class="card js-eq" id="card-programas">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="card-title m-0">PROGRAMAS DE ESTUDIOS</div>
                            </div>
                            <div class="card-body">
                                <div class="digits text-center mb-3" id="programasDigits"
                                    data-total="{{ $programasTotal }}"></div>
                                <ul class="list-unstyled programas-list m-0">
                                    @foreach ($programas as $nombre)
                                        <li class="programa-row">{{ $nombre }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- CENTRO: Material de ayuda --}}
                    <div class="col-12 col-lg-5">
                        <div class="card h-100" id="card-material">
                            <div class="card-header">
                                <div class="card-title m-0">MATERIAL DE AYUDA</div>
                            </div>

                            <div class="card-body help-grid">
                                {{-- Fila 1 --}}
                                <div class="help-row">
                                    <i class="fa-solid fa-folder-open fa-lg text-muted"></i>
                                    <div class="help-title">Manual de usuario</div>
                                    <a href="#" class="btn btn-outline-primary btn-sm">Descargar</a>
                                </div>

                                {{-- Fila 2 --}}
                                <div class="help-row">
                                    <i class="fa-solid fa-video fa-lg text-muted"></i>
                                    <div class="help-title">Videotutoriales</div>
                                    <a href="#" class="btn btn-outline-primary btn-sm">Ver</a>
                                </div>

                                {{-- Fila 3 --}}
                                <div class="help-row">
                                    <i class="fa-solid fa-phone fa-lg text-muted"></i>
                                    <div class="help-title">Soporte técnico</div>
                                    <a href="https://api.whatsapp.com/send?phone=51922364111&text=Hola%20quiero%20informaci%C3%B3n%20sobre%20el%20instituto."
                                        target="_blank" rel="noopener noreferrer"
                                        class="btn btn-outline-primary btn-sm">+51 968 731 102</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- DERECHA: Acceso --}}
                    <div class="col col-12 col-lg-4">
                        <div class="card js-eq" id="card-acceso">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="card-title m-0">Acceso al Portal Web</div>
                                <a href="/" target="_blank" class="btn btn-outline-primary">
                                    <i class="fa-solid fa-eye"></i> Entrar
                                </a>
                            </div>
                            <div class="card-body">
                                <a href="/" target="_blank">
                                    <img class="w-100 rounded" alt="portal"
                                        src="{{ asset('images/Logo_Silfer.png') }}" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FILA 2: DOCENTES A ANCHO COMPLETO --}}
                <div class="row g-4 mt-1">
                    <div class="col-12">
                        <div class="card" id="card-docentes-full">
                            <div class="card-header">
                                <div class="card-title m-0">DOCENTES POR PROGRAMAS DE ESTUDIO</div>
                            </div>
                            <div class="card-body">
                                <div id="docentesChartWrap">
                                    {{-- Mantén el mismo ID que usa tu JS --}}
                                    <canvas id="chartVisitas"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <br>
            @include('include.footer')
        </main>
    </div>

    {{-- Scripts base --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Datos para el gráfico --}}
    <script>
        window.DOCENTES_PROG = {
            labels: @json($docProgLabels),
            data: @json($docProgData),
        };
    </script>

    {{-- Igualación de altura solo entre Programas y Acceso --}}
    <script>
        (function() {
            function syncCardHeights() {
                const base = document.getElementById('card-programas');
                const targets = [document.getElementById('card-acceso')].filter(Boolean);
                if (!base || targets.length === 0) return;

                [base, ...targets].forEach(el => el.style.height = '');
                const h = Math.ceil(base.getBoundingClientRect().height);
                [base, ...targets].forEach(el => el.style.height = h + 'px');
            }

            window.addEventListener('load', () => setTimeout(syncCardHeights, 250));
            window.addEventListener('resize', syncCardHeights);

            const baseEl = document.getElementById('card-programas');
            if (window.ResizeObserver && baseEl) {
                const ro = new ResizeObserver(syncCardHeights);
                ro.observe(baseEl);
            }
        })();
    </script>

    <script>
        (function() {
            function syncCardHeights() {
                const base = document.getElementById('card-programas'); // referencia
                const targets = [
                    document.getElementById('card-material'), // <== NUEVO
                    document.getElementById('card-acceso')
                ].filter(Boolean);

                if (!base || targets.length === 0) return;

                // Limpia antes de medir
                [base, ...targets].forEach(el => el.style.height = '');

                // Toma la altura del card de Programas
                const h = Math.ceil(base.getBoundingClientRect().height);

                // Aplica esa altura como height fija (idéntica en todos)
                [base, ...targets].forEach(el => el.style.height = h + 'px');
            }

            window.addEventListener('load', () => setTimeout(syncCardHeights, 250));
            window.addEventListener('resize', syncCardHeights);

            const baseEl = document.getElementById('card-programas');
            if (window.ResizeObserver && baseEl) {
                const ro = new ResizeObserver(syncCardHeights);
                ro.observe(baseEl);
            }
        })();
    </script>


    {{-- Tu bundle (asegúrate de usar maintainAspectRatio:false) --}}
    @vite('resources/js/admin/dashboard/dashboard.js')
    @vite('resources/css/darkmode.css')
    @vite('resources/js/darkmode.js')
    @vite('resources/js/admin/dashboard/coloresadministrables.js')
</body>

</html>
