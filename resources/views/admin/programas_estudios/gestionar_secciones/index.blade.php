<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestion de Secciones</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/programa-estudio.css') }}">
    @vite('resources/css/admin/programas_estudios/gestionar_secciones/gestionar_secciones.css')

    <!-- Oculta filas SOLO por paginación (no afecta al search.js) -->
    <style>
        tbody tr[data-pg="0"] {
            display: none !important;
        }
    </style>
</head>

<body data-titulo="Gestión de Secciones de Programas de Estudio" class="has-sidebar">
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">
            <div class="card pe-card shadow-sm">
                <div class="card-body">

                    <!-- onsubmit cancelado para evitar submits con Enter en los buscadores -->
                    <form id="frmPrograma" enctype="multipart/form-data" onsubmit="return false;">@csrf
                        <!-- Programa -->
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                            <div class="flex-grow-1" style="max-width:420px;">
                                <label for="programSelect" class="visually-hidden">Programa de estudio</label>
                                <select id="programSelect" class="form-select program-select">
                                    <option value="" selected>Seleccione un programa de estudio</option>
                                </select>
                            </div>
                        </div>

                        <!-- Tabs -->
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                            <ul class="pe-tabs nav gap-3">
                                <li class="nav-item"><button type="button" class="nav-link pe-tab active"
                                        data-tab="tab-coordinador"><i
                                            class="fa-solid fa-user-tie me-2"></i>Coordinador</button></li>
                                <li class="nav-item"><button type="button" class="nav-link pe-tab"
                                        data-tab="tab-perfil"><i class="fa-solid fa-id-card-clip me-2"></i>Perfil de
                                        egresado</button></li>
                                <li class="nav-item"><button type="button" class="nav-link pe-tab"
                                        data-tab="tab-areas"><i class="fa-solid fa-layer-group me-2"></i>Áreas de
                                        especialización</button></li>
                                <li class="nav-item"><button type="button" class="nav-link pe-tab"
                                        data-tab="tab-egresados"><i
                                            class="fa-solid fa-graduation-cap me-2"></i>Egresados</button></li>
                                <li class="nav-item"><button type="button" class="nav-link pe-tab"
                                        data-tab="tab-malla"><i class="fa-solid fa-table-list me-2"></i>Malla</button>
                                </li>
                                <li class="nav-item"><button type="button" class="nav-link pe-tab"
                                        data-tab="tab-convenios"><i
                                            class="fa-solid fa-handshake me-2"></i>Convenios</button></li>
                                <li class="nav-item"><button type="button" class="nav-link pe-tab"
                                        data-tab="tab-galeria"><i class="fa-regular fa-image me-2"></i>Galería</button>
                                </li>
                            </ul>
                        </div>
                        <hr class="mt-0 mb-3">

                        <!-- ===================== COORDINADOR ===================== -->
                        <section id="tab-coordinador" class="tab-panel show">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                <h6 class="section-title mb-0">Coordinadores</h6>
                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-teal btn-pill" id="btnUpdate"><i
                                            class="fa-solid fa-rotate me-2"></i> Actualizar</button>
                                    <button type="button" class="btn btn-teal btn-pill" id="btnAddCoord"><i
                                            class="fa-solid fa-user-plus me-2"></i> Añadir coordinador</button>
                                </div>
                            </div>

                            <div id="coordList" class="row g-3">
                                <div class="col-12 coord-item">
                                    <div class="coord-card p-3">
                                        <input type="hidden" name="coordinadores[0][id]" value="">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label">Nombres</label>
                                                <input name="coordinadores[0][nombres]" type="text"
                                                    class="form-control" placeholder="Ej. Juan Carlos">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Apellidos</label>
                                                <input name="coordinadores[0][apellidos]" type="text"
                                                    class="form-control" placeholder="Ej. Méndez García">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Cargo</label>
                                                <input name="coordinadores[0][cargo]" type="text"
                                                    class="form-control" placeholder="Coordinador Académico">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Foto</label>
                                                <input name="coordinadores[0][foto]" type="file"
                                                    class="form-control coord-file" accept="image/*" data-index="0">
                                                <div class="mt-2"><img class="coord-preview" data-index="0"
                                                        src="{{ asset('images/no-photo.jpg') }}" alt="Vista previa">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-label">Mensaje del coordinador</label>
                                                <textarea name="coordinadores[0][mensaje]" class="form-control" rows="3"
                                                    placeholder="Escribe un breve mensaje..."></textarea>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="btn btn-outline-danger btn-sm mt-3 d-none btnRemoveCoord">
                                            <i class="fa-regular fa-trash-can me-1"></i>Quitar
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <template id="tplCoord">
                                <div class="col-12 coord-item">
                                    <div class="coord-card p-3">
                                        <input type="hidden" name="coordinadores[__INDEX__][id]" value="">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label">Nombres</label>
                                                <input name="coordinadores[__INDEX__][nombres]" type="text"
                                                    class="form-control" placeholder="Ej. Juan Carlos">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Apellidos</label>
                                                <input name="coordinadores[__INDEX__][apellidos]" type="text"
                                                    class="form-control" placeholder="Ej. Méndez García">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Cargo</label>
                                                <input name="coordinadores[__INDEX__][cargo]" type="text"
                                                    class="form-control" placeholder="Coordinador Académico">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Foto</label>
                                                <input name="coordinadores[__INDEX__][foto]" type="file"
                                                    class="form-control coord-file" accept="image/*"
                                                    data-index="__INDEX__">
                                                <div class="mt-2"><img class="coord-preview" data-index="__INDEX__"
                                                        src="{{ asset('images/no-photo.jpg') }}" alt="Vista previa">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-label">Mensaje del coordinador</label>
                                                <textarea name="coordinadores[__INDEX__][mensaje]" class="form-control" rows="3"
                                                    placeholder="Escribe un breve mensaje..."></textarea>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="btn btn-outline-danger btn-sm mt-3 btnRemoveCoord">
                                            <i class="fa-regular fa-trash-can me-1"></i>Quitar
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </section>

                        <!-- ===================== PERFIL ===================== -->
                        <section id="tab-perfil" class="tab-panel">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                <h6 class="section-title mb-0">Descripción del Perfil de Egresado</h6>
                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-teal btn-pill" id="btnUpdatePerfil"><i
                                            class="fa-solid fa-rotate me-2"></i> Actualizar</button>
                                </div>
                            </div>
                            <textarea id="perfilDescripcion" class="form-control" rows="6"
                                placeholder="Describe aquí el perfil del egresado..." name="perfil_egresado"></textarea>
                        </section>

                        <!-- ===================== ÁREAS ===================== -->
                        <section id="tab-areas" class="tab-panel">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                    <h6 class="section-title mb-0">Áreas de especialización</h6>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="btn-toolbar gap-2 me-2">
                                            <button type="button" class="btn btn-dark btn-pill btn-icon"
                                                title="Exportar a Excel" data-export-excel>
                                                <i class="fa-regular fa-file-excel me-2"></i> Excel
                                            </button>
                                            <button type="button" class="btn btn-dark btn-pill btn-icon"
                                                title="Exportar a PDF" data-export-pdf>
                                                <i class="fa-regular fa-file-pdf me-2"></i> PDF
                                            </button>
                                        </div>
                                        <div class="search-wrap position-relative me-2">
                                            <i class="fa-solid fa-magnifying-glass search-icon"></i>
                                            <input type="text" class="form-control form-control-sm search-input"
                                                placeholder="Buscar...">
                                        </div>
                                        <button type="button" class="btn btn-teal btn-pill" id="btnAddArea"><i
                                                class="fa-solid fa-plus me-2"></i> Añadir área</button>
                                        <button type="button" class="btn btn-teal btn-pill" id="btnReloadAreas"><i
                                                class="fa-solid fa-rotate me-2"></i> Actualizar</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered content-table" id="tblAreas">
                                        <thead>
                                            <tr>
                                                <th style="width:60px">#</th>
                                                <th>Nombre</th>
                                                <th>Descripción</th>
                                                <th style="width:140px">Imagen</th>
                                                <th style="width:120px" class="text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tblAreasBody"></tbody>
                                    </table>
                                </div>
                            </div>
                        </section>

                        <!-- ===================== EGRESADOS ===================== -->
                        <section id="tab-egresados" class="tab-panel">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                    <h6 class="section-title mb-0">Egresados</h6>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="btn-toolbar gap-2 me-2">
                                            <button type="button" class="btn btn-dark btn-pill btn-icon"
                                                title="Exportar a Excel" data-export-excel>
                                                <i class="fa-regular fa-file-excel me-2"></i> Excel
                                            </button>
                                            <button type="button" class="btn btn-dark btn-pill btn-icon"
                                                title="Exportar a PDF" data-export-pdf>
                                                <i class="fa-regular fa-file-pdf me-2"></i> PDF
                                            </button>
                                        </div>
                                        <div class="search-wrap position-relative me-2">
                                            <i class="fa-solid fa-magnifying-glass search-icon"></i>
                                            <input type="text" class="form-control form-control-sm search-input"
                                                placeholder="Buscar...">
                                        </div>
                                        <button type="button" class="btn btn-teal btn-pill" id="btnAddEgresado"><i
                                                class="fa-solid fa-user-graduate me-2"></i> Añadir egresado</button>
                                        <button type="button" class="btn btn-teal btn-pill"
                                            id="btnReloadEgresados"><i class="fa-solid fa-rotate me-2"></i>
                                            Actualizar</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered content-table" id="tblEgresados">
                                        <thead>
                                            <tr>
                                                <th style="width:60px">#</th>
                                                <th>Nombre completo</th>
                                                <th>Cargo</th>
                                                <th style="width:140px">Imagen</th>
                                                <th style="width:120px" class="text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tblEgresadosBody"></tbody>
                                    </table>
                                </div>
                            </div>
                        </section>

                        <!-- ===================== MALLA (con export & search) ===================== -->
                        <section id="tab-malla" class="tab-panel">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                    <h6 class="section-title mb-0">Malla Curricular</h6>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="btn-toolbar gap-2 me-2">
                                            <button type="button" class="btn btn-dark btn-pill btn-icon"
                                                title="Exportar a Excel" data-export-excel>
                                                <i class="fa-regular fa-file-excel me-2"></i> Excel
                                            </button>
                                            <button type="button" class="btn btn-dark btn-pill btn-icon"
                                                title="Exportar a PDF" data-export-pdf>
                                                <i class="fa-regular fa-file-pdf me-2"></i> PDF
                                            </button>
                                        </div>
                                        <div class="search-wrap position-relative me-2">
                                            <i class="fa-solid fa-magnifying-glass search-icon"></i>
                                            <input type="text" class="form-control form-control-sm search-input"
                                                placeholder="Buscar...">
                                        </div>
                                        <button type="button" class="btn btn-teal btn-pill" id="btnAddMalla">
                                            <i class="fa-solid fa-plus me-2"></i> Añadir fila
                                        </button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered content-table" id="tblMalla">
                                        <thead>
                                            <tr>
                                                <th>Nombre de módulo</th>
                                                <th>Semestre</th>
                                                <th>Curso</th>
                                                <th style="width:110px">Crédito</th>
                                                <th style="width:110px">Horas</th>
                                                <th style="width:120px" class="text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tblMallaBody">
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">Seleccione un
                                                    programa para ver su malla.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>

                        <!-- ===================== CONVENIOS ===================== -->
                        <section id="tab-convenios" class="tab-panel">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                    <h6 class="section-title mb-0">Convenios</h6>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="btn-toolbar gap-2 me-2">
                                            <button type="button" class="btn btn-dark btn-pill btn-icon"
                                                title="Exportar a Excel" data-export-excel>
                                                <i class="fa-regular fa-file-excel me-2"></i> Excel
                                            </button>
                                            <button type="button" class="btn btn-dark btn-pill btn-icon"
                                                title="Exportar a PDF" data-export-pdf>
                                                <i class="fa-regular fa-file-pdf me-2"></i> PDF
                                            </button>
                                        </div>
                                        <div class="search-wrap position-relative me-2">
                                            <i class="fa-solid fa-magnifying-glass search-icon"></i>
                                            <input type="text" class="form-control form-control-sm search-input"
                                                placeholder="Buscar...">
                                        </div>
                                        <button type="button" class="btn btn-teal btn-pill" id="btnAddConvenio"><i
                                                class="fa-solid fa-plus me-2"></i> Añadir convenio</button>
                                        <button type="button" class="btn btn-teal btn-pill"
                                            id="btnReloadConvenios"><i class="fa-solid fa-rotate me-2"></i>
                                            Actualizar</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered content-table" id="tblConvenios">
                                        <thead>
                                            <tr>
                                                <th style="width:60px">#</th>
                                                <th>Entidad</th>
                                                <th style="width:140px">Imagen</th>
                                                <th style="width:120px" class="text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tblConveniosBody"></tbody>
                                    </table>
                                </div>
                            </div>
                        </section>

                        <!-- ===================== GALERÍA (CRUD + Ver imagen) ===================== -->
                        <section id="tab-galeria" class="tab-panel">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                    <h6 class="section-title mb-0">Galería</h6>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="btn-toolbar gap-2 me-2">
                                            <button type="button" class="btn btn-dark btn-pill btn-icon"
                                                title="Exportar a Excel" data-export-excel>
                                                <i class="fa-regular fa-file-excel me-2"></i> Excel
                                            </button>
                                            <button type="button" class="btn btn-dark btn-pill btn-icon"
                                                title="Exportar a PDF" data-export-pdf>
                                                <i class="fa-regular fa-file-pdf me-2"></i> PDF
                                            </button>
                                        </div>
                                        <div class="search-wrap position-relative me-2">
                                            <i class="fa-solid fa-magnifying-glass search-icon"></i>
                                            <input type="text" class="form-control form-control-sm search-input"
                                                placeholder="Buscar...">
                                        </div>
                                        <button type="button" class="btn btn-teal btn-pill" id="btnAddImg"><i
                                                class="fa-regular fa-image me-2"></i>Añadir imagen</button>
                                        <button type="button" class="btn btn-teal btn-pill" id="btnReloadGaleria"><i
                                                class="fa-solid fa-rotate me-2"></i> Actualizar</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered content-table" id="tblGaleria">
                                        <thead>
                                            <tr>
                                                <th style="width:60px">#</th>
                                                <th>Nombre de imagen</th>
                                                <th style="width:160px">Imagen</th>
                                                <th style="width:120px" class="text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tblGaleriaBody"></tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                    </form>

                </div>
            </div>
        </div>
    </main>

    @include('include.footer')

    <!-- ===== Modales (sin cambios funcionales) ===== -->
    <!-- Área -->
    <div class="modal fade" id="modalArea" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="frmArea" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAreaTitle" style="color:#2563eb;">Nueva área</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="areaId" value="">
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label"
                                    style="color:#2563eb;">Nombre</label><input type="text" class="form-control"
                                    id="areaNombre" placeholder="Nombre del área"></div>
                            <div class="col-md-6"><label class="form-label"
                                    style="color:#2563eb;">Imagen</label><input type="file" class="form-control"
                                    id="areaImagen" accept="image/*"></div>
                            <div class="col-12"><label class="form-label" style="color:#2563eb;">Descripción</label>
                                <textarea class="form-control" id="areaDescripcion" rows="4" placeholder="Descripción del área"></textarea>
                            </div>
                            <div class="col-12"><img id="areaPreview" class="area-img-preview" alt="Vista previa"
                                    src="{{ asset('images/no-photo.jpg') }}"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary" type="submit"><i
                                class="fa-regular fa-floppy-disk me-2"></i>Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Egresado -->
    <div class="modal fade" id="modalEgresado" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="frmEgresado" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEgresadoTitle" style="color:#2563eb;">Nuevo egresado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="egreId" value="">
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label" style="color:#2563eb;">Nombre
                                    completo</label><input type="text" class="form-control" id="egreNombre"
                                    placeholder="Ej. María González"></div>
                            <div class="col-md-6"><label class="form-label"
                                    style="color:#2563eb;">Cargo</label><input type="text" class="form-control"
                                    id="egreCargo" placeholder="Ej. CTO"></div>
                            <div class="col-md-6"><label class="form-label"
                                    style="color:#2563eb;">Imagen</label><input type="file" class="form-control"
                                    id="egreImagen" accept="image/*"></div>
                            <div class="col-12"><img id="egrePreview" class="egre-img-preview" alt="Vista previa"
                                    src="{{ asset('images/no-photo.jpg') }}"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary" type="submit"><i
                                class="fa-regular fa-floppy-disk me-2"></i>Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Convenio -->
    <div class="modal fade" id="modalConvenio" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="frmConvenio" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalConvenioTitle" style="color:#2563eb;">Nuevo convenio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="convId" value="">
                        <div class="row g-3">
                            <div class="col-md-8"><label class="form-label"
                                    style="color:#2563eb;">Entidad</label><input type="text" class="form-control"
                                    id="convEntidad" placeholder="Ej. Microsoft"></div>
                            <div class="col-md-4"><label class="form-label"
                                    style="color:#2563eb;">Imagen</label><input type="file" class="form-control"
                                    id="convImagen" accept="image/*"></div>
                            <div class="col-12"><img id="convPreview" class="conv-img-preview" alt="Vista previa"
                                    src="{{ asset('images/no-photo.jpg') }}"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary" type="submit"><i
                                class="fa-regular fa-floppy-disk me-2"></i>Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Galería -->
    <div class="modal fade" id="modalGaleria" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="frmGaleria" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalGaleriaTitle" style="color:#2563eb;">Nueva imagen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="galId" value="">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label" style="color:#2563eb;">Nombre</label>
                                <input type="text" class="form-control" id="galNombre"
                                    placeholder="Ej. Galería 1">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" style="color:#2563eb;">Imagen</label>
                                <input type="file" class="form-control" id="galImagen" accept="image/*">
                            </div>
                            <div class="col-12">
                                <img id="galPreview" class="conv-img-preview" alt="Vista previa"
                                    src="{{ asset('images/no-photo.jpg') }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary" type="submit"><i
                                class="fa-regular fa-floppy-disk me-2"></i>Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Ver Imagen -->
    <div class="modal fade" id="modalViewImg" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-2">
                    <img id="viewImgEl" src="{{ asset('images/no-photo.jpg') }}" alt="Imagen"
                        style="width:100%;max-height:70vh;object-fit:contain;border-radius:10px;background:#f8f9fb">
                </div>
            </div>
        </div>
    </div>

    <!-- Modales Malla (sin cambios) -->
    <div class="modal fade" id="modalModulo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="frmModulo">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalModuloTitle" style="color:#2563eb;"
                        >Nuevo módulo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="moduloId">
                        <div class="mb-3"><label class="form-label" style="color:#2563eb;"
                            >Nombre de módulo</label>
                            <input type="text" id="moduloNombre" class="form-control" placeholder="Ej. Módulo 1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary" type="submit">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalSemestre" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="frmSemestre">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSemestreTitle" style="color:#2563eb;"
                        >Nuevo semestre</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="semestreId">
                        <input type="hidden" id="semestreModuloId">
                        <div class="mb-3"><label class="form-label" style="color:#2563eb;"
                            >Nombre de semestre</label>
                            <input type="text" id="semestreNombre" class="form-control"
                                placeholder="Ej. Semestre 1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary" type="submit">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCurso" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="frmCurso">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCursoTitle" style="color:#2563eb;"
                        >Nuevo curso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="cursoId">
                        <input type="hidden" id="cursoSemestreId">
                        <div class="row g-3">
                            <div class="col-12"><label class="form-label" style="color:#2563eb;"
                                >Nombre del curso</label>
                                <input type="text" id="cursoNombre" class="form-control"
                                    placeholder="Ej. Matemática Básica">
                            </div>
                            <div class="col-6"><label class="form-label" style="color:#2563eb;"
                                >Créditos</label>
                                <input type="number" id="cursoCreditos" class="form-control" min="0"
                                    value="0">
                            </div>
                            <div class="col-6"><label class="form-label" style="color:#2563eb;"
                                >Horas</label>
                                <input type="number" id="cursoHoras" class="form-control" min="0"
                                    value="0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary" type="submit">Guardar</button>
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
                        <p class="mb-0" style="color:#2563eb;">¿Seguro que deseas eliminar <strong
                                id="delNombre"></strong>?</p>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/js/admin/programas_estudios/gestionar_secciones/gestionar_secciones.js')
    @vite('resources/js/admin/programas_estudios/gestionar_secciones/malla_pagination_by_module.js')
    @vite('resources/css/content.css')
    @vite('resources/js/titulo.js')
    @vite('resources/js/pagination.js')
    @vite('resources/js/search.js')
    @vite('resources/js/exportarPDF.js')
    @vite('resources/js/exportarEXCEL.js')
    @vite('resources/css/darkmode.css')
    @vite('resources/js/darkmode.js')
    @vite('resources/js/pagination-section.js')
    <!-- Paginación reactiva por sección (convive con search.js y sin tocar tus JS) -->


</body>

</html>
