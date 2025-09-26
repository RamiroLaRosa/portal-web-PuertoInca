<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Roles</title>

    <!-- CDNs (opcional, solo para estilos base y dropdown)    <!-- JS de Bootstrap (solo para el dropdown de "Seleccionar celdas") -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/admin/seguridad/roles/roles.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/roles.css') }}">
</head>

<body data-titulo="Listado de roles" class="has-sidebar">
    @include('include.preloader')
    @include('include.header')

    <aside class="sidebar-fixed">
        @include('include.sidebar')
    </aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">

            <div class="card roles-card shadow-sm">

                <div class="card-body">

                    <!-- Barra de herramientas + buscador -->
                    <div class="roles-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Gestión de los roles del sistema</h5>

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

                            <!-- Botón de búsqueda -->
                            <div class="search-wrap position-relative me-2">
                                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                                <input type="text" class="form-control form-control-sm search-input"
                                    placeholder="Buscar...">
                            </div>

                            <button class="btn btn-primary btn-new-role btn-pill btn-icon" type="button"
                                title="Nuevo rol" data-bs-toggle="modal" data-bs-target="#modalNuevoRol">
                                <i class="fa-solid fa-plus me-2"></i> Nuevo rol
                            </button>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <div class="fw-bold mb-1">No se pudo guardar:</div>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Tabla -->
                    <div class="table-responsive">
                        <table class="table table-bordered content-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($roles as $rol)
                                    <tr>
                                        <td>{{ $rol->id }}</td>
                                        <td class="text-muted fw-semibold">{{ $rol->nombre }}</td>
                                        <td class="text-muted">{{ $rol->descripcion }}</td>
                                        <td class="text-center">
                                            <div class="d-inline-flex gap-1">
                                                <a href="#"
                                                    class="btn btn-warning btn-sm text-white btn-edit-role"
                                                    title="Editar" data-id="{{ $rol->id }}"
                                                    data-nombre="{{ $rol->nombre }}"
                                                    data-descripcion="{{ $rol->descripcion }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm btn-delete-role"
                                                    title="Eliminar" data-id="{{ $rol->id }}"
                                                    data-name="{{ $rol->nombre }}">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No hay roles registrados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal: Nuevo Rol -->
        <div class="modal fade" id="modalNuevoRol" tabindex="-1" aria-labelledby="modalNuevoRolLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalNuevoRolLabel" style="color:#2563eb;">Nuevo rol</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="rolNombre" class="form-label" style="color:#2563eb;">Nombre <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="rolNombre" name="nombre" value="{{ old('nombre') }}"
                                    class="form-control @error('nombre') is-invalid @enderror"
                                    placeholder="Ej. Coordinador">
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="rolDescripcion" class="form-label"
                                    style="color:#2563eb;">Descripción</label>
                                <textarea id="rolDescripcion" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror"
                                    rows="3" placeholder="Breve descripción">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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

        <!-- Modal: Editar Rol -->
        <div class="modal fade" id="modalEditarRol" tabindex="-1" aria-labelledby="modalEditarRolLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="formEditarRol" action="#" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditarRolLabel" style="color:#2563eb;">Editar rol</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editRolNombre" class="form-label" style="color:#2563eb;">Nombre <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="editRolNombre" name="nombre" class="form-control"
                                    placeholder="Ej. Coordinador">
                            </div>

                            <div class="mb-3">
                                <label for="editRolDescripcion" class="form-label"
                                    style="color:#2563eb;">Descripción</label>
                                <textarea id="editRolDescripcion" name="descripcion" class="form-control" rows="3"
                                    placeholder="Breve descripción"></textarea>
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

        <!-- Modal: Confirmar Eliminación -->
        <div class="modal fade" id="modalEliminarRol" tabindex="-1" aria-labelledby="modalEliminarRolLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="deleteRoleForm" action="#" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEliminarRolLabel" style="color:#2563eb;">Eliminar rol
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>

                        <div class="modal-body">
                            <p class="mb-0" style="color:#2563eb;">
                                ¿Seguro que deseas eliminar el rol <strong id="deleteRoleName">—</strong>?
                            </p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger">Sí, eliminar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <br>
    @include('include.footer')

    {{-- Reabrir modal de "Nuevo rol" si hubo errores al crear --}}
    @if ($errors->any() && old('_from') === 'create')
        <!-- Eliminado script embebido, ahora gestionado en roles.js -->
    @endif

    {{-- Script SIEMPRE activo para abrir modal de edición --}}
    <!-- Eliminado <script src="/js/web/main.js"></script> si la lógica fue extraída -->

    <!-- JS de Bootstrap (solo para el dropdown de “Seleccionar celdas”) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <!-- js de título -->
    @vite('resources/js/titulo.js')

    <!-- js general -->
    @vite('resources/js/admin/seguridad/roles/roles.js')

    <!-- js de paginación -->
    @vite('resources/js/pagination.js')

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



</body>


</html>
