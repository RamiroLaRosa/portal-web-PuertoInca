<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registro de Estadísticas</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/estadisticas.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/transparencia/estadisticas/estadisticas.css') }}">
</head>

<body class="has-sidebar">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="row g-3">

                {{-- ========= FORM SUPERIOR ========= --}}
                <div class="col-xxl-7">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h4 class="mb-3 fw-bold">Registro De Estadísticas</h4>
                            <hr class="mt-0 mb-4">

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form class="row g-4" action="{{ route('estadistica.store') }}" method="POST" novalidate>
                                @csrf
                                <div class="col-md-6">
                                    <label class="form-label">Seleccione una tabla estadística</label>
                                    <select name="tema_estadistico_id" id="temaSup" class="form-select" required>
                                        <option value="" selected hidden>Seleccione opción</option>
                                        @foreach ($temas as $t)
                                            <option value="{{ $t->id }}">{{ $t->tema }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Seleccione un programa de estudio</label>
                                    <select name="programa_estudio_id" id="programaSup" class="form-select" required>
                                        <option value="" selected hidden>Seleccione opción</option>
                                        @foreach ($programas as $p)
                                            <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Seleccione un año</label>
                                    <select name="anio_estadistico_id" id="anioSup" class="form-select" required>
                                        <option value="" selected hidden>Seleccione opción</option>
                                        @foreach ($anios as $a)
                                            <option value="{{ $a->id }}">{{ $a->anio }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Ingrese la cantidad</label>
                                    <input type="number" min="0" name="cantidad" class="form-control"
                                        placeholder="0" required>
                                </div>

                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="supActivo" name="is_active"
                                            value="1" checked>
                                        <label class="form-check-label" for="supActivo">Activo</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-teal btn-pill" type="submit">
                                        + Nuevo Registro o Actualización
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- ========= GRAFICO ========= --}}
                <div class="col-xxl-5">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="mb-3 fw-semibold">Vista gráfica</h6>
                            <div class="chart-wrap">
                                <canvas id="chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ========= TABLA INFERIOR ========= --}}
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-end justify-content-between flex-wrap gap-2">
                                <div style="max-width: 420px;" class="w-100">
                                    <label class="form-label mb-1">Seleccione una tabla estadística</label>
                                    <select id="temaInf" class="form-select">
                                        <option value="" selected hidden>Seleccione opción</option>
                                        @foreach ($temas as $t)
                                            <option value="{{ $t->id }}">{{ $t->tema }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <div class="btn-toolbar gap-2 me-2">
                                        <button type="button" class="btn btn-dark btn-pill btn-icon">Excel</button>
                                        <button type="button" class="btn btn-dark btn-pill btn-icon">PDF</button>
                                        <button type="button" class="btn btn-dark btn-pill btn-icon">Print</button>
                                    </div>
                                    <div class="position-relative">
                                        <i class="fa-solid fa-magnifying-glass position-absolute"
                                            style="left:10px;top:50%;transform:translateY(-50%);opacity:.5"></i>
                                        <input id="buscarProg" type="text" class="form-control form-control-sm ps-4"
                                            placeholder="Buscar…">
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive mt-3">
                                <table class="table table-bordered content-table" id="gridTabla">
                                    <thead id="theadAnios">
                                        <tr>
                                            <th>Programa de Estudio</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyGrid">
                                        <tr class="empty-row">
                                            <td>La tabla está vacía.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    {{-- ========= MODAL EDITAR ========= --}}
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEditar" method="POST" action="#">
                    @csrf @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#2563eb;">Editar cantidad</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editId">
                        <div class="mb-3">
                            <label class="form-label" style="color:#2563eb;">Cantidad</label>
                            <input type="number" min="0" name="cantidad" id="editCantidad"
                                class="form-control" required>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="editActivo" name="is_active"
                                value="1" checked>
                            <label class="form-check-label" for="editActivo">Activo</label>
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

    {{-- ========= MODAL ELIMINAR ========= --}}
    <div class="modal fade" id="modalEliminar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEliminar" method="POST" action="#">
                    @csrf @method('DELETE')
                    <input type="hidden" id="delId" name="id">
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#2563eb;">Eliminar registro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="color:#2563eb;">
                        ¿Seguro que deseas eliminar este registro?
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

    @include('include.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        window.ESTADISTICA_GRID_URL = '{{ route('estadistica.grid') }}';
        window.YEARS = @json($anios);
        window.yearsFull = @json($anios);
    </script>
    @vite('resources/js/admin/transparencia/estadistica/estadisticas.js')
    @vite('resources/css/darkmode.css')
    @vite('resources/js/darkmode.js')
</body>

</html>
