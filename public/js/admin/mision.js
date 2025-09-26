// public/js/admin/mision.js
document.addEventListener("DOMContentLoaded", () => {
    // Base URL para PUT/DELETE de valores (viene del data-atributo en <body>)
    const baseUrl = document.body.dataset.valoresBaseUrl || "";

    // --- Helpers ---
    const getModal = (id) => {
        const el = document.getElementById(id);
        if (!el || !window.bootstrap) return null;
        return bootstrap.Modal.getOrCreateInstance(el);
    };
    const setPreview = (iconEl, codeEl, cls) => {
        if (iconEl) iconEl.className = cls;
        if (codeEl) codeEl.textContent = cls;
    };

    // --- Modales ---
    const editModal = getModal("modalEditarValor");
    const delModal = getModal("modalEliminarValor");

    // --- Formularios ---
    const formEdit = document.getElementById("formEditarValor");
    const formDel = document.getElementById("formEliminarValor");

    // --- Campos EDITAR ---
    const eNombre = document.getElementById("editNombre");
    const eDesc = document.getElementById("editDescripcion");
    const eActive = document.getElementById("editActive");
    const editSelect = document.getElementById("editIconoSelect");
    const editPrev = document.getElementById("editIconPreview");
    const editCode = document.getElementById("editIconCode");

    // --- Campos NUEVO (select + preview) ---
    const newSelect = document.getElementById("newIcono");
    const newPrev = document.getElementById("newIconPreview");
    const newCode = document.getElementById("newIconCode"); // opcional si existe <code id="newIconCode">

    // Preview NUEVO
    if (newSelect) {
        const updateNewPreview = () => setPreview(newPrev, newCode, newSelect.value || "fa-solid fa-star");
        newSelect.addEventListener("change", updateNewPreview);
        updateNewPreview();
    }

    // Preview EDITAR
    const updateEditPreview = () => setPreview(editPrev, editCode, editSelect?.value || "fa-solid fa-star");
    if (editSelect) editSelect.addEventListener("change", updateEditPreview);

    // Abrir modal EDITAR
    document.querySelectorAll(".btn-edit").forEach((btn) => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            const nombre = btn.dataset.nombre || "";
            const desc = btn.dataset.descripcion || "";
            const icono = btn.dataset.icono || "fa-solid fa-star";
            const act = btn.dataset.active === "1";

            if (eNombre) eNombre.value = nombre;
            if (eDesc) eDesc.value = desc;
            if (eActive) eActive.checked = act;

            if (editSelect) {
                editSelect.value = icono;   // clase Font Awesome
                updateEditPreview();
            }

            if (formEdit && baseUrl) formEdit.action = `${baseUrl}/${id}`; // PUT /{id}
            editModal && editModal.show();
        });
    });

    // Abrir modal ELIMINAR
    const delName = document.getElementById("delNombre");
    document.querySelectorAll(".btn-delete").forEach((btn) => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            if (delName) delName.textContent = btn.dataset.nombre || "";
            if (formDel && baseUrl) formDel.action = `${baseUrl}/${id}`;   // DELETE /{id}
            delModal && delModal.show();
        });
    });
});
