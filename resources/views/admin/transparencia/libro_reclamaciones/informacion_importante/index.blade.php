<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Información Importante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/documentos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/transparencia/libro/informacion.css') }}">
    @vite('resources/css/darkmode.css')
</head>

<body data-titulo="Registro de información importante Libro de Reclamaciones" class="has-sidebar">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="card roles-card shadow-sm">
                <div class="card-body">

                    <div class="roles-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Información Importante</h5>
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <div class="btn-toolbar gap-2 me-2">
                                <button class="btn btn-dark btn-pill btn-icon" title="Exportar a Excel"
                                    data-export-excel>
                                    <i class="fa-regular fa-file-excel me-2"></i> Excel
                                </button>
                                <button class="btn btn-dark btn-pill btn-icon" title="Exportar a PDF" data-export-pdf>
                                    <i class="fa-regular fa-file-pdf me-2"></i> PDF
                                </button>
                            </div>
                            <div class="search-wrap position-relative me-2">
                                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                                <input id="searchInput" type="text" class="form-control form-control-sm search-input"
                                    placeholder="Buscar...">
                            </div>
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
                                    <th class="col-actions">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tupaBody">
                                <!-- Filas se renderizan por JS.
                                     Para que el modal funcione, agrega un botón:
                                     <button class="btn btn-danger btn-sm btn-delete"
                                             data-id="__ID__"
                                             data-title="__TÍTULO__"
                                             data-bs-toggle="modal"
                                             data-bs-target="#modalEliminar">
                                        <i class="fa-regular fa-trash-can"></i>
                                     </button>
                                -->
                            </tbody>
                        </table>
                        <!-- El paginador se renderiza aquí por JS -->
                    </div>

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
                                <label class="form-label" style="color:#2563eb;">Título</label>
                                <input type="text" name="concepto" id="createConcepto" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Descripcion</label>
                                <input type="number" name="monto" id="createMonto" step="0.01" min="0"
                                    class="form-control" required>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="createActive" name="is_active"
                                    value="1" checked>
                                <label class="form-check-label" for="createActive">Activo</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Cancelar</button>
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
                                <label class="form-label" style="color:#2563eb;">Título</label>
                                <input type="text" id="editConcepto" name="concepto" class="form-control"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Descripcion</label>
                                <input type="number" id="editMonto" name="monto" step="0.01" min="0"
                                    class="form-control" required>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="editActive" name="is_active"
                                    value="1">
                                <label class="form-check-label" for="editActive">Activo</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal: Eliminar (nuevo) -->
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

    <!-- js general y paginación -->
    @vite('resources/js/admin/transparencia/libro/informacion/informacion.js')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- js de título -->
    @vite('resources/js/titulo.js')

    <!-- js de búsqueda -->
    @vite('resources/js/search.js')

    <!-- js de exportación a PDF -->
    @vite('resources/js/exportarPDF.js')

    <!-- js de exportación a Excel -->
    @vite('resources/js/exportarEXCEL.js')

    <!-- css de dark mode -->
    @vite('resources/css/darkmode.css')

    <!-- js de dark mode -->
    @vite('resources/js/darkmode.js')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.INFO_ROUTES = {
            list: "{{ route('informacion.list') }}",
            store: "{{ route('informacion.store') }}",
            update: "{{ route('informacion.update', ':id') }}",
            destroy: "{{ route('informacion.destroy', ':id') }}"
        };
    </script>

    {{-- Script para poblar el modal de eliminar (puedes moverlo a informacion.js) --}}
    <script>
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.btn-delete');
            if (!btn) return;

            const id = btn.getAttribute('data-id');
            const title = btn.getAttribute('data-title') || 'este registro';

            const form = document.getElementById('formEliminar');
            const delTitle = document.getElementById('delTitulo');

            // Construye la URL usando INFO_ROUTES.destroy
            const destroyTemplate = (window.INFO_ROUTES && window.INFO_ROUTES.destroy) || '';
            const url = destroyTemplate.replace(':id', id);

            if (form && url) form.setAttribute('action', url);
            if (delTitle) delTitle.textContent = title;
        });
    </script>
</body>

</html>
