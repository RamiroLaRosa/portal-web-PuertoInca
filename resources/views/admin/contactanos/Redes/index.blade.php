{{-- resources/views/admin/contactanos/Redes/index.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Redes Sociales</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/documentos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/contactanos/redes/redes.css') }}">

    @php
        // Catálogo visible (label) => valor guardado (clase FA)
        $ICON_OPTIONS = [
            'Facebook' => 'fa-brands fa-facebook-f',
            'Instagram' => 'fa-brands fa-instagram',
            'YouTube' => 'fa-brands fa-youtube',
            'X (Twitter)' => 'fa-brands fa-x-twitter',
            'LinkedIn' => 'fa-brands fa-linkedin-in',
            'WhatsApp' => 'fa-brands fa-whatsapp',
            'TikTok' => 'fa-brands fa-tiktok',
            'Telegram' => 'fa-brands fa-telegram',
            'Sitio web' => 'fa-solid fa-globe',
            'Email' => 'fa-solid fa-envelope',
        ];
        $ICON_LABELS = array_flip($ICON_OPTIONS); // valor => label (por si quieres mostrar el nombre)
    @endphp

    <style>
        .actions .btn-icon {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .truncate-url {
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        @media(min-width:992px) {
            .truncate-url {
                max-width: 680px
            }
        }

        @media(max-width:991.98px) {
            .truncate-url {
                max-width: 320px
            }
        }
    </style>
</head>

<body data-titulo="Registro de información sobre Redes Sociales" class="has-sidebar">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="card roles-card shadow-sm">
                <div class="card-body">

                    {{-- Toolbar --}}
                    <div class="roles-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Registro de Redes Sociales</h5>
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
                                    placeholder="Buscar…">
                            </div>
                            <button class="btn btn-primary btn-new-role btn-pill btn-icon" data-bs-toggle="modal"
                                data-bs-target="#modalNuevo">
                                <i class="fa-solid fa-plus me-2"></i> Nuevo registro
                            </button>
                        </div>
                    </div>

                    {{-- Flashes --}}
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

                    {{-- Tabla --}}
                    <div class="table-responsive">
                        <table class="table table-bordered content-table redes-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Enlace</th>
                                    <th>Icono</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $row)
                                    <tr data-row-id="{{ $row->id }}">
                                        <td>{{ $row->id }}</td>
                                        <td class="text-muted fw-semibold">{{ $row->nombre }}</td>
                                        <td class="text-muted">
                                            <div class="truncate-url" title="{{ $row->enlace }}">
                                                <a href="{{ $row->enlace }}" target="_blank"
                                                    rel="noopener">{{ $row->enlace }}</a>
                                            </div>
                                        </td>
                                        <td class="text-muted fw-semibold">
                                            <i class="{{ $row->icono }}"></i>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-inline-flex gap-1">
                                                <button class="btn btn-warning btn-sm text-white btn-icon btn-edit"
                                                    title="Editar" data-id="{{ $row->id }}"
                                                    data-nombre="{{ $row->nombre }}"
                                                    data-enlace="{{ $row->enlace }}" data-icono="{{ $row->icono }}"
                                                    data-edit-url="{{ route('redes.update', $row) }}"
                                                    data-active="{{ (int) $row->is_active }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>

                                                <button class="btn btn-danger btn-sm btn-icon btn-delete"
                                                    title="Eliminar" data-bs-toggle="modal"
                                                    data-bs-target="#modalEliminar"
                                                    data-delete-url="{{ route('redes.destroy', $row) }}"
                                                    data-title="{{ $row->nombre }}">
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
    </main>

    {{-- Modal: Nuevo (centrado) --}}
    <div class="modal fade" id="modalNuevo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('redes.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#2563eb;">Nuevo registro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" style="color:#2563eb;">Nombre *</label>
                            <input type="text" name="nombre" class="form-control" required maxlength="100">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color:#2563eb;">Enlace (URL) *</label>
                            <input type="url" name="enlace" class="form-control" placeholder="https://…"
                                required maxlength="255">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color:#2563eb;">Icono *</label>
                            <div class="d-flex gap-2">
                                <select name="icono" id="nIcono" class="form-select" required>
                                    @foreach ($ICON_OPTIONS as $label => $value)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                <span class="btn btn-light px-3" title="Vista previa">
                                    <i id="iconPreviewNew" class="{{ reset($ICON_OPTIONS) }}"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="nuevoActivo" name="is_active"
                                value="1" checked>
                            <label class="form-check-label" for="nuevoActivo">Activo</label>
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

    {{-- Modal: Editar (centrado) --}}
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formEditar" action="#" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#2563eb;">Editar registro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" style="color:#2563eb;">Nombre *</label>
                            <input type="text" id="eNombre" name="nombre" class="form-control" required
                                maxlength="100">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color:#2563eb;">Enlace (URL) *</label>
                            <input type="url" id="eEnlace" name="enlace" class="form-control" required
                                maxlength="255">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color:#2563eb;">Icono *</label>
                            <div class="d-flex gap-2">
                                <select id="eIcono" name="icono" class="form-select" required>
                                    @foreach ($ICON_OPTIONS as $label => $value)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                <span class="btn btn-light px-3" title="Vista previa">
                                    <i id="iconPreviewEdit"></i>
                                </span>
                            </div>
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

    {{-- Modal: Eliminar --}}
    <div class="modal fade" id="modalEliminar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formEliminar" action="#" method="POST">
                    @csrf @method('DELETE')
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

    {{-- utilidades (si las usas) --}}
    @vite('resources/js/titulo.js')
    @vite('resources/js/pagination.js')
    @vite('resources/js/search.js')
    @vite('resources/js/exportarPDF.js')
    @vite('resources/js/exportarEXCEL.js')

    {{-- JS de esta página --}}
    @vite('resources/js/admin/contactanos/redes/redes.js')

    @vite('resources/css/darkmode.css')
    @vite('resources/js/darkmode.js')
</body>

</html>
