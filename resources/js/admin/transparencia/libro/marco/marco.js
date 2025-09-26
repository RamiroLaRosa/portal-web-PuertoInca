document.addEventListener('DOMContentLoaded', () => {
    // ====== DOM ======
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    const tbody = document.getElementById('tupaBody');
    const searchInput = document.getElementById('searchInput');
    const alertBox = document.getElementById('alertContainer');
    const paginationContainer = document.getElementById('paginationContainer');

    const modalNuevo = new bootstrap.Modal(document.getElementById('modalNuevo'));
    const modalEditar = new bootstrap.Modal(document.getElementById('modalEditar'));

    const formNuevo = document.getElementById('formNuevo');
    const formEditar = document.getElementById('formEditar');

    // Inputs (reutilizamos ids existentes en los modales)
    const createTitulo = document.getElementById('createConcepto');
    const createDesc = document.getElementById('createMonto');
    const createActive = document.getElementById('createActive');

    const editId = document.getElementById('editId');
    const editTitulo = document.getElementById('editConcepto');
    const editDesc = document.getElementById('editMonto');
    const editActive = document.getElementById('editActive');

    // ====== Ajustes visuales seguros (sin depender de Blade ni for=) ======
    (() => {
        // Cambiar textos de labels por posición dentro de cada modal
        const nuevoLabels = document.querySelectorAll('#modalNuevo .form-label');
        if (nuevoLabels[0]) nuevoLabels[0].textContent = 'Título *';
        if (nuevoLabels[1]) nuevoLabels[1].textContent = 'Descripción *';

        const editarLabels = document.querySelectorAll('#modalEditar .form-label');
        if (editarLabels[0]) editarLabels[0].textContent = 'Título *';
        if (editarLabels[1]) editarLabels[1].textContent = 'Descripción *';

        // Descripción usa <input type="text"> para permitir texto largo
        if (createDesc) createDesc.type = 'text';
        if (editDesc) editDesc.type = 'text';
    })();

    // ====== Estado ======
    let rows = [];
    let currentPage = 1;
    const itemsPerPage = 5;

    // ====== Helpers ======
    function notify(type, msg) {
        if (!alertBox) return;
        alertBox.style.display = 'block';
        alertBox.innerHTML =
            `<div class="alert alert-${type} alert-dismissible fade show mb-0">
           ${msg}
           <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
         </div>`;
        setTimeout(() => (alertBox.style.display = 'none'), 3500);
    }

    function renderTable(term = '', page = 1) {
        const q = term.trim().toLowerCase();
        const data = q
            ? rows.filter(r =>
                String(r.id).includes(q) ||
                (r.titulo || '').toLowerCase().includes(q) ||
                (r.descripcion || '').toLowerCase().includes(q)
            )
            : rows;

        tbody.innerHTML = '';
        if (!data.length) {
            tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">Sin registros.</td></tr>`;
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
            ${r.titulo ?? ''}
            ${r.is_active ? '' : '<span class="badge bg-secondary ms-2">Inactivo</span>'}
          </td>
          <td class="text-muted col-desc">${r.descripcion ?? ''}</td>
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
            const res = await fetch(window.MARCO_ROUTES.grid);
            if (!res.ok) throw new Error('HTTP ' + res.status);
            rows = await res.json();
            renderTable(searchInput?.value || '', 1);
        } catch (e) {
            notify('danger', 'No se pudo cargar la lista.');
        }
    }

    // ====== Eventos ======
    searchInput?.addEventListener('input', e => renderTable(e.target.value, 1));

    tbody?.addEventListener('click', async e => {
        const btn = e.target.closest('button');
        if (!btn) return;

        const id = Number(btn.dataset.id);
        const action = btn.dataset.action;

        if (action === 'edit') {
            const r = rows.find(x => x.id === id);
            if (!r) return notify('danger', 'No se encontró el registro.');
            editId.value = r.id;
            editTitulo.value = r.titulo ?? '';
            editDesc.value = r.descripcion ?? '';
            editActive.checked = !!r.is_active;
            modalEditar.show();
        }

        if (action === 'delete') {
            if (!confirm('¿Eliminar el registro?')) return;
            try {
                const res = await fetch(window.MARCO_ROUTES.destroy.replace(':id', id), {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' }
                });
                if (!res.ok) throw new Error('HTTP ' + res.status);
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
            descripcion: (createDesc?.value || '').trim(),
            is_active: createActive?.checked ? 1 : 0
        };
        try {
            const res = await fetch(window.MARCO_ROUTES.store, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });
            if (!res.ok) throw new Error('HTTP ' + res.status);
            formNuevo.reset();
            if (createActive) createActive.checked = true;
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
            descripcion: (editDesc?.value || '').trim(),
            is_active: editActive?.checked ? 1 : 0
        };
        try {
            const res = await fetch(window.MARCO_ROUTES.update.replace(':id', id), {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });
            if (!res.ok) throw new Error('HTTP ' + res.status);
            modalEditar.hide();
            await fetchGrid();
            notify('success', 'Cambios guardados.');
        } catch {
            notify('danger', 'No se pudo actualizar.');
        }
    });

    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-delete');
        if (!btn) return;

        const id = btn.getAttribute('data-id');
        const title = btn.getAttribute('data-title') || 'este registro';

        const form = document.getElementById('formEliminar');
        const delTitle = document.getElementById('delTitulo');

        const tpl = (window.MARCO_ROUTES && window.MARCO_ROUTES.destroy) || '';
        const url = tpl.replace(':id', id);

        if (form && url) form.setAttribute('action', url);
        if (delTitle) delTitle.textContent = title;
    });

    // ====== Inicial ======
    fetchGrid();
});