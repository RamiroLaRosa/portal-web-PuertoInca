<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Derechos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/documentos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/transparencia/libro/derecho.css') }}">
</head>

<body data-titulo="Registro de Derechos del Usuario" class="has-sidebar">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="card roles-card shadow-sm">
                <div class="card-body">

                    <div class="roles-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Derechos</h5>
                        <div class="d-flex flex-wrap align-items-center gap-2">

                            <div class="btn-toolbar gap-2 me-2">
                                <!-- Botón de exportación a Excel -->
                                <button class="btn btn-dark btn-pill btn-icon" title="Exportar a Excel"
                                    data-export-excel>
                                    <i class="fa-regular fa-file-excel me-2"></i> Excel
                                </button>
                                <!-- Botón de exportación a PDF -->
                                <button class="btn btn-dark btn-pill btn-icon" title="Exportar a PDF" data-export-pdf>
                                    <i class="fa-regular fa-file-pdf me-2"></i> PDF
                                </button>
                            </div>

                            <!-- Buscador -->
                            <div class="search-wrap position-relative me-2">
                                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                                <input id="searchInput" type="text" class="form-control form-control-sm search-input"
                                    placeholder="Buscar...">
                            </div>
                            <!-- Botón de nuevo registro -->
                            <button id="btnNuevo" class="btn btn-primary btn-pill btn-icon" data-bs-toggle="modal"
                                data-bs-target="#modalNuevo">
                                <i class="fa-solid fa-plus"></i> Nuevo registro
                            </button>
                        </div>
                    </div>

                    <div id="alertContainer" class="mb-3" style="display:none;"></div>

                    <div class="table-responsive">
                        <table class="table table-bordered content-table" id="tupaTable">
                            <thead>
                                <tr>
                                    <th class="col-id">#</th>
                                    <th class="col-title">Título</th>
                                    <th class="col-desc">Descripción</th>
                                    <th class="col-icono">Ícono</th>
                                    <th class="col-actions">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tupaBody">
                                <!-- Filas se renderizan por JS -->
                            </tbody>
                        </table>
                    </div>
                    <div id="paginationContainer" class="mt-3 d-flex justify-content-end"></div>
                </div>
            </div>
        </div>

        <!-- Modal: Nuevo -->
        <div class="modal fade" id="modalNuevo" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="formNuevo">
                        <div class="modal-header">
                            <h5 class="modal-title" style="color:#2563eb;">Nuevo registro</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Título *</label>
                                <input type="text" id="createTitulo" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Descripción *</label>
                                <input type="text" id="createDescripcion" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Ícono</label>
                                <select id="createIcono" class="form-select" required></select>
                                <small class="text-muted d-block mt-1">Vista previa: <i id="createIconPreview" class=""></i></small>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="createActive" checked>
                                <label class="form-check-label" for="createActive">Activo</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal: Editar -->
        <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="formEditar">
                        <div class="modal-header">
                            <h5 class="modal-title" style="color:#2563eb;">Editar registro</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="editId">
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Título *</label>
                                <input type="text" id="editTitulo" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Descripción *</label>
                                <input type="text" id="editDescripcion" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Ícono</label>
                                <select id="editIcono" class="form-select" required></select>
                                <small class="text-muted d-block mt-1">Vista previa: <i id="editIconPreview" class=""></i></small>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="editActive">
                                <label class="form-check-label" for="editActive">Activo</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal: Eliminar -->
        <div class="modal fade" id="modalEliminar" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="formEliminar" action="#" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title" style="color:#2563eb;">Eliminar</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body" style="color:#2563eb;">
                            ¿Seguro que deseas eliminar <strong id="delTitulo">este registro</strong>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger">Sí, eliminar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>

    @include('include.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/js/admin/transparencia/libro/derecho/derecho.js')

    <!-- js de paginación -->
    @vite('resources/js/pagination.js')

    <!-- js de título -->
    @vite('resources/js/titulo.js')

    <!-- js de búsqueda -->
    @vite('resources/js/search.js')

    <!-- js de exportación a PDF -->
    @vite('resources/js/exportarPDF.js')

    <!-- js de exportación a Excel -->
    @vite('resources/js/exportarEXCEL.js')

    <!-- js modo oscuro -->
    @vite('resources/js/darkmode.js')

    <!-- css modo oscuro -->
    @vite('resources/css/darkmode.css')

    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        window.DERECHOS_ROUTES = {
            grid: "{{ route('derechos.grid') }}",
            store: "{{ route('derechos.store') }}",
            update: "{{ route('derechos.update', ':id') }}",
            destroy: "{{ route('derechos.destroy', ':id') }}"
        };
    </script>
</body>
</html>