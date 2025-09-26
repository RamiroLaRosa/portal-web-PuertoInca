{{-- resources/views/admin/noticias/index.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Noticias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/documentos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/noticias/noticias.css') }}">
    @vite('resources/css/darkmode.css')
</head>

<body data-titulo="Registro de información sobre Noticias" class="has-sidebar">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="card roles-card shadow-sm">
                <div class="card-body">

                    {{-- Toolbar --}}
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Registro de Noticias</h5>
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
                                <input type="text" class="form-control form-control-sm search-input"
                                    placeholder="Buscar...">
                            </div>
                            <button class="btn btn-primary btn-new-role btn-pill btn-icon" type="button"
                                data-bs-toggle="modal" data-bs-target="#modalNuevo">
                                <i class="fa-solid fa-plus me-2"></i> Nueva noticia
                            </button>
                        </div>

                        {{-- flashes --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show w-100 mt-3">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        @if ($errors->any() && old('_from') === 'create')
                            <div class="alert alert-danger w-100 mt-3">
                                <div class="fw-bold mb-1">No se pudo guardar:</div>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $e)
                                        <li>{{ $e }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div> {{-- /Toolbar --}}

                    {{-- Tabla --}}
                    <div class="table-responsive">
                        <table class="table table-bordered content-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Título</th>
                                    <th>Descripción</th>
                                    <th>Fecha</th>
                                    <th>Imagen</th>
                                    <th>Documento</th> {{-- <== NUEVA COLUMNA --}}
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $row)
                                    @php
                                        $imgSrc = $row->imagen ? asset(ltrim($row->imagen, '/')) : null;

                                        // Resolver URL del documento (guardas /assets/archivo.pdf)
                                        $docRaw = $row->documento;
                                        $docUrl = $docRaw ? asset(ltrim($docRaw, '/')) : null;
                                    @endphp
                                    <tr>
                                        <td>{{ $row->id }}</td>
                                        <td class="text-muted fw-semibold">{{ $row->titulo }}</td>
                                        <td class="text-muted">{{ $row->descripcion }}</td>
                                        <td class="text-muted">
                                            {{ optional($row->fecha)->translatedFormat('d F Y') }}
                                        </td>

                                        {{-- Imagen --}}
                                        <td class="text-center">
                                            <span class="img-thumb {{ $imgSrc ? '' : 'disabled' }}"
                                                @if ($imgSrc) data-src="{{ $imgSrc }}" title="Ver imagen" @else title="Sin imagen" @endif>
                                                <i class="fa-regular fa-image"></i>
                                            </span>
                                        </td>

                                        {{-- Documento --}}
                                        <td class="text-center">
                                            @if ($docUrl)
                                                <span class="img-thumb" title="Ver documento PDF"
                                                    onclick="window.open('{{ $docUrl }}','_blank')">
                                                    <i class="fa-regular fa-file-pdf"></i>
                                                </span>
                                            @else
                                                <span class="img-thumb disabled" title="Sin documento">
                                                    <i class="fa-regular fa-file-pdf"></i>
                                                </span>
                                            @endif
                                        </td>


                                        {{-- Acciones --}}
                                        <td class="text-center">
                                            <div class="d-inline-flex gap-1">
                                                <button class="btn btn-warning btn-sm text-white btn-edit"
                                                    title="Editar" data-id="{{ $row->id }}"
                                                    data-update-url="{{ route('noticias.update', $row) }}"
                                                    data-titulo="{{ $row->titulo }}"
                                                    data-descripcion="{{ $row->descripcion }}"
                                                    data-fecha="{{ optional($row->fecha)->format('Y-m-d') }}"
                                                    data-active="{{ (int) $row->is_active }}"
                                                    data-documento="{{ $docRaw ?? '' }}"
                                                    data-documento-url="{{ $docUrl ?? '' }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>

                                                {{-- Botón que abre el modal de eliminar --}}
                                                <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                    title="Eliminar"
                                                    data-delete-url="{{ route('noticias.destroy', $row) }}"
                                                    data-title="{{ $row->titulo }}">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Sin registros.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div> {{-- /card-body --}}
            </div>
        </div>
    </main>

    {{-- Modal NUEVO --}}
    <div class="modal fade" id="modalNuevo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('noticias.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf <input type="hidden" name="_from" value="create">
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#2563eb;">Nueva noticia</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <div class="col-md-8">
                            <label class="form-label" style="color:#2563eb;">Título *</label>
                            <input type="text" name="titulo" class="form-control" required
                                value="{{ old('titulo') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" style="color:#2563eb;">Fecha *</label>
                            <input type="date" name="fecha" class="form-control" required
                                value="{{ old('fecha') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="color:#2563eb;">Descripción *</label>
                            <textarea name="descripcion" rows="4" class="form-control" required>{{ old('descripcion') }}</textarea>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label" style="color:#2563eb;">Imagen (JPG/PNG/WEBP)</label>
                            <input type="file" name="imagen" accept="image/*" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" style="color:#2563eb;">Documento (PDF)</label>
                            <input type="file" name="documento" accept="application/pdf" class="form-control">
                        </div>
                        <div class="col-12 d-flex align-items-center">
                            <div class="form-check form-switch ms-auto">
                                <input class="form-check-input" type="checkbox" id="nActivo" name="is_active"
                                    value="1" checked>
                                <label class="form-check-label" for="nActivo">Activo</label>
                            </div>
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

    {{-- Modal EDITAR --}}
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formEditar" action="#" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#2563eb;">Editar noticia</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <div class="col-md-8">
                            <label class="form-label" style="color:#2563eb;">Título *</label>
                            <input type="text" id="eTitulo" name="titulo" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" style="color:#2563eb;">Fecha *</label>
                            <input type="date" id="eFecha" name="fecha" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="color:#2563eb;">Descripción *</label>
                            <textarea id="eDescripcion" name="descripcion" rows="4" class="form-control" required></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Reemplazar imagen</label>
                            <input type="file" name="imagen" accept="image/*" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Reemplazar documento (PDF)</label>
                            <input type="file" name="documento" accept="application/pdf" class="form-control">
                            <div class="form-text mt-1">
                                <a id="eDocumentoLink" href="#" target="_blank" class="d-none">
                                    Ver documento actual
                                </a>
                                <span id="eSinDocumento" class="text-muted d-none">Sin documento actual</span>
                            </div>
                        </div>

                        <div class="col-12 d-flex align-items-center">
                            <div class="form-check form-switch ms-auto">
                                <input class="form-check-input" type="checkbox" id="eActivo" name="is_active"
                                    value="1">
                                <label class="form-check-label" for="eActivo">Activo</label>
                            </div>
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

    {{-- Modal PREVIEW IMG --}}
    <div class="modal fade" id="modalImg" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <a id="openImgNewTab" class="btn btn-outline-primary btn-sm" href="#" target="_blank">
                        <i class="fa-solid fa-up-right-from-square me-1"></i> Abrir en pestaña nueva
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-2 text-center">
                    <img id="imgPreview" src="" class="img-fluid rounded shadow-sm" alt="preview">
                </div>
            </div>
        </div>
    </div>

    {{-- Modal ELIMINAR --}}
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
                        ¿Seguro que deseas eliminar <strong id="delTitulo">esta noticia</strong>?
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

    @vite('resources/js/titulo.js')
    @vite('resources/js/pagination.js')
    @vite('resources/js/search.js')
    @vite('resources/js/exportarPDF.js')
    @vite('resources/js/exportarEXCEL.js')
    @vite('resources/js/admin/noticias/noticias.js')
    @vite('resources/css/darkmode.css')
    @vite('resources/js/darkmode.js')
</body>

</html>
