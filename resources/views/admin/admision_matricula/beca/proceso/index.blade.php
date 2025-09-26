@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Procesos de Becas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/hero.css') }}">

    <style>
        /* Cabecera fija al hacer scroll */
        .sticky-head th { position: sticky; top: 0; z-index: 2; }

        /* Tabla y columnas */
        .proc-beca-table { table-layout: fixed; }
        .proc-beca-table th, .proc-beca-table td { vertical-align: middle; }

        /* Truncados suaves de texto */
        .truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .col-titulo { max-width: 420px; }
        .col-desc   { max-width: 560px; }

        /* Botones de acción uniformes */
        .actions .btn {
            width: 34px; height: 34px;
            display: inline-flex; align-items: center; justify-content: center;
            padding: 0;
        }
    </style>
</head>

<body data-titulo="Registro de información sobre Procesos de Beca" class="has-sidebar">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="card roles-card shadow-sm">
                <div class="card-body">

                    <div class="roles-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Registro de información sobre Procesos de Beca</h5>
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <div class="btn-toolbar gap-2 me-2">
                                <!-- Exportar a Excel -->
                                <button class="btn btn-dark btn-pill btn-icon" title="Exportar a Excel" data-export-excel>
                                    <i class="fa-regular fa-file-excel me-2"></i> Excel
                                </button>
                                <!-- Exportar a PDF -->
                                <button class="btn btn-dark btn-pill btn-icon" title="Exportar a PDF" data-export-pdf>
                                    <i class="fa-regular fa-file-pdf me-2"></i> PDF
                                </button>
                            </div>
                            <!-- Buscador -->
                            <div class="search-wrap position-relative me-2">
                                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                                <input type="text" class="form-control form-control-sm search-input"
                                    placeholder="Buscar...">
                            </div>
                            <!-- Nuevo registro -->
                            <button class="btn btn-primary btn-pill btn-icon" type="button" data-bs-toggle="modal"
                                data-bs-target="#modalNuevo">
                                <i class="fa-solid fa-plus me-2"></i> Nuevo registro
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
                        <table class="table table-bordered content-table">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 10%;">Nro de Paso</th>
                                    <th style="width: 15%;">Título</th>
                                    <th style="width: 45%;">Descripción</th>
                                    <th style="width: 25%;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $row)
                                    <tr>
                                        <td class="text-center">{{ $row->id }}</td>
                                        <td class="text-muted fw-semibold">{{ $row->nro_paso }}</td>
                                        <td class="text-muted fw-semibold">{{ $row->titulo }}</td>
                                        <td class="text-muted" style="white-space: pre-line;">{{ $row->descripcion }}</td>
                                        <td class="text-center">
                                            <div class="d-inline-flex gap-1 actions">
                                                <button class="btn btn-warning btn-sm text-white btn-edit"
                                                    title="Editar" data-id="{{ $row->id }}"
                                                    data-nro_paso="{{ $row->nro_paso }}"
                                                    data-titulo="{{ e($row->titulo) }}"
                                                    data-descripcion="{{ e($row->descripcion) }}"
                                                    data-active="{{ (int) $row->is_active }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>

                                                {{-- Eliminar con modal (sin confirm nativo) --}}
                                                <button class="btn btn-danger btn-sm btn-delete"
                                                    title="Eliminar"
                                                    data-url="{{ route('beca-pasos.destroy', ['paso' => $row->id]) }}"
                                                    data-title="{{ e($row->titulo) }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalEliminar">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Sin registros.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        {{-- Modal: Nuevo --}}
        <div class="modal fade" id="modalNuevo" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('beca-pasos.store') }}" method="POST">
                        @csrf <input type="hidden" name="_from" value="create">
                        <div class="modal-header">
                            <h5 class="modal-title" style="color:#2563eb;">Nuevo proceso</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Nro de paso *</label>
                                <input type="number" name="nro_paso" min="1" step="1"
                                    class="form-control @error('nro_paso') is-invalid @enderror"
                                    value="{{ old('nro_paso') }}" required>
                                @error('nro_paso')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Título *</label>
                                <input type="text" name="titulo"
                                    class="form-control @error('titulo') is-invalid @enderror"
                                    value="{{ old('titulo') }}" required>
                                @error('titulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Descripción *</label>
                                <textarea name="descripcion" rows="3" class="form-control @error('descripcion') is-invalid @enderror" required>{{ old('descripcion') }}</textarea>
                                @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="createActive" name="is_active" value="1" checked>
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

        {{-- Modal: Editar --}}
        <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="formEditar" action="#" method="POST">
                        @csrf @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" style="color:#2563eb;">Editar proceso</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Nro de paso *</label>
                                <input type="number" id="editNro" name="nro_paso" min="1" step="1" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Título *</label>
                                <input type="text" id="editTitulo" name="titulo" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Descripción *</label>
                                <textarea id="editDesc" name="descripcion" rows="3" class="form-control" required></textarea>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="editActive" name="is_active" value="1">
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

        {{-- Modal: Eliminar (sin confirm nativo) --}}
        <div class="modal fade" id="modalEliminar" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="formEliminar" action="#" method="POST">
                        @csrf @method('DELETE')
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
    @vite('resources/js/admin/admision_matricula/beca/proceso/beca-proceso.js')

    <!-- css de dark mode -->
    @vite('resources/css/darkmode.css')

    <!-- js de dark mode -->
    @vite('resources/js/darkmode.js')

</body>
</html>
