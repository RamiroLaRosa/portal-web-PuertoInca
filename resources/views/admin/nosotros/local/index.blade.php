<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Locales</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/local.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/nosotros/locales/local.css') }}">

</head>

<body class="has-sidebar" data-titulo="Listado de Locales">
    @include('include.preloader')
    @include('include.header')

    <aside class="sidebar-fixed">
        @include('include.sidebar')
    </aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">

            <div class="card roles-card shadow-sm">
                <div class="card-body">

                    {{-- Toolbar --}}
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Locales</h5>

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
                        </div>
                    </div>

                    {{-- Alertas --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Cerrar"></button>
                        </div>
                    @endif

                    {{-- Tabla --}}
                    <div class="table-responsive">
                        <table class="table table-bordered content-table align-middle">
                            <thead>
                                <tr>
                                    <th style="width:60px">#</th>
                                    <th>Direccion</th>
                                    <th>Telefono</th>
                                    <th>Correo</th>
                                    <th>Horario</th>
                                    <th class="code-cell">Link (iframe como texto)</th>
                                    <th style="width:120px">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($locales as $l)
                                    <tr>
                                        <td>{{ $l->id }}</td>
                                        <td class="text-muted fw-semibold">{{ $l->direccion }}</td>
                                        <td class="text-muted">{{ $l->telefono }}</td>
                                        <td class="text-muted">{{ $l->correo }}</td>
                                        <td class="text-muted">{{ $l->horario }}</td>
                                        <td>
                                            <div class="code-box">{{ $l->link }}</div>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-warning btn-sm text-white btn-edit" title="Editar"
                                                data-id="{{ $l->id }}" data-direccion="{{ $l->direccion }}"
                                                data-telefono="{{ $l->telefono }}" data-correo="{{ $l->correo }}"
                                                data-horario="{{ $l->horario }}"
                                                data-link="{{ htmlentities($l->link, ENT_QUOTES) }}"
                                                data-active="{{ $l->is_active ? 1 : 0 }}">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No hay registros.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </main>

    {{-- Modal Editar --}}
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="formEditar" action="#" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarLabel" style="color:#2563eb;">Editar Local</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body row g-3">
                        <div class="col-12">
                            <label class="form-label" style="color:#2563eb;">Dirección</label>
                            <input type="text" id="eDireccion" name="direccion" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Teléfono</label>
                            <input type="text" id="eTelefono" name="telefono" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Correo</label>
                            <input type="email" id="eCorreo" name="correo" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Horario</label>
                            <input type="text" id="eHorario" name="horario" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="color:#2563eb;">Iframe (pega aquí el código completo)</label>
                            <textarea id="eLink" name="link" rows="6" class="form-control"
                                placeholder='<iframe src="..."></iframe>' required></textarea>
                            <small class="text-muted">Se guardará como texto y se mostrará tal cual en la
                                lista.</small>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="eActive"
                                    name="is_active">
                                <label class="form-check-label" for="eActive">Activo</label>
                            </div>
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

    <br>
    @include('include.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/js/admin/nosotros/local/locales.js')
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
