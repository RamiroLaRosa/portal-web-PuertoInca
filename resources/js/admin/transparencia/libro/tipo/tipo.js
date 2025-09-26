document.addEventListener("DOMContentLoaded", () => {
    const CSRF_TOKEN = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    const tbody = document.getElementById("tupaBody");
    const searchInput = document.getElementById("searchInput");
    const alertBox = document.getElementById("alertContainer");
    const paginationContainer = document.getElementById("paginationContainer");

    const modalNuevo = new bootstrap.Modal(
        document.getElementById("modalNuevo")
    );
    const modalEditar = new bootstrap.Modal(
        document.getElementById("modalEditar")
    );

    const formNuevo = document.getElementById("formNuevo");
    const formEditar = document.getElementById("formEditar");

    const createNombre = document.getElementById("createConcepto");
    const createDesc = document.getElementById("createMonto");
    const editId = document.getElementById("editId");
    const editNombre = document.getElementById("editConcepto");
    const editDesc = document.getElementById("editMonto");

    // Ajusta etiquetas y oculta switch
    ["createActive", "editActive"].forEach((id) => {
        const el = document.getElementById(id);
        if (el && el.closest(".form-check"))
            el.closest(".form-check").style.display = "none";
    });
    document
        .querySelectorAll("#modalNuevo label, #modalEditar label")
        .forEach((l) => {
            if (l.htmlFor.includes("Concepto")) l.textContent = "Nombre *";
            if (l.htmlFor.includes("Monto")) l.textContent = "Descripción *";
        });
    createDesc.type = "text";
    editDesc.type = "text";

    let rows = [];
    let currentPage = 1;
    const itemsPerPage = 5;

    const notify = (type, msg) => {
        alertBox.style.display = "block";
        alertBox.innerHTML = `<div class="alert alert-${type} alert-dismissible fade show mb-0">
           ${msg}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
         </div>`;
        setTimeout(() => (alertBox.style.display = "none"), 3500);
    };

    const renderTable = (term = '') => {
        const esc = (s) => String(s ?? '')
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');

        const q = term.trim().toLowerCase();
        const data = q
            ? rows.filter(
                  (r) =>
                      String(r.id).includes(q) ||
                      (r.nombre || "").toLowerCase().includes(q) ||
                      (r.descripcion || "").toLowerCase().includes(q)
              )
            : rows;

        tbody.innerHTML = "";
        if (!data.length) {
            tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">Sin registros.</td></tr>`;
            paginationContainer.innerHTML = "";
            return;
        }

        data.forEach(r => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="col-id">${r.id}</td>
                <td class="text-muted fw-semibold col-nombre">${esc(r.nombre)}</td>
                <td class="text-muted col-descripcion">${esc(r.descripcion)}</td>
                <td class="text-center col-acciones">
                    <div class="d-inline-flex gap-1">
                        <button class="btn btn-warning btn-sm text-white"
                                data-action="edit" data-id="${r.id}" title="Editar">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>

                        <button class="btn btn-danger btn-sm btn-delete"
                                data-id="${r.id}"
                                data-title="${esc(r.nombre)}"
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
        html += `<li class="page-item${currentPage === 1 ? " disabled" : ""}">
            <a class="page-link" href="#" data-page="${
                currentPage - 1
            }">&laquo;</a></li>`;
        for (let i = 1; i <= totalPages; i++) {
            html += `<li class="page-item${i === currentPage ? " active" : ""}">
                <a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
        }
        html += `<li class="page-item${
            currentPage === totalPages ? " disabled" : ""
        }">
            <a class="page-link" href="#" data-page="${
                currentPage + 1
            }">&raquo;</a></li>`;
        html += `</ul></nav>`;
        paginationContainer.innerHTML = html;

        paginationContainer
            .querySelectorAll(".page-link[data-page]")
            .forEach((link) => {
                link.addEventListener("click", function (e) {
                    e.preventDefault();
                    const page = parseInt(this.getAttribute("data-page"));
                    if (page >= 1 && page <= totalPages) {
                        renderTable(term || searchInput.value, page);
                    }
                });
            });
    }


    async function fetchGrid() {
        const res = await fetch(window.TIPO_RECLAMACION_ROUTES.grid);
        if (!res.ok) {
            notify("danger", "Error al cargar la lista");
            return;
        }
        rows = await res.json();
        renderTable(searchInput.value, 1);
    }

    searchInput.addEventListener("input", (e) =>
        renderTable(e.target.value, 1)
    );

    tbody.addEventListener("click", async (e) => {
        const btn = e.target.closest("button");
        if (!btn) return;
        const id = btn.dataset.id;
        if (btn.dataset.action === "edit") {
            const r = rows.find((x) => x.id == id);
            if (!r) return;
            editId.value = r.id;
            editNombre.value = r.nombre;
            editDesc.value = r.descripcion;
            modalEditar.show();
        } else if (btn.dataset.action === "delete") {
            if (!confirm("¿Eliminar este registro?")) return;
            const res = await fetch(
                window.TIPO_RECLAMACION_ROUTES.destroy.replace(":id", id),
                {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": CSRF_TOKEN,
                        Accept: "application/json",
                    },
                }
            );
            if (res.ok) {
                await fetchGrid();
                notify("success", "Registro eliminado.");
            } else notify("danger", "No se pudo eliminar.");
        }
    });

    formNuevo.addEventListener("submit", async (e) => {
        e.preventDefault();
        const payload = {
            nombre: createNombre.value.trim(),
            descripcion: createDesc.value.trim(),
        };
        const res = await fetch(window.TIPO_RECLAMACION_ROUTES.store, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": CSRF_TOKEN,
                Accept: "application/json",
            },
            body: JSON.stringify(payload),
        });
        if (res.ok) {
            formNuevo.reset();
            modalNuevo.hide();
            await fetchGrid();
            notify("success", "Registro creado correctamente.");
        } else notify("danger", "Error al crear.");
    });

    formEditar.addEventListener("submit", async (e) => {
        e.preventDefault();
        const id = editId.value;
        const payload = {
            nombre: editNombre.value.trim(),
            descripcion: editDesc.value.trim(),
        };
        const res = await fetch(
            window.TIPO_RECLAMACION_ROUTES.update.replace(":id", id),
            {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": CSRF_TOKEN,
                    Accept: "application/json",
                },
                body: JSON.stringify(payload),
            }
        );
        if (res.ok) {
            modalEditar.hide();
            await fetchGrid();
            notify("success", "Cambios guardados.");
        } else notify("danger", "Error al actualizar.");
    });

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-delete');
        if (!btn) return;

        const id = btn.getAttribute('data-id');
        const title = btn.getAttribute('data-title') || 'este registro';

        const form = document.getElementById('formEliminar');
        const delTitle = document.getElementById('delTitulo');

        const destroyTpl = (window.TIPO_RECLAMACION_ROUTES && window.TIPO_RECLAMACION_ROUTES.destroy) || '';
        const url = destroyTpl.replace(':id', id);

        if (form && url) form.setAttribute('action', url);
        if (delTitle) delTitle.textContent = title;
    });

    fetchGrid();
});
