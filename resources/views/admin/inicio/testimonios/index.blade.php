@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Testimonios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/testimonios.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/inicio/testimonios/testimonios.css') }}">
    @vite('resources/css/darkmode.css')
</head>

<body data-titulo="Registro de información sobre Testimonios" class="has-sidebar">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="card roles-card shadow-sm">
                <div class="card-body">

                    <div class="roles-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Testimonios</h5>
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
                                <i class="fa-solid fa-plus me-2"></i> Nuevo Testimonio
                            </button>
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

                    <div class="table-responsive">
                        <table class="table table-bordered content-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Imagen</th>
                                    <th>Puntuación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($testimonios as $t)
                                    @php
                                        $img = ltrim($t->imagen ?? '', './');
                                        $imgUrl = Str::startsWith($img, ['http://', 'https://'])
                                            ? $img
                                            : asset($img ?: 'images/no-photo.jpg');
                                    @endphp
                                    <tr>
                                        <td>{{ $t->id }}</td>
                                        <td class="text-muted fw-semibold">{{ $t->nombre }}</td>
                                        <td class="text-muted">{{ $t->descripcion }}</td>
                                        <td class="text-center">
                                            <span class="img-thumb btn-preview-img" data-src="{{ $imgUrl }}"
                                                data-title="{{ $t->nombre }}">
                                                <i class="fa-regular fa-image"></i>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="rating" aria-label="{{ $t->puntuacion }} de 5">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= (int) $t->puntuacion)
                                                        <i class="fa-solid fa-star"></i>
                                                    @else
                                                        <i class="fa-regular fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-inline-flex gap-1">
                                                <button class="btn btn-warning btn-sm text-white btn-edit"
                                                    title="Editar" data-id="{{ $t->id }}"
                                                    data-nombre="{{ $t->nombre }}"
                                                    data-descripcion="{{ $t->descripcion }}"
                                                    data-img="{{ $imgUrl }}"
                                                    data-puntuacion="{{ (int) $t->puntuacion }}"
                                                    data-active="{{ (int) $t->is_active }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm btn-delete" title="Eliminar"
                                                    data-id="{{ $t->id }}" data-nombre="{{ $t->nombre }}">
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

        {{-- Modal: nuevo --}}
        <div class="modal fade" id="modalNuevo" tabindex="-1" aria-labelledby="modalNuevoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('testimonios.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_from" value="create">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalNuevoLabel" style="color:#2563eb;">Nuevo Testimonio</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Nombre <span class="text-danger">*</span></label>
                                <input type="text" name="nombre" value="{{ old('nombre') }}"
                                    class="form-control @error('nombre') is-invalid @enderror" required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Descripción <span class="text-danger">*</span></label>
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

                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Puntuación <span class="text-danger">*</span></label>
                                <div class="d-flex align-items-center gap-3">
                                    <select id="puntuacionCreate" name="puntuacion"
                                        class="form-select w-auto @error('puntuacion') is-invalid @enderror" required>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}"
                                                {{ old('puntuacion') == $i ? 'selected' : '' }}>{{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                    <span id="ratingCreatePreview" class="rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                                class="{{ old('puntuacion', 5) >= $i ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                                        @endfor
                                    </span>
                                </div>
                                @error('puntuacion')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="createActive" name="is_active"
                                    value="1" {{ old('is_active') ? 'checked' : '' }}>
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

        {{-- Modal: preview imagen --}}
        <div class="modal fade" id="modalPreviewImg" tabindex="-1" aria-labelledby="modalPreviewImgLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPreviewImgLabel" style="color:#2563eb;">Vista previa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="previewImgEl" src="" class="img-fluid rounded" alt="Imagen">
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal: editar --}}
        <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="formEditar" action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditarLabel" style="color:#2563eb;">Editar Testimonio</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Nombre <span class="text-danger">*</span></label>
                                <input type="text" id="editNombre" name="nombre" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Descripción <span class="text-danger">*</span></label>
                                <textarea id="editDescripcion" name="descripcion" rows="3" class="form-control" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label d-block" style="color:#2563eb;">Imagen actual</label>
                                <div class="text-center">
                                    <img id="editImgPreview" src="{{ asset('images/no-photo.jpg') }}"
                                        class="img-fluid rounded mb-2" style="max-height:180px">
                                </div>
                                <label class="form-label" style="color:#2563eb;">Cambiar imagen (opcional)</label>
                                <input type="file" name="imagen" id="editImagen" accept="image/*"
                                    class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Puntuación <span class="text-danger">*</span></label>
                                <div class="d-flex align-items-center gap-3">
                                    <select id="puntuacionEdit" name="puntuacion" class="form-select w-auto"
                                        required>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <span id="ratingEditPreview" class="rating"></span>
                                </div>
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

        {{-- Modal: eliminar --}}
        <div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="formEliminar" action="#" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEliminarLabel" style="color:#2563eb;">Eliminar Testimonio</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
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

    <br>
    @include('include.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        window.testimoniosEditUrlBase = "{{ url('/admin/inicio/testimonios') }}";
        window.showModalNuevoOnError = @json($errors->any() && old('_from') === 'create');
    </script>

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
    @vite(['resources/js/admin/inicio/testimonios/testimonios.js'])

    <!-- css de dark mode -->
    @vite('resources/css/darkmode.css')

    <!-- js de dark mode -->
    @vite('resources/js/darkmode.js')
</body>
</html>
