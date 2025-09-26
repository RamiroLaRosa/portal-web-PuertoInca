<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Organigrama</title>

    <!-- CDNs (opcional, solo para estilos base y dropdown) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/organigrama.css') }}">
</head>

<body class="has-sidebar" data-pdf-url="{{ $documentUrl ?? '' }}" data-pdfjs-use="0" data-pdfjs-base="/pdfjs/web/viewer.html?file=">
    @include('include.preloader')
    @include('include.header')

    <aside class="sidebar-fixed">
        @include('include.sidebar')
    </aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">

            <div class="card doc-card shadow-sm">
                <div class="card-body">

                    <div class="page-head d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                        <h3 class="mb-0 fw-bold text-teal">Selecciona un documento para actualizar</h3>
                        <button type="submit" form="formDoc" class="btn btn-teal btn-pill">Actualizar</button>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @error('documento')
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @enderror

                    <!-- FORMULARIO -->
                    <form id="formDoc" class="doc-uploader d-flex align-items-center gap-2 mb-4"
                        action="{{ route('organigrama.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="flex-grow-1 d-flex gap-2">
                            <input class="form-control" type="file" id="filePdf" name="documento"
                                accept="application/pdf">
                            <span id="fileName" class="small text-muted align-self-center">Sin archivos
                                seleccionados</span>
                        </div>
                    </form>

                    <h6 class="mv-title mb-2">Visualización del documento</h6>

                    <div class="pdf-viewer-wrapper">
                        <div id="pdfEmptyState" class="pdf-empty">
                            <i class="fa-regular fa-file-pdf"></i>
                            <p class="mb-1">Aún no hay documento cargado</p>
                            <small class="text-muted">Selecciona un PDF para previsualizarlo aquí.</small>
                        </div>
                        <iframe id="pdfFrame" class="pdf-frame" title="Vista previa del documento"></iframe>
                    </div>

                </div>
            </div>

        </div>
    </main>

    <br>
    @include('include.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/js/admin/nosotros/organigrama/organigrama.js')
    @vite('resources/css/darkmode.css')
    @vite('resources/js/darkmode.js')
</body>

</html>
