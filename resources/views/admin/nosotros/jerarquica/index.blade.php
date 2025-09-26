{{-- resources/views/admin/nosotros/jerarquica/index.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Plana Jerarquica</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/hero.css') }}">
</head>

<body class="has-sidebar" data-titulo="Listado de Plana Jerarquica" data-jerarquica-base-url="{{ url('/admin/nosotros/jerarquica') }}"
    data-no-photo="{{ asset('images/no-photo.jpg') }}">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="card roles-card shadow-sm">
                <div class="card-body">
                    <div class="roles-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Plana Jerarquica</h5>

                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <div class="btn-toolbar gap-2 me-2">

                                <!-- Botón de exportación a Excel -->
                                <button class="btn btn-dark btn-pill btn-icon" title="Exportar a Excel"
                                    data-export-excel>
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
                                <i class="fa-solid fa-plus me-2"></i> Nuevo Coordinador
                            </button>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
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
                        <table class="table roles-table table-bordered content-table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Cargo</th>
                                    <th>Imagen</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $p)
                                    <tr>
                                        <td>{{ $p->id }}</td>
                                        <td class="text-muted fw-semibold">{{ $p->nombre }}</td>
                                        <td class="text-muted">{{ $p->cargo }}</td>
                                        <td class="text-center">
                                            @php
                                                $src = $p->imagen
                                                    ? asset(ltrim($p->imagen, '/'))
                                                    : asset('images/no-photo.jpg');
                                            @endphp
                                            <button type="button" class="btn btn-light btn-sm p-2 btn-view-img"
                                                data-src="{{ $src }}" data-title="{{ $p->nombre }}"
                                                title="Ver imagen">
                                                <span class="img-thumb"><i class="fa-regular fa-image"></i></span>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-inline-flex gap-1">
                                                <button type="button"
                                                    class="btn btn-warning btn-sm text-white btn-edit"
                                                    data-id="{{ $p->id }}" data-nombre="{{ $p->nombre }}"
                                                    data-cargo="{{ $p->cargo }}" data-active="{{ $p->is_active }}"
                                                    data-bs-toggle="modal" data-bs-target="#modalEditar">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                    data-id="{{ $p->id }}" data-nombre="{{ $p->nombre }}"
                                                    data-bs-toggle="modal" data-bs-target="#modalEliminar">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No hay registros.</td>
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
                    <form action="{{ route('jerarquica.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" style="color:#2563eb;">Nuevo Coordinador</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Nombre <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Cargo <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="cargo" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Imagen (opcional)</label>
                                <input type="file" name="imagen" class="form-control" accept="image/*">
                            </div>
                            <div class="form-check">
                                {{-- Enviar 0 si queda desmarcado --}}
                                <input type="hidden" name="is_active" value="0">
                                {{-- Enviar 1 si está marcado --}}
                                <input class="form-check-input" type="checkbox" name="is_active" id="newActive"
                                    value="1" checked>
                                <label class="form-check-label" for="newActive">Activo</label>
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
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" style="color:#2563eb;">Editar Coordinador</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Nombre <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="nombre" id="editNombre" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Cargo <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="cargo" id="editCargo" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Imagen (opcional)</label>
                                <input type="file" name="imagen" class="form-control" accept="image/*">
                            </div>
                            <div class="form-check">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input" type="checkbox" name="is_active" id="editActive" value="1">
                                <label class="form-check-label" for="editActive">Activo</label>
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

        {{-- Modal Eliminar --}}
        <div class="modal fade" id="modalEliminar" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="formEliminar" action="#" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title" style="color:#2563eb;">Eliminar Coordinador</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body" style="color:#2563eb;">
                            ¿Seguro que deseas eliminar a <span class="fw-semibold" id="delNombre"></span>?
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-secondary" type="button"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button class="btn btn-danger" type="submit">Eliminar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal: Ver Imagen --}}
        <div class="modal fade" id="modalVerImagen" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imgTitle" style="color:#2563eb;">Imagen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body p-0">
                        <img id="imgPreview" src="" alt="Imagen" class="img-fluid w-100"
                            style="display:block;">
                    </div>
                </div>
            </div>
        </div>

    </main>

    <br>
    @include('include.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/js/admin/nosotros/jerarquica/jerarquica.js')
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
