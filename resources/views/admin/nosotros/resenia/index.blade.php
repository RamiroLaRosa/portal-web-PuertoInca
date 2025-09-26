@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reseña Histórica</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/hero.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/nosotros/resenia/resenia.css') }}">
</head>

<body class="has-sidebar" data-titulo="Listado de Reseñas Historicas" data-resenia-base-url="{{ url('/admin/nosotros/resenia') }}"
    data-open-new="{{ $errors->any() && old('_from') === 'create' ? '1' : '0' }}">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="card roles-card shadow-sm">
                <div class="card-body">

                    <div class="roles-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Reseña Histórica</h5>
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

                            <button class="btn btn-primary btn-new-role btn-pill btn-icon" type="button"
                                data-bs-toggle="modal" data-bs-target="#modalNuevo">
                                <i class="fa-solid fa-plus me-2"></i> Nuevo año
                            </button>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
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
                        <table class="table  table-bordered content-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Título</th>
                                    <th>Descripción</th>
                                    <th>Imagen</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $row)
                                    @php
                                        $img = ltrim($row->imagen ?? '', './');
                                        $imgUrl = Str::startsWith($img, ['http://', 'https://'])
                                            ? $img
                                            : asset($img ?: 'images/no-photo.jpg');
                                    @endphp
                                    <tr>
                                        <td>{{ $row->id }}</td>
                                        <td class="text-muted fw-semibold">{{ $row->titulo }}</td>
                                        <td class="text-muted">{{ $row->descripcion }}</td>
                                        <td class="text-center">
                                            <span class="img-thumb btn-preview-img" data-src="{{ $imgUrl }}"
                                                data-title="{{ $row->titulo }}">
                                                <i class="fa-regular fa-image"></i>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-inline-flex gap-1">
                                                <button class="btn btn-warning btn-sm text-white btn-edit"
                                                    title="Editar" data-id="{{ $row->id }}"
                                                    data-titulo="{{ $row->titulo }}"
                                                    data-descripcion="{{ $row->descripcion }}"
                                                    data-img="{{ $imgUrl }}"
                                                    data-active="{{ (int) $row->is_active }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm btn-delete" title="Eliminar"
                                                    data-id="{{ $row->id }}" data-titulo="{{ $row->titulo }}">
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
                    <form action="{{ route('resenia.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_from" value="create">
                        <div class="modal-header">
                            <h5 class="modal-title" style="color:#2563eb;">Nuevo año</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Título <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="titulo" value="{{ old('titulo') }}"
                                    class="form-control @error('titulo') is-invalid @enderror" required>
                                @error('titulo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Descripción <span
                                        class="text-danger">*</span></label>
                                <textarea name="descripcion" rows="3" class="form-control @error('descripcion') is-invalid @enderror" required>{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Imagen (opcional)</label>
                                <input type="file" name="imagen" accept="image/*"
                                    class="form-control @error('imagen') is-invalid @enderror">
                                @error('imagen')
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

        {{-- Modal: Preview imagen --}}
        <div class="modal fade" id="modalPreviewImg" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="previewTitle" style="color:#2563eb;">Vista previa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="previewImg" src="" class="img-fluid rounded" alt="Imagen">
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal: Editar --}}
        <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="formEditar" action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" style="color:#2563eb;">Editar</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Título <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="editTitulo" name="titulo" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Descripción <span
                                        class="text-danger">*</span></label>
                                <textarea id="editDescripcion" name="descripcion" rows="3" class="form-control" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label d-block" style="color:#2563eb;">Imagen actual</label>
                                <img id="editImgPreview" src="{{ asset('images/no-photo.jpg') }}"
                                    style="max-height:160px" class="rounded border mb-2">
                                <input type="file" name="imagen" accept="image/*" class="form-control">
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
                            ¿Seguro que deseas eliminar <strong id="delTitulo">—</strong>?
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
    @vite('resources/js/admin/nosotros/resenia/resenia.js')
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
