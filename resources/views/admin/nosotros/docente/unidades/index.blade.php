@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestión de Unidades Didácticas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/docente.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* Cabecera fija y tabla estable */
        .sticky-head th {
            position: sticky;
            top: 0;
            z-index: 2;
        }

        .table {
            table-layout: fixed;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        /* Truncado elegante */
        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: inline-block;
            max-width: 100%;
        }

        /* Anchuras sugeridas */
        th.col-num {
            width: 70px;
        }

        th.col-actions {
            width: 130px;
        }

        /* Oculta SOLO filas paginadas dentro del área visible (no afecta PDF/Excel) */
        .app-content .content-table tbody tr[data-pg="0"] {
            display: none !important;
        }
    </style>
</head>

<body class="has-sidebar" data-titulo="Gestión de Unidades Didácticas">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <!-- Config para JS externo -->
    <div id="unidadesApp" data-url-docentes="{{ url('/admin/nosotros/unidades-didacticas/docentes') }}"
        data-url-listado="{{ url('/admin/nosotros/unidades-didacticas/listado') }}"
        data-url-modulos="{{ url('/admin/nosotros/unidades-didacticas/modulos') }}"
        data-url-semestres="{{ url('/admin/nosotros/unidades-didacticas/semestres') }}"
        data-url-cursos="{{ url('/admin/nosotros/unidades-didacticas/cursos') }}"
        data-url-store="{{ route('unidades.store') }}"
        data-url-destroy="{{ url('/admin/nosotros/unidades-didacticas') }}/">
    </div>

    <main class="app-content">
        <div class="container-fluid px-2 px-md-3">
            <div class="card card-ui">
                <div class="card-body">

                    <div class="content-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="fw-bold mb-0">Gestión de Unidades Didácticas</h5>
                        <button id="btnNuevo" class="btn btn-primary btn-pill" type="button" disabled>
                            <i class="fa-solid fa-plus me-2"></i> Nuevo registro
                        </button>
                    </div>

                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <select id="selPrograma" class="form-select">
                            <option value="">Seleccione un programa de estudio</option>
                            @foreach ($programas as $p)
                                <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                            @endforeach
                        </select>

                        <select id="selDocente" class="form-select" disabled>
                            <option value="">Seleccione un docente</option>
                        </select>

                        <div class="btn-toolbar gap-2 me-2">
                            <!-- Excel -->
                            <button class="btn btn-dark btn-pill btn-icon" type="button" title="Exportar a Excel"
                                data-export-excel>
                                <i class="fa-regular fa-file-excel me-2"></i> Excel
                            </button>
                            <!-- PDF -->
                            <button class="btn btn-dark btn-pill btn-icon" type="button" title="Exportar a PDF"
                                data-export-pdf>
                                <i class="fa-regular fa-file-pdf me-2"></i> PDF
                            </button>
                        </div>

                        <div class="search-wrap position-relative me-2">
                            <i class="fa-solid fa-magnifying-glass search-icon"></i>
                            <input type="text" class="form-control form-control-sm search-input"
                                placeholder="Buscar...">
                        </div>
                    </div>

                    {{-- Tabla --}}
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered content-table align-middle">
                            <thead>
                                <tr>
                                    <th class="col-num">#</th>
                                    <th>Curso</th>
                                    <th class="text-center col-actions">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyUd">
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">Seleccione programa y
                                        docente.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div> <!-- /card-body -->
            </div> <!-- /card -->
        </div> <!-- /container -->
    </main>

    {{-- MODAL NUEVO --}}
    <div class="modal fade" id="modalNuevo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-bold" style="color:#2563eb;">Nuevo registro</h6>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Programa de estudio</label>
                            <select id="newPrograma" class="form-select" disabled></select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Docente</label>
                            <select id="newDocente" class="form-select" disabled></select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" style="color:#2563eb;">Módulo</label>
                            <select id="selModulo" class="form-select">
                                <option value="">Seleccione</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" style="color:#2563eb;">Semestre</label>
                            <select id="selSemestre" class="form-select" disabled>
                                <option value="">Seleccione</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" style="color:#2563eb;">Curso</label>
                            <select id="selCurso" class="form-select" disabled>
                                <option value="">Seleccione</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button id="btnGuardarNuevo" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL CONFIRMACIÓN --}}
    <div class="modal fade" id="modalConfirm" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-bold" style="color:#2563eb;">Confirmar acción</h6>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="confirmMessage" style="color:#2563eb;">¿Deseas continuar?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnConfirmOk" class="btn btn-danger">Sí, eliminar</button>
                </div>
            </div>
        </div>
    </div>

    @include('include.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/js/admin/nosotros/docente/unidades/unidades.js')
    @vite('resources/css/content.css')

    @vite('resources/js/titulo.js')

    <!-- No cargamos pagination.js global aquí -->
    @vite('resources/js/search.js')
    @vite('resources/js/exportarPDF.js')
    @vite('resources/js/exportarEXCEL.js')
    @vite('resources/css/darkmode.css')
    @vite('resources/js/darkmode.js')

    <!-- Paginación local + bloqueo Enter en búsqueda -->
    @vite('resources/js/pagination-render.js')
</body>

</html>
