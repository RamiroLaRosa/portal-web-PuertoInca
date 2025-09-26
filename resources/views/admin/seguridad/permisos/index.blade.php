<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Permisos</title>

    <!-- CDNs (opcional, solo para estilos base y dropdown)    <!-- JS de Bootstrap (solo para el dropdown de "Seleccionar celdas") -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    {{-- <script src="{{ asset('js/admin/seguridad/permisos/permisos.js') }}"></script> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/permisos.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body data-titulo="Listado de permisos" class="has-sidebar">
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
                        <h5 class="mb-0 fw-bold">Gestión de los permisos del sistema</h5>

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
                                    <th>Rol</th>
                                    <th>Módulo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($permisos->groupBy('rol.nombre') as $rolNombre => $permisosPorRol)
                                    @foreach ($permisosPorRol as $index => $permiso)
                                        <tr>
                                            <td>{{ $permiso->id }}</td>

                                            {{-- Solo mostrar el rol en la primera fila, con rowspan --}}
                                            @if ($index === 0)
                                                <td class="text-muted fw-semibold"
                                                    rowspan="{{ $permisosPorRol->count() }}">
                                                    {{ $rolNombre }}
                                                </td>
                                            @endif

                                            <td class="text-muted">{{ $permiso->modulo->nombre }}</td>

                                            <td class="text-center">
                                                <form action="{{ route('permisos.update', $permiso->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <input type="hidden" name="newpermiso"
                                                        value="{{ $permiso->is_active ? 0 : 1 }}">

                                                    @if ($permiso->is_active)
                                                        <i class="fa fa-check-circle text-success"
                                                            aria-hidden="true"></i>
                                                        <select name="is_active" class="editBtn default-select"
                                                            onchange="this.form.submit()">
                                                            <option selected value="1">Habilitado</option>
                                                            <option value="0">Inhabilitado</option>
                                                        </select>
                                                    @else
                                                        <i class="fa fa-times-circle text-danger"
                                                            aria-hidden="true"></i>
                                                        <select name="is_active" class="editBtn default-select"
                                                            onchange="this.form.submit()">
                                                            <option value="1">Habilitado</option>
                                                            <option selected value="0">Inhabilitado</option>
                                                        </select>
                                                    @endif

                                                </form>
                                            </td>

                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No hay permisos registrados.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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
    @vite('resources/js/admin/seguridad/permisos/permisos.js')

    <!-- js de paginación -->
    @vite('resources/js/admin/seguridad/permisos/pagination.js')

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
