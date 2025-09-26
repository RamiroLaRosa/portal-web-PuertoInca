<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reclamos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/documentos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/transparencia/libro/reclamos.css') }}">
    <style>
        /* Fijar layout para que respete anchos */
        .content-table {
            table-layout: fixed;
            width: 100%;
        }

        .content-table th,
        .content-table td {
            overflow: hidden;
            word-wrap: break-word;
        }

        /* Mantener tal cual */
        .content-table .col-descripcion {
            width: 320px;
            max-width: 320px;
        }

        .content-table .col-estado {
            width: 220px;
            min-width: 220px;
        }

        /* Ampliar el resto de columnas en bloque */
        .content-table th:not(.col-descripcion):not(.col-estado),
        .content-table td:not(.col-descripcion):not(.col-estado) {
            min-width: 140px;
            /* Aumenta el mínimo */
            width: 140px;
            /* puedes subir a 150-160px si quieres más */
        }
    </style>
</head>

<body data-title="Registro de Reclamos" class="has-sidebar">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="card roles-card shadow-sm">
                <div class="card-body">

                    <div class="roles-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Reclamos</h5>
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <!-- Botón de exportación a Excel -->
                            <button class="btn btn-dark btn-pill btn-icon" title="Exportar a Excel" data-export-excel>
                                <i class="fa-regular fa-file-excel me-2"></i> Excel
                            </button>
                            <!-- Botón de exportación a PDF -->
                            <button class="btn btn-dark btn-pill btn-icon" title="Exportar a PDF" data-export-pdf>
                                <i class="fa-regular fa-file-pdf me-2"></i> PDF
                            </button>
                            <!-- Filtro por tipo de reclamación -->
                            <select id="filtroTipo" class="form-select form-select-sm" style="min-width:260px">
                                <option value="">— Filtrar por Tipo de Reclamación —</option>
                            </select>
                            <!-- Buscador -->
                            <div class="search-wrap position-relative">
                                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                                <input id="searchInput" type="text" class="form-control form-control-sm search-input"
                                    placeholder="Buscar...">
                            </div>
                        </div>
                    </div>

                    <div id="alertContainer" class="mb-3" style="display:none;"></div>

                    <div class="table-responsive">
                        <table class="table table-bordered content-table" id="tupaTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tipo Documento</th>
                                    <th>Número de Documento</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Correo</th>
                                    <th>Tipo Reclamación</th>
                                    <th>Área Relacionada</th>
                                    <th>Fecha Incidente</th>
                                    <th>Asunto</th>
                                    <th class="col-descripcion">Descripción</th>
                                    <th class="col-estado">Estado</th>
                                    <th>Respuesta</th>
                                    <th>Documento</th>
                                    <th>Fecha de respuesta</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tupaBody">
                                <!-- Filas renderizadas por JS -->
                            </tbody>
                        </table>
                    </div>
                    <div id="paginationContainer" class="mt-3 d-flex justify-content-end"></div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Agregar/Editar Respuesta -->
    <div class="modal fade" id="modalRespuesta" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="formRespuesta">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRespuestaTitle" style="color:#2563eb;">Agregar respuesta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="resp_reclamo_id">
                        <input type="hidden" id="resp_mode" value="create">

                        <div class="mb-3">
                            <label class="form-label" style="color:#2563eb;">Respuesta</label>
                            <textarea class="form-control" id="resp_respuesta" rows="4" required></textarea>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" style="color:#2563eb;">Fecha de respuesta</label>
                                <input type="date" class="form-control" id="resp_fecha">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="color:#2563eb;">Documento (opcional)</label>
                                <input type="file" class="form-control" id="resp_documento"
                                    accept=".pdf,.doc,.docx,.png,.jpg,.jpeg">
                                <div class="form-text" id="resp_doc_actual" style="display:none;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa-regular fa-floppy-disk me-1"></i>
                            Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Eliminar Respuesta -->
    <div class="modal fade" id="modalDeleteRespuesta" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <form id="formDeleteRespuesta">
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#2563eb;">Eliminar respuesta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="del_reclamo_id">
                        <p class="mb-0" style="color:#2563eb;">¿Seguro que deseas eliminar la respuesta y el documento?</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="submit"><i class="fa-regular fa-trash-can me-1"></i>
                            Eliminar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @include('include.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.RECLAMOS_ROUTES = {
            grid: "{{ route('reclamos.grid') }}",
            tipos: "{{ route('reclamos.tipos') }}",
            estados: "{{ route('reclamos.estados') }}",
            updEst: @json(route('reclamos.estado.update', ['reclamo' => '_ID_'])),

            // NUEVO: CRUD de respuesta
            respStore: @json(route('reclamos.respuesta.store', ['reclamo' => '_ID_'])),
            respUpdate: @json(route('reclamos.respuesta.update', ['reclamo' => '_ID_'])),
            respDelete: @json(route('reclamos.respuesta.destroy', ['reclamo' => '_ID_'])),
        };
    </script>


    @vite('resources/js/admin/transparencia/libro/reclamos/reclamos.js')
    @vite('resources/js/titulo.js')
    @vite('resources/js/search.js')
    @vite('resources/js/exportarPDF.js')
    @vite('resources/js/exportarEXCEL.js')
    @vite('resources/js/darkmode.js')
    @vite('resources/css/darkmode.css')
    <link rel="stylesheet" href="{{ asset('css/admin/transparencia/libro/reclamos.css') }}">
</body>

</html>
