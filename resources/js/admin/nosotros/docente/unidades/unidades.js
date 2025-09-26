document.addEventListener('DOMContentLoaded', () => {
    const root = document.getElementById('unidadesApp');
    if (!root) return;

    const URL_DOCENTES = root.dataset.urlDocentes;
    const URL_LISTADO = root.dataset.urlListado;
    const URL_MODULOS = root.dataset.urlModulos;
    const URL_SEMESTRES = root.dataset.urlSemestres;
    const URL_CURSOS = root.dataset.urlCursos;
    const URL_STORE = root.dataset.urlStore;
    const URL_DESTROY = root.dataset.urlDestroy; // + {id}

    const CSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    const $ = (s) => document.querySelector(s);
    const tbody = $('#tbodyUd');
    const selPrograma = $('#selPrograma');
    const selDocente = $('#selDocente');
    const btnNuevo = $('#btnNuevo');
    const modalNuevo = new bootstrap.Modal($('#modalNuevo'));

    // Modal confirm reusable
    const confirmEl = $('#modalConfirm');
    const confirmMsgEl = $('#confirmMessage');
    const confirmOkBtn = $('#btnConfirmOk');
    const confirmModal = new bootstrap.Modal(confirmEl);

    function askConfirm(message = '¿Deseas continuar?') {
        return new Promise((resolve) => {
            confirmMsgEl.textContent = message;

            const onHidden = () => { cleanup(); resolve(false); };

            const onOk = () => {
                // evita dobles clicks y cierra el modal
                confirmOkBtn.disabled = true;
                // quitamos el listener de hidden para que no resuelva "false" después
                confirmEl.removeEventListener('hidden.bs.modal', onHidden);
                confirmModal.hide();          // <-- aquí se cierra el modal
                cleanup();
                resolve(true);
            };

            function cleanup() {
                confirmOkBtn.disabled = false;
                confirmOkBtn.removeEventListener('click', onOk);
                confirmEl.removeEventListener('hidden.bs.modal', onHidden);
            }

            confirmOkBtn.addEventListener('click', onOk, { once: true });
            confirmEl.addEventListener('hidden.bs.modal', onHidden, { once: true });

            confirmModal.show();
        });
    }


    // Helpers fetch
    async function getJSON(url) {
        const res = await fetch(url, { headers: { Accept: 'application/json' } });
        if (!res.ok) throw new Error(`GET ${url} -> ${res.status}`);
        return res.json();
    }
    async function postJSON(url, payload) {
        return fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CSRF
            },
            body: JSON.stringify(payload || {})
        });
    }
    async function deleteJSON(url) {
        return fetch(url, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
    }

    function setEmptyRow(text = 'No hay datos para mostrar.') {
        tbody.innerHTML = `<tr><td colspan="3" class="text-center text-muted py-4">${text}</td></tr>`;
    }

    // === Cargar docentes por programa
    async function loadDocentes(programaId) {
        selDocente.disabled = true;
        selDocente.innerHTML = `<option value="">Cargando docentes...</option>`;
        try {
            const data = await getJSON(`${URL_DOCENTES}?programa_id=${encodeURIComponent(programaId)}`);
            selDocente.innerHTML = `<option value="">Seleccione un docente</option>`;
            (data.items || []).forEach(d => {
                const o = document.createElement('option');
                o.value = d.id;
                o.textContent = d.nombre;
                selDocente.appendChild(o);
            });
            selDocente.disabled = false;
        } catch (e) {
            console.error(e);
            selDocente.innerHTML = `<option value="">(Error) No se pudo cargar</option>`;
        }
    }

    // === Listado por docente
    async function loadListado(programaId, docenteId) {
        setEmptyRow('Cargando...');
        try {
            const data = await getJSON(`${URL_LISTADO}?programa_id=${encodeURIComponent(programaId)}&docente_id=${encodeURIComponent(docenteId)}`);
            const items = data.items || [];
            if (items.length === 0) return setEmptyRow('No hay unidades asignadas a este docente.');
            tbody.innerHTML = '';
            items.forEach((it, i) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
            <td class="text-center">${i + 1}</td>
            <td><span class="truncate" title="${it.curso ?? '—'}">${it.curso ?? '—'}</span></td>
            <td class="text-center">
              <button class="btn btn-danger btn-sm" data-action="del" data-id="${it.id}" title="Eliminar">
                <i class="fa-regular fa-trash-can"></i>
              </button>
            </td>`;
                tbody.appendChild(tr);
            });
        } catch (e) {
            console.error(e);
            setEmptyRow('Ocurrió un error al listar.');
        }
    }

    // === Modal NUEVO: helpers de cascada
    function resetSelect(sel, ph = 'Seleccione') {
        sel.innerHTML = `<option value="">${ph}</option>`;
        sel.disabled = true;
    }

    async function loadModulos(programaId) {
        const sel = $('#selModulo');
        resetSelect(sel);
        resetSelect($('#selSemestre'));
        resetSelect($('#selCurso'));
        try {
            const data = await getJSON(`${URL_MODULOS}?programa_id=${encodeURIComponent(programaId)}`);
            sel.innerHTML = `<option value="">Seleccione</option>`;
            (data.items || []).forEach(m => {
                const o = document.createElement('option');
                o.value = m.id;
                o.textContent = m.nombre;
                sel.appendChild(o);
            });
            sel.disabled = false;
        } catch (e) {
            sel.innerHTML = `<option value="">(Error) No se pudo cargar</option>`;
        }
    }

    async function loadSemestres(moduloId) {
        const sel = $('#selSemestre');
        resetSelect(sel);
        resetSelect($('#selCurso'));
        if (!moduloId) return;
        try {
            const data = await getJSON(`${URL_SEMESTRES}?modulo_id=${encodeURIComponent(moduloId)}`);
            sel.innerHTML = `<option value="">Seleccione</option>`;
            (data.items || []).forEach(s => {
                const o = document.createElement('option');
                o.value = s.id;
                o.textContent = s.nombre;
                sel.appendChild(o);
            });
            sel.disabled = false;
        } catch (e) {
            sel.innerHTML = `<option value="">(Error) No se pudo cargar</option>`;
        }
    }

    async function loadCursos(semestreId) {
        const sel = $('#selCurso');
        resetSelect(sel);
        if (!semestreId) return;
        try {
            const data = await getJSON(`${URL_CURSOS}?semestre_id=${encodeURIComponent(semestreId)}`);
            sel.innerHTML = `<option value="">Seleccione</option>`;
            (data.items || []).forEach(c => {
                const o = document.createElement('option');
                o.value = c.id;
                o.textContent = c.nombre;
                sel.appendChild(o);
            });
            sel.disabled = false;
        } catch (e) {
            sel.innerHTML = `<option value="">(Error) No se pudo cargar</option>`;
        }
    }

    // === Eventos maestros
    selPrograma?.addEventListener('change', () => {
        const pid = selPrograma.value;
        setEmptyRow('Seleccione un docente.');
        selDocente.innerHTML = `<option value="">Seleccione un docente</option>`;
        selDocente.disabled = !pid;
        btnNuevo.disabled = true;
        if (pid) loadDocentes(pid);
    });

    selDocente?.addEventListener('change', () => {
        const pid = selPrograma.value;
        const did = selDocente.value;
        btnNuevo.disabled = !(pid && did);
        if (pid && did) loadListado(pid, did);
        else setEmptyRow('Seleccione un docente.');
    });

    // === Abrir modal Nuevo
    btnNuevo?.addEventListener('click', async () => {
        // Copiamos selección actual
        $('#newPrograma').innerHTML = selPrograma.innerHTML;
        $('#newPrograma').value = selPrograma.value;
        $('#newDocente').innerHTML = selDocente.innerHTML;
        $('#newDocente').value = selDocente.value;

        // Cargar cascada
        await loadModulos(selPrograma.value);
        resetSelect($('#selSemestre'));
        resetSelect($('#selCurso'));

        modalNuevo.show();
    });

    // Cascada en modal
    $('#selModulo')?.addEventListener('change', e => loadSemestres(e.target.value));
    $('#selSemestre')?.addEventListener('change', e => loadCursos(e.target.value));

    // === Guardar nuevo
    $('#btnGuardarNuevo')?.addEventListener('click', async () => {
        const programa_id = selPrograma.value;
        const docente_id = selDocente.value;
        const curso_id = $('#selCurso').value;

        if (!programa_id || !docente_id || !curso_id) {
            alert('Selecciona módulo, semestre y curso.');
            return;
        }

        try {
            const res = await postJSON(URL_STORE, { programa_id, docente_id, curso_id });

            if (res.status === 422) {
                const j = await res.json();
                alert(j.message || 'Validación fallida.');
                return;
            }
            if (!res.ok) {
                alert('No se pudo guardar.');
                return;
            }

            modalNuevo.hide();
            await loadListado(programa_id, docente_id);
        } catch (e) {
            console.error(e);
            alert('Ocurrió un error al guardar.');
        }
    });

    // === Eliminar (con modal confirm)
    tbody?.addEventListener('click', async (ev) => {
        const btn = ev.target.closest('button[data-action="del"]');
        if (!btn) return;

        const id = btn.dataset.id;
        const ok = await askConfirm('¿Eliminar este registro?');
        if (!ok) return;

        try {
            const res = await deleteJSON(URL_DESTROY + id);
            const j = await res.json();
            if (!j.ok) {
                alert('No se pudo eliminar.');
                return;
            }
            const pid = selPrograma.value, did = selDocente.value;
            if (pid && did) await loadListado(pid, did);
        } catch (e) {
            console.error(e);
            alert('Ocurrió un error al eliminar.');
        } finally {
            // garantía: que el modal esté cerrado pase lo que pase
            try { confirmModal.hide(); } catch (_) { }
        }
    });

});
