@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Módulos (Header)</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/hero.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/inicio/hero/hero.css') }}">
</head>

<body data-titulo="Registro de información sobre Módulos" class="has-sidebar">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="card roles-card shadow-sm">
                <div class="card-body">

                    <div class="roles-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Registro de información sobre Módulos</h5>
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
                                    <th style="width:70px">#</th>
                                    <th>Nombre</th>
                                    <th style="width:220px">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($headers as $h)
                                    <tr>
                                        <td>{{ $h->id }}</td>
                                        <td class="text-muted fw-semibold">{{ $h->nombre }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <select class="form-select form-select-sm header-visibility"
                                                    data-id="{{ $h->id }}" aria-label="Cambiar visibilidad">
                                                    <option value="1" @selected($h->is_active)>Visualizar
                                                    </option>
                                                    <option value="0" @selected(!$h->is_active)>Ocultar</option>
                                                </select>
                                            </div>
                                            <small class="text-muted d-block mt-1">
                                                Estado actual:
                                                @if ($h->is_active)
                                                    <span class="badge bg-success">Visible</span>
                                                @else
                                                    <span class="badge bg-secondary">Oculto</span>
                                                @endif
                                            </small>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Sin registros.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if (method_exists($headers, 'links'))
                        <div class="d-flex justify-content-end mt-3">{{ $headers->links() }}</div>
                    @endif

                </div>
            </div>
        </div>
    </main>

    <br>
    @include('include.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.headerUpdateUrlBase = "{{ url('/admin/inicio/header') }}";
    </script>

    @vite('resources/js/titulo.js')
    @vite('resources/js/pagination.js')
    @vite('resources/js/search.js')
    @vite('resources/js/exportarPDF.js')
    @vite('resources/js/exportarEXCEL.js')

    @vite(['resources/js/admin/seguridad/modulo/modulo.js'])

    @vite('resources/css/darkmode.css')
    @vite('resources/js/darkmode.js')
</body>

</html>
