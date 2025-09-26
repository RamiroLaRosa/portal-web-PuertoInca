// public/js/admin/resenia.js
document.addEventListener("DOMContentLoaded", () => {
    const baseUrl = document.body.dataset.reseniaBaseUrl || "";
    const openNew = document.body.dataset.openNew === "1";

    // Helper para obtener/crear instancias de Bootstrap Modal
    const getModal = (id) => {
        const el = document.getElementById(id);
        if (!el || !window.bootstrap) return null;
        return bootstrap.Modal.getOrCreateInstance(el);
    };

    // Reabrir "Nuevo" si el servidor devolvió errores de validación
    if (openNew) {
        const m = getModal("modalNuevo");
        m && m.show();
    }

    // -------- Preview imagen desde la tabla --------
    const prevModal = getModal("modalPreviewImg");
    document.querySelectorAll(".btn-preview-img").forEach((btn) => {
        btn.addEventListener("click", () => {
            const img = document.getElementById("previewImg");
            const title = document.getElementById("previewTitle");
            if (img) img.src = btn.dataset.src || "";
            if (title) title.textContent = btn.dataset.title || "Vista previa";
            prevModal && prevModal.show();
        });
    });

    // -------- Editar --------
    const editModal = getModal("modalEditar");
    const formEdit = document.getElementById("formEditar");
    const eTitulo = document.getElementById("editTitulo");
    const eDesc = document.getElementById("editDescripcion");
    const eImgPrev = document.getElementById("editImgPreview");
    const eActive = document.getElementById("editActive");

    document.querySelectorAll(".btn-edit").forEach((btn) => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            if (eTitulo) eTitulo.value = btn.dataset.titulo || "";
            if (eDesc) eDesc.value = btn.dataset.descripcion || "";
            if (eImgPrev) eImgPrev.src = btn.dataset.img || "";
            if (eActive) eActive.checked = btn.dataset.active === "1";
            if (formEdit && baseUrl) formEdit.action = `${baseUrl}/${id}`; // PUT por ID
            editModal && editModal.show();
        });
    });

    // -------- Eliminar --------
    const delModal = getModal("modalEliminar");
    const formDel = document.getElementById("formEliminar");
    const delTit = document.getElementById("delTitulo");

    document.querySelectorAll(".btn-delete").forEach((btn) => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            if (delTit) delTit.textContent = btn.dataset.titulo || "";
            if (formDel && baseUrl) formDel.action = `${baseUrl}/${id}`; // DELETE por ID
            delModal && delModal.show();
        });
    });
});
