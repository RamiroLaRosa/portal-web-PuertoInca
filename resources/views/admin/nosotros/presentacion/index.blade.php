<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Presentación Institucional</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/presentacion.css') }}">
</head>

<body class="has-sidebar">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="card form-card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Palabras del director</h5>

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

                    <form id="presentacionForm" action="{{ route('presentacion.update', $presentacion->id) }}"
                        method="POST" enctype="multipart/form-data" class="form-compact">
                        @csrf
                        @method('PUT')

                        {{-- Título --}}
                        <div class="mb-3">
                            <label class="form-label">Título</label>
                            <input type="text" class="form-control" name="titulo"
                                value="{{ old('titulo', $presentacion->titulo) }}" required>
                        </div>

                        {{-- Foto del Director (preview + reemplazo opcional) --}}
                        <div class="mb-3">
                            <label class="form-label d-block">Foto del Director</label>
                            <div class="mb-2">
                                <img src="{{ asset($presentacion->foto_director ?: 'images/no-photo.jpg') }}"
                                    alt="Foto del Director" style="max-height: 160px" class="rounded border">
                            </div>

                            <div class="custom-file-wrap">
                                <input type="file" class="form-control custom-file-input" name="foto_director"
                                    id="fotoDirector" accept="image/*">
                                <div class="custom-file-ui">
                                    <button type="button" class="btn btn-outline-secondary btn-sm"
                                        onclick="document.getElementById('fotoDirector').click()">
                                        Seleccionar archivo
                                    </button>
                                    <span id="fileName" class="file-name">Sin archivos seleccionados</span>
                                </div>
                            </div>
                        </div>

                        {{-- Nombre del Director --}}
                        <div class="mb-3">
                            <label class="form-label">Nombre del Director</label>
                            <input type="text" class="form-control" name="nombre_director"
                                value="{{ old('nombre_director', $presentacion->nombre_director) }}" required>
                        </div>

                        {{-- Palabras del Director (TinyMCE) --}}
                        <div class="mb-3">
                            <label class="form-label">Palabras del Director</label>
                            <textarea id="palabrasDirector" name="palabras_director">
              {!! old('palabras_director', $presentacion->palabras_director) !!}
            </textarea>
                        </div>

                        {{-- Activo (opcional) --}}
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="isActive" name="is_active"
                                value="1" {{ old('is_active', $presentacion->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="isActive">Activo</label>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="{{ route('presentacion.index') }}" class="btn btn-light">Cancelar</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </main>

    @include('include.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
    @vite('resources/js/admin/nosotros/presentacion/presentacion.js')
    @vite('resources/css/darkmode.css')
    @vite('resources/js/darkmode.js')
</body>

</html>
