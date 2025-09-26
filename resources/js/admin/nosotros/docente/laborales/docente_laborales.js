// public/js/admin/laborales_gestion.js
(() => {
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';

    /* -------------------------------------------------
     * Rutas dinámicas (viene de la vista Blade)
     * ------------------------------------------------- */
    const DS = document.body.dataset || {};
    const URL_DOCENTES = DS.docentesUrl || '';        // ?programa={id}
    const URL_LIST = DS.listUrl || '';            // ?docente={id}
    const URL_STORE = DS.storeUrl || '';
    const URL_SHOW_TPL = DS.showUrlTpl || '';         // .../__ID__
    const URL_UPDATE_TPL = DS.updateUrlTpl || '';       // .../__ID__
    const URL_DESTROY_TPL = DS.destroyUrlTpl || '';      // .../__ID__

    /* -------------------------------------------------
     * Referencias DOM
     * ------------------------------------------------- */
    const programSelect = document.getElementById('programSelect');
    const docenteSelect = document.getElementById('docenteSelect');
    const tbody = document.getElementById('tbodyLaborales');

    const modalNuevo = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalNuevo'));
    const modalEditar = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalEditar'));
    const modalEliminar = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalEliminar'));

    const btnNuevo = document.getElementById('btnNuevo');
    const formNuevo = document.getElementById('formNuevo');
    const btnSaveNew = document.getElementById('btnGuardarNuevo');

    const newProgramaId = document.getElementById('newProgramaId');
    const newDocenteId = document.getElementById('newDocenteId');

    const formEditar = document.getElementById('formEditar');
    const btnSaveEdit = document.getElementById('btnGuardarEditar');
    const editId = document.getElementById('editId');
    const editProgramaId = document.getElementById('editProgramaId');
    const editDocenteId = document.getElementById('editDocenteId');
    const editInstitucion = document.getElementById('editInstitucion');
    const editCargo = document.getElementById('editCargo');
    const editExperiencia = document.getElementById('editExperiencia');
    const editInicio = document.getElementById('editInicio');
    const editTermino = document.getElementById('editTermino');

    const btnConfirmDel = document.getElementById('btnConfirmEliminar');
    let deleteId = null;

    /* -------------------------------------------------
     * Helpers
     * ------------------------------------------------- */
    function renderEmpty(msg = 'Seleccione un programa y luego un docente para listar los datos laborales.') {
        tbody.innerHTML = `<tr class="empty-row"><td colspan="8">${msg}</td></tr>`;
    }

    async function loadDocentes(programId, targetSelect) {
        targetSelect.innerHTML = `<option value="">Cargando…</option>`;
        targetSelect.disabled = true;
        if (!programId) {
            targetSelect.innerHTML = `<option value="">Seleccione un docente</option>`;
            return;
        }
        try {
            const url = `${URL_DOCENTES}?programa=${encodeURIComponent(programId)}`;
            const r = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const { data = [] } = await r.json();

            if (!data.length) {
                targetSelect.innerHTML = `<option value="">(Sin docentes)</option>`;
                return;
            }
            targetSelect.innerHTML =
                `<option value="">Seleccione un docente</option>` +
                data.map(d => `<option value="${d.id}">${d.nombre}</option>`).join('');
            targetSelect.disabled = false;
        } catch (e) {
            console.error(e);
            targetSelect.innerHTML = `<option value="">Error al cargar</option>`;
        }
    }

    async function loadLaborales(docenteId) {
        if (!docenteId) { renderEmpty('Seleccione un docente para listar.'); return; }
        tbody.innerHTML = `<tr class="empty-row"><td colspan="8">Cargando…</td></tr>`;
        try {
            const url = `${URL_LIST}?docente=${encodeURIComponent(docenteId)}`;
            const r = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const { data = [] } = await r.json();

            if (!data.length) { renderEmpty('No hay datos laborales para este docente.'); return; }

            tbody.innerHTML = data.map((r, i) => `
                <tr>
                    <td>${i + 1}</td>
                    <td class="text-muted fw-semibold">${r.institucion ?? ''}</td>
                    <td class="text-muted">${r.cargo ?? ''}</td>
                    <td class="text-muted">${r.experiencia ?? ''}</td>
                    <td class="text-muted">${r.inicio_labor ?? ''}</td>
                    <td class="text-muted">${r.termino_labor ?? ''}</td>
                    <td class="text-muted">${r.tiempo_cargo ?? ''}</td>
                    <td class="text-center">
                        <div class="d-inline-flex gap-1">
                            <button class="btn btn-warning btn-sm text-white btn-edit" data-id="${r.id}" title="Editar">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                            <button class="btn btn-danger btn-sm btn-del" data-id="${r.id}" title="Eliminar">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </div>
                    </td>
                </tr>`).join('');
        } catch (e) {
            console.error(e);
            renderEmpty('Ocurrió un error al cargar los datos.');
        }
    }

    /* -------------------------------------------------
     * Filtros
     * ------------------------------------------------- */
    programSelect.addEventListener('change', async (e) => {
        await loadDocentes(e.target.value, docenteSelect);
        renderEmpty('Seleccione un docente para listar.');
    });
    docenteSelect.addEventListener('change', (e) => loadLaborales(e.target.value));

    /* -------------------------------------------------
     * NUEVO
     * ------------------------------------------------- */
    btnNuevo.addEventListener('click', async () => {
        formNuevo.reset();
        newProgramaId.value = programSelect.value || '';
        await loadDocentes(newProgramaId.value, newDocenteId);
        newDocenteId.value = docenteSelect.value || '';
        modalNuevo.show();
    });

    formNuevo.addEventListener('submit', async (e) => {
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
            if (!r.ok) {
                const msg = (await r.json()).message || 'Error al guardar';
                throw new Error(msg);
            }
            const json = await r.json();
            if (!json.ok) throw new Error('No se pudo guardar');

            if (docenteSelect.value === fd.get('docente_id')) await loadLaborales(docenteSelect.value);
            modalNuevo.hide();
        } catch (err) {
            console.error(err); alert(err.message || 'Hubo un problema al guardar.');
        } finally { btnSaveNew.disabled = false; }
    });

    /* -------------------------------------------------
     * EDITAR
     * ------------------------------------------------- */
    tbody.addEventListener('click', async (e) => {
        const btn = e.target.closest('.btn-edit');
        if (!btn) return;

        try {
            const r = await fetch(URL_SHOW_TPL.replace('__ID__', btn.dataset.id), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            if (!r.ok) throw new Error('No se pudo obtener el registro.');
            const d = await r.json();

            editId.value = d.id;
            editProgramaId.value = programSelect.value || '';
            await loadDocentes(editProgramaId.value, editDocenteId);
            editDocenteId.value = d.docente_id;

            editInstitucion.value = d.institucion ?? '';
            editCargo.value = d.cargo ?? '';
            editExperiencia.value = d.experiencia ?? '';
            editInicio.value = d.inicio_labor ?? '';
            editTermino.value = d.termino_labor ?? '';

            modalEditar.show();
        } catch (err) {
            console.error(err); alert('No se pudo cargar la información.');
        }
    });

    formEditar.addEventListener('submit', async (e) => {
        e.preventDefault();
        btnSaveEdit.disabled = true;
        const id = editId.value;
        try {
            const fd = new FormData(formEditar); // _token + _method=PUT
            const r = await fetch(URL_UPDATE_TPL.replace('__ID__', id), {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrf
                },
                body: fd
            });
            if (!r.ok) {
                const msg = (await r.json()).message || 'Error al actualizar';
                throw new Error(msg);
            }
            const json = await r.json();
            if (!json.ok) throw new Error('No se pudo actualizar');

            if (docenteSelect.value) await loadLaborales(docenteSelect.value);
            modalEditar.hide();
        } catch (err) {
            console.error(err); alert(err.message || 'Hubo un problema al actualizar.');
        } finally { btnSaveEdit.disabled = false; }
    });

    /* -------------------------------------------------
     * ELIMINAR
     * ------------------------------------------------- */
    tbody.addEventListener('click', (e) => {
        const btn = e.target.closest('.btn-del');
        if (!btn) return;
        deleteId = btn.dataset.id;
        modalEliminar.show();
    });

    btnConfirmDel.addEventListener('click', async () => {
        if (!deleteId) return;
        btnConfirmDel.disabled = true;
        try {
            const r = await fetch(URL_DESTROY_TPL.replace('__ID__', deleteId), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            if (!r.ok) {
                const msg = (await r.json()).message || 'No se pudo eliminar';
                throw new Error(msg);
            }
            const json = await r.json();
            if (!json.ok) throw new Error('No se pudo eliminar');

            modalEliminar.hide(); deleteId = null;
            if (docenteSelect.value) await loadLaborales(docenteSelect.value);
        } catch (err) {
            console.error(err); alert(err.message || 'Error al eliminar.');
        } finally { btnConfirmDel.disabled = false; }
    });

    /* -------------------------------------------------
     * Inicio
     * ------------------------------------------------- */
    renderEmpty();
})();