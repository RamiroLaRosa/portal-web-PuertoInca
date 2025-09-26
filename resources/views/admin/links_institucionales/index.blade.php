{{-- resources/views/admin/links_institucionales/index.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Links Institucionales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/documentos.css') }}">
    <style>
        /* Cabecera fija dentro del .table-responsive */
        .sticky-head th {
            position: sticky;
            top: 0;
            z-index: 2;
        }

        /* Mejoras generales de la tabla */
        .roles-table {
            table-layout: fixed;
            /* Respeta el colgroup */
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .roles-table th,
        .roles-table td {
            vertical-align: middle;
        }

        /* Enlace truncado con puntos suspensivos */
        .truncate-url {
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Botones de acción del mismo tamaño */
        .actions .btn-icon {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        /* Ajustes responsivos: más espacio al enlace en pantallas grandes */
        @media (min-width: 992px) {
            .truncate-url {
                max-width: 680px;
            }
        }

        @media (max-width: 991.98px) {
            .truncate-url {
                max-width: 320px;
            }
        }
    </style>

</head>

<body data-titulo="Registro de Links Institucionales" class="has-sidebar">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="card roles-card shadow-sm">
                <div class="card-body">

                    <div class="roles-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Registro de Links Institucionales</h5>
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <div class="btn-toolbar gap-2 me-2">
                                <button class="btn btn-dark btn-pill btn-icon" title="Exportar a Excel" data-export-excel>
                                    <i class="fa-regular fa-file-excel me-2"></i> Excel
                                </button>
                                <button class="btn btn-dark btn-pill btn-icon" title="Exportar a PDF" data-export-pdf>
                                    <i class="fa-regular fa-file-pdf me-2"></i> PDF
                                </button>
                            </div>
                            <div class="search-wrap position-relative me-2">
                                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                                <input type="text" class="form-control form-control-sm search-input"
                                    placeholder="Buscar...">
                            </div>
                            <button class="btn btn-primary btn-new-role btn-pill btn-icon" type="button"
                                data-bs-toggle="modal" data-bs-target="#modalNuevo">
                                <i class="fa-solid fa-plus me-2"></i> Nuevo Link
                            </button>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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

                    <div class="table-responsive">
                        <table class="table table-bordered content-table align-middle">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Nombre</th>
                                    <th>Enlace</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($items as $row)
                                    <tr>
                                        <td class="text-center">{{ $row->id }}</td>
                                        <td class="fw-semibold text-muted">{{ $row->nombre }}</td>

                                        {{-- Enlace truncado con tooltip --}}
                                        <td>
                                            <div class="truncate-url" title="{{ $row->enlace }}">
                                                <a href="{{ $row->enlace }}" target="_blank" rel="noopener"
                                                    class="text-decoration-underline">
                                                    {{ $row->enlace }}
                                                </a>
                                            </div>
                                        </td>

                                        {{-- Acciones compactas e iguales --}}
                                        <td class="text-center">
                                            <div class="d-inline-flex gap-1 actions">
                                                <button class="btn btn-warning btn-icon btn-sm text-white btn-edit"
                                                    data-id="{{ $row->id }}" data-nombre="{{ $row->nombre }}"
                                                    data-enlace="{{ $row->enlace }}"
                                                    data-active="{{ (int) $row->is_active }}" title="Editar">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>

                                                {{-- Botón que abre el modal de eliminar --}}
                                                <button class="btn btn-danger btn-icon btn-sm btn-delete"
                                                    title="Eliminar" data-bs-toggle="modal"
                                                    data-bs-target="#modalEliminar"
                                                    data-delete-url="{{ route('links.destroy', $row) }}"
                                                    data-title="{{ $row->nombre }}">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Sin registros.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </main>

    {{-- Modal Nuevo --}}
    <div class="modal fade" id="modalNuevo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('links.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#2563eb;">Nuevo link institucional</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" style="color:#2563eb;">Nombre *</label>
                            <input type="text" name="nombre" class="form-control" required maxlength="150">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color:#2563eb;">Enlace (URL) *</label>
                            <input type="url" name="enlace" class="form-control" placeholder="https://..."
                                required>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="nuevoActivo" name="is_active"
                                value="1" checked>
                            <label class="form-check-label" for="nuevoActivo">Activo</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary" type="button"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary" type="submit">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Editar --}}
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formEditar" action="#" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#2563eb;">Editar link institucional</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" style="color:#2563eb;">Nombre *</label>
                            <input type="text" id="eNombre" name="nombre" class="form-control" required
                                maxlength="150">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color:#2563eb;">Enlace (URL) *</label>
                            <input type="url" id="eEnlace" name="enlace" class="form-control"
                                placeholder="https://..." required>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="eActivo" name="is_active"
                                value="1">
                            <label class="form-check-label" for="eActivo">Activo</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary" type="button"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary" type="submit">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal: Eliminar (patrón unificado) --}}
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
                        <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Sí, eliminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('include.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- js de título -->
    @vite('resources/js/titulo.js')

    <!-- js de paginación -->
    @vite('resources/js/pagination.js')

    <!-- js de búsqueda -->
    @vite('resources/js/search.js')

    <!-- js de exportación a PDF -->
    @vite('resources/js/exportarPDF.js')

    <!-- js de exportación a Excel -->
    @vite('resources/js/exportarEXCEL.js')

    <!-- js general -->
    @vite('resources/js/admin/links_institucionales/links.js')

    <!-- css de dark mode -->
    @vite('resources/css/darkmode.css')

    <!-- js de dark mode -->
    @vite('resources/js/darkmode.js')
</body>
</html>
