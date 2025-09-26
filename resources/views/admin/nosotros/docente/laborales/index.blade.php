<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestión de Datos Laborales</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/docente.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* Oculta SOLO las filas marcadas por la paginación local dentro del área visible.
       Así, al clonar la tabla para PDF/Excel (fuera de .app-content), NO se ocultan. */
        .app-content .content-table tbody tr[data-pg="0"] {
            display: none !important;
        }
    </style>
</head>

<body class="has-sidebar" data-titulo="Gestión de Datos Laborales" data-docentes-url="{{ route('laborales.docentes') }}"
    data-list-url="{{ route('laborales.list') }}" data-store-url="{{ route('laborales.store') }}"
    data-show-url-tpl="{{ route('laborales.show', '__ID__') }}"
    data-update-url-tpl="{{ route('laborales.update', '__ID__') }}"
    data-destroy-url-tpl="{{ route('laborales.destroy', '__ID__') }}">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="card content-card shadow-sm">
                <div class="card-body">

                    <div class="content-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Gestión de Datos Laborales</h5>

                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <select id="programSelect" class="form-select" style="min-width:300px;">
                                <option value="" selected>Seleccione un programa de estudio</option>
                                @foreach ($programas as $p)
                                    <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                @endforeach
                            </select>

                            <select id="docenteSelect" class="form-select" style="min-width:300px;">
                                <option value="" selected>Seleccione un docente</option>
                            </select>

                            <div class="btn-toolbar gap-2 me-2">
                                <!-- Excel -->
                                <button type="button" class="btn btn-dark btn-pill btn-icon" title="Exportar a Excel"
                                    data-export-excel>
                                    <i class="fa-regular fa-file-excel me-2"></i> Excel
                                </button>

                                <!-- PDF -->
                                <button type="button" class="btn btn-dark btn-pill btn-icon" title="Exportar a PDF"
                                    data-export-pdf>
                                    <i class="fa-regular fa-file-pdf me-2"></i> PDF
                                </button>
                            </div>

                            <div class="search-wrap position-relative me-2">
                                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                                <input type="text" class="form-control form-control-sm search-input"
                                    placeholder="Buscar...">
                            </div>

                            <button id="btnNuevo" class="btn btn-teal btn-pill" type="button">+ Nuevo
                                Registro</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered content-table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Institución</th>
                                    <th>Cargo</th>
                                    <th>Experiencia</th>
                                    <th>Inicio labor</th>
                                    <th>Término labor</th>
                                    <th>Tiempo cargo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyLaborales">
                                <tr class="empty-row">
                                    <td colspan="8">Seleccione un programa y luego un docente para listar los datos
                                        laborales.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </main>

    {{-- ====== Modal: Nuevo ====== --}}
    <div class="modal fade" id="modalNuevo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form id="formNuevo" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" style="color:#2563eb;">Nuevo dato laboral</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Programa de estudio</label>
                            <select id="newProgramaId" class="form-select">
                                <option value="">Seleccione…</option>
                                @foreach ($programas as $p)
                                    <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Docente</label>
                            <select id="newDocenteId" name="docente_id" class="form-select" required>
                                <option value="">Seleccione…</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Institución</label>
                            <input type="text" name="institucion" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Cargo</label>
                            <input type="text" name="cargo" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Experiencia (texto)</label>
                            <input type="text" name="experiencia" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" style="color:#2563eb;">Inicio labor</label>
                            <input type="date" name="inicio_labor" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" style="color:#2563eb;">Término labor</label>
                            <input type="date" name="termino_labor" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button id="btnGuardarNuevo" type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ====== Modal: Editar ====== --}}
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form id="formEditar" class="modal-content">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" id="editId">
                <div class="modal-header">
                    <h5 class="modal-title" style="color:#2563eb;">Editar dato laboral</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Programa de estudio</label>
                            <select id="editProgramaId" class="form-select">
                                <option value="">Seleccione…</option>
                                @foreach ($programas as $p)
                                    <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Docente</label>
                            <select id="editDocenteId" name="docente_id" class="form-select" required>
                                <option value="">Seleccione…</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Institución</label>
                            <input type="text" id="editInstitucion" name="institucion" class="form-control"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Cargo</label>
                            <input type="text" id="editCargo" name="cargo" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Experiencia</label>
                            <input type="text" id="editExperiencia" name="experiencia" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" style="color:#2563eb;">Inicio labor</label>
                            <input type="date" id="editInicio" name="inicio_labor" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" style="color:#2563eb;">Término labor</label>
                            <input type="date" id="editTermino" name="termino_labor" class="form-control"
                                required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button id="btnGuardarEditar" type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ====== Modal: Eliminar ====== --}}
    <div class="modal fade" id="modalEliminar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="color:#2563eb;">Eliminar registro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="color:#2563eb;">
                    ¿Seguro que deseas eliminar este dato laboral?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button id="btnConfirmEliminar" type="button" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    @include('include.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/js/admin/nosotros/docente/laborales/docente_laborales.js')
    @vite('resources/css/content.css')

    @vite('resources/js/titulo.js')

    <!-- OJO: no cargamos pagination.js global en esta vista -->
    @vite('resources/js/search.js')
    @vite('resources/js/exportarPDF.js')
    @vite('resources/js/exportarEXCEL.js')
    @vite('resources/css/darkmode.css')
    @vite('resources/js/darkmode.js')

    <!-- Paginación local + bloqueo de Enter en búsqueda -->
    @vite('resources/js/pagination-render.js')
</body>

</html>
