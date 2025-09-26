<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Misión · Visión · Valores</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/mision.css') }}">
</head>

<body class="has-sidebar" data-titulo="Mision - Vision - Valores" data-valores-base-url="{{ url('/admin/nosotros/valores') }}">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="card roles-card shadow-sm">
                <div class="card-body">

                    {{-- ENCABEZADO --}}
                    <div class="page-head d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                        <h3 class="mb-0 fw-bold text-teal">Editar El Contenido</h3>
                        <button class="btn btn-primary btn-pill" type="submit" form="mvForm">
                            Actualizar Contenido
                        </button>
                    </div>

                    {{-- ÉXITOS / ERRORES --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <div class="fw-bold mb-1">Revisa los campos:</div>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- FORMULARIO ÚNICO: MISIÓN + VISIÓN --}}
                    <form id="mvForm" action="{{ route('mv.update') }}" method="POST">
                        @csrf @method('PUT')

                        {{-- MISIÓN --}}
                        <section class="mv-section mb-3">
                            <h6 class="mv-title">MISIÓN</h6>
                            <div class="mv-box">
                                <textarea name="mision_descripcion" class="form-control mv-textarea @error('mision_descripcion') is-invalid @enderror"
                                    rows="3" placeholder="Escribe la misión...">{{ old('mision_descripcion', $mision->descripcion) }}</textarea>
                                @error('mision_descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </section>

                        {{-- VISIÓN --}}
                        <section class="mv-section mb-4">
                            <h6 class="mv-title">VISIÓN</h6>
                            <div class="mv-box">
                                <textarea name="vision_descripcion" class="form-control mv-textarea @error('vision_descripcion') is-invalid @enderror"
                                    rows="3" placeholder="Escribe la visión...">{{ old('vision_descripcion', $vision->descripcion) }}</textarea>
                                @error('vision_descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </section>
                    </form>

                    {{-- VALORES --}}
                    <div class="values-head d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                        <h6 class="mv-title mb-0">VALORES</h6>

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

                            <div class="search-wrap position-relative me-2">
                                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                                <input type="text" class="form-control form-control-sm search-input"
                                    placeholder="Buscar...">
                            </div>

                            <button class="btn btn-primary btn-pill" type="button" data-bs-toggle="modal"
                                data-bs-target="#modalNuevoValor">
                                <i class="fa-solid fa-plus me-2"></i> Nuevo Valor
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered content-table">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Título</th>
                                    <th>Descripción</th>
                                    <th class="text-center">Iconos</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($valores as $valor)
                                    <tr>
                                        <td class="text-center">{{ $valor->id }}</td>
                                        <td class="text-muted fw-semibold">{{ $valor->nombre }}</td>
                                        <td class="text-muted">{{ $valor->descripcion }}</td>
                                        <td class="text-center"><i class="{{ $valor->icono }}"></i></td>
                                        <td class="text-center">
                                            <div class="d-inline-flex gap-1">
                                                <button class="btn btn-warning btn-sm text-white btn-edit"
                                                    data-id="{{ $valor->id }}" data-nombre="{{ $valor->nombre }}"
                                                    data-descripcion="{{ $valor->descripcion }}"
                                                    data-icono="{{ $valor->icono }}"
                                                    data-active="{{ (int) $valor->is_active }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm btn-delete"
                                                    data-id="{{ $valor->id }}" data-nombre="{{ $valor->nombre }}">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Sin valores registrados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        {{-- MODAL: NUEVO VALOR --}}
        <div class="modal fade" id="modalNuevoValor" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('valores.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" style="color:#2563eb;">Nuevo Valor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Título <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="nombre" value="{{ old('nombre') }}"
                                    class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Descripción <span
                                        class="text-danger">*</span></label>
                                <textarea name="descripcion" rows="3" class="form-control" required>{{ old('descripcion') }}</textarea>
                            </div>

                            <div class="mb-2">
                                <label class="form-label" style="color:#2563eb;">Ícono <span
                                        class="text-danger">*</span></label>
                                <select id="newIcono" name="icono" class="form-select" required>
                                    @foreach ($iconOptions as $label => $class)
                                        <option value="{{ $class }}" @selected(old('icono') === $class)
                                            data-icon="{{ $class }}">
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text" style="color:#2563eb;">
                                    Vista previa: <i id="newIconPreview" class="{{ old('icono') }}"></i>
                                </div>
                            </div>

                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="newActive" name="is_active"
                                    value="1" checked>
                                <label class="form-check-label" for="newActive">Activo</label>
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

        {{-- MODAL: EDITAR VALOR --}}
        <div class="modal fade" id="modalEditarValor" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="formEditarValor" action="#" method="POST">
                        @csrf @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" style="color:#2563eb;">Editar Valor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Título <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="editNombre" name="nombre" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Descripción <span
                                        class="text-danger">*</span></label>
                                <textarea id="editDescripcion" name="descripcion" rows="3" class="form-control" required></textarea>
                            </div>

                            <div class="mb-2">
                                <label class="form-label" style="color:#2563eb;">Ícono <span
                                        class="text-danger">*</span></label>
                                <select id="editIconoSelect" name="icono" class="form-select" required>
                                    @foreach ($iconOptions as $label => $class)
                                        <option value="{{ $class }}" data-icon="{{ $class }}">
                                            {{ $label }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text" style="color:#2563eb;">
                                    Vista previa: <i id="editIconPreview" class="fa-solid fa-star"></i>
                                    <code id="editIconCode">fa-solid fa-star</code>
                                </div>
                            </div>

                            <div class="form-check form-switch mt-2">
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

        {{-- MODAL: ELIMINAR VALOR --}}
        <div class="modal fade" id="modalEliminarValor" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="formEliminarValor" action="#" method="POST">
                        @csrf @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title" style="color:#2563eb;">Eliminar Valor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body" style="color:#2563eb;">
                            ¿Seguro que deseas eliminar <strong id="delNombre">—</strong>?
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

    @include('include.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/js/admin/nosotros/mision/mision.js')
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
