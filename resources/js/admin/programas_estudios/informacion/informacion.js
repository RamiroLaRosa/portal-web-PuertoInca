document.addEventListener("DOMContentLoaded", function () {
    const baseUrl = document.body.dataset.baseUrl || "/admin/programas/informacion";

    const programSelect = document.getElementById("programSelect");
    const btnNuevo = document.getElementById("btnNuevo");
    const tableBody = document.querySelector(".content-table tbody");

    const modalNuevo = new bootstrap.Modal(document.getElementById("modalNuevo"));
    const cPrograma = document.getElementById("cPrograma");
    const formNuevo = document.getElementById("formNuevo");

    const modalEdit = new bootstrap.Modal(document.getElementById("modalEditar"));
    const formEdit = document.getElementById("formEditar");
    const eDuracion = document.getElementById("eDuracion");
    const eModalidad = document.getElementById("eModalidad");
    const eTurno = document.getElementById("eTurno");
    const eHorario = document.getElementById("eHorario");
    const eActive = document.getElementById("eActive");

    const modalDel = new bootstrap.Modal(document.getElementById("modalEliminar"));
    const formDel = document.getElementById("formEliminar");

    function escapeHtml(str = "") {
        return String(str).replace(/[&<>"']/g, (c) => ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[c]));
    }

    // Abrir "Nuevo" con el programa actual seleccionado
    btnNuevo?.addEventListener("click", () => {
        const actual = programSelect?.value;
        if (actual && cPrograma) cPrograma.value = actual;
        modalNuevo.show();
    });

    // Cargar tabla por programa
    function cargar(programaId) {
        fetch(`${baseUrl}/list?programa=${encodeURIComponent(programaId)}`)
            .then((r) => r.json())
            .then(({ data }) => {
                tableBody.innerHTML = "";
                if (!data || !data.length) {
                    tableBody.innerHTML =
                        '<tr><td colspan="6" class="text-center text-muted">No hay datos disponibles.</td></tr>';
                    return;
                }
                data.forEach((d, i) => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
              <td>${i + 1}</td>
              <td class="text-muted fw-semibold">${escapeHtml(d.duracion)}</td>
              <td class="text-muted">${escapeHtml(d.modalidad)}</td>
              <td class="text-muted">${escapeHtml(d.turno)}</td>
              <td class="text-muted">${escapeHtml(d.horario)}</td>
              <td class="text-center">
                <div class="d-inline-flex gap-1">
                  <button class="btn btn-warning btn-sm text-white btn-edit" type="button" title="Editar" data-id="${d.id}">
                    <i class="fa-regular fa-pen-to-square"></i>
                  </button>
                  <button class="btn btn-danger btn-sm btn-del" type="button" title="Eliminar" data-id="${d.id}">
                    <i class="fa-regular fa-trash-can"></i>
                  </button>
                </div>
              </td>`;
                    tableBody.appendChild(row);
                });
            })
            .catch(() => {
                tableBody.innerHTML =
                    '<tr><td colspan="6" class="text-center text-danger">Error al cargar los datos.</td></tr>';
            });
    }

    programSelect?.addEventListener("change", () => {
        const id = programSelect.value;
        if (id) cargar(id);
        else tableBody.innerHTML =
            '<tr class="empty-row"><td colspan="6" class="text-center text-muted">Seleccione un programa de estudio para listar</td></tr>';
    });

    // Delegación: editar / eliminar
    tableBody.addEventListener("click", async (ev) => {
        const btn = ev.target.closest("button");
        if (!btn) return;

        // Editar
        if (btn.classList.contains("btn-edit")) {
            const id = btn.dataset.id;
            try {
                const res = await fetch(`${baseUrl}/${id}`);
                if (!res.ok) throw new Error("Bad response");
                const row = await res.json();

                eDuracion.value = row.duracion || "";
                eModalidad.value = row.modalidad || "";
                eTurno.value = row.turno || "";
                eHorario.value = row.horario || "";
                eActive.checked = !!row.is_active;

                formEdit.action = `${baseUrl}/${encodeURIComponent(id)}`; // PUT
                modalEdit.show();
            } catch {
                alert("No se pudo cargar el registro.");
            }
            return;
        }

        // Eliminar
        if (btn.classList.contains("btn-del")) {
            const id = btn.dataset.id;
            formDel.action = `${baseUrl}/${encodeURIComponent(id)}`;
            modalDel.show();
            return;
        }
    });

    // Guardar (nuevo) por AJAX
    if (formNuevo) {
        formNuevo.addEventListener("submit", async function (e) {
            e.preventDefault();
            const data = new FormData(formNuevo);
            formNuevo.querySelectorAll(".is-invalid").forEach((el) => el.classList.remove("is-invalid"));

            try {
                const res = await fetch(baseUrl, { method: "POST", headers: { Accept: "application/json" }, body: data });
                if (res.ok) {
                    modalNuevo.hide();
                    showToast("success", "Registro creado correctamente.");
                    if (programSelect.value) cargar(programSelect.value);
                    formNuevo.reset();
                    return;
                }
                const json = await res.json();
                if (json.errors) {
                    let msg = Object.values(json.errors).flat().join("<br>");
                    showToast("danger", msg);
                    Object.keys(json.errors).forEach((name) => {
                        const input = formNuevo.querySelector(`[name="${name}"]`);
                        if (input) input.classList.add("is-invalid");
                    });
                } else {
                    showToast("danger", json.message || "Error al guardar");
                }
            } catch {
                showToast("danger", "Error de red");
            }
        });
    }

    function showToast(type, message) {
        let toast = document.createElement("div");
        toast.className = `toast align-items-center text-bg-${type} border-0 show custom-toast-pos`;
        toast.role = "alert";
        toast.innerHTML = `
        <div class="d-flex">
          <div class="toast-body">${message}</div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>`;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 5000);
    }
});
