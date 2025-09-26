{{-- resources/views/admin/nosotros/docente/gestion/index.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestión Docente</title>

    <!-- Estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/docente.css') }}">

    <!-- CSRF para peticiones AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Oculta filas SOLO por paginación (no afecta al search.js) -->
    <style>
        tbody tr[data-pg="0"] { display: none !important; }
    </style>
</head>

<body
    data-titulo="Gestión de Docentes"
    data-list-url="{{ route('gestion.list') }}"
    data-store-url="{{ route('gestion.store') }}"
    data-docentes-base-url="{{ url('/admin/nosotros/docentes') }}"
    data-no-photo="{{ asset('images/no-photo.jpg') }}"
    class="has-sidebar"
>
    @include('include.preloader')
    @include('include.header')
    <aside class="sidebar-fixed">@include('include.sidebar')</aside>

    <main class="app-content">
        <div class="container-fluid px-3 px-md-4">

            <div class="card content-card shadow-sm">
                <div class="card-body">

                    <!-- Toolbar -->
                    <div class="content-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="mb-0 fw-bold">Gestión de Docentes</h5>

                        <div class="d-flex align-items-center gap-2">
                            <select id="programSelect" class="form-select" style="min-width:280px;">
                                <option value="" selected>Seleccione un programa de estudio</option>
                                @foreach ($programas as $p)
                                    <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                @endforeach
                            </select>

                            <div class="d-flex gap-2 me-2">
                                <!-- Botón de exportación a Excel -->
                                <button type="button" class="btn btn-dark btn-pill btn-icon" title="Exportar a Excel" data-export-excel>
                                    <i class="fa-regular fa-file-excel me-2"></i> Excel
                                </button>

                                <!-- Botón de exportación a PDF -->
                                <button type="button" class="btn btn-dark btn-pill btn-icon" title="Exportar a PDF" data-export-pdf>
                                    <i class="fa-regular fa-file-pdf me-2"></i> PDF
                                </button>
                            </div>

                            <div class="search-wrap position-relative me-2">
                                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                                <input type="text" class="form-control form-control-sm search-input" placeholder="Buscar...">
                            </div>

                            <button id="btnNuevo" class="btn btn-teal btn-pill" type="button">
                                + Nuevo Registro
                            </button>
                        </div>
                    </div>

                    <!-- Tabla -->
                    <div class="table-responsive">
                        <table class="table table-bordered content-table align-middle">
                            <thead>
                                <tr>
                                    <th style="width:70px;">#</th>
                                    <th>Nombre</th>
                                    <th style="width:220px;">Cargo</th>
                                    <th style="width:320px;">Correo</th>
                                    <th style="width:140px;">Imagen</th>
                                    <th style="width:160px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyDocentes">
                                <tr class="empty-row">
                                    <td colspan="6">Seleccione un programa de estudio para listar los docentes.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </main>

    {{-- ========= Modal: Nuevo Docente (centrado) ========= --}}
    <div class="modal fade" id="modalNuevo" tabindex="-1" aria-labelledby="modalNuevoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form id="formNuevo" class="modal-content" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNuevoLabel" style="color:#2563eb;">Nuevo docente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Programa de estudio</label>
                            <select name="programa_estudio_id" id="newProgramaId" class="form-select" required>
                                <option value="">Seleccione…</option>
                                @foreach ($programas as $p)
                                    <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Correo</label>
                            <input type="email" class="form-control" name="correo" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Nombre completo</label>
                            <input type="text" class="form-control" name="nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Cargo</label>
                            <input type="text" class="form-control" name="cargo" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" style="color:#2563eb;">Foto (opcional) — Máx. 2MB</label>
                            <input type="file" class="form-control" name="foto" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button id="btnGuardarNuevo" type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ========= Modal: Ver Foto (ya centrado) ========= --}}
    <div class="modal fade" id="modalFoto" tabindex="-1" aria-labelledby="modalFotoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFotoLabel" style="color:#2563eb;">Foto del docente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body p-0">
                    <img id="fotoImg" src="" alt="Foto del docente" class="img-fluid w-100">
                </div>
            </div>
        </div>
    </div>

    {{-- ========= Modal: Editar Docente (centrado) ========= --}}
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form id="formEditar" class="modal-content" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" id="editId">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarLabel" style="color:#2563eb;">Editar docente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Programa de estudio</label>
                            <select name="programa_estudio_id" id="editProgramaId" class="form-select" required>
                                <option value="">Seleccione…</option>
                                @foreach ($programas as $p)
                                    <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Correo</label>
                            <input type="email" class="form-control" name="correo" id="editCorreo" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Nombre completo</label>
                            <input type="text" class="form-control" name="nombre" id="editNombre" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:#2563eb;">Cargo</label>
                            <input type="text" class="form-control" name="cargo" id="editCargo" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label" style="color:#2563eb;">Reemplazar foto (opcional) — Máx. 2MB</label>
                            <input type="file" class="form-control" name="foto" id="editFoto" accept="image/*">
                            <div class="form-text">Si sube una nueva imagen, reemplazará a la actual.</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label d-block" style="color:#2563eb;">Foto actual</label>
                            <img id="editFotoPreview" src="{{ asset('images/no-photo.jpg') }}" class="img-thumbnail" alt="Foto actual">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button id="btnGuardarEditar" type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ========= Modal: Eliminar Docente (centrado) ========= --}}
    <div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEliminarLabel" style="color:#2563eb;">Eliminar Docente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" style="color:#2563eb;">
                    ¿Seguro que deseas eliminar a <strong id="delNombre">—</strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button id="btnConfirmEliminar" type="button" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    @include('include.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/js/admin/nosotros/docente/gestion/docente_gestion.js')
    @vite('resources/css/content.css')
    @vite('resources/js/titulo.js')
    @vite('resources/js/pagination.js')
    @vite('resources/js/search.js')
    @vite('resources/js/exportarPDF.js')
    @vite('resources/js/exportarEXCEL.js')
    @vite('resources/css/darkmode.css')
    @vite('resources/js/darkmode.js')

    <!-- Paginación reactiva (convive con search.js y tus exportaciones) -->
    <script>
    (function(){
      const ITEMS = 5;

      const table   = document.querySelector('.content-table');      // tabla única de esta vista
      const tbody   = document.getElementById('tbodyDocentes');
      const wrapper = table?.parentElement?.parentElement;           // .table-responsive -> contenedor
      if(!table || !tbody || !wrapper) return;

      let current = 1;

      // Filas NO ocultas por el buscador (search.js usa style.display='none')
      const visibleRows = () =>
        Array.from(tbody.querySelectorAll('tr')).filter(tr => tr.style.display !== 'none');

      function render(page){
        const rows = visibleRows();

        // Limpia paginador si no hay filas visibles (o solo está la fila vacía)
        const hasRealRows = rows.some(tr => !tr.classList.contains('empty-row'));
        wrapper.querySelectorAll('.content-pagination').forEach(n => n.remove());
        rows.forEach(tr => tr.removeAttribute('data-pg'));
        if(!hasRealRows) return;

        const total = Math.max(1, Math.ceil(rows.length / ITEMS));
        current = Math.min(Math.max(page,1), total);

        const start = (current - 1) * ITEMS;
        const end   = start + ITEMS;

        // Marca como ocultas (solo por paginación) las fuera de rango
        rows.slice(0, start).forEach(tr => tr.setAttribute('data-pg','0'));
        rows.slice(end).forEach(tr => tr.setAttribute('data-pg','0'));

        // Redibuja paginador
        const nav = document.createElement('div');
        nav.className = 'content-pagination mt-3 d-flex justify-content-end';
        let html = `
          <nav>
            <ul class="pagination justify-content-end mb-0">
              <li class="page-item ${current<=1?'disabled':''}" data-role="prev">
                <a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
              </li>`;
        for(let i=1;i<=total;i++){
          html += `
              <li class="page-item ${i===current?'active':''}" data-page="${i}">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
              </li>`;
        }
        html += `
              <li class="page-item ${current>=total?'disabled':''}" data-role="next">
                <a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
              </li>
            </ul>
          </nav>`;
        nav.innerHTML = html;
        wrapper.appendChild(nav);

        nav.querySelector('[data-role="prev"] a')?.addEventListener('click', e => { e.preventDefault(); render(current-1); });
        nav.querySelector('[data-role="next"] a')?.addEventListener('click', e => { e.preventDefault(); render(current+1); });
        nav.querySelectorAll('.page-link[data-page]').forEach(a => {
          a.addEventListener('click', e => { e.preventDefault(); render(parseInt(a.dataset.page)); });
        });
      }

      // Observa cambios de filas (carga AJAX) y cambios de estilo (filtro de búsqueda)
      const mo = new MutationObserver(() => render(1));
      mo.observe(tbody, { childList: true, subtree: false, attributes: true, attributeFilter: ['style'] });

      // Primer render
      render(1);
    })();
    </script>
</body>
</html>
