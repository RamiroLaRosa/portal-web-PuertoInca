document.addEventListener('DOMContentLoaded', () => {
    const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Dom
    const tbody = document.getElementById('tupaBody');
    const searchInput = document.getElementById('searchInput');
    const alertBox = document.getElementById('alertContainer');
    const paginationContainer = document.getElementById('paginationContainer');

    const formNuevo = document.getElementById('formNuevo');
    const formEditar = document.getElementById('formEditar');

    const modalNuevo = new bootstrap.Modal(document.getElementById('modalNuevo'));
    const modalEditar = new bootstrap.Modal(document.getElementById('modalEditar'));

    // Crear
    const createTitulo = document.getElementById('createTitulo');
    const createDescripcion = document.getElementById('createDescripcion');
    const createIcono = document.getElementById('createIcono');
    const createIconPreview = document.getElementById('createIconPreview');
    const createActive = document.getElementById('createActive');

    // Editar
    const editId = document.getElementById('editId');
    const editTitulo = document.getElementById('editTitulo');
    const editDescripcion = document.getElementById('editDescripcion');
    const editIcono = document.getElementById('editIcono');
    const editIconPreview = document.getElementById('editIconPreview');
    const editActive = document.getElementById('editActive');

    // Opciones de iconos
    const ICON_OPTIONS = [
        { label: 'Información', value: 'fa-solid fa-circle-info' },
        { label: 'Protección', value: 'fa-solid fa-shield-halved' },
        { label: 'Elegir', value: 'fa-solid fa-user-check' },
        { label: 'Trato Equitativo', value: 'fa-solid fa-scale-balanced' },
        { label: 'Reclamar', value: 'fa-solid fa-file-pen' },
        { label: 'Privacidad', value: 'fa-solid fa-user-shield' },
        { label: 'Libro', value: 'fa-solid fa-book' },
        { label: 'Documento', value: 'fa-solid fa-file-lines' },
        { label: 'Check', value: 'fa-solid fa-check-circle' },
        { label: 'Exclamación', value: 'fa-solid fa-triangle-exclamation' },
    ];

    function fillIconSelect(selectEl, previewEl) {
        selectEl.innerHTML = '';
        ICON_OPTIONS.forEach(opt => {
            const o = document.createElement('option');
            o.value = opt.value;
            o.textContent = opt.label;
            selectEl.appendChild(o);
        });
        selectEl.addEventListener('change', () => {
            previewEl.className = selectEl.value;
        });
        // set preview initial
        if (selectEl.value) previewEl.className = selectEl.value;
    }

    // Estado
    let rows = [];
    let currentPage = 1;
    const itemsPerPage = 5;

    function notify(type, msg) {
        if (!alertBox) return;
        alertBox.style.display = 'block';
        alertBox.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show mb-0">
          ${msg}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>`;
        setTimeout(() => alertBox.style.display = 'none', 3500);
    }

    function renderTable(term = '', page = 1) {
        const q = term.trim().toLowerCase();
        const data = q ? rows.filter(r =>
            String(r.id).includes(q) ||
            (r.titulo || '').toLowerCase().includes(q) ||
            (r.descripcion || '').toLowerCase().includes(q) ||
            (r.icono || '').toLowerCase().includes(q)
        ) : rows;

        tbody.innerHTML = '';
        if (!data.length) {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center text-muted">Sin registros.</td></tr>`;
            paginationContainer.innerHTML = '';
            return;
        }

        // PAGINACIÓN
        const totalPages = Math.ceil(data.length / itemsPerPage) || 1;
        currentPage = Math.max(1, Math.min(page, totalPages));
        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const pageData = data.slice(start, end);

        pageData.forEach(r => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                    <td class="col-id">${r.id}</td>
                    <td class="text-muted fw-semibold col-title">
                        ${r.titulo ?? ''} ${r.is_active ? '' : '<span class="badge bg-secondary ms-2">Inactivo</span>'}
                    </td>
                    <td class="text-muted col-desc">${r.descripcion ?? ''}</td>
                    <td class="col-icono text-center">
                        <i class="${r.icono ?? ''}" title="${r.icono ?? ''}"></i>
                    </td>
                    <td class="text-center col-actions">
                        <div class="d-inline-flex gap-1">
                        <button class="btn btn-warning btn-sm text-white" data-action="edit" data-id="${r.id}" title="Editar">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                        <button class="btn btn-danger btn-sm btn-delete"
                                data-id="${r.id}"
                                data-title="${(r.titulo ?? '').replace(/"/g,'&quot;')}"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEliminar"
                                title="Eliminar">
                        <i class="fa-regular fa-trash-can"></i>
                        </button>
                        </div>
                    </td>`;
            tbody.appendChild(tr);
        });

        renderPagination(totalPages, currentPage, term);
    }

    function renderPagination(totalPages, currentPage, term) {
        // SIEMPRE muestra el paginador, aunque solo haya una página
        let html = `<nav><ul class="pagination mb-0">`;
        html += `<li class="page-item${currentPage === 1 ? ' disabled' : ''}">
            <a class="page-link" href="#" data-page="${currentPage - 1}">&laquo;</a></li>`;
        for (let i = 1; i <= totalPages; i++) {
            html += `<li class="page-item${i === currentPage ? ' active' : ''}">
                <a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
        }
        html += `<li class="page-item${currentPage === totalPages ? ' disabled' : ''}">
            <a class="page-link" href="#" data-page="${currentPage + 1}">&raquo;</a></li>`;
        html += `</ul></nav>`;
        paginationContainer.innerHTML = html;

        paginationContainer.querySelectorAll('.page-link[data-page]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const page = parseInt(this.getAttribute('data-page'));
                if (page >= 1 && page <= totalPages) {
                    renderTable(term || searchInput.value, page);
                }
            });
        });
    }

    async function fetchGrid() {
        try {
            const res = await fetch(window.DERECHOS_ROUTES.grid);
            if (!res.ok) throw new Error();
            rows = await res.json();
            renderTable(searchInput?.value || '', 1);
        } catch {
            notify('danger', 'No se pudo cargar la lista.');
        }
    }

    // ===== Eventos =====
    searchInput?.addEventListener('input', e => renderTable(e.target.value, 1));

    // abrir modal nuevo → rellenar combo
    document.getElementById('btnNuevo')?.addEventListener('click', () => {
        fillIconSelect(createIcono, createIconPreview);
        createIconPreview.className = createIcono.value || '';
    });

    // tabla: editar / eliminar
    tbody?.addEventListener('click', async e => {
        const btn = e.target.closest('button'); if (!btn) return;
        const id = Number(btn.dataset.id);
        const action = btn.dataset.action;

        if (action === 'edit') {
            const r = rows.find(x => x.id === id);
            if (!r) return;

            editId.value = r.id;
            editTitulo.value = r.titulo ?? '';
            editDescripcion.value = r.descripcion ?? '';
            fillIconSelect(editIcono, editIconPreview);
            // seleccionar valor del registro y previsualizar
            if (r.icono) editIcono.value = r.icono;
            editIconPreview.className = editIcono.value || '';
            editActive.checked = !!r.is_active;

            modalEditar.show();
        }

        if (action === 'delete') {
            if (!confirm('¿Eliminar el registro?')) return;
            try {
                const res = await fetch(window.DERECHOS_ROUTES.destroy.replace(':id', id), {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
                });
                if (!res.ok) throw new Error();
                await fetchGrid();
                notify('success', 'Registro eliminado.');
            } catch {
                notify('danger', 'No se pudo eliminar.');
            }
        }
    });

    formNuevo?.addEventListener('submit', async e => {
        e.preventDefault();
        const payload = {
            titulo: (createTitulo?.value || '').trim(),
            descripcion: (createDescripcion?.value || '').trim(),
            icono: createIcono?.value || '',
            is_active: createActive?.checked ? 1 : 0
        };
        try {
            const res = await fetch(window.DERECHOS_ROUTES.store, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });
            if (!res.ok) throw new Error();
            formNuevo.reset();
            createActive.checked = true;
            modalNuevo.hide();
            await fetchGrid();
            notify('success', 'Registro creado correctamente.');
        } catch {
            notify('danger', 'Revisa los campos obligatorios.');
        }
    });

    formEditar?.addEventListener('submit', async e => {
        e.preventDefault();
        const id = Number(editId.value);
        const payload = {
            titulo: (editTitulo?.value || '').trim(),
            descripcion: (editDescripcion?.value || '').trim(),
            icono: editIcono?.value || '',
            is_active: editActive?.checked ? 1 : 0
        };
        try {
            const res = await fetch(window.DERECHOS_ROUTES.update.replace(':id', id), {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });
            if (!res.ok) throw new Error();
            modalEditar.hide();
            await fetchGrid();
            notify('success', 'Cambios guardados.');
        } catch {
            notify('danger', 'No se pudo actualizar.');
        }
    });

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-delete');
        if (!btn) return;

        const id = btn.getAttribute('data-id');
        const title = btn.getAttribute('data-title') || 'este registro';

        const form = document.getElementById('formEliminar');
        const delTitle = document.getElementById('delTitulo');

        const tpl = (window.DERECHOS_ROUTES && window.DERECHOS_ROUTES.destroy) || '';
        const url = tpl.replace(':id', id);

        if (form && url) form.setAttribute('action', url);
        if (delTitle) delTitle.textContent = title;
    });

    // init
    fillIconSelect(createIcono, createIconPreview); // por si abren y envían sin tocar select
    fetchGrid();
});