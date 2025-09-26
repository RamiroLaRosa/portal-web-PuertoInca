@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tipos de Becas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/hero.css') }}">

    <style>
        /* Cabecera fija al hacer scroll dentro del contenedor */
        .sticky-head th { position: sticky; top: 0; z-index: 2; }

        /* Layout de tabla */
        .beca-tipo-table { table-layout: fixed; }
        .beca-tipo-table th, .beca-tipo-table td { vertical-align: middle; }

        /* Truncado para celdas largas */
        .truncate-text {
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        @media (min-width: 992px) {
            .truncate-desc { max-width: 520px; }
            .truncate-req  { max-width: 320px; }
        }
        @media (max-width: 991.98px) {
            .truncate-desc { max-width: 280px; }
            .truncate-req  { max-width: 220px; }
        }

        /* Botones de acción consistentes */
        .actions .btn {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }
    </style>
</head>

<body data-titulo="Registro de información sobre Tipos de Beca" class="has-sidebar">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="card roles-card shadow-sm">
                <div class="card-body">

                    <div class="roles-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Registro de información sobre Tipos de Beca</h5>
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
                            <button class="btn btn-primary btn-pill btn-icon" data-bs-toggle="modal"
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
                                    <th class="text-center">#</th>
                                    <th>Título</th>
                                    <th>Descripción</th>
                                    <th>Requisito</th>
                                    <th>Icono</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $row)
                                    <tr>
                                        <td class="text-center">{{ $row->id }}</td>
                                        <td class="text-muted fw-semibold">{{ $row->titulo }}</td>
                                        <td>
                                            <div class="truncate-text truncate-desc" title="{{ $row->descripcion }}">
                                                {{ $row->descripcion }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="truncate-text truncate-req" title="{{ $row->requisito }}">
                                                {{ $row->requisito }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <i class="{{ $row->icono }}"></i>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-inline-flex gap-1 actions">
                                                <button class="btn btn-warning btn-sm text-white btn-edit"
                                                    data-id="{{ $row->id }}"
                                                    data-titulo="{{ e($row->titulo) }}"
                                                    data-descripcion="{{ e($row->descripcion) }}"
                                                    data-requisito="{{ e($row->requisito) }}"
                                                    data-icono="{{ $row->icono }}"
                                                    data-active="{{ (int) $row->is_active }}"
                                                    title="Editar">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>

                                                {{-- Eliminar con modal (sin confirm nativo) --}}
                                                <button class="btn btn-danger btn-sm btn-delete"
                                                    title="Eliminar"
                                                    data-url="{{ route('beca-tipo.destroy', ['tipo' => $row->id]) }}"
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
                                        <td colspan="6" class="text-center text-muted">Sin registros.</td>
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
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('beca-tipo.store') }}" method="POST">
                        @csrf <input type="hidden" name="_from" value="create">
                        <div class="modal-header">
                            <h5 class="modal-title" style="color:#2563eb;">Nueva beca</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" style="color:#2563eb;">Título *</label>
                                    <input type="text" name="titulo"
                                        class="form-control @error('titulo') is-invalid @enderror"
                                        value="{{ old('titulo') }}" required>
                                    @error('titulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="color:#2563eb;">Requisito *</label>
                                    <input type="text" name="requisito"
                                        class="form-control @error('requisito') is-invalid @enderror"
                                        value="{{ old('requisito') }}" required>
                                    @error('requisito')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label" style="color:#2563eb;">Descripción *</label>
                                    <textarea name="descripcion" rows="3" class="form-control @error('descripcion') is-invalid @enderror" required>{{ old('descripcion') }}</textarea>
                                    @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="color:#2563eb;">Icono *</label>
                                    <select name="icono" class="form-select @error('icono') is-invalid @enderror" required>
                                        <option value="" hidden>Seleccione…</option>
                                        @foreach ($iconOptions as $label => $value)
                                            <option value="{{ $value }}" @selected(old('icono') === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('icono')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="createActive" name="is_active" value="1" checked>
                                        <label class="form-check-label" for="createActive">Activo</label>
                                    </div>
                                </div>
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
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form id="formEditar" action="#" method="POST">
                        @csrf @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" style="color:#2563eb;">Editar beca</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" style="color:#2563eb;">Título *</label>
                                    <input type="text" id="editTitulo" name="titulo" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="color:#2563eb;">Requisito *</label>
                                    <input type="text" id="editRequisito" name="requisito" class="form-control" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label" style="color:#2563eb;">Descripción *</label>
                                    <textarea id="editDescripcion" name="descripcion" rows="3" class="form-control" required></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="color:#2563eb;">Icono *</label>
                                    <select id="editIcono" name="icono" class="form-select" required>
                                        @foreach ($iconOptions as $label => $value)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="editActive" name="is_active" value="1">
                                        <label class="form-check-label" for="editActive">Activo</label>
                                    </div>
                                </div>
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
    @vite('resources/js/admin/admision_matricula/beca/tipo/beca-tipo.js')

    <!-- css de dark mode -->
    @vite('resources/css/darkmode.css')

    <!-- js de dark mode -->
    @vite('resources/js/darkmode.js')
</body>
</html>
