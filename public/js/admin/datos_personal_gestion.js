// public/js/admin/datos_personal_gestion.js
(() => {
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';

    // Rutas desde <body data-*="">
    const DS = document.body.dataset || {};
    const URL_DOCENTES = DS.docentesUrl || '';          // ?programa={id}
    const URL_LIST = DS.listUrl || '';              // ?docente={id}
    const URL_STORE = DS.storeUrl || '';
    const URL_SHOW_TPL = DS.showUrlTpl || '';           // .../__ID__
    const URL_UPDATE_TPL = DS.updateUrlTpl || '';         // .../__ID__
    const URL_DESTROY_TPL = DS.destroyUrlTpl || '';        // .../__ID__

    // Filtros
    const selPrograma = document.getElementById('selPrograma');
    const selDocente = document.getElementById('selDocente');
    const btnNuevo = document.getElementById('btnNuevo');
    const tbody = document.getElementById('tbodyDatos');

    // Modales
    const modalNuevo = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalNuevo'), { backdrop: true });
    const modalEditar = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalEditar'), { backdrop: true });
    const modalEliminar = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalEliminar'), { backdrop: true });

    // Formularios / botones
    const formNuevo = document.getElementById('formNuevo');
    const formEditar = document.getElementById('formEditar');
    const btnSaveNew = document.getElementById('btnGuardarNuevo');
    const btnSaveEdit = document.getElementById('btnGuardarEditar');
    const btnConfirmDel = document.getElementById('btnConfirmEliminar');

    // Campos modal NUEVO
    const newPrograma = document.getElementById('newPrograma');
    const newDocente = document.getElementById('newDocente');

    // Campos modal EDITAR
    const editId = document.getElementById('editId');
    const editPrograma = document.getElementById('editPrograma');
    const editDocente = document.getElementById('editDocente');
    const editNombres = document.getElementById('editNombres');
    const editApellidos = document.getElementById('editApellidos');
    const editCorreo = document.getElementById('editCorreo');
    const editTelefono = document.getElementById('editTelefono');

    // Eliminar
    const delNombreEl = document.getElementById('delNombre');
    let deleteId = null;

    function renderEmpty(msg = 'Seleccione programa y docente para listar los datos.') {
        tbody.innerHTML = `<tr class="empty-row"><td colspan="6">${msg}</td></tr>`;
    }

    function escapeHtml(str) {
        const d = document.createElement('div');
        d.innerText = str ?? '';
        return d.innerHTML;
    }

    async function loadDocentes(programaId, targetSelect) {
        targetSelect.innerHTML = `<option value="">Cargando…</option>`;
        targetSelect.disabled = true;

        try {
            const url = `${URL_DOCENTES}?programa=${encodeURIComponent(programaId)}`;
            const r = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const { data = [] } = await r.json();

            if (!data.length) {
                targetSelect.innerHTML = `<option value="">Sin docentes</option>`;
                return;
            }
            targetSelect.innerHTML =
                `<option value="">Seleccione un docente</option>` +
                data.map(d => `<option value="${d.id}">${escapeHtml(d.nombre)}</option>`).join('');
            targetSelect.disabled = false;
        } catch (e) {
            console.error(e);
            targetSelect.innerHTML = `<option value="">Error al cargar</option>`;
        }
    }

    async function loadDatos(docenteId) {
        if (!docenteId) {
            renderEmpty();
            return;
        }
        tbody.innerHTML = `<tr class="empty-row"><td colspan="6">Cargando…</td></tr>`;
        try {
            const url = `${URL_LIST}?docente=${encodeURIComponent(docenteId)}`;
            const r = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const { data = [] } = await r.json();

            if (!data.length) {
                renderEmpty('No hay registros para este docente.');
                return;
            }
            tbody.innerHTML = data.map((d, i) => `
          <tr>
            <td>${i + 1}</td>
            <td class="text-muted fw-semibold">${escapeHtml(d.nombres)}</td>
            <td class="text-muted">${escapeHtml(d.apellidos)}</td>
            <td class="text-muted">${escapeHtml(d.correo)}</td>
            <td class="text-muted">${escapeHtml(d.telefono || '')}</td>
            <td class="text-center">
              <div class="d-inline-flex gap-1">
                <button class="btn btn-warning btn-sm text-white btn-edit" data-id="${d.id}" title="Editar">
                  <i class="fa-regular fa-pen-to-square"></i>
                </button>
                <button class="btn btn-danger btn-sm btn-del" data-id="${d.id}"
                        data-nombre="${encodeURIComponent((d.nombres || '') + ' ' + (d.apellidos || ''))}"
                        title="Eliminar">
                  <i class="fa-regular fa-trash-can"></i>
                </button>
              </div>
            </td>
          </tr>
        `).join('');
        } catch (e) {
            console.error(e);
            renderEmpty('Ocurrió un error al cargar.');
        }
    }

    // Filtro: programa → docentes
    selPrograma.addEventListener('change', async e => {
        const pid = e.target.value;
        selDocente.innerHTML = `<option value="">Seleccione un docente</option>`;
        selDocente.disabled = true;
        btnNuevo.disabled = true;
        renderEmpty();

        if (!pid) return;
        await loadDocentes(pid, selDocente);
    });

    // Filtro: docente → datos personales
    selDocente.addEventListener('change', e => {
        const did = e.target.value;
        btnNuevo.disabled = !did;
        loadDatos(did);
    });

    // ---------- NUEVO ----------
    btnNuevo.addEventListener('click', async () => {
        // preseleccionar filtros actuales
        newPrograma.value = selPrograma.value || '';
        newDocente.innerHTML = `<option value="">Seleccione…</option>`;
        newDocente.disabled = true;

        if (newPrograma.value) await loadDocentes(newPrograma.value, newDocente);
        if (selDocente.value) newDocente.value = selDocente.value;

        formNuevo.reset(); // limpia inputs
        // mantener selects después del reset
        newPrograma.value = selPrograma.value || '';
        if (newPrograma.value) await loadDocentes(newPrograma.value, newDocente);
        if (selDocente.value) newDocente.value = selDocente.value;

        modalNuevo.show();
    });

    // cascada dentro del modal nuevo
    newPrograma.addEventListener('change', async e => {
        newDocente.innerHTML = `<option value="">Seleccione…</option>`;
        newDocente.disabled = true;
        if (e.target.value) await loadDocentes(e.target.value, newDocente);
    });

    formNuevo.addEventListener('submit', async e => {
        e.preventDefault();
        btnSaveNew.disabled = true;
        try {
            const fd = new FormData(formNuevo);
            const r = await fetch(URL_STORE, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrf
                },
                body: fd
            });
            if (!r.ok) throw new Error((await r.json()).message || 'Error al guardar');
            const j = await r.json();
            if (!j.ok) throw new Error('No se pudo guardar');
            modalNuevo.hide();

            // refrescar si coincide el docente actual
            if (selDocente.value && selDocente.value === String(fd.get('docente_id'))) {
                await loadDatos(selDocente.value);
            }
        } catch (e) {
            console.error(e);
            alert(e.message || 'Error al guardar.');
        } finally {
            btnSaveNew.disabled = false;
        }
    });

    // ---------- EDITAR ----------
    tbody.addEventListener('click', async e => {
        const btn = e.target.closest('.btn-edit');
        if (!btn) return;

        const id = btn.dataset.id;
        try {
            const r = await fetch(URL_SHOW_TPL.replace('__ID__', id), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            if (!r.ok) throw new Error('No se pudo obtener el registro');
            const d = await r.json();

            editId.value = d.id;

            // Preseleccionar programa/docente actuales (usamos los filtros ya elegidos)
            editPrograma.value = selPrograma.value || '';
            editDocente.innerHTML = `<option value="">Seleccione…</option>`;
            editDocente.disabled = true;
            if (editPrograma.value) await loadDocentes(editPrograma.value, editDocente);
            editDocente.value = String(d.docente_id);

            editNombres.value = d.nombres || '';
            editApellidos.value = d.apellidos || '';
            editCorreo.value = d.correo || '';
            editTelefono.value = d.telefono || '';

            modalEditar.show();
        } catch (e) {
            console.error(e);
            alert('No se pudo cargar la información.');
        }
    });

    // cascada en modal editar
    editPrograma.addEventListener('change', async e => {
        editDocente.innerHTML = `<option value="">Seleccione…</option>`;
        editDocente.disabled = true;
        if (e.target.value) await loadDocentes(e.target.value, editDocente);
    });

    formEditar.addEventListener('submit', async e => {
        e.preventDefault();
        btnSaveEdit.disabled = true;
        const id = editId.value;
        try {
            const fd = new FormData(formEditar); // incluye _method=PUT
            const r = await fetch(URL_UPDATE_TPL.replace('__ID__', id), {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrf
                },
                body: fd
            });
            if (!r.ok) throw new Error((await r.json()).message || 'Error al actualizar');
            const j = await r.json();
            if (!j.ok) throw new Error('No se pudo actualizar');

            modalEditar.hide();
            if (selDocente.value) await loadDatos(selDocente.value);
        } catch (e) {
            console.error(e);
            alert(e.message || 'Error al actualizar.');
        } finally {
            btnSaveEdit.disabled = false;
        }
    });

    // ---------- ELIMINAR ----------
    tbody.addEventListener('click', e => {
        const btn = e.target.closest('.btn-del');
        if (!btn) return;
        deleteId = btn.dataset.id;
        const n = decodeURIComponent(btn.dataset.nombre || '');
        delNombreEl.textContent = n || 'este registro';
        modalEliminar.show();
    });

    btnConfirmDel.addEventListener('click', async () => {
        if (!deleteId) return;
        btnConfirmDel.disabled = true;
        try {
            const r = await fetch(URL_DESTROY_TPL.replace('__ID__', deleteId), {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrf
                }
            });
            if (!r.ok) throw new Error((await r.json()).message || 'No se pudo eliminar');
            const j = await r.json();
            if (!j.ok) throw new Error('No se pudo eliminar');

            modalEliminar.hide();
            deleteId = null;
            if (selDocente.value) await loadDatos(selDocente.value);
        } catch (e) {
            console.error(e);
            alert(e.message || 'Error al eliminar.');
        } finally {
            btnConfirmDel.disabled = false;
        }
    });
})();
