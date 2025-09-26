/* Transparencia > Libro de Reclamaciones > Reclamos
 * Lista, filtros, paginación, cambio de estado y CRUD de respuesta (ver documento inline).
 */
'use strict';

document.addEventListener('DOMContentLoaded', () => {
    // ---- Elementos base ----
    const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const tbody = document.getElementById('tupaBody');
    const pager = document.getElementById('paginationContainer');
    const filtroTipo = document.getElementById('filtroTipo');
    const searchInput = document.getElementById('searchInput');
    const alertContainer = document.getElementById('alertContainer');

    // ---- Modales ----
    const modalRespuestaEl = document.getElementById('modalRespuesta');
    const modalRespuesta = new bootstrap.Modal(modalRespuestaEl);
    const formRespuesta = document.getElementById('formRespuesta');

    const modalDeleteEl = document.getElementById('modalDeleteRespuesta');
    const modalDelete = new bootstrap.Modal(modalDeleteEl);
    const formDelete = document.getElementById('formDeleteRespuesta');

    // ---- Inputs de modales ----
    const resp_reclamo_id = document.getElementById('resp_reclamo_id');
    const resp_mode = document.getElementById('resp_mode');
    const resp_respuesta = document.getElementById('resp_respuesta');
    const resp_fecha = document.getElementById('resp_fecha');
    const resp_documento = document.getElementById('resp_documento');
    const resp_doc_actual = document.getElementById('resp_doc_actual');
    const modalRespuestaTitle = document.getElementById('modalRespuestaTitle');

    const del_reclamo_id = document.getElementById('del_reclamo_id');

    // ---- Estado ----
    let rows = [];
    let estados = [];
    const itemsPerPage = 5;
    let currentPage = 1;

    // ---- Rutas ----
    const buildUpdUrl = (id) => window.RECLAMOS_ROUTES.updEst.replace('_ID_', String(id));
    const buildStoreUrl = (id) => window.RECLAMOS_ROUTES.respStore.replace('_ID_', String(id));
    const buildUpdateUrl = (id) => window.RECLAMOS_ROUTES.respUpdate.replace('_ID_', String(id));
    const buildDeleteUrl = (id) => window.RECLAMOS_ROUTES.respDelete.replace('_ID_', String(id));

    // ---- Utils ----
    const estadoNombre = (id) => (estados.find(x => Number(x.id) === Number(id))?.nombre) || '';
    const esc = (s = '') => String(s).replace(/[&<>"']/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[m]));

    const showAlert = (type, message) => {
        alertContainer.style.display = 'block';
        alertContainer.className = `alert alert-${type}`;
        alertContainer.textContent = message;
        clearTimeout(showAlert._t);
        showAlert._t = setTimeout(() => { alertContainer.style.display = 'none'; }, 3500);
    };

    function iconDoc(url) {
        const ico = `<i class="fa-regular fa-file-lines"></i>`;
        return url
            ? `<a href="${url}" target="_blank" rel="noopener" title="Abrir documento">${ico}</a>`
            : `<span class="text-muted" title="Sin documento">${ico}</span>`;
    }

    async function readJsonSafe(res) {
        const ct = (res.headers.get('content-type') || '').toLowerCase();
        const text = await res.text();                  // leemos una vez
        if (ct.includes('application/json')) {
            try { return JSON.parse(text); } catch { }
        }
        // A veces devuelven JSON pero sin content-type correcto:
        try { return JSON.parse(text); } catch { }
        return { _raw: text }; // devolvemos algo para no romper el flujo
    }


    // ---- Catálogos ----
    async function loadTipos() {
        try {
            const res = await fetch(window.RECLAMOS_ROUTES.tipos, { credentials: 'same-origin' });
            if (!res.ok) throw new Error(`HTTP ${res.status}`);
            const data = await res.json();
            filtroTipo.innerHTML =
                `<option value="">— Filtrar por Tipo de Reclamación —</option>` +
                data.map(t => `<option value="${t.id}">${esc(t.nombre)}</option>`).join('');
        } catch (err) {
            console.error('Error cargando tipos:', err);
            filtroTipo.innerHTML = `<option value="">(sin tipos)</option>`;
        }
    }

    async function loadEstados() {
        try {
            const res = await fetch(window.RECLAMOS_ROUTES.estados, { credentials: 'same-origin' });
            if (!res.ok) throw new Error(`HTTP ${res.status}`);
            estados = await res.json();
        } catch (err) {
            console.error('Error cargando estados:', err);
            estados = [];
        }
    }

    // ---- Grid ----
    async function fetchGrid() {
        try {
            const params = new URLSearchParams();
            if (filtroTipo.value) params.set('tipo_reclamacion_id', filtroTipo.value);
            if (searchInput.value.trim()) params.set('search', searchInput.value.trim());

            const url = `${window.RECLAMOS_ROUTES.grid}?${params.toString()}`;
            const res = await fetch(url, { credentials: 'same-origin' });
            if (!res.ok) throw new Error(`HTTP ${res.status}`);

            rows = await res.json();
            currentPage = 1;
            renderTable();
            renderPagination();
        } catch (err) {
            console.error('Error cargando grid:', err);
            rows = [];
            renderTable();
            renderPagination();
            showAlert('danger', 'No se pudo cargar la lista de reclamos.');
        }
    }

    function renderTable() {
        tbody.innerHTML = '';
        if (!rows.length) {
            tbody.innerHTML = `<tr><td colspan="16" class="text-center text-muted">Sin registros.</td></tr>`;
            pager.innerHTML = '';
            return;
        }

        const start = (currentPage - 1) * itemsPerPage;
        const pageRows = rows.slice(start, start + itemsPerPage);

        for (const r of pageRows) {
            const nombreCompleto = `${r.nombres ?? ''} ${r.apellidos ?? ''}`.trim();
            const tipoDoc = r.tipo_documento?.nombre_corto || r.tipo_documento?.nombre || '';
            const tipoRecl = r.tipo_reclamacion?.nombre || '';

            // === Regla: si YA tiene respuesta, deshabilitar botón "add" ===
            const hasRespuesta = !!(r.respuesta && String(r.respuesta).trim().length);
            const addDisabled = hasRespuesta || !!r.fecha_respuesta || !!r.documento_respuesta;

            const tr = document.createElement('tr');
            tr.dataset.id = r.id;
            tr.innerHTML = `
        <td>${r.id}</td>
        <td>${esc(tipoDoc)}</td>
        <td>${esc(r.numero_documento ?? '')}</td>
        <td>${esc(nombreCompleto)}</td>
        <td>${esc(r.telefono ?? '')}</td>
        <td>${esc(r.email ?? '')}</td>
        <td>${esc(tipoRecl)}</td>
        <td>${esc(r.area_relacionada ?? '')}</td>
        <td>${esc(r.fecha_incidente ?? '')}</td>
        <td>${esc(r.asunto ?? '')}</td>
        <td class="col-descripcion"><div class="td-clip" title="${esc(r.descripcion ?? '')}">${esc(r.descripcion ?? '')}</div></td>
        <td class="col-estado">
          <select class="form-select w-100 estado-select" data-id="${r.id}" data-prev="${r.estado_id}" title="${esc(estadoNombre(r.estado_id))}">
            ${estados.map(e => `<option value="${e.id}" ${Number(r.estado_id) === Number(e.id) ? 'selected' : ''}>${esc(e.nombre)}</option>`).join('')}
          </select>
        </td>
        <td class="col-respuesta">${esc(r.respuesta ?? '')}</td>
        <td class="col-doc">${iconDoc(r.documento_ver_url || r.documento_url)}</td>
        <td class="col-fecha">${esc(r.fecha_respuesta ?? '')}</td>
        <td class="col-acciones">
          <button class="btn btn-sm btn-success me-1"
                  data-accion="add" data-id="${r.id}"
                  title="${addDisabled ? 'Ya tiene respuesta' : 'Añadir respuesta'}"
                  ${addDisabled ? 'disabled aria-disabled="true"' : ''}>
            <i class="fa-solid fa-plus"></i>
          </button>
          <button class="btn btn-sm btn-warning me-1" data-accion="edit"   data-id="${r.id}" title="Editar respuesta">
            <i class="fa-regular fa-pen-to-square"></i>
          </button>
          <button class="btn btn-sm btn-danger"       data-accion="delete" data-id="${r.id}" title="Eliminar respuesta">
            <i class="fa-regular fa-trash-can"></i>
          </button>
        </td>
      `;
            tbody.appendChild(tr);
        }
    }

    function renderPagination() {
        pager.innerHTML = '';
        if (!rows.length) return;

        const totalPages = Math.ceil(rows.length / itemsPerPage);
        const nav = document.createElement('nav');
        const ul = document.createElement('ul');
        ul.className = 'pagination mb-0';

        const mk = (label, disabled, handler) => {
            const li = document.createElement('li');
            li.className = `page-item ${disabled ? 'disabled' : ''}`;
            li.innerHTML = `<a class="page-link" href="#">${label}</a>`;
            li.addEventListener('click', e => { e.preventDefault(); if (!disabled) handler(); });
            return li;
        };

        ul.appendChild(mk('«', currentPage === 1, () => { currentPage--; renderTable(); renderPagination(); }));

        for (let p = 1; p <= totalPages; p++) {
            const li = document.createElement('li');
            li.className = `page-item ${p === currentPage ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" href="#">${p}</a>`;
            li.addEventListener('click', e => { e.preventDefault(); currentPage = p; renderTable(); renderPagination(); });
            ul.appendChild(li);
        }

        ul.appendChild(mk('»', currentPage === totalPages, () => { currentPage++; renderTable(); renderPagination(); }));

        nav.appendChild(ul);
        pager.appendChild(nav);
    }

    // ---- Filtros ----
    filtroTipo.addEventListener('change', fetchGrid);
    searchInput.addEventListener('input', () => {
        clearTimeout(searchInput._t);
        searchInput._t = setTimeout(fetchGrid, 250);
    });

    // ---- Cambio de estado ----
    tbody.addEventListener('change', async e => {
        const sel = e.target.closest('.estado-select');
        if (!sel) return;

        const id = sel.dataset.id;
        const prevValue = sel.getAttribute('data-prev');
        const estado_id = sel.value;

        sel.disabled = true; sel.classList.add('opacity-50');

        try {
            const res = await fetch(buildUpdUrl(id), {
                method: 'PUT',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': CSRF,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ estado_id })
            });
            if (!res.ok) throw new Error(`HTTP ${res.status}`);
            const json = await res.json();

            const row = rows.find(x => String(x.id) === String(id));
            if (row) row.estado_id = Number(json.estado_id);

            sel.setAttribute('data-prev', String(json.estado_id));
            sel.title = json.estado_nombre || '';
            showAlert('success', 'Estado actualizado.');
        } catch (err) {
            sel.value = prevValue ?? sel.value;
            showAlert('danger', 'No se pudo actualizar el estado.');
        } finally {
            sel.disabled = false; sel.classList.remove('opacity-50');
        }
    });

    // ---- Abrir modales ----
    tbody.addEventListener('click', (e) => {
        const btn = e.target.closest('button[data-accion]');
        if (!btn) return;

        // Si el botón está deshabilitado, no hacemos nada
        if (btn.hasAttribute('disabled')) return;

        const id = btn.dataset.id;
        const row = rows.find(x => String(x.id) === String(id));
        if (!row) return;

        if (btn.dataset.accion === 'add') {
            modalRespuestaTitle.textContent = 'Agregar respuesta';
            resp_mode.value = 'create';
            resp_reclamo_id.value = id;
            resp_respuesta.value = '';
            resp_fecha.value = '';
            resp_documento.value = '';
            resp_doc_actual.style.display = 'none';
            modalRespuesta.show();
        }

        if (btn.dataset.accion === 'edit') {
            document.getElementById('modalRespuestaTitle').textContent = 'Editar respuesta';
            resp_mode.value = 'edit';
            resp_reclamo_id.value = id;
            resp_respuesta.value = row.respuesta ?? '';
            resp_fecha.value = row.fecha_respuesta ?? '';
            resp_documento.value = '';
            if (row.documento_ver_url || row.documento_url) {
                const link = row.documento_ver_url || row.documento_url;
                resp_doc_actual.style.display = 'block';
                resp_doc_actual.innerHTML = `Documento actual: <a href="${link}" target="_blank" rel="noopener">ver archivo</a>`;
            } else {
                resp_doc_actual.style.display = 'none';
            }
            modalRespuesta.show();
        }

        if (btn.dataset.accion === 'delete') {
            document.getElementById('del_reclamo_id').value = id;
            modalDelete.show();
        }
    });

    // ---- Guardar respuesta ----
    formRespuesta.addEventListener('submit', async (e) => {
        e.preventDefault();

        const id = resp_reclamo_id.value;
        const isEdit = (resp_mode.value === 'edit');
        const url = isEdit ? buildUpdateUrl(id) : buildStoreUrl(id);

        const fd = new FormData();
        fd.append('respuesta', resp_respuesta.value);
        if (resp_fecha.value) fd.append('fecha_respuesta', resp_fecha.value);
        if (resp_documento.files[0]) fd.append('documento', resp_documento.files[0]);
        if (isEdit) fd.append('_method', 'PUT'); // spoof para PUT con archivos

        try {
            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: fd,
                credentials: 'same-origin'
            });

            // Si NO es 2xx => error real
            if (!res.ok) {
                const body = await res.text();
                throw new Error(`HTTP ${res.status} ${res.statusText}: ${body.slice(0, 300)}`);
            }

            // 2xx: intentamos leer JSON; si falla, igual consideramos éxito
            const json = await readJsonSafe(res);

            if (json && json.ok && json.reclamo) {
                const idx = rows.findIndex(x => String(x.id) === String(id));
                if (idx !== -1) {
                    rows[idx] = {
                        ...rows[idx],
                        ...json.reclamo,
                        documento_url: json.reclamo?.documento_url ?? rows[idx].documento_url,
                        documento_ver_url: json.reclamo?.documento_ver_url ?? rows[idx].documento_ver_url
                    };
                }
            } else {
                // Respuesta no-JSON (p.ej. HTML de login/debugbar). Refrescamos desde el servidor.
                await fetchGrid();
            }

            modalRespuesta.hide();
            renderTable(); // por si no hubo fetchGrid
            showAlert('success', isEdit ? 'Respuesta actualizada.' : 'Respuesta agregada.');
        } catch (err) {
            console.error('[RESPUESTA SAVE] ', err);
            showAlert('danger', 'No se pudo guardar la respuesta.');
        }
    });


    // ---- Eliminar respuesta ----
    formDelete.addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = del_reclamo_id.value;

        try {
            const res = await fetch(buildDeleteUrl(id), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            if (!res.ok) {
                const body = await res.text();
                throw new Error(`HTTP ${res.status} ${res.statusText}: ${body.slice(0, 300)}`);
            }

            const json = await readJsonSafe(res);

            if (json && json.ok && json.reclamo) {
                const idx = rows.findIndex(x => String(x.id) === String(id));
                if (idx !== -1) rows[idx] = { ...rows[idx], ...json.reclamo };
            } else {
                await fetchGrid();
            }

            modalDelete.hide();
            renderTable();
            showAlert('success', 'Respuesta eliminada.');
        } catch (err) {
            console.error('[RESPUESTA DELETE] ', err);
            showAlert('danger', 'No se pudo eliminar la respuesta.');
        }
    });

    // ---- Init ----
    Promise.all([loadTipos(), loadEstados()]).then(fetchGrid);
});
