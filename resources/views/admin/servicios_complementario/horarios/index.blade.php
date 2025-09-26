{{-- resources/views/admin/servicios_complementario/horarios/index.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Servicios Complementarios - Horario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/documentos.css') }}">
    {{-- OJO: confirma el path correcto (servicios vs servicos) --}}
    <link rel="stylesheet" href="{{ asset('css/admin/servicos_complementarios/horarios/horarios.css') }}">
</head>

<body data-titulo="Listado de Horarios de Servicios Complementarios" class="has-sidebar">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="card roles-card shadow-sm">
                <div class="card-body">

                    {{-- Toolbar --}}
                    <div class="roles-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Registro de Horarios de Servicios Complementarios</h5>
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
                            <button class="btn btn-primary btn-new-role btn-pill btn-icon" data-bs-toggle="modal"
                                data-bs-target="#modalNuevo">
                                <i class="fa-solid fa-plus me-2"></i> Nuevo registro
                            </button>
                        </div>
                    </div>

                    {{-- flashes --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Tabla --}}
                    <div class="table-responsive">
                        <table class="table table-bordered content-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Servicio</th>
                                    <th>Lunes - Viernes</th>
                                    <th>Sabados</th>
                                    <th>Domingos</th>
                                    <th>Contactos</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $row)
                                    <tr>
                                        <td>{{ $row->id }}</td>
                                        <td class="text-muted fw-semibold">{{ $row->servicio->nombre ?? '—' }}</td>
                                        <td class="text-muted">{{ $row->lunes_viernes }}</td>
                                        <td class="text-muted">{{ $row->sabados }}</td>
                                        <td class="text-muted">{{ $row->domingos }}</td>
                                        <td class="text-muted">{{ $row->contacto ?: '—' }}</td>
                                        <td class="text-center">
                                            <div class="d-inline-flex gap-1">
                                                <button class="btn btn-warning btn-sm text-white btn-edit"
                                                    data-id="{{ $row->id }}"
                                                    data-servicio="{{ $row->servicio_complementario_id }}"
                                                    data-lv="{{ $row->lunes_viernes }}" data-sab="{{ $row->sabados }}"
                                                    data-dom="{{ $row->domingos }}"
                                                    data-contacto="{{ $row->contacto }}"
                                                    data-active="{{ (int) $row->is_active }}" title="Editar">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>

                                                {{-- Botón que abre el modal de eliminar --}}
                                                <button class="btn btn-danger btn-sm btn-delete" title="Eliminar"
                                                    data-bs-toggle="modal" data-bs-target="#modalEliminar"
                                                    data-delete-url="{{ route('horario.destroy', $row) }}"
                                                    data-title="{{ $row->servicio->nombre ?? 'Horario #' . $row->id }}">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Sin registros.</td>
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
                <form action="{{ route('horario.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#2563eb;">Nuevo horario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label" style="color:#2563eb;">Servicio *</label>
                            <select name="servicio_complementario_id" class="form-select" required>
                                <option value="" hidden>Seleccione…</option>
                                @foreach ($servicios as $s)
                                    <option value="{{ $s->id }}">{{ $s->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="color:#2563eb;">Lunes - Viernes *</label>
                            <input type="text" name="lunes_viernes" class="form-control"
                                placeholder="7:30 AM - 5:00 PM" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="color:#2563eb;">Sábados *</label>
                            <input type="text" name="sabados" class="form-control" placeholder="8:00 AM - 12:00 PM"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="color:#2563eb;">Domingos *</label>
                            <input type="text" name="domingos" class="form-control"
                                placeholder="Cerrado / Horario" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="color:#2563eb;">Contacto</label>
                            <input type="text" name="contacto" class="form-control" placeholder="Ext. 101">
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="nActivo" name="is_active"
                                value="1" checked>
                            <label class="form-check-label" for="nActivo">Activo</label>
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
                <form id="formEditar" action="#" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#2563eb;">Editar horario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label" style="color:#2563eb;">Servicio *</label>
                            <select id="eServicio" name="servicio_complementario_id" class="form-select" required>
                                @foreach ($servicios as $s)
                                    <option value="{{ $s->id }}">{{ $s->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="color:#2563eb;">Lunes - Viernes *</label>
                            <input id="eLV" type="text" name="lunes_viernes" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color:#2563eb;">Sábados *</label>
                            <input id="eSab" type="text" name="sabados" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color:#2563eb;">Domingos *</label>
                            <input id="eDom" type="text" name="domingos" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color:#2563eb;">Contacto</label>
                            <input id="eContacto" type="text" name="contacto" class="form-control">
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="eActivo" name="is_active"
                                value="1">
                            <label class="form-check-label" for="eActivo">Activo</label>
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

    {{-- Modal: Eliminar (igual al de Reseña Histórica) --}}
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
                        ¿Seguro que deseas eliminar <strong id="delTitulo">este registro</strong>?
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
    @vite('resources/js/admin/servicios_complementario/horarios/horarios_servicios.js')
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
