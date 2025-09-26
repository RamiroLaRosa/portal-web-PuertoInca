@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Beneficiarios de Beca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/hero.css') }}">

    <style>
        /* Cabecera fija al hacer scroll */
        .sticky-head th { position: sticky; top: 0; z-index: 2; }

        /* Tabla y columnas */
        .benef-table { table-layout: fixed; }
        .benef-table th, .benef-table td { vertical-align: middle; }

        /* Truncados suaves en texto */
        .truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .col-benef { max-width: 420px; }
        .col-tipo  { max-width: 320px; }

        /* Botones de acción uniformes */
        .actions .btn {
            width: 34px; height: 34px;
            display: inline-flex; align-items: center; justify-content: center;
            padding: 0;
        }
    </style>
</head>

<body data-titulo="Registro de información sobre Beneficiario de Beca" class="has-sidebar">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="card roles-card shadow-sm">
                <div class="card-body">
                    <div class="roles-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Registro de información sobre Beneficiario de Beca</h5>
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <!-- Exportar a Excel -->
                            <button class="btn btn-dark btn-pill btn-icon" title="Exportar a Excel" data-export-excel>
                                <i class="fa-regular fa-file-excel me-2"></i> Excel
                            </button>
                            <!-- Exportar a PDF -->
                            <button class="btn btn-dark btn-pill btn-icon" title="Exportar a PDF" data-export-pdf>
                                <i class="fa-regular fa-file-pdf me-2"></i> PDF
                            </button>
                            <!-- Buscador -->
                            <div class="search-wrap position-relative me-2">
                                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                                <input type="text" class="form-control form-control-sm search-input"
                                    placeholder="Buscar...">
                            </div>
                            <!-- Filtro de programa y nuevo registro -->
                            <form method="GET" class="d-flex gap-2">
                                <select name="programa" class="form-select" style="min-width:340px"
                                    onchange="this.form.submit()">
                                    <option value="">Seleccione un programa de estudio</option>
                                    @foreach ($programas as $p)
                                        <option value="{{ $p->id }}" @selected(($programaId ?? '') == $p->id)>{{ $p->nombre }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-primary btn-pill btn-icon" data-bs-toggle="modal"
                                    data-bs-target="#modalNuevo" @disabled(empty($programaId))>
                                    <i class="fa-solid fa-plus me-2"></i> Nuevo registro
                                </button>
                            </form>
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

                    @if (empty($programaId))
                        <div class="text-center text-muted py-5">
                            Selecciona un programa de estudio para ver los beneficiarios.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered content-table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Beneficiario</th>
                                        <th>Tipo de Beca</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($items as $row)
                                        <tr>
                                            <td class="text-center">{{ $row->id }}</td>
                                            <td class="text-muted fw-semibold">
                                                <span class="truncate col-benef" title="{{ $row->nombre }}">{{ $row->nombre }}</span>
                                            </td>
                                            <td class="text-muted">
                                                <span class="truncate col-tipo" title="{{ $row->tipo->titulo ?? '—' }}">
                                                    {{ $row->tipo->titulo ?? '—' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-inline-flex gap-1 actions">
                                                    <button class="btn btn-warning btn-sm text-white btn-edit"
                                                        title="Editar"
                                                        data-id="{{ $row->id }}"
                                                        data-programa="{{ $row->programa_id }}"
                                                        data-tipo="{{ $row->tipo_beca_id }}"
                                                        data-nombre="{{ e($row->nombre) }}"
                                                        data-active="{{ (int) $row->is_active }}">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </button>

                                                    {{-- Eliminar con modal (sin confirm nativo) --}}
                                                    <button class="btn btn-danger btn-sm btn-delete"
                                                        title="Eliminar"
                                                        data-url="{{ route('beca-beneficiario.destroy', $row) }}"
                                                        data-title="{{ e($row->nombre) }}"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalEliminar">
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
                    @endif
                </div>
            </div>
        </div>

        {{-- Modal: Nuevo --}}
        <div class="modal fade" id="modalNuevo" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('beca-beneficiario.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" style="color:#2563eb;">Nuevo beneficiario</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Programa *</label>
                                <select name="programa_id" class="form-select" required>
                                    @foreach ($programas as $p)
                                        <option value="{{ $p->id }}" @selected(($programaId ?? '') == $p->id)>{{ $p->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Tipo de Beca *</label>
                                <select name="tipo_beca_id" class="form-select" required>
                                    <option value="" hidden>Seleccione…</option>
                                    @foreach ($tipos as $t)
                                        <option value="{{ $t->id }}">{{ $t->titulo }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Nombre del beneficiario *</label>
                                <input type="text" name="nombre" class="form-control" maxlength="150" required>
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
                            <h5 class="modal-title" style="color:#2563eb;">Editar beneficiario</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Programa *</label>
                                <select id="editPrograma" name="programa_id" class="form-select" required>
                                    @foreach ($programas as $p)
                                        <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Tipo de Beca *</label>
                                <select id="editTipo" name="tipo_beca_id" class="form-select" required>
                                    @foreach ($tipos as $t)
                                        <option value="{{ $t->id }}">{{ $t->titulo }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Nombre del beneficiario *</label>
                                <input type="text" id="editNombre" name="nombre" class="form-control" maxlength="150" required>
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
                            ¿Seguro que deseas eliminar a <strong id="delTitulo">este beneficiario</strong>?
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
    @vite('resources/js/admin/admision_matricula/beca/beneficiarios/beca-beneficiarios.js')

    <!-- css de dark mode -->
    @vite('resources/css/darkmode.css')

    <!-- js de dark mode -->
    @vite('resources/js/darkmode.js')
</body>
</html>
