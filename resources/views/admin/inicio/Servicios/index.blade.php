<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nuestros Servicios</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/roles.css') }}">
</head>

<body data-titulo="Registro de información sobre Nuestros Servicios" class="has-sidebar">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="card roles-card shadow-sm">
                <div class="card-body">
                    <div class="roles-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Registro de información sobre Nuestros Servicios</h5>
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <div class="btn-toolbar gap-2 me-2">
                                <button class="btn btn-dark btn-pill btn-icon" title="Exportar a Excel" data-export-excel>
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
                                title="Nuevo servicio" data-bs-toggle="modal" data-bs-target="#modalNuevoServicio">
                                <i class="fa-solid fa-plus me-2"></i> Nuevo servicio
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

                    <!-- Tabla -->
                    <div class="table-responsive">
                        <table class="table table-bordered content-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Icono</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($servicios as $s)
                                    <tr>
                                        <td>{{ $s->id }}</td>
                                        <td class="text-muted fw-semibold">{{ $s->nombre }}</td>
                                        <td class="text-muted">{{ $s->descripcion }}</td>
                                        <td class="text-muted"><i class="{{ $s->icono }}"></i></td>
                                        <td class="text-center">
                                            <div class="d-inline-flex gap-1">
                                                <button type="button"
                                                    class="btn btn-warning btn-sm text-white btn-edit-servicio"
                                                    title="Editar" data-id="{{ $s->id }}"
                                                    data-nombre="{{ $s->nombre }}"
                                                    data-descripcion="{{ $s->descripcion }}"
                                                    data-icono="{{ $s->icono }}"
                                                    data-active="{{ (int) $s->is_active }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm btn-delete-servicio"
                                                    title="Eliminar" data-id="{{ $s->id }}"
                                                    data-nombre="{{ $s->nombre }}">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </div>
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

        <!-- Modal: Nuevo Servicio -->
        <div class="modal fade" id="modalNuevoServicio" tabindex="-1" aria-labelledby="modalNuevoServicioLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('servicios-inicio.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_from" value="create">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalNuevoServicioLabel" style="color:#2563eb;">Nuevo servicio</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Nombre <span class="text-danger">*</span></label>
                                <input type="text" name="nombre" value="{{ old('nombre') }}"
                                    class="form-control @error('nombre') is-invalid @enderror"
                                    placeholder="Ej. Biblioteca Digital" required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Descripción <span class="text-danger">*</span></label>
                                <textarea name="descripcion" rows="3" class="form-control @error('descripcion') is-invalid @enderror"
                                    placeholder="Describe el servicio..." required>{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label d-block" style="color:#2563eb;">Ícono <span class="text-danger">*</span></label>
                                <div class="d-flex align-items-center gap-3">
                                    <select id="iconoSelect" name="icono"
                                        class="form-select w-auto @error('icono') is-invalid @enderror" required>
                                        <option value="" disabled {{ old('icono') ? '' : 'selected' }}>
                                            Selecciona un ícono</option>
                                        @foreach ($icons as $value => $label)
                                            <option value="{{ $value }}"
                                                {{ old('icono') === $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span id="iconPreview" class="fs-3">
                                        @if (old('icono'))
                                            <i class="{{ old('icono') }}"></i>
                                        @endif
                                    </span>
                                </div>
                                @error('icono')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="isActiveSwitch" name="is_active"
                                    value="1" {{ old('is_active') ? 'checked' : '' }}>
                                <label class="form-check-label" for="isActiveSwitch">Activo</label>
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

        <!-- Modal: Editar servicio -->
        <div class="modal fade" id="modalEditarServicio" tabindex="-1" aria-labelledby="modalEditarServicioLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="formEditarServicio" action="#" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditarServicioLabel" style="color:#2563eb;">Editar servicio</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Nombre <span class="text-danger">*</span></label>
                                <input type="text" name="nombre" id="editNombre" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="color:#2563eb;">Descripción <span class="text-danger">*</span></label>
                                <textarea name="descripcion" id="editDescripcion" rows="3" class="form-control" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label d-block" style="color:#2563eb;">Ícono <span class="text-danger">*</span></label>
                                <div class="d-flex align-items-center gap-3">
                                    <select id="iconoEditSelect" name="icono" class="form-select w-auto" required>
                                        @foreach ($icons as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <span id="iconoEditPreview" class="fs-3"></span>
                                </div>
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

        <!-- Modal: Eliminar servicio -->
        <div class="modal fade" id="modalEliminarServicio" tabindex="-1"
            aria-labelledby="modalEliminarServicioLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="formDeleteServicio" action="#" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEliminarServicioLabel" style="color:#2563eb;">Eliminar servicio</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body" style="color:#2563eb;">
                            ¿Seguro que deseas eliminar el servicio <strong id="delServicioNombre">—</strong>?
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

    <script>
        window.serviciosEditUrlBase = "{{ url('/admin/inicio/servicios') }}";
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
    @vite(['resources/js/admin/inicio/servicios/servicios.js'])

    <!-- css de dark mode -->
    @vite('resources/css/darkmode.css')

    <!-- js de dark mode -->
    @vite('resources/js/darkmode.js')

    <br>
    @include('include.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
