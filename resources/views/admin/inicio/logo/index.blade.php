@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sección Inicial - Imagen</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/hero.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/inicio/hero/hero.css') }}">
</head>

<body data-titulo="Logo del header" class="has-sidebar">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="card roles-card shadow-sm">
                <div class="card-body">

                    <div class="roles-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Imagen de Sección Inicial</h5>

                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <button class="btn btn-primary btn-pill btn-icon btn-open-modal"
                                data-id="{{ $record->id ?? '' }}"
                                data-foto="{{ isset($record->foto)
                                    ? (Str::startsWith($record->foto, ['http://', 'https://'])
                                        ? $record->foto
                                        : asset(ltrim($record->foto, '/')))
                                    : asset('images/no-photo.jpg') }}"
                                data-active="{{ isset($record->is_active) ? (int) $record->is_active : 1 }}"
                                type="button" title="{{ $record ? 'Actualizar imagen' : 'Subir imagen' }}">
                                <i class="fa-regular fa-image me-2"></i>
                                {{ $record ? 'Actualizar imagen' : 'Subir imagen' }}
                            </button>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Cerrar"></button>
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
                                    <th>Imagen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($record)
                                    @php
                                        $foto = $record->foto ?? '';
                                        $isAbsolute = Str::startsWith($foto, ['http://', 'https://']);
                                        $fotoUrl = $isAbsolute ? $foto : asset(ltrim($foto, '/'));
                                    @endphp
                                    <tr>
                                        <td>{{ $record->id }}</td>
                                        <td class="text-center">
                                            <span class="img-thumb btn-preview-image" data-src="{{ $fotoUrl }}"
                                                data-title="Vista previa" title="Ver imagen">
                                                <i class="fa-regular fa-image"></i>
                                            </span>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">
                                            Sin imagen. Usa el botón <b>Subir imagen</b>.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        {{-- Modal: preview --}}
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

        {{-- Modal: crear/editar --}}
        <div class="modal fade" id="modalGuardarImagen" tabindex="-1" aria-labelledby="modalGuardarImagenLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="formGuardarImagen" action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalGuardarImagenLabel" style="color:#2563eb;">
                                {{ $record ? 'Actualizar imagen' : 'Subir imagen' }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3 text-center">
                                <label class="form-label" style="color:#2563eb;">Imagen actual</label>
                                @php
                                    $actual = $record->foto ?? null;
                                    $actualUrl = $actual
                                        ? (Str::startsWith($actual, ['http://', 'https://'])
                                            ? $actual
                                            : asset(ltrim($actual, '/')))
                                        : asset('images/no-photo.jpg');
                                @endphp
                                <img id="modalActualPreview" src="{{ $actualUrl }}" class="img-fluid rounded mb-2"
                                    style="max-height:180px" alt="Actual">
                            </div>

                            <div class="mb-3">
                                <label for="inputFoto" class="form-label" style="color:#2563eb;">Seleccionar
                                    imagen</label>
                                <input type="file" name="foto" id="inputFoto" accept="image/*"
                                    class="form-control" {{ $record ? '' : 'required' }}>
                                <div class="form-text">Formatos: JPG, PNG, WEBP. Peso recomendado &lt; 2MB.</div>
                            </div>

                            <div class="mb-3 text-center">
                                <label class="form-label" style="color:#2563eb;">Vista previa nueva</label>
                                <img id="modalNuevaPreview" src="{{ asset('images/no-photo.jpg') }}"
                                    class="img-fluid rounded mb-2" style="max-height:180px" alt="Nueva"
                                    data-default="{{ asset('images/no-photo.jpg') }}">
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="inputActivo" name="is_active"
                                    value="1"
                                    {{ ($record && (int) $record->is_active === 1) || !$record ? 'checked' : '' }}>
                                <label class="form-check-label" for="inputActivo">Activo</label>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">
                                {{ $record ? 'Guardar cambios' : 'Subir imagen' }}
                            </button>
                        </div>

                        <div id="methodHolder"></div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <br>
    @include('include.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        window.heroImageUrlBase = "{{ url('/admin/inicio/hero-image') }}";
    </script>

    @vite('resources/js/titulo.js')
    @vite('resources/js/darkmode.js')
    @vite(['resources/js/admin/inicio/logo/image-only.js'])
</body>

</html>
