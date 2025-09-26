// public/js/admin/academicos.js
let deleteId = null;

(() => {
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';

    // Rutas inyectadas desde el <body data-*> del Blade
    const D = document.body.dataset || {};
    const URL_DOCENTES = D.docentesUrl || '';                 // ?programa={id}
    const URL_LIST = D.listUrl || '';                     // ?docente={id}
    const URL_STORE = D.storeUrl || '';
    const URL_SHOW_TPL = D.showUrlTpl || '';                  // .../__ID__
    const URL_UPDATE_TPL = D.updateUrlTpl || '';                // .../__ID__
    const URL_DESTROY_TPL = D.destroyUrlTpl || '';               // .../__ID__

    // Filtros / tabla
    const programSelect = document.getElementById('programSelect');
    const docenteSelect = document.getElementById('docenteSelect');
    const tbody = document.getElementById('tbodyAcademicos');

    // Modales
    const modalNuevo = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalNuevo'));
    const modalEditar = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalEditar'));
    const modalEliminar = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalEliminar'));

    // Formularios / botones
    const formNuevo = document.getElementById('formNuevo');
    const formEditar = document.getElementById('formEditar');
    const btnNuevo = document.getElementById('btnNuevo');
    const btnSaveNew = document.getElementById('btnGuardarNuevo');
    const btnSaveEdit = document.getElementById('btnGuardarEditar');
    const btnConfirmDel = document.getElementById('btnConfirmEliminar');

    // Campos NUEVO
    const newProgramaId = document.getElementById('newProgramaId');
    const newDocenteId = document.getElementById('newDocenteId');

    // Campos EDITAR
    const editId = document.getElementById('editId');
    const editProgramaId = document.getElementById('editProgramaId');
    const editDocenteId = document.getElementById('editDocenteId');
    const editGrado = document.getElementById('editGrado');
    const editSituacion = document.getElementById('editSituacion');
    const editEspecialidad = document.getElementById('editEspecialidad');
    const editInstitucion = document.getElementById('editInstitucion');
    const editFecha = document.getElementById('editFecha');
    const editRegistro = document.getElementById('editRegistro');

    function renderEmpty(msg = 'Seleccione un programa y luego un docente para listar los datos académicos.') {
        tbody.innerHTML = `<tr class="empty-row"><td colspan="8">${msg}</td></tr>`;
    }

    async function loadDocentes(programId, targetSelect) {
        targetSelect.innerHTML = `<option value="">Cargando…</option>`;
        if (!programId) {
            targetSelect.innerHTML = `<option value="">Seleccione un docente</option>`;
            return;
        }
        const url = `${URL_DOCENTES}?programa=${encodeURIComponent(programId)}`;
        const resp = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        const { data = [] } = await resp.json();
        if (!data.length) {
            targetSelect.innerHTML = `<option value="">(Sin docentes)</option>`;
            return;
        }
        targetSelect.innerHTML =
            `<option value="" selected>Seleccione un docente</option>` +
            data.map(d => `<option value="${d.id}">${d.nombre}</option>`).join('');
    }

    async function loadAcademicos(docenteId) {
        if (!docenteId) {
            renderEmpty('Seleccione un docente para listar los datos académicos.');
            return;
        }
        tbody.innerHTML = `<tr class="empty-row"><td colspan="8">Cargando…</td></tr>`;
        try {
            const url = `${URL_LIST}?docente=${encodeURIComponent(docenteId)}`;
            const resp = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const { data = [] } = await resp.json();

            if (!data.length) {
                renderEmpty('No hay registros para este docente.');
                return;
            }

            tbody.innerHTML = data.map((r, i) => `
          <tr>
            <td>${i + 1}</td>
            <td class="text-muted fw-semibold">${r.grado ?? ''}</td>
            <td class="text-muted">${r.situacion_academica ?? ''}</td>
            <td class="text-muted">${r.especialidad ?? ''}</td>
            <td class="text-muted">${r.institucion_educativa ?? ''}</td>
            <td class="text-muted">${r.fecha_emision ?? ''}</td>
            <td class="text-muted">${r.registro ?? ''}</td>
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
          </tr>
        `).join('');
        } catch (e) {
            console.error(e);
            renderEmpty('Ocurrió un error al cargar los datos.');
        }
    }

    // ===== Filtros
    programSelect.addEventListener('change', async (e) => {
        await loadDocentes(e.target.value, docenteSelect);
        renderEmpty('Seleccione un docente para listar los datos académicos.');
    });
    docenteSelect.addEventListener('change', (e) => loadAcademicos(e.target.value));

    // ===== Nuevo
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
            const resp = await fetch(URL_STORE, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrf },
                body: fd
            });
            if (!resp.ok) {
                let msg = 'Error al guardar';
                try { msg = (await resp.json()).message || msg; } catch { }
                throw new Error(msg);
            }
            const json = await resp.json();
            if (!json.ok) throw new Error('No se pudo guardar');

            if (docenteSelect.value === fd.get('docente_id')) {
                await loadAcademicos(docenteSelect.value);
            }
            modalNuevo.hide();
        } catch (err) {
            console.error(err);
            alert(err.message || 'Hubo un problema al guardar.');
        } finally {
            btnSaveNew.disabled = false;
        }
    });

    // ===== Editar
    tbody.addEventListener('click', async (e) => {
        const btn = e.target.closest('.btn-edit');
        if (!btn) return;

        try {
            const resp = await fetch(URL_SHOW_TPL.replace('__ID__', btn.dataset.id), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            if (!resp.ok) throw new Error('No se pudo obtener el registro.');
            const d = await resp.json();

            editId.value = d.id;
            editProgramaId.value = programSelect.value || '';
            await loadDocentes(editProgramaId.value, editDocenteId);
            editDocenteId.value = d.docente_id;

            editGrado.value = d.grado ?? '';
            editSituacion.value = d.situacion_academica ?? '';
            editEspecialidad.value = d.especialidad ?? '';
            editInstitucion.value = d.institucion_educativa ?? '';
            editFecha.value = d.fecha_emision ?? '';
            editRegistro.value = d.registro ?? '';

            modalEditar.show();
        } catch (err) {
            console.error(err);
            alert('No se pudo cargar la información.');
        }
    });

    formEditar.addEventListener('submit', async (e) => {
        e.preventDefault();
        btnSaveEdit.disabled = true;
        const id = editId.value;
        try {
            const fd = new FormData(formEditar); // incluye _method=PUT
            const resp = await fetch(URL_UPDATE_TPL.replace('__ID__', id), {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrf },
                body: fd
            });
            if (!resp.ok) {
                let msg = 'Error al actualizar';
                try { msg = (await resp.json()).message || msg; } catch { }
                throw new Error(msg);
            }
            const json = await resp.json();
            if (!json.ok) throw new Error('No se pudo actualizar');

            if (docenteSelect.value) await loadAcademicos(docenteSelect.value);
            modalEditar.hide();
        } catch (err) {
            console.error(err);
            alert(err.message || 'Hubo un problema al actualizar.');
        } finally {
            btnSaveEdit.disabled = false;
        }
    });

    // ===== Eliminar
    let deleteId = null;
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
            const resp = await fetch(URL_DESTROY_TPL.replace('__ID__', deleteId), {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest' }
            });
            if (!resp.ok) {
                let msg = 'No se pudo eliminar';
                try { msg = (await resp.json()).message || msg; } catch { }
                throw new Error(msg);
            }
            const json = await resp.json();
            if (!json.ok) throw new Error('No se pudo eliminar');

            modalEliminar.hide();
            deleteId = null;
            if (docenteSelect.value) await loadAcademicos(docenteSelect.value);
        } catch (err) {
            console.error(err);
            alert(err.message || 'Error al eliminar.');
        } finally {
            btnConfirmDel.disabled = false;
        }
    });

    // Estado inicial
    renderEmpty();
})();
