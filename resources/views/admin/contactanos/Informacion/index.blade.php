{{-- resources/views/admin/contactanos/informacion/index.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contactanos</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/documentos.css') }}">
</head>

<body data-titulo="Registro de información sobre Contactanos" class="has-sidebar">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="card roles-card shadow-sm">
                <div class="card-body">

                    <div class="roles-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Registro de Contactanos</h5>
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <div class="btn-toolbar gap-2 me-2">
                                <!-- Exportar a Excel -->
                                <button class="btn btn-dark btn-pill btn-icon" title="Exportar a Excel" data-export-excel>
                                    <i class="fa-regular fa-file-excel me-2"></i> Excel
                                </button>
                                <!-- Exportar a PDF -->
                                <button class="btn btn-dark btn-pill btn-icon" title="Exportar a PDF" data-export-pdf>
                                    <i class="fa-regular fa-file-pdf me-2"></i> PDF
                                </button>
                            </div>
                            <!-- Buscador -->
                            <div class="search-wrap position-relative me-2">
                                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                                <input type="text" class="form-control form-control-sm search-input"
                                    placeholder="Buscar...">
                            </div>
                            <!-- Nuevo registro -->
                            <button class="btn btn-primary btn-new-role btn-pill btn-icon" data-bs-toggle="modal"
                                data-bs-target="#modalCrear">
                                <i class="fa-solid fa-plus me-2"></i> Nuevo registro
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
                        <table class="table table-bordered content-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Teléfono Principal</th>
                                    <th>WhatsApp</th>
                                    <th>Correo</th>
                                    <th>Teléfono Emergencias</th>
                                    <th>Dirección</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $row)
                                    <tr>
                                        <td>{{ $row->id }}</td>
                                        <td class="text-muted fw-semibold">{{ $row->telefono_principal }}</td>
                                        <td class="text-muted">{{ $row->whatsapp }}</td>
                                        <td class="text-muted">{{ $row->correo }}</td>
                                        <td class="text-muted">{{ $row->emergencia }}</td>
                                        <td class="text-muted">{{ $row->direccion }}</td>
                                        <td class="text-center">
                                            <div class="d-inline-flex gap-1">
                                                <button class="btn btn-warning btn-sm text-white btn-edit"
                                                    title="Editar" data-id="{{ $row->id }}"
                                                    data-telefono="{{ $row->telefono_principal }}"
                                                    data-whatsapp="{{ $row->whatsapp }}"
                                                    data-correo="{{ $row->correo }}"
                                                    data-emergencia="{{ $row->emergencia }}"
                                                    data-direccion="{{ $row->direccion }}"
                                                    data-active="{{ (int) $row->is_active }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>

                                                {{-- Botón que abre el modal de eliminar --}}
                                                <button class="btn btn-danger btn-sm btn-delete" title="Eliminar"
                                                    data-bs-toggle="modal" data-bs-target="#modalEliminar"
                                                    data-delete-url="{{ route('contactanos.destroy', $row) }}"
                                                    data-title="tel. {{ $row->telefono_principal }}">
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

    {{-- Modal CREAR --}}
    <div class="modal fade" id="modalCrear" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('contactanos.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#2563eb;">Nuevo contacto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label class="form-label" style="color:#2563eb;">Teléfono principal *</label>
                            <input type="text" name="telefono_principal" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" style="color:#2563eb;">WhatsApp *</label>
                            <input type="text" name="whatsapp" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" style="color:#2563eb;">Correo *</label>
                            <input type="email" name="correo" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" style="color:#2563eb;">Teléfono emergencias *</label>
                            <input type="text" name="emergencia" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" style="color:#2563eb;">Dirección *</label>
                            <input type="text" name="direccion" class="form-control" required>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="cActivo" name="is_active"
                                value="1" checked>
                            <label class="form-check-label" for="cActivo">Activo</label>
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

    {{-- Modal EDITAR --}}
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formEditar" method="POST" action="#">
                    @csrf @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#2563eb;">Editar contacto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label class="form-label" style="color:#2563eb;">Teléfono principal *</label>
                            <input type="text" id="eTelefono" name="telefono_principal" class="form-control"
                                required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" style="color:#2563eb;">WhatsApp *</label>
                            <input type="text" id="eWhatsapp" name="whatsapp" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" style="color:#2563eb;">Correo *</label>
                            <input type="email" id="eCorreo" name="correo" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" style="color:#2563eb;">Teléfono emergencias *</label>
                            <input type="text" id="eEmergencia" name="emergencia" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" style="color:#2563eb;">Dirección *</label>
                            <input type="text" id="eDireccion" name="direccion" class="form-control" required>
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

    {{-- Modal: Eliminar (mismo patrón que Reseña Histórica) --}}
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
    @vite('resources/js/admin/contactanos/informacion/contactanos.js')

    <!-- css de dark mode -->
    @vite('resources/css/darkmode.css')

    <!-- js de dark mode -->
    @vite('resources/js/darkmode.js')

</body>
</html>
