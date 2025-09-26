@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Seccion Inicial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/hero.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/inicio/hero/hero.css') }}">
</head>

<body data-titulo="Registro de información sobre Sección Inicial" class="has-sidebar">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="card roles-card shadow-sm">
                <div class="card-body">

                    <div class="roles-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Registro de información sobre Sección Inicial</h5>
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
                                    <th>Título</th>
                                    <th>Descripción</th>
                                    <th>Imagen</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($heroes as $h)
                                    @php
                                        $foto = $h->foto ?? '';
                                        $isAbsolute = Str::startsWith($foto, ['http://', 'https://']);
                                        $fotoUrl = $isAbsolute ? $foto : asset(ltrim($foto, '/'));
                                    @endphp
                                    <tr>
                                        <td>{{ $h->id }}</td>
                                        <td class="text-muted fw-semibold">{{ $h->titulo }}</td>
                                        <td class="text-muted">{{ $h->descripcion }}</td>
                                        <td class="text-center">
                                            <span class="img-thumb btn-preview-image" data-src="{{ $fotoUrl }}"
                                                data-title="{{ $h->titulo }}" title="Ver imagen">
                                                <i class="fa-regular fa-image"></i>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-warning btn-sm text-white btn-edit-hero"
                                                title="Editar" data-id="{{ $h->id }}"
                                                data-titulo="{{ $h->titulo }}"
                                                data-descripcion="{{ $h->descripcion }}"
                                                data-foto="{{ $fotoUrl }}"
                                                data-active="{{ (int) $h->is_active }}">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
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

        {{-- Modal vista previa imagen --}}
        <div class="modal fade" id="modalPreviewImagen" tabindex="-1" aria-labelledby="modalPreviewImagenLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPreviewImagenLabel" style="color:#2563eb;">Vista previa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="previewImg" src="" alt="Imagen" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal editar --}}
        <div class="modal fade" id="modalEditarHero" tabindex="-1" aria-labelledby="modalEditarHeroLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="formEditarHero" action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditarHeroLabel" style="color:#2563eb;">Editar Sección
                                Inicial</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Título <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="titulo" id="editTitulo" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Descripción <span
                                        class="text-danger">*</span></label>
                                <textarea name="descripcion" id="editDescripcion" rows="3" class="form-control" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Imagen actual</label>
                                <div class="text-center">
                                    <img id="editPreview" src="{{ asset('images/no-photo.jpg') }}"
                                        class="img-fluid rounded mb-2" style="max-height:180px">
                                </div>
                                <label for="editFoto" class="form-label" style="color:#2563eb;">Cambiar imagen
                                    (opcional)</label>
                                <input type="file" name="foto" id="editFoto" accept="image/*"
                                    class="form-control">
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="editActivo" name="is_active"
                                    value="1">
                                <label class="form-check-label" for="editActivo">Activo</label>
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
    </main>

    <br>
    @include('include.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.heroEditUrlBase = "{{ url('/admin/inicio/hero') }}";
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
    @vite(['resources/js/admin/inicio/hero/hero.js'])

    <!-- css de dark mode -->
    @vite('resources/css/darkmode.css')

    <!-- js de dark mode -->
    @vite('resources/js/darkmode.js')
</body>
</html>
