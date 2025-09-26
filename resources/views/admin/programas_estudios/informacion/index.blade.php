<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Información de los Programas</title>

    <!-- Estilos base -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/docente.css') }}">
    <link rel="icon" type="image/png"
        href="{{ asset('css/admin/programas_estudios/informacion/informacion.css') }}" />

</head>

<body data-no-photo="{{ asset('images/no-photo.jpg') }}" data-base-url="{{ url('/admin/programas/informacion') }}"
    data-titulo="Listado de Información de Programas de Estudio" class="has-sidebar">

    @include('include.preloader')
    @include('include.header')

    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="card roles-card shadow-sm">
                <div class="card-body">
                    <!-- Barra de herramientas -->
                    <div class="roles-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Información de Programas de Estudio</h5>
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-flex gap-2 me-2">

                                <!-- Botón de exportación a Excel -->
                                <button class="btn btn-dark btn-pill btn-icon" title="Exportar a Excel"
                                    data-export-excel>
                                    <i class="fa-regular fa-file-excel me-2"></i> Excel
                                </button>
                                <button class="btn btn-dark btn-pill btn-icon" title="Exportar a PDF" data-export-pdf>
                                    <i class="fa-regular fa-file-pdf me-2"></i> PDF
                                </button>
                            </div>

                            <select id="programSelect" class="form-select" style="min-width:280px;">
                                <option value="" selected>Seleccione un programa de estudio</option>
                                @foreach ($programas as $p)
                                    <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                @endforeach
                            </select>

                            <div class="search-wrap position-relative me-2">
                                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                                <input type="text" class="form-control form-control-sm search-input"
                                    placeholder="Buscar...">
                            </div>

                            <button id="btnNuevo" class="btn btn-primary btn-pill btn-icon" type="button">
                                + Nuevo Registro
                            </button>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Cerrar"></button>
                        </div>
                    @endif

                    <!-- Tabla -->
                    <div class="table-responsive">
                        <table class="table table-bordered content-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width:60px">#</th>
                                    <th>Duración</th>
                                    <th>Modalidad</th>
                                    <th>Turno</th>
                                    <th>Horario</th>
                                    <th style="width:140px">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="empty-row">
                                    <td colspan="6" class="text-center text-muted">
                                        Seleccione un programa de estudio para listar
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <br>
    @include('include.footer')

    {{-- Ver imagen --}}
    <div class="modal fade" id="modalVerImagen" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="imgTitle" class="modal-title" style="color:#2563eb;">Imagen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body p-0">
                    <img id="imgPreview" src="" alt="Imagen" class="img-fluid w-100" style="display:block;">
                </div>
            </div>
        </div>
    </div>

    {{-- Nuevo --}}
    <div class="modal fade" id="modalNuevo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formNuevo" onsubmit="return false;">
                    @csrf
                    <input type="hidden" name="_from" value="create">

                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#2563eb;">Nuevo registro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-2">
                            <label class="form-label" style="color:#2563eb;">Programa de estudio <span
                                    class="text-danger">*</span></label>
                            <select id="cPrograma" name="programa_id" class="form-select" required>
                                <option value="">Seleccione</option>
                                @foreach ($programas as $p)
                                    <option value="{{ $p->id }}"
                                        {{ old('programa_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('programa_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label" style="color:#2563eb;">Duración <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="duracion" value="{{ old('duracion') }}" class="form-control"
                                required>
                            @error('duracion')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label" style="color:#2563eb;">Modalidad <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="modalidad" value="{{ old('modalidad') }}"
                                class="form-control" required>
                            @error('modalidad')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label" style="color:#2563eb;">Turno <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="turno" value="{{ old('turno') }}" class="form-control"
                                required>
                            @error('turno')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label" style="color:#2563eb;">Horario <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="horario" value="{{ old('horario') }}" class="form-control"
                                required>
                            @error('horario')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="cActive" name="is_active"
                                value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                            <label class="form-check-label" for="cActive">Activo</label>
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

    {{-- Editar --}}
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formEditar" action="#" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#2563eb;">Editar Información</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-2">
                            <label class="form-label" style="color:#2563eb;">Duración</label>
                            <input type="text" name="duracion" id="eDuracion" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" style="color:#2563eb;">Modalidad</label>
                            <input type="text" name="modalidad" id="eModalidad" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" style="color:#2563eb;">Turno</label>
                            <input type="text" name="turno" id="eTurno" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" style="color:#2563eb;">Horario</label>
                            <input type="text" name="horario" id="eHorario" class="form-control" required>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="eActive" name="is_active"
                                value="1">
                            <label class="form-check-label" for="eActive">Activo</label>
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

    {{-- Eliminar --}}
    <div class="modal fade" id="modalEliminar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formEliminar" action="#" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#2563eb;">Eliminar registro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body" style="color:#2563eb;">
                        ¿Seguro que deseas eliminar este registro?
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

    <!-- Reabrir modal nuevo ante errores de validación -->
    @if ($errors->any() && old('_from') === 'create')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const m = new bootstrap.Modal(document.getElementById('modalNuevo'));
                m.show();
            });
        </script>
    @endif


    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                let msg = `{!! implode('<br>', $errors->all()) !!}`;
                let toast = document.createElement('div');
                toast.className = 'toast align-items-center text-bg-danger border-0 show custom-toast-pos';
                toast.role = 'alert';
                toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${msg}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 5000);
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                let msg = `{!! session('success') !!}`;
                let toast = document.createElement('div');
                toast.className = 'toast align-items-center text-bg-success border-0 show custom-toast-pos';
                toast.role = 'alert';
                toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${msg}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 4000);
            });
        </script>
    @endif

    <style>
        .custom-toast-pos {
            position: fixed !important;
            right: 2.5rem;
            bottom: 2.5rem;
            z-index: 1080;
            min-width: 320px;
            max-width: 90vw;
        }
    </style>







    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @vite(['resources/js/admin/programas_estudios/informacion/informacion.js'])

    @vite('resources/css/content.css')

    @vite('resources/js/titulo.js')
    @vite('resources/js/pagination.js')
    @vite('resources/js/search.js')
    @vite('resources/js/exportarPDF.js')
    @vite('resources/js/exportarEXCEL.js')
    @vite('resources/js/darkmode.js')
    @vite('resources/css/content.css')
    @vite('resources/css/darkmode.css')

</body>

</html>
