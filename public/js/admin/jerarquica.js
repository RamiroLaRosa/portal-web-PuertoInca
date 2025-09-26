// public/js/admin/jerarquica.js
document.addEventListener("DOMContentLoaded", () => {
    const baseUrl = document.body.dataset.jerarquicaBaseUrl || "";
    const noPhoto = document.body.dataset.noPhoto || "";
    const getModal = (id) => {
        const el = document.getElementById(id);
        return el && window.bootstrap
            ? bootstrap.Modal.getOrCreateInstance(el)
            : null;
    };

    // ----- EDITAR -----
    const formEditar = document.getElementById("formEditar");
    const eNombre = document.getElementById("editNombre");
    const eCargo = document.getElementById("editCargo");
    const eActive = document.getElementById("editActive");

    document.querySelectorAll(".btn-edit").forEach((btn) => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            if (eNombre) eNombre.value = btn.dataset.nombre || "";
            if (eCargo) eCargo.value = btn.dataset.cargo || "";
            if (eActive) eActive.checked = btn.dataset.active === "1";
            if (formEditar && baseUrl) formEditar.action = `${baseUrl}/${id}`;
        });
    });

    // ----- ELIMINAR -----
    const formEliminar = document.getElementById("formEliminar");
    const delName = document.getElementById("delNombre");

    document.querySelectorAll(".btn-delete").forEach((btn) => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            if (delName) delName.textContent = btn.dataset.nombre || "";
            if (formEliminar && baseUrl) formEliminar.action = `${baseUrl}/${id}`;
        });
    });

    // ----- VER IMAGEN -----
    const imgModalEl = document.getElementById("modalVerImagen");
    const imgModal = getModal("modalVerImagen");
    const imgTag = document.getElementById("imgPreview");
    const imgTitle = document.getElementById("imgTitle");

    document.querySelectorAll(".btn-view-img").forEach((btn) => {
        btn.addEventListener("click", () => {
            const src = btn.dataset.src || noPhoto;
            const title = btn.dataset.title || "Imagen";
            if (imgTag) imgTag.src = src;
            if (imgTitle) imgTitle.textContent = title;
            imgModal && imgModal.show();
        });
    });

    // Limpia la imagen al cerrar
    imgModalEl?.addEventListener("hidden.bs.modal", () => {
        if (imgTag) imgTag.src = "";
    });
});
