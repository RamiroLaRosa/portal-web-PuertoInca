@php
    /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\ServicioComplementario[] $items */
@endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Servicios Complementarios</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/documentos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/servicios_complementarios/gestionar/gestionar.css') }}">
</head>

<body data-titulo="Listado de Servicios Complementarios" class="has-sidebar">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">

            <div class="card roles-card shadow-sm">
                <div class="card-body">

                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Registro de Servicios Complementarios</h5>

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
                            <button class="btn btn-primary btn-pill" data-bs-toggle="modal"
                                data-bs-target="#modalNuevo">
                                <i class="fa-solid fa-plus me-2"></i> Nuevo registro
                            </button>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered content-table" id="tabla">
                            {{-- Distribución de anchos (puedes ajustar %/px a tu gusto) --}}
                            <colgroup>
                                <col style="width: 4rem;"> {{-- # --}}
                                <col style="width: 18%;"> {{-- Nombre --}}
                                <col style="width: 18%;"> {{-- Subnombre --}}
                                <col style="width: 26%;"> {{-- Descripción (más ancho) --}}
                                <col style="width: 18%;"> {{-- Ubicación --}}
                                <col style="width: 12%;"> {{-- Personal --}}
                                <col style="width: 7rem;"> {{-- Imagen --}}
                                <col style="width: 8rem;"> {{-- Acciones --}}
                            </colgroup>

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Subnombre</th>
                                    <th>Descripcion</th>
                                    <th>Ubicacion</th>
                                    <th>Personal</th>
                                    <th>Imagen</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($items as $row)
                                    <tr>
                                        <td>{{ $row->id }}</td>
                                        <td class="text-muted fw-semibold">{{ $row->nombre_solo }}</td>
                                        <td class="text-muted">{{ $row->subnombre_solo }}</td>
                                        <td class="text-muted">{{ $row->descripcion }}</td>
                                        <td class="text-muted">{{ $row->ubicacion }}</td>
                                        <td class="text-muted">{{ $row->personal }}</td>
                                        <td class="text-center">
                                            <span class="img-thumb" data-src="{{ asset(ltrim($row->imagen, './')) }}"
                                                title="Ver imagen">
                                                <i class="fa-regular fa-image"></i>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-inline-flex gap-1 actions">
                                                <button class="btn btn-warning btn-sm text-white btn-edit"
                                                    data-id="{{ $row->id }}"
                                                    data-nombre="{{ $row->nombre_solo }}"
                                                    data-subnombre="{{ $row->subnombre_solo }}"
                                                    data-descripcion='@json($row->descripcion)'
                                                    data-ubicacion="{{ $row->ubicacion }}"
                                                    data-personal="{{ $row->personal }}"
                                                    data-active="{{ (int) $row->is_active }}" title="Editar">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm btn-delete" title="Eliminar"
                                                    data-bs-toggle="modal" data-bs-target="#modalEliminar"
                                                    data-delete-url="{{ route('servicios.destroy', $row) }}"
                                                    data-title="{{ $row->subnombre_solo ? $row->nombre_solo . ' — ' . $row->subnombre_solo : $row->nombre_solo }}">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">Sin registros.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>

    {{-- Modal Nuevo --}}
    <div class="modal fade" id="modalNuevo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('servicios.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#2563eb;">Nuevo Servicio</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Nombre *</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Subnombre</label>
                            <input type="text" name="subnombre" class="form-control">
                        </div>

                        <div class="col-12">
                            <label class="form-label" style="color:#2563eb;">Descripción *</label>
                            <textarea name="descripcion" rows="4" class="form-control" required></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Ubicación</label>
                            <input type="text" name="ubicacion" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Personal</label>
                            <input type="text" name="personal" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Imagen (JPG/PNG/WEBP)</label>
                            <input type="file" name="imagen" accept="image/*" class="form-control">
                        </div>

                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="nuevoActivo" name="is_active"
                                    value="1" checked>
                                <label class="form-check-label" for="nuevoActivo">Activo</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            type="button">Cancelar</button>
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
                    @csrf @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#2563eb;">Editar Servicio</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Nombre *</label>
                            <input type="text" id="eNombre" name="nombre" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Subnombre</label>
                            <input type="text" id="eSubnombre" name="subnombre" class="form-control">
                        </div>

                        <div class="col-12">
                            <label class="form-label" style="color:#2563eb;">Descripción *</label>
                            <textarea id="eDescripcion" name="descripcion" rows="4" class="form-control" required></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Ubicación</label>
                            <input type="text" id="eUbicacion" name="ubicacion" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Personal</label>
                            <input type="text" id="ePersonal" name="personal" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Reemplazar imagen</label>
                            <input type="file" name="imagen" accept="image/*" class="form-control">
                        </div>

                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="eActivo" name="is_active"
                                    value="1">
                                <label class="form-check-label" for="eActivo">Activo</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            type="button">Cancelar</button>
                        <button class="btn btn-primary" type="submit">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Imagen --}}
    <div class="modal fade" id="modalImg" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="btn btn-outline-primary btn-sm" id="openImgNewTab" href="#" target="_blank">
                        <i class="fa-solid fa-up-right-from-square me-1"></i> Abrir en pestaña nueva
                    </a>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-2 text-center">
                    <img id="imgPreview" src="" class="img-fluid rounded shadow-sm" alt="preview">
                </div>
            </div>
        </div>
    </div>

    {{-- Modal: Eliminar (nuevo) --}}
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
                        ¿Seguro que deseas eliminar <strong id="delTitulo">este servicio</strong>?
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

    @include('include.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/js/admin/servicios_complementario/gestionar/servicios_complementarios.js')
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
