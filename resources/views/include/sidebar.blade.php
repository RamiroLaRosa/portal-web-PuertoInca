<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Sidebar unificado (header + menú)</title>

    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
</head>

<body>
    <div class="app">
        <!-- Sidebar UNIFICADO -->
        <aside class="dlabnav">
            <!-- Header integrado -->
            <div class="sidebar-brand">
                <a href="{{ route('dashboard.index') }}" class="brand-logo">
                    <img src="{{ asset('images/Logo_Blanco.png') }}" alt="Logo" width="40" height="40">
                    <div class="brand-title">
                        <img src="{{ asset('images/institucion/banner.png') }}" alt="Panel Administrativo"
                            width="170" height="40">
                    </div>
                </a>
            </div>
            <!-- Scroll del menú -->
            <div class="dlabnav-scroll">
                <ul class="metismenu" id="menu">
                    <!-- MENU -->
                    <li class="p-1">
                        <a href="{{ route('dashboard.index') }}">
                            <i data-lucide="layout-dashboard"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    @foreach ($datalist as $data)
                        @if ($data->nombre_modulo === 'Seguridad' && $data->estado_permiso === 'Activo')
                            <!-- USUARIO ADMIN -->
                            <li class="p-1">
                                <a class="has-arrow" href="javascript:void(0);">
                                    <i data-lucide="shield"></i>
                                    <span class="nav-text">Seguridad</span>
                                </a>
                                <ul>
                                    <li><a href="{{ route('roles.index') }}">Roles</a></li>
                                    <li><a href="{{ route('permisos.index') }}">Permisos</a></li>
                                    <li><a href="{{ route('admin.header.index') }}">Modulos</a></li>
                                    <li><a href="{{ route('admin.submodulos.index') }}">Submodulos</a></li>
                                    <li><a href="{{ route('administradores.index') }}">Administradores</a></li>
                                </ul>
                            </li>
                        @elseif ($data->nombre_modulo === 'Inicio' && $data->estado_permiso === 'Activo')
                            <!-- Inicio -->
                            <li class="p-1">
                                <a class="has-arrow" href="javascript:void(0);">
                                    <i data-lucide="home"></i>
                                    <span class="nav-text">Inicio</span>
                                </a>
                                <ul>
                                    <li><a href="{{ route('admin.inicio.logo.index') }}">Logo Institucional</a></li>
                                    <li><a href="{{ route('hero.index') }}">Hero</a></li>
                                    <li><a href="{{ route('servicios-inicio.index') }}">Servicios</a></li>
                                    <li><a href="{{ route('estadistica-inicio.index') }}">Estadistica</a></li>
                                    <li><a href="{{ route('beneficio.index') }}">Beneficios</a></li>
                                    <li><a href="{{ route('testimonios.index') }}">Testimonios</a></li>
                                </ul>
                            </li>
                        @elseif ($data->nombre_modulo === 'Nosotros' && $data->estado_permiso === 'Activo')
                            <!-- Nosotros -->
                            <li class="p-1">
                                <a class="has-arrow" href="javascript:void(0);">
                                    <i data-lucide="users"></i>
                                    <span class="nav-text">Nosotros</span>
                                </a>
                                <ul>
                                    <li><a href="{{ route('presentacion.index') }}">Presentación</a></li>
                                    <li><a href="{{ route('resenia.index') }}">Reseña Histórica</a></li>
                                    <li><a href="{{ route('mv.index') }}">Misión, Visión y Valores</a></li>
                                    <li><a href="{{ route('organigrama.index') }}">Organigrama Institucional</a></li>
                                    <li><a href="{{ route('jerarquica.index') }}">Plana Jerárquica</a></li>
                                    <li>
                                        <a class="has-arrow" href="javascript:void(0);"><span class="nav-text">Plana
                                                Docente</span></a>
                                        <ul>
                                            <li><a href="{{ route('gestion.index') }}">Gestionar docentes</a></li>
                                            <li><a href="{{ route('personales.index') }}">Gestionar datos
                                                    personales</a></li>
                                            <li><a href="{{ route('academico.index') }}">Gestionar datos académicos</a>
                                            </li>
                                            <li><a href="{{ route('laboral.index') }}">Gestionar datos laborales</a>
                                            </li>
                                            <li><a href="{{ route('unidades.index') }}">Gestionar unidades
                                                    didácticas</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{ route('local.index') }}">Locales</a></li>
                                </ul>
                            </li>
                        @elseif ($data->nombre_modulo === 'Programas de Estudio' && $data->estado_permiso === 'Activo')
                            <!-- Programas de Estudio -->
                            <li class="p-1">
                                <a class="has-arrow" href="javascript:void(0);">
                                    <i data-lucide="graduation-cap"></i>
                                    <span class="nav-text">Programas de Estudio</span>
                                </a>
                                <ul>
                                    <li><a href="{{ route('programas.index') }}">Gestionar Programas</a></li>
                                    <li><a href="{{ route('informacion.index') }}">Gestionar Información</a></li>
                                    <li><a href="{{ route('programas.seccion.index') }}">Gestionar Secciones</a></li>
                                </ul>
                            </li>
                        @elseif ($data->nombre_modulo === 'Admisión y Matrícula' && $data->estado_permiso === 'Activo')
                            <!-- Admisión y Matrícula -->
                            <li class="p-1">
                                <a class="has-arrow" href="javascript:void(0);">
                                    <i data-lucide="clipboard-list"></i>
                                    <span class="nav-text">Admisión y Matrícula</span>
                                </a>
                                <ul>
                                    <li>
                                        <a class="has-arrow" href="javascript:void(0);"><span
                                                class="nav-text">Admisión</span></a>
                                        <ul>
                                            <li><a href="{{ route('admin-titulo.index') }}">Titulo</a></li>
                                            <li><a href="{{ route('admin-resultados.index') }}">Resultados</a></li>
                                            <li><a href="{{ route('admin-modalidades.index') }}">Modalidades</a></li>
                                            <li><a href="{{ route('admin-requisitos.index') }}">Requisitos</a></li>
                                            <li><a href="{{ route('admin-cronograma.index') }}">Cronograma</a></li>
                                            <li><a href="{{ route('admin-exonerados.index') }}">Exonerados</a></li>
                                            <li><a href="{{ route('admin-vacantes.index') }}">Vacantes</a></li>
                                            <li><a href="{{ route('admin-pasos.index') }}">Pasos</a></li>
                                            <li><a href="{{ route('admin-proceso.index') }}">Procesos</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a class="has-arrow" href="javascript:void(0);"><span
                                                class="nav-text">Matrícula</span></a>
                                        <ul>
                                            <li><a href="{{ route('matri-tipos.index') }}">Tipos de Matricula</a></li>
                                            <li><a href="{{ route('matri-requisitos.index') }}">Requisitos</a></li>
                                            <li><a href="{{ route('matri-detalle-requisitos.index') }}">Detalle
                                                    Requisitos</a>
                                            </li>
                                            <li><a href="{{ route('matri-pasos.index') }}">Procesos</a></li>
                                            <li><a href="{{ route('matri-cronograma.index') }}">Cronograma</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a class="has-arrow" href="javascript:void(0);"><span
                                                class="nav-text">Becas</span></a>
                                        <ul>
                                            <li><a href="{{ route('beca-tipo.index') }}">Becas</a></li>
                                            <li><a href="{{ route('beca-beneficiario.index') }}">Beneficiarios</a>
                                            </li>
                                            <li><a href="{{ route('beca-pasos.index') }}">Proceso</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        @elseif ($data->nombre_modulo === 'Transparencia' && $data->estado_permiso === 'Activo')
                            <!-- Transparencia -->
                            <li class="p-1">
                                <a class="has-arrow" href="javascript:void(0);">
                                    <i data-lucide="file-text"></i>
                                    <span class="nav-text">Transparencia</span>
                                </a>
                                <ul>
                                    <li><a href="{{ route('documentos.index') }}">Documentos de Gestión</a></li>
                                    <li><a href="{{ route('tupa.index') }}">TUPA</a></li>
                                    <li><a href="{{ route('inversiones.index') }}">Inversiones y Recursos</a></li>
                                    <li>
                                        <a class="has-arrow" href="javascript:void(0);"><span class="nav-text">Libro
                                                de
                                                reclamaciones</span></a>
                                        <ul>
                                            <li><a href="{{ route('informacion-libro.index') }}">Información
                                                    Importante</a>
                                            </li>
                                            <li><a href="{{ route('tipo-reclamacion.index') }}">Tipos de
                                                    Reclamaciones</a>
                                            </li>
                                            <li><a href="{{ route('marco-legal.index') }}">Marco Legal</a></li>
                                            <li><a href="{{ route('reclamos.index') }}">Reclamos</a></li>
                                            <li><a href="{{ route('derechos.index') }}">Derechos</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{ route('licenciamiento.index') }}">Licenciamiento</a></li>
                                    <li><a href="{{ route('estadistica.index') }}">Estadísticas</a></li>
                                </ul>
                            </li>
                        @elseif ($data->nombre_modulo === 'Servicios complementarios' && $data->estado_permiso === 'Activo')
                            <!-- Servicios complementarios -->
                            <li class="p-1">
                                <a class="has-arrow" href="javascript:void(0);">
                                    <i data-lucide="briefcase"></i>
                                    <span class="nav-text">Servicios complementarios</span>
                                </a>
                                <ul>
                                    <li><a href="{{ route('servicios.index') }}">Gestionar Servicios</a></li>
                                    <li><a href="{{ route('horario.index') }}">Horarios de Atencion</a></li>
                                </ul>
                            </li>
                        @elseif ($data->nombre_modulo === 'Noticias' && $data->estado_permiso === 'Activo')
                            <!-- Noticias -->
                            <li class="p-1">
                                <a href="{{ route('admin-noticias.index') }}">
                                    <i data-lucide="newspaper"></i>
                                    <span class="nav-text">Noticias</span>
                                </a>
                            </li>
                            <!-- Links institucionales -->
                            <li class="p-1">
                                <a href="{{ route('links.index') }}">
                                    <i data-lucide="link"></i>
                                    <span class="nav-text">Links institucionales</span>
                                </a>
                            </li>
                        @endif
                    @endforeach

                    <!-- Contáctanos -->
                    <li class="p-1">
                        <a class="has-arrow" href="javascript:void(0);">
                            <i data-lucide="phone"></i>
                            <span class="nav-text">Contáctanos</span>
                        </a>
                        <ul>
                            <li><a href="{{ route('contactanos.index') }}">Info Contáctanos</a></li>
                            <li><a href="{{ route('redes.index') }}">Redes Sociales</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- (Opcional) Contenido de tu app -->
        <main class="content">
            <!-- tu contenido -->
        </main>
    </div>

    <script>
        (function() {
            const nav = document.querySelector('.dlabnav .metismenu');
            if (!nav) return;

            // Inyectar flechas <span class="chev">
            nav.querySelectorAll('a.has-arrow').forEach(a => {
                if (!a.querySelector('.chev')) {
                    const chev = document.createElement('span');
                    chev.className = 'chev';
                    a.appendChild(chev);
                }
            });

            function toggleItem(li, open) {
                const submenu = li.querySelector(':scope > ul');
                if (!submenu) return;

                if (open) {
                    submenu.style.display = 'block';
                    submenu.style.height = submenu.scrollHeight + 'px';
                    submenu.style.opacity = '1';
                    li.classList.add('mm-active');
                    const onEnd = (e) => {
                        if (e.propertyName !== 'height') return;
                        submenu.style.height = 'auto';
                        submenu.removeEventListener('transitionend', onEnd);
                    };
                    submenu.addEventListener('transitionend', onEnd);
                } else {
                    const h = submenu.scrollHeight;
                    submenu.style.height = h + 'px';
                    submenu.getBoundingClientRect();
                    submenu.style.height = '0px';
                    submenu.style.opacity = '0';
                    li.classList.remove('mm-active');
                    const onEnd = (e) => {
                        if (e.propertyName !== 'height') return;
                        submenu.style.display = '';
                        submenu.removeEventListener('transitionend', onEnd);
                    };
                    submenu.addEventListener('transitionend', onEnd);
                }
            }

            function closeSiblings(currentLi) {
                const parentUl = currentLi.parentElement;
                parentUl.querySelectorAll(':scope > li.mm-active').forEach(li => {
                    if (li !== currentLi) toggleItem(li, false);
                });
            }

            nav.addEventListener('click', function(e) {
                const a = e.target.closest('a.has-arrow');
                if (!a || !nav.contains(a)) return;
                e.preventDefault();
                const li = a.parentElement;
                const isOpen = li.classList.contains('mm-active');
                closeSiblings(li);
                toggleItem(li, !isOpen);
            });

            // Estado inicial (si hay items abiertos por server-side)
            nav.querySelectorAll('li.mm-active > ul').forEach(ul => {
                ul.style.height = 'auto';
                ul.style.opacity = '1';
                ul.style.display = 'block';
            });

            window.addEventListener('resize', () => {
                nav.querySelectorAll('li.mm-active > ul').forEach(ul => {
                    ul.style.height = 'auto';
                });
            });
        })();

        window.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                // Crea los SVG desde tus <i data-lucide="..."></i>
                lucide.createIcons();
            } else {
                console.error('Lucide no se cargó desde la CDN');
            }
        });
    </script>
</body>

</html>
