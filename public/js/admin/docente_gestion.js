// public/js/admin/docente_gestion.js
document.addEventListener("DOMContentLoaded", () => {
    // Rutas y constantes desde <body data-*>
    const LIST_URL = document.body.dataset.listUrl || "";
    const STORE_URL = document.body.dataset.storeUrl || "";
    const DOCENTES_BASE = document.body.dataset.docentesBaseUrl || "";
    const NO_PHOTO = document.body.dataset.noPhoto || "";
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || "";

    // UI refs
    const select = document.getElementById("programSelect");
    const tbody = document.getElementById("tbodyDocentes");

    // Modales
    const modalNuevo = bootstrap.Modal.getOrCreateInstance("#modalNuevo", { backdrop: "static" });
    const modalFoto = bootstrap.Modal.getOrCreateInstance("#modalFoto", { backdrop: "static" });
    const modalEditar = bootstrap.Modal.getOrCreateInstance("#modalEditar", { backdrop: "static" });
    const modalEliminar = bootstrap.Modal.getOrCreateInstance("#modalEliminar", { backdrop: "static" });

    // Form Nuevo
    const btnNuevo = document.getElementById("btnNuevo");
    const formNuevo = document.getElementById("formNuevo");
    const newProg = document.getElementById("newProgramaId");
    const btnSaveNew = document.getElementById("btnGuardarNuevo");

    // Ver foto
    const fotoImg = document.getElementById("fotoImg");
    const fotoTitle = document.getElementById("modalFotoLabel");

    // Editar
    const formEditar = document.getElementById("formEditar");
    const btnSaveEdit = document.getElementById("btnGuardarEditar");
    const editId = document.getElementById("editId");
    const editProgramaId = document.getElementById("editProgramaId");
    const editCorreo = document.getElementById("editCorreo");
    const editNombre = document.getElementById("editNombre");
    const editCargo = document.getElementById("editCargo");
    const editFoto = document.getElementById("editFoto");
    const editFotoPreview = document.getElementById("editFotoPreview");

    // Eliminar
    const delNombreEl = document.getElementById("delNombre");
    const btnConfirmDel = document.getElementById("btnConfirmEliminar");
    let deleteId = null;

    // Helpers
    function renderEmpty(msg = "Seleccione un programa de estudio para listar los docentes.") {
        tbody.innerHTML = `<tr class="empty-row"><td colspan="6">${msg}</td></tr>`;
    }
    function escapeHtml(str) {
        const div = document.createElement("div");
        div.innerText = str ?? "";
        return div.innerHTML;
    }

    // ------- Listar docentes -------
    async function loadDocentes(programaId) {
        if (!programaId) {
            renderEmpty();
            return;
        }
        tbody.innerHTML = `<tr class="empty-row"><td colspan="6">Cargando...</td></tr>`;

        try {
            const url = `${LIST_URL}?programa=${encodeURIComponent(programaId)}`;
            const resp = await fetch(url, { headers: { "X-Requested-With": "XMLHttpRequest" } });
            const { data = [] } = await resp.json();

            if (!data.length) {
                renderEmpty("No hay docentes registrados para este programa.");
                return;
            }

            tbody.innerHTML = data.map((d, i) => `
          <tr>
            <td>${i + 1}</td>
            <td class="text-muted fw-semibold">${escapeHtml(d.nombre)}</td>
            <td class="text-muted">${escapeHtml(d.cargo)}</td>
            <td class="text-muted">${escapeHtml(d.correo)}</td>
            <td class="text-center">
              <button type="button" class="btn btn-light btn-sm btn-foto"
                title="Ver foto"
                data-foto="${encodeURIComponent(d.foto_url || "")}"
                data-nombre="${encodeURIComponent(d.nombre || "")}">
                <i class="fa-regular fa-image"></i>
              </button>
            </td>
            <td class="text-center">
              <div class="d-inline-flex gap-1">
                <button class="btn btn-warning btn-sm text-white btn-edit" type="button"
                        title="Editar" data-id="${d.id}">
                  <i class="fa-regular fa-pen-to-square"></i>
                </button>
                <button class="btn btn-danger btn-sm btn-del" type="button"
                        title="Eliminar" data-id="${d.id}"
                        data-nombre="${encodeURIComponent(d.nombre || "")}">
                  <i class="fa-regular fa-trash-can"></i>
                </button>
              </div>
            </td>
          </tr>
        `).join("");
        } catch (e) {
            console.error(e);
            renderEmpty("Ocurrió un error al cargar los docentes.");
        }
    }

    // ------- Nuevo -------
    btnNuevo.addEventListener("click", () => {
        formNuevo.reset();
        newProg.value = select.value || "";
        modalNuevo.show();
    });

    formNuevo.addEventListener("submit", async (e) => {
        e.preventDefault();
        btnSaveNew.disabled = true;
        try {
            const fd = new FormData(formNuevo);
            const resp = await fetch(STORE_URL, {
                method: "POST",
                headers: { "X-Requested-With": "XMLHttpRequest" },
                body: fd
            });
            if (!resp.ok) {
                let msg = "Error al guardar";
                try { msg = (await resp.json()).message || msg; } catch { }
                throw new Error(msg);
            }
            const json = await resp.json();
            if (!json.ok) throw new Error("No se pudo guardar");

            if (select.value === fd.get("programa_estudio_id")) await loadDocentes(select.value);
            modalNuevo.hide();
        } catch (err) {
            console.error(err);
            alert(err.message || "Hubo un problema al guardar.");
        } finally {
            btnSaveNew.disabled = false;
        }
    });

    // ------- Ver foto -------
    tbody.addEventListener("click", (e) => {
        const btn = e.target.closest(".btn-foto");
        if (!btn) return;
        const url = decodeURIComponent(btn.dataset.foto || "");
        const nombre = decodeURIComponent(btn.dataset.nombre || "Foto del docente");
        fotoImg.src = url || NO_PHOTO;
        fotoTitle.textContent = nombre;
        modalFoto.show();
    });

    // ------- Editar (cargar datos) -------
    tbody.addEventListener("click", async (e) => {
        const btn = e.target.closest(".btn-edit");
        if (!btn) return;
        const id = btn.dataset.id;

        try {
            const resp = await fetch(`${DOCENTES_BASE}/${id}`, {
                headers: { "X-Requested-With": "XMLHttpRequest" }
            });
            if (!resp.ok) throw new Error("No se pudo obtener el docente");
            const d = await resp.json();

            editId.value = d.id;
            editProgramaId.value = d.programa_estudio_id;
            editCorreo.value = d.correo || "";
            editNombre.value = d.nombre || "";
            editCargo.value = d.cargo || "";
            editFotoPreview.src = d.foto_url || NO_PHOTO;
            if (editFoto) editFoto.value = "";

            modalEditar.show();
        } catch (err) {
            console.error(err);
            alert("No se pudo cargar la información del docente.");
        }
    });

    // ------- Editar (guardar) -------
    formEditar.addEventListener("submit", async (e) => {
        e.preventDefault();
        btnSaveEdit.disabled = true;
        const id = editId.value;
        try {
            const fd = new FormData(formEditar); // incluye _token y _method=PUT
            const resp = await fetch(`${DOCENTES_BASE}/${id}`, {
                method: "POST", // Laravel respeta _method=PUT
                headers: { "X-Requested-With": "XMLHttpRequest" },
                body: fd
            });
            if (!resp.ok) {
                let msg = "Error al guardar cambios";
                try { msg = (await resp.json()).message || msg; } catch { }
                throw new Error(msg);
            }
            const json = await resp.json();
            if (!json.ok) throw new Error("No se pudo actualizar");

            if (select.value) await loadDocentes(select.value);
            modalEditar.hide();
        } catch (err) {
            console.error(err);
            alert(err.message || "Hubo un problema al actualizar.");
        } finally {
            btnSaveEdit.disabled = false;
        }
    });

    // ------- Eliminar -------
    tbody.addEventListener("click", (e) => {
        const btn = e.target.closest(".btn-del");
        if (!btn) return;
        deleteId = btn.dataset.id || null;
        const name = decodeURIComponent(btn.dataset.nombre || "");
        delNombreEl.textContent = name || "este docente";
        modalEliminar.show();
    });

    btnConfirmDel.addEventListener("click", async () => {
        if (!deleteId) return;
        btnConfirmDel.disabled = true;
        try {
            const resp = await fetch(`${DOCENTES_BASE}/${deleteId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": CSRF,
                    "X-Requested-With": "XMLHttpRequest"
                }
            });
            if (!resp.ok) {
                let msg = "No se pudo eliminar";
                try { msg = (await resp.json()).message || msg; } catch { }
                throw new Error(msg);
            }
            const json = await resp.json();
            if (!json.ok) throw new Error("No se pudo eliminar");

            modalEliminar.hide();
            deleteId = null;
            if (select.value) await loadDocentes(select.value);
        } catch (err) {
            console.error(err);
            alert(err.message || "Error al eliminar.");
        } finally {
            btnConfirmDel.disabled = false;
        }
    });

    // Cargar lista al seleccionar programa
    select.addEventListener("change", (e) => loadDocentes(e.target.value));
});
