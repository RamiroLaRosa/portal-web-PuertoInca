document.addEventListener("DOMContentLoaded", () => {
    const CSRF_TOKEN = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    const tbody = document.getElementById("tupaBody");
    const searchInput = document.getElementById("searchInput");
    const alertBox = document.getElementById("alertContainer");
    const paginationContainer = document.createElement("div");
    paginationContainer.className = "mt-3 d-flex justify-content-end";
    tbody.parentElement.after(paginationContainer);

    const modalNuevo = new bootstrap.Modal(
        document.getElementById("modalNuevo")
    );
    const modalEditar = new bootstrap.Modal(
        document.getElementById("modalEditar")
    );
    const formNuevo = document.getElementById("formNuevo");
    const formEditar = document.getElementById("formEditar");
    const createTitulo = document.getElementById("createConcepto");
    const createDesc = document.getElementById("createMonto");
    const editId = document.getElementById("editId");
    const editTitulo = document.getElementById("editConcepto");
    const editDesc = document.getElementById("editMonto");

    let rows = [];
    let currentPage = 1;
    const itemsPerPage = 5;

    function notify(type, msg) {
        alertBox.style.display = "block";
        alertBox.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show mb-0">
          ${msg}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>`;
        setTimeout(() => (alertBox.style.display = "none"), 3500);
    }

    function renderTable(term = "", page = 1) {
        const q = term.trim().toLowerCase();
        const data = q
            ? rows.filter(
                  (r) =>
                      String(r.id).includes(q) ||
                      (r.titulo || "").toLowerCase().includes(q) ||
                      (r.descripcion || "").toLowerCase().includes(q)
              )
            : rows;

        tbody.innerHTML = "";
        if (!data.length) {
            tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">Sin registros.</td></tr>`;
            paginationContainer.innerHTML = "";
            return;
        }

        // PAGINACIÓN
        const totalPages = Math.ceil(data.length / itemsPerPage);
        currentPage = Math.max(1, Math.min(page, totalPages));
        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const pageData = data.slice(start, end);

        for (const r of pageData) {
            const tr = document.createElement("tr");
            tr.innerHTML = `
          <td>${r.id}</td>
          <td class="text-muted fw-semibold">${r.titulo ?? ''}</td>
          <td class="text-muted">${r.descripcion ?? ''}</td>
          <td class="text-center">
            <div class="d-inline-flex gap-1">
              <button class="btn btn-warning btn-sm text-white" data-action="edit" data-id="${r.id}" title="Editar">
                <i class="fa-regular fa-pen-to-square"></i>
              </button>
              <button class="btn btn-danger btn-sm btn-delete"
                        data-id="ID_DEL_REGISTRO"
                        data-title="TÍTULO DEL REGISTRO"
                        data-bs-toggle="modal"
                        data-bs-target="#modalEliminar">
                <i class="fa-regular fa-trash-can"></i>
                </button>
            </div>
          </td>`;
            tbody.appendChild(tr);
        }

        renderPagination(totalPages, currentPage, term);
    }

    function renderPagination(totalPages, currentPage, term) {
        if (totalPages <= 1) {
            paginationContainer.innerHTML = "";
            return;
        }
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

    async function fetchList() {
        const res = await fetch(window.INFO_ROUTES.list);
        if (!res.ok) {
            notify("danger", "No se pudo cargar la lista.");
            return;
        }
        rows = await res.json();
        renderTable(searchInput.value || "", 1);
    }

    searchInput.addEventListener("input", (e) =>
        renderTable(e.target.value, 1)
    );

    tbody.addEventListener("click", async (e) => {
        const btn = e.target.closest("button");
        if (!btn) return;
        const id = Number(btn.dataset.id);
        const action = btn.dataset.action;

        if (action === "edit") {
            const r = rows.find((x) => x.id === id);
            if (!r) return notify("danger", "No se encontró el registro.");
            editId.value = r.id;
            editTitulo.value = r.titulo ?? "";
            editDesc.value = r.descripcion ?? "";
            modalEditar.show();
        }

        if (action === "delete") {
            if (!confirm("¿Eliminar el registro?")) return;
            const res = await fetch(
                window.INFO_ROUTES.destroy.replace(":id", id),
                {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": CSRF_TOKEN,
                        Accept: "application/json",
                    },
                }
            );
            if (res.ok) {
                await fetchList();
                notify("success", "Registro eliminado.");
            } else notify("danger", "No se pudo eliminar.");
        }
    });

    formNuevo.addEventListener("submit", async (e) => {
        e.preventDefault();
        const payload = {
            titulo: createTitulo.value.trim(),
            descripcion: createDesc.value.trim(),
        };
        const res = await fetch(window.INFO_ROUTES.store, {
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
            await fetchList();
            notify("success", "Registro creado correctamente.");
        } else {
            notify("danger", "Revisa los campos obligatorios.");
        }
    });

    formEditar.addEventListener("submit", async (e) => {
        e.preventDefault();
        const id = Number(editId.value);
        const payload = {
            titulo: editTitulo.value.trim(),
            descripcion: editDesc.value.trim(),
        };
        const res = await fetch(window.INFO_ROUTES.update.replace(":id", id), {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": CSRF_TOKEN,
                Accept: "application/json",
            },
            body: JSON.stringify(payload),
        });
        if (res.ok) {
            modalEditar.hide();
            await fetchList();
            notify("success", "Cambios guardados.");
        } else {
            notify("danger", "No se pudo actualizar.");
        }
    });

    // Carga inicial
    fetchList();
});
