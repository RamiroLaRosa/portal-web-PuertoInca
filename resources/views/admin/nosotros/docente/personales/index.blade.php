<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestión de Datos Personal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/docente.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="has-sidebar" data-titulo="Gestión de Datos Personal" data-docentes-url="{{ route('datosp.docentes') }}"
    data-list-url="{{ route('datosp.list') }}" data-store-url="{{ route('datosp.store') }}"
    data-show-url-tpl="{{ route('datosp.show', '__ID__') }}"
    data-update-url-tpl="{{ route('datosp.update', '__ID__') }}"
    data-destroy-url-tpl="{{ route('datosp.destroy', '__ID__') }}">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="card content-card shadow-sm">
                <div class="card-body">
                    <div class="content-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Gestión de Datos Personal</h5>

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

                            <!-- Botón de exportación a Excel -->
                            <button class="btn btn-dark btn-pill btn-icon" title="Exportar a Excel" data-export-excel>
                                <i class="fa-regular fa-file-excel me-2"></i> Excel
                            </button>

                            <!-- Botón de exportación a PDF -->
                            <button class="btn btn-dark btn-pill btn-icon" title="Exportar a PDF" data-export-pdf>
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
                                    <th style="width:70px;">#</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Correo</th>
                                    <th>Teléfono</th>
                                    <th style="width:160px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyDatos">
                                <tr class="empty-row">
                                    <td colspan="6">Seleccione programa y docente para listar los datos.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </main>

    {{-- ===== Modal: Nuevo (centrado) ===== --}}
    <div class="modal fade" id="modalNuevo" tabindex="-1" aria-labelledby="modalNuevoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form id="formNuevo" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNuevoLabel" style="color:#2563eb;">Nuevo registro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Programa de estudio</label>
                            <select id="newPrograma" class="form-select" required>
                                <option value="">Seleccione…</option>
                                @foreach ($programas as $p)
                                    <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Docente</label>
                            <select name="docente_id" id="newDocente" class="form-select" required>
                                <option value="">Seleccione…</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Nombres</label>
                            <input type="text" class="form-control" name="nombres" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Apellidos</label>
                            <input type="text" class="form-control" name="apellidos" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Correo</label>
                            <input type="email" class="form-control" name="correo" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Teléfono</label>
                            <input type="text" class="form-control" name="telefono" maxlength="30">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancelar</button>
                    <button id="btnGuardarNuevo" class="btn btn-primary" type="submit">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===== Modal: Editar (centrado) ===== --}}
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form id="formEditar" class="modal-content">
                @csrf
                @method('PUT')
                <input type="hidden" id="editId">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarLabel" style="color:#2563eb;">Editar registro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Programa de estudio</label>
                            <select id="editPrograma" class="form-select" required>
                                <option value="">Seleccione…</option>
                                @foreach ($programas as $p)
                                    <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Docente</label>
                            <select name="docente_id" id="editDocente" class="form-select" required>
                                <option value="">Seleccione…</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Nombres</label>
                            <input type="text" class="form-control" name="nombres" id="editNombres" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Apellidos</label>
                            <input type="text" class="form-control" name="apellidos" id="editApellidos" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Correo</label>
                            <input type="email" class="form-control" name="correo" id="editCorreo" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Teléfono</label>
                            <input type="text" class="form-control" name="telefono" id="editTelefono"
                                maxlength="30">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancelar</button>
                    <button id="btnGuardarEditar" class="btn btn-primary" type="submit">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===== Modal: Eliminar (centrado) ===== --}}
    <div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEliminarLabel" style="color:#2563eb;">Eliminar registro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" style="color:#2563eb;">
                    ¿Seguro que deseas eliminar a <strong id="delNombre">—</strong>?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancelar</button>
                    <button id="btnConfirmEliminar" class="btn btn-danger" type="button">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    @include('include.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/js/admin/nosotros/docente/personales/datos_personal_gestion.js')
    @vite('resources/css/content.css')

    @vite('resources/js/titulo.js')

    @vite('resources/js/pagination.js')

    @vite('resources/js/search.js')

    @vite('resources/js/exportarPDF.js')

    @vite('resources/js/exportarEXCEL.js')

    @vite('resources/css/darkmode.css')

    @vite('resources/js/darkmode.js')
</body>

</html>
