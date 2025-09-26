<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administradores</title>

    <!-- CDNs (opcional, solo para estilos base y dropdown)    <!-- JS de Bootstrap (solo para el dropdown de "Seleccionar celdas") -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/admin/seguridad/administradores/administradores.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/administradores.css') }}">
</head>

<body data-titulo="Listado de administradores" class="has-sidebar">
    @include('include.preloader')
    @include('include.header')

    <aside class="sidebar-fixed">
        @include('include.sidebar')
    </aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">

            <div class="card administradores-card shadow-sm">

                <div class="card-body">

                    <!-- Barra de herramientas + buscador -->
                    <div
                        class="administradores-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Gestión de los administradores del sistema</h5>

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

                            <!-- Botón de búsqueda -->
                            <div class="search-wrap position-relative me-2">
                                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                                <input type="text" class="form-control form-control-sm search-input"
                                    placeholder="Buscar...">
                            </div>

                            <button class="btn btn-primary btn-new-administrador btn-pill btn-icon" type="button"
                                title="Nuevo administrador" data-bs-toggle="modal"
                                data-bs-target="#modalNuevoAdministrador">
                                <i class="fa-solid fa-plus me-2"></i> Nuevo administrador
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
                                    <th>Tip. Documento</th>
                                    <th>Nro. Documento</th>
                                    <th>Apellidos</th>
                                    <th>Nombres</th>
                                    <th>Rol</th>
                                    <th>Correo</th>
                                    <th>Celular</th>
                                    <th>Activo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($administradores as $administrador)
                                    <tr>
                                        <td>{{ $administrador->id }}</td>
                                        <td class="text-muted fw-semibold">
                                            {{ $administrador->tipo_documento->nombre_corto }}</td>
                                        <td class="text-muted fw-semibold">{{ $administrador->codigo }}</td>
                                        <td class="text-muted">{{ $administrador->apellidos }}</td>
                                        <td class="text-muted">{{ $administrador->nombres }}</td>
                                        <td class="text-muted">{{ $administrador->rol->nombre }}</td>
                                        <td class="text-muted">{{ $administrador->correo }}</td>
                                        <td class="text-muted">{{ $administrador->celular }}</td>
                                        <td>
                                            @if ($administrador->is_active)
                                                <span class="badge bg-success">Activo</span>
                                            @else
                                                <span class="badge bg-danger">Inactivo</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-inline-flex gap-1">
                                                <a href="#"
                                                    class="btn btn-warning btn-sm text-white btn-edit-administrador"
                                                    title="Editar" data-id="{{ $administrador->id }}"
                                                    data-codigo="{{ $administrador->codigo }}"
                                                    data-apellidos="{{ $administrador->apellidos }}"
                                                    data-nombres="{{ $administrador->nombres }}"
                                                    data-correo="{{ $administrador->correo }}"
                                                    data-celular="{{ $administrador->celular }}"
                                                    data-id_rol="{{ $administrador->rol->id }}"
                                                    data-id_tipo_documento="{{ $administrador->tipo_documento->id }}"
                                                    data-is_active="{{ $administrador->is_active }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                                <button type="button"
                                                    class="btn btn-secondary btn-sm btn-password-administrador"
                                                    title="Cambiar contraseña" data-id="{{ $administrador->id }}"
                                                    data-name="{{ $administrador->apellidos }}, {{ $administrador->nombres }}">
                                                    <i class="fa-solid fa-key"></i>
                                                </button>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm btn-delete-administrador"
                                                    title="Eliminar" data-id="{{ $administrador->id }}"
                                                    data-name="{{ $administrador->apellidos }}, {{ $administrador->nombres }}">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No hay administradores
                                            registrados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal: Nuevo Administrador -->
        <div class="modal fade" id="modalNuevoAdministrador" tabindex="-1"
            aria-labelledby="modalNuevoAdministradorLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('administradores.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalNuevoAdministradorLabel" style="color:#2563eb;">Nuevo
                                administrador</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>

                        <div class="modal-body">

                            <div class="mb-3">
                                <label for="administradorTipoDocumento" class="form-label"
                                    style="color:#2563eb;">Tipo
                                    de Documento</label>
                                <select id="administradorTipoDocumento" name="id_documento"
                                    class="form-select @error('id_documento') is-invalid @enderror">
                                    <option value="">Seleccione un tipo de documento</option>
                                    @foreach ($tipos_documentos as $td)
                                        <option value="{{ $td->id }}"
                                            {{ old('id_documento') == $td->id ? 'selected' : '' }}>
                                            {{ $td->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_documento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="administradorCodigo" class="form-label"
                                    style="color:#2563eb;">Codigo</label>
                                <input type="text" id="administradorCodigo" name="codigo"
                                    value="{{ old('codigo') }}"
                                    class="form-control @error('codigo') is-invalid @enderror" placeholder="">
                                @error('codigo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="administradorApellidos" class="form-label"
                                    style="color:#2563eb;">Apellidos</label>
                                <input type="text" id="administradorApellidos" name="apellidos"
                                    value="{{ old('apellidos') }}"
                                    class="form-control @error('apellidos') is-invalid @enderror" placeholder="">
                                @error('apellidos')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="administradorNombres" class="form-label"
                                    style="color:#2563eb;">Nombres</label>
                                <input type="text" id="administradorNombres" name="nombres"
                                    value="{{ old('nombres') }}"
                                    class="form-control @error('nombres') is-invalid @enderror" placeholder="">
                                @error('nombres')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="administradorCorreo" class="form-label"
                                    style="color:#2563eb;">Correo</label>
                                <input type="text" id="administradorCorreo" name="correo"
                                    value="{{ old('correo') }}"
                                    class="form-control @error('correo') is-invalid @enderror" placeholder="">
                                @error('correo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="administradorPassword" class="form-label"
                                    style="color:#2563eb;">Contraseña <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" id="administradorPassword" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Ingrese una contraseña" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="administradorCelular" class="form-label"
                                    style="color:#2563eb;">Celular</label>
                                <input type="text" id="administradorCelular" name="celular"
                                    value="{{ old('celular') }}"
                                    class="form-control @error('celular') is-invalid @enderror" placeholder="">
                                @error('celular')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="administradorRol" class="form-label" style="color:#2563eb;">Rol</label>
                                <select id="administradorRol" name="rol_id"
                                    class="form-select @error('rol_id') is-invalid @enderror">
                                    <option value="">Seleccione un rol</option>
                                    @foreach ($roles as $rol)
                                        <option value="{{ $rol->id }}"
                                            {{ old('rol_id') == $rol->id ? 'selected' : '' }}>
                                            {{ $rol->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('rol_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="administradorIsActive" class="form-label"
                                    style="color:#2563eb;">Estado</label>
                                <select id="administradorIsActive" name="is_active"
                                    class="form-select @error('is_active') is-invalid @enderror">
                                    <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Activo
                                    </option>
                                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactivo
                                    </option>
                                </select>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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

        <!-- Modal: Editar Administrador -->
        <div class="modal fade" id="modalEditarAdministrador" tabindex="-1"
            aria-labelledby="modalEditarAdministradorLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="formEditarAdministrador" action="#" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditarAdministradorLabel" style="color:#2563eb;">Editar
                                administrador</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>

                        <div class="modal-body">

                            <div class="mb-3">
                                <label for="editAdministradorTipoDocumento" class="form-label"
                                    style="color:#2563eb;">Tipo de Documento</label>
                                <select id="editAdministradorTipoDocumento" name="id_documento" class="form-select">
                                    <option value="">Seleccione un tipo de documento</option>
                                    @foreach ($tipos_documentos as $td)
                                        <option value="{{ $td->id }}">{{ $td->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="editAdministradorCodigo" class="form-label" style="color:#2563eb;">Codigo
                                    <span class="text-danger">*</span></label>
                                <input type="text" id="editAdministradorCodigo" name="codigo"
                                    class="form-control" placeholder="">
                            </div>
                            <div class="mb-3">
                                <label for="editAdministradorApellidos" class="form-label"
                                    style="color:#2563eb;">Apellidos
                                    <span class="text-danger">*</span></label>
                                <input type="text" id="editAdministradorApellidos" name="apellidos"
                                    class="form-control" placeholder="">
                            </div>
                            <div class="mb-3">
                                <label for="editAdministradorNombres" class="form-label"
                                    style="color:#2563eb;">Nombres
                                    <span class="text-danger">*</span></label>
                                <input type="text" id="editAdministradorNombres" name="nombres"
                                    class="form-control" placeholder="">
                            </div>
                            <div class="mb-3">
                                <label for="editAdministradorCorreo" class="form-label" style="color:#2563eb;">Correo
                                    <span class="text-danger">*</span></label>
                                <input type="text" id="editAdministradorCorreo" name="correo"
                                    class="form-control" placeholder="">
                            </div>
                            <div class="mb-3">
                                <label for="editAdministradorCelular" class="form-label"
                                    style="color:#2563eb;">Celular
                                    <span class="text-danger">*</span></label>
                                <input type="text" id="editAdministradorCelular" name="celular"
                                    class="form-control" placeholder="">
                            </div>

                            <div class="mb-3">
                                <label for="editAdministradorRol" class="form-label"
                                    style="color:#2563eb;">Rol</label>
                                <select id="editAdministradorRol" name="rol_id" class="form-select">
                                    <option value="">Seleccione un rol</option>
                                    @foreach ($roles as $rol)
                                        <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="editAdministradorIsActive" class="form-label"
                                    style="color:#2563eb;">Estado</label>
                                <select id="editAdministradorIsActive" name="is_active" class="form-select">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
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

        <!-- Modal: Cambiar contraseña -->
        <div class="modal fade" id="modalPasswordAdministrador" tabindex="-1"
            aria-labelledby="modalPasswordAdministradorLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="formPasswordAdministrador" action="#" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalPasswordAdministradorLabel" style="color:#2563eb;">
                                Cambiar contraseña
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-2" style="color:#2563eb;">
                                Cambiar contraseña para <strong id="passwordAdministradorName">—</strong>
                            </p>
                            <div class="mb-3">
                                <label for="passwordAdministradorNew" class="form-label" style="color:#2563eb;">Nueva
                                    contraseña <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" id="passwordAdministradorNew" name="password"
                                        class="form-control" placeholder="Ingrese nueva contraseña" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePasswordNew">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Actualizar contraseña</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <!-- Modal: Confirmar Eliminación -->
        <div class="modal fade" id="modalEliminarAdministrador" tabindex="-1"
            aria-labelledby="modalEliminarAdministradorLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="deleteAdministradorForm" action="#" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEliminarAdministradorLabel" style="color:#2563eb;">
                                Eliminar administrador
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>

                        <div class="modal-body">
                            <p class="mb-0" style="color:#2563eb;">
                                ¿Seguro que deseas eliminar el administrador <strong
                                    id="deleteAdministradorName">—</strong>?
                            </p>
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

    <br>
    @include('include.footer')

    {{-- Reabrir modal de "Nuevo administrador" si hubo errores al crear --}}
    @if ($errors->any() && old('_from') === 'create')
        <!-- Eliminado script embebido, ahora gestionado en administradores.js -->
    @endif

    {{-- Script SIEMPRE activo para abrir modal de edición --}}
    <!-- Eliminado <script src="/js/web/main.js"></script> si la lógica fue extraída -->

    <!-- JS de Bootstrap (solo para el dropdown de “Seleccionar celdas”) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <!-- js de título -->
    @vite('resources/js/titulo.js')

    <!-- js general -->
    @vite('resources/js/admin/seguridad/administradores/administradores.js')

    <!-- js de paginación -->
    @vite('resources/js/pagination.js')

    <!-- js de búsqueda -->
    @vite('resources/js/search.js')

    <!-- js de exportación a PDF -->
    @vite('resources/js/exportarPDF.js')

    <!-- js de exportación a Excel -->
    @vite('resources/js/exportarEXCEL.js')

    <!-- css de dark mode -->
    @vite('resources/css/darkmode.css')

    <!-- js de dark mode -->
    @vite('resources/js/darkmode.js')



</body>


</html>
