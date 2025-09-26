<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestion de Programas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/hero.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/programas_estudios/gestion_programa/gestionar_programa.css') }}">

</head>

<body data-titulo="Gestión de Programas de Estudio" class="has-sidebar">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="card roles-card shadow-sm">
                <div class="card-body">

                    {{-- Toolbar --}}
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Sección Inicial – Programas de Estudio</h5>

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

                            <button class="btn btn-primary btn-pill btn-icon" data-bs-toggle="modal"
                                data-bs-target="#modalNuevo">
                                <i class="fa-solid fa-plus me-2"></i> Nuevo programa
                            </button>
                        </div>
                    </div>

                    {{-- mensajes --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Tabla --}}
                    <div class="table-responsive">
                        <table class="table table-bordered content-table programa-table align-middle">
                            <thead>
                                <tr>
                                    <th style="width:70px">#</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th style="width:120px">Imagen</th>
                                    <th style="width:150px">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($programas as $p)
                                    <tr>
                                        <td>{{ $p->id }}</td>
                                        <td class="text-muted fw-semibold">{{ $p->nombre }}</td>
                                        <td class="text-muted">{{ $p->descripcion }}</td>
                                        <td class="text-center">
                                            <button class="img-thumb-btn btn-show-img" title="Ver imagen"
                                                data-img="{{ asset(ltrim($p->imagen, '/')) }}"
                                                data-nombre="{{ $p->nombre }}">
                                                <i class="fa-regular fa-image"></i>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-inline-flex gap-1">
                                                <button class="btn btn-warning btn-sm text-white btn-edit"
                                                    title="Editar" data-id="{{ $p->id }}"
                                                    data-nombre="{{ $p->nombre }}"
                                                    data-descripcion="{{ $p->descripcion }}"
                                                    data-img="{{ asset(ltrim($p->imagen, '/')) }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>

                                                <button class="btn btn-danger btn-sm btn-delete" title="Eliminar"
                                                    data-id="{{ $p->id }}" data-nombre="{{ $p->nombre }}">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No hay programas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </main>

    {{-- MODAL: Ver Imagen --}}
    <div class="modal fade" id="modalImagen" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="tituloImg" class="modal-title" style="color:#2563eb;">Imagen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="vistaImg" src="" class="img-fluid rounded shadow-sm" alt="Imagen del programa">
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL: Nuevo --}}
    <div class="modal fade" id="modalNuevo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('programas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#2563eb;">Nuevo programa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body row g-3">
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Nombre</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Imagen (opcional)</label>
                            <input type="file" name="imagen" class="form-control" accept="image/*">
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="color:#2563eb;">Descripción</label>
                            <textarea name="descripcion" rows="4" class="form-control" required></textarea>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="nActivo"
                                    name="is_active" checked>
                                <label class="form-check-label" for="nActivo">Activo</label>
                            </div>
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

    {{-- MODAL: Editar --}}
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="formEditar" action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#2563eb;">Editar programa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body row g-3">
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Nombre</label>
                            <input type="text" class="form-control" id="eNombre" name="nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Imagen (opcional)</label>
                            <input type="file" class="form-control" id="eImagen" name="imagen"
                                accept="image/*">
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="color:#2563eb;">Descripción</label>
                            <textarea class="form-control" id="eDescripcion" name="descripcion" rows="4" required></textarea>
                        </div>
                        <div class="col-12">
                            <img id="ePreview" src="" class="img-fluid rounded border"
                                alt="Previsualización" />
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="eActivo"
                                    name="is_active">
                                <label class="form-check-label" for="eActivo">Activo</label>
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

    {{-- MODAL: Eliminar --}}
    <div class="modal fade" id="modalEliminar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formEliminar" action="#" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#2563eb;">Eliminar programa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0" style="color:#2563eb;">¿Seguro que deseas eliminar <strong id="delNombre"></strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <br>
    @include('include.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/js/admin/programas_estudios/gestionar_programas/gestionar_programa.js')
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
