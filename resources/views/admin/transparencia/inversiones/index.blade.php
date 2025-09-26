{{-- resources/views/admin/transparencia/inversiones/index.blade.php --}}
@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inversiones</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/documentos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/transparencia/inversiones/inversiones.css') }}">
</head>

<body data-titulo="Listado de Inversiones" class="has-sidebar">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="card roles-card shadow-sm">
                <div class="card-body">

                    {{-- toolbar --}}
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Registro de Inversiones</h5>
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

                            <button class="btn btn-primary btn-pill" data-bs-toggle="modal"
                                data-bs-target="#modalNuevo">
                                <i class="fa-solid fa-plus me-2"></i>Nuevo registro
                            </button>
                        </div>
                    </div>

                    {{-- flashes --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if ($errors->any() && old('_from') === 'create')
                        <div class="alert alert-danger">
                            <div class="fw-bold mb-1">No se pudo guardar:</div>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- tabla --}}
                    <div class="table-responsive">
                        <table class="table table-bordered content-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Documento</th>
                                    <th>Imagen</th>
                                    <th>Tipo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $row)
                                    <tr>
                                        <td>{{ $row->id }}</td>
                                        <td class="text-muted fw-semibold">{{ $row->nombre }}</td>
                                        <td class="text-muted">{{ $row->descripcion }}</td>
                                        <td class="text-center">
                                            @php
                                                $docPath = $row->documento;
                                                $docUrl = $docPath ? asset(ltrim($docPath, './')) : null;
                                            @endphp
                                            <span class="pdf-thumb {{ $docPath ? 'clickable' : 'disabled' }}"
                                                @if ($docPath) data-src="{{ $docUrl }}" data-type="pdf" title="Ver documento" @else title="Sin documento" @endif>
                                                <i class="fa-solid fa-file-pdf"></i>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $imgPath = $row->imagen;
                                                $imgUrl = $imgPath ? asset(ltrim($imgPath, './')) : null;
                                            @endphp
                                            <span class="img-thumb {{ $imgPath ? 'clickable' : 'disabled' }}"
                                                @if ($imgPath) data-src="{{ $imgUrl }}" data-type="img" title="Ver imagen" @else title="Sin imagen" @endif>
                                                <i class="fa-solid fa-image"></i>
                                            </span>
                                        </td>
                                        <td class="text-muted fw-semibold">{{ $row->tipo->nombre ?? '—' }}</td>
                                        <td class="text-center">
                                            <div class="d-inline-flex gap-1">
                                                <button class="btn btn-warning btn-sm text-white btn-edit"
                                                    data-id="{{ $row->id }}" data-nombre="{{ $row->nombre }}"
                                                    data-descripcion="{{ $row->descripcion }}"
                                                    data-tipo="{{ $row->tipo_inversion_id }}"
                                                    data-active="{{ (int) $row->is_active }}" title="Editar">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>

                                                {{-- Botón que abre el modal de eliminar --}}
                                                <button class="btn btn-danger btn-sm btn-delete" title="Eliminar"
                                                    data-bs-toggle="modal" data-bs-target="#modalEliminar"
                                                    data-delete-url="{{ route('inversiones.destroy', $row) }}"
                                                    data-title="{{ $row->nombre }}">
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

                </div>
            </div>
        </div>

        {{-- Modal Nuevo --}}
        <div class="modal fade" id="modalNuevo" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('inversiones.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf <input type="hidden" name="_from" value="create">
                        <div class="modal-header">
                            <h5 class="modal-title" style="color:#2563eb;">Nuevo registro</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Nombre *</label>
                                <input type="text" name="nombre" class="form-control" required
                                    value="{{ old('nombre') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Descripción *</label>
                                <textarea name="descripcion" rows="3" class="form-control" required>{{ old('descripcion') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Tipo *</label>
                                <select name="tipo_inversion_id" class="form-select" required>
                                    <option value="" hidden>Seleccione…</option>
                                    @foreach ($tipos as $t)
                                        <option value="{{ $t->id }}">{{ $t->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Documento (PDF)</label>
                                <input type="file" name="documento" accept="application/pdf"
                                    class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Imagen (JPG/PNG/WEBP)</label>
                                <input type="file" name="imagen" accept="image/*" class="form-control">
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="crearActivo" name="is_active"
                                    value="1" checked>
                                <label class="form-check-label" for="crearActivo">Activo</label>
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
                    <form id="formEditar" action="#" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" style="color:#2563eb;">Editar registro</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Nombre *</label>
                                <input type="text" id="eNombre" name="nombre" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Descripción *</label>
                                <textarea id="eDescripcion" name="descripcion" rows="3" class="form-control" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Tipo *</label>
                                <select id="eTipo" name="tipo_inversion_id" class="form-select" required>
                                    @foreach ($tipos as $t)
                                        <option value="{{ $t->id }}">{{ $t->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Reemplazar documento (PDF)</label>
                                <input type="file" name="documento" accept="application/pdf"
                                    class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Reemplazar imagen</label>
                                <input type="file" name="imagen" accept="image/*" class="form-control">
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

        {{-- Modal PREVIEW PDF --}}
        <div class="modal fade" id="modalPdf" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <a class="btn btn-outline-primary btn-sm" id="openPdfNewTab" href="#" target="_blank">
                            <i class="fa-solid fa-up-right-from-square me-1"></i> Abrir en pestaña nueva
                        </a>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-0" style="height:70vh">
                        <iframe id="pdfFrame" src="" style="width:100%; height:100%; border:0"></iframe>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal PREVIEW Imagen --}}
        <div class="modal fade" id="modalImg" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <a class="btn btn-outline-primary btn-sm" id="openImgNewTab" href="#" target="_blank">
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

        {{-- Modal ELIMINAR (nuevo) --}}
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

    </main>

    @include('include.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/js/admin/transparencia/inversiones/inversiones.js')

    @vite('resources/css/content.css')

    @vite('resources/js/titulo.js')

    @vite('resources/js/pagination.js')

    @vite('resources/js/search.js')

    @vite('resources/js/exportarPDF.js')

    @vite('resources/js/exportarEXCEL.js')

    @vite('resources/css/darkmode.css')

    @vite('resources/js/darkmode.js')

    {{-- Script mínimo para poblar el modal de eliminar (puedes moverlo a inversiones.js) --}}
    <script>
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-delete');
            if (!btn) return;

            const url = btn.getAttribute('data-delete-url');
            const title = btn.getAttribute('data-title') || 'este registro';

            const form = document.getElementById('formEliminar');
            const delTitle = document.getElementById('delTitulo');

            if (form) form.setAttribute('action', url);
            if (delTitle) delTitle.textContent = title;
        });
    </script>
</body>

</html>
