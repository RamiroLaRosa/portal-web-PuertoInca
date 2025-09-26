{{-- filepath: /C:/Users/SF-USER-02/Documents/GitHub/WEB-PUNO/Plantilla_IESTP/resources/views/admin/admision_matricula/admision/resultados/index.blade.php --}}
@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Resultados de Admisión</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/documentos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/admision_matricula/admision/resultados.css') }}">
</head>

<body data-titulo="Registro de resultados de admisión" class="has-sidebar">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">

            <div class="card roles-card shadow-sm">
                <div class="card-body">

                    <div class="roles-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Gestionar resultados de admisión</h5>
                        <div class="d-flex flex-wrap align-items-center gap-2">
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
                            <!-- Buscador -->
                            <div class="search-wrap position-relative me-2">
                                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                                <input type="text" class="form-control form-control-sm search-input"
                                    placeholder="Buscar...">
                            </div>
                            <!-- Botón de nuevo registro -->
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
                                    <th>#</th>
                                    <th>Programa</th>
                                    <th>Turno</th>
                                    <th>PDF</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $row)
                                    <tr>
                                        <td>{{ $row->id }}</td>
                                        <td class="text-muted fw-semibold">{{ $row->programa->nombre ?? '—' }}</td>
                                        <td class="text-muted">{{ $row->turno->nombre ?? '—' }}</td>
                                        <td class="text-center">
                                            <span class="pdf-thumb btn-preview-pdf" data-src="{{ $row->documento_url }}"
                                                data-title="Resultado - {{ $row->programa->nombre ?? 'ID ' . $row->programa_id }}">
                                                <i class="fa-solid fa-file-pdf"></i>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-inline-flex gap-1">
                                                {{-- Editar --}}
                                                <button class="btn btn-warning btn-sm text-white btn-edit"
                                                    data-id="{{ $row->id }}"
                                                    data-programa="{{ $row->programa_id }}"
                                                    data-turno="{{ $row->turno_id }}"
                                                    data-doc="{{ $row->documento_url }}"
                                                    data-active="{{ (int) $row->is_active }}" title="Editar">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>

                                                {{-- Eliminar (abre modal) --}}
                                                <button class="btn btn-danger btn-sm btn-delete"
                                                    title="Eliminar"
                                                    data-url="{{ route('admision-resultados.destroy', $row) }}"
                                                    data-title="Resultado - {{ $row->programa->nombre ?? ('ID '.$row->programa_id) }} ({{ $row->turno->nombre ?? ('ID '.$row->turno_id) }})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalEliminar">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>

                                                {{-- Abrir en pestaña nueva --}}
                                                <a class="btn btn-dark btn-sm" href="{{ $row->documento_url }}"
                                                    target="_blank" title="Abrir PDF">
                                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                                </a>
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
                    <form action="{{ route('admision-resultados.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf <input type="hidden" name="_from" value="create">
                        <div class="modal-header">
                            <h5 class="modal-title" style="color:#2563eb;">Nuevo resultado</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Programa *</label>
                                <select name="programa_id" class="form-select" required>
                                    <option value="" hidden>Seleccione…</option>
                                    @foreach ($programas as $p)
                                        <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Turno *</label>
                                <select name="turno_id" class="form-select" required>
                                    <option value="" hidden>Seleccione…</option>
                                    @foreach ($turnos as $t)
                                        <option value="{{ $t->id }}">{{ $t->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Documento (PDF) *</label>
                                <input type="file" name="documento" accept="application/pdf"
                                    class="form-control @error('documento') is-invalid @enderror" required>
                                @error('documento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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

        {{-- Modal: Preview PDF --}}
        <div class="modal fade" id="modalPreviewPdf" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pdfTitle" style="color:#2563eb;">Vista previa</h5>
                        <div class="ms-auto">
                            <a id="pdfNewTab" href="#" class="btn btn-dark btn-sm" target="_blank">
                                <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Abrir en pestaña
                            </a>
                        </div>
                        <button type="button" class="btn-close ms-2" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body d-flex justify-content-center align-items-center p-0 bg-light"
                        style="min-height: 80vh;">
                        <iframe id="pdfFrame" class="border-0 rounded-2 shadow" style="width: 95%; height: 82vh; max-width: 1200px;"></iframe>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal: Editar --}}
        <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="formEditar" action="#" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" style="color:#2563eb;">Editar resultado</h5>
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
                                <label class="form-label" style="color:#2563eb;">Turno *</label>
                                <select id="editTurno" name="turno_id" class="form-select" required>
                                    @foreach ($turnos as $t)
                                        <option value="{{ $t->id }}">{{ $t->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Documento actual</label>
                                <div class="d-flex align-items-center gap-2">
                                    <a id="editDocLink" href="#" target="_blank"
                                        class="btn btn-outline-dark btn-sm">
                                        <i class="fa-solid fa-file-pdf me-1"></i> Ver PDF
                                    </a>
                                    <small class="text-muted">Puedes reemplazarlo subiendo uno nuevo:</small>
                                </div>
                                <input type="file" name="documento" accept="application/pdf"
                                    class="form-control mt-2">
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

        {{-- Modal: Eliminar --}}
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
                            ¿Seguro que deseas eliminar <strong id="delTitulo">este resultado</strong>?
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

    <!-- js general -->
    @vite('resources/js/admin/admision_matricula/admision/resultados/resultados.js')

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
