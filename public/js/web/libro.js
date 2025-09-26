/* ====== libro.js (único y actualizado) ====== */

/* 1) Iconos lucide  */
window.addEventListener("DOMContentLoaded", () => {
    if (window.lucide?.createIcons) lucide.createIcons();
});

/* 2) Estado global mínimo */
let activeSection = "hero";
let currentStep = 1;
let selectedComplaintType = "";

/* 3) Navegación / scroll */
function scrollToSection(sectionId) {
    const el = document.getElementById(sectionId);
    if (el) {
        const yOffset = -80;
        const y = el.getBoundingClientRect().top + window.pageYOffset + yOffset;
        window.scrollTo({ top: y, behavior: "smooth" });
    }
    closeMobileMenu();
}
window.scrollToSection = scrollToSection;

function updateActiveNavigation() {
    const sections = document.querySelectorAll("section[id]");
    let current = "hero";
    sections.forEach((sec) => {
        const top = sec.offsetTop;
        const h = sec.clientHeight;
        if (window.scrollY >= top - 200 && window.scrollY < top + h - 200) {
            current = sec.getAttribute("id") || "hero";
        }
    });
    if (current !== activeSection) {
        const prev = document.querySelector(
            `[data-section="${activeSection}"]`
        );
        if (prev) {
            prev.classList.remove("bg-[#E27227]");
            prev.classList.add("hover:bg-[#1A4FD3]/20");
        }
        const now = document.querySelector(`[data-section="${current}"]`);
        if (now) {
            now.classList.add("bg-[#E27227]");
            now.classList.remove("hover:bg-[#1A4FD3]/20");
        }
        activeSection = current;
    }
}
window.addEventListener("scroll", updateActiveNavigation);
window.addEventListener("load", updateActiveNavigation);

/* 4) Menú móvil */
function toggleMobileMenu() {
    const mobileMenu = document.getElementById("mobile-menu");
    const menuIcon = document.getElementById("menu-icon");
    const closeIcon = document.getElementById("close-icon");
    if (!mobileMenu) return;

    const show = mobileMenu.classList.contains("hidden");
    mobileMenu.classList.toggle("hidden", !show);
    menuIcon?.classList.toggle("hidden", show);
    closeIcon?.classList.toggle("hidden", !show);
}
window.toggleMobileMenu = toggleMobileMenu;

function closeMobileMenu() {
    const mobileMenu = document.getElementById("mobile-menu");
    const menuIcon = document.getElementById("menu-icon");
    const closeIcon = document.getElementById("close-icon");
    if (!mobileMenu) return;
    mobileMenu.classList.add("hidden");
    menuIcon?.classList.remove("hidden");
    closeIcon?.classList.add("hidden");
}
window.closeMobileMenu = closeMobileMenu;

document.addEventListener("click", (e) => {
    const mobileMenu = document.getElementById("mobile-menu");
    const mobileBtn = document.getElementById("mobile-menu-button");
    if (
        mobileMenu &&
        mobileBtn &&
        !mobileMenu.contains(e.target) &&
        !mobileBtn.contains(e.target)
    ) {
        closeMobileMenu();
    }
});

/* 5) Cards de tipo de reclamación */
function selectComplaintType(cardEl) {
    document
        .querySelectorAll(".complaint-type-card")
        .forEach((c) => c.classList.remove("border-[#E27227]"));
    cardEl.classList.add("border-[#E27227]");

    const id = Number(cardEl.getAttribute("data-id"));
    const hidden = document.getElementById("tipoReclamacion");
    if (hidden) hidden.value = String(id);

    selectedComplaintType =
        cardEl?.querySelector(".font-bold")?.textContent?.trim() || "";
}
window.selectComplaintType = selectComplaintType;

/* 6) Pasos del formulario */
function changeStep(delta) {
    const total = 3;
    if (delta > 0 && !validateCurrentStep()) return;

    const next = Math.min(total, Math.max(1, currentStep + delta));
    if (next === currentStep) return;

    document.getElementById(`step${currentStep}`)?.classList.add("hidden");
    document.getElementById(`step${next}`)?.classList.remove("hidden");

    document.getElementById("prevBtn")?.classList.toggle("hidden", next === 1);
    document
        .getElementById("nextBtn")
        ?.classList.toggle("hidden", next === total);
    document
        .getElementById("submitBtn")
        ?.classList.toggle("hidden", next !== total);

    const titles = [
        "Información Personal",
        "Tipo de Reclamación",
        "Detalle de la Reclamación",
    ];
    const stepText = document.getElementById("step-text");
    if (stepText) stepText.textContent = `Paso ${next}: ${titles[next - 1]}`;

    const progress = document.querySelectorAll(".progress-step");
    progress.forEach((el, i) => {
        el.classList.remove("active", "completed");
        if (i < next - 1) el.classList.add("completed");
        if (i === next - 1) el.classList.add("active");
    });

    currentStep = next;
}
window.changeStep = changeStep;

/* 7) Validaciones por paso (Descripción solo obligatoria, sin mínimo) */
function validateCurrentStep() {
    if (currentStep === 1) {
        const ids = [
            "nombres",
            "apellidos",
            "tipoDocumento",
            "numeroDocumento",
            "telefono",
            "email",
        ];
        for (const id of ids) {
            const el = document.getElementById(id);
            if (!el || !String(el.value).trim()) {
                el?.focus();
                alert(
                    "Por favor completa todos los campos obligatorios del Paso 1."
                );
                return false;
            }
        }
        return true;
    }

    if (currentStep === 2) {
        const hiddenTipo = document.getElementById("tipoReclamacion");
        if (!hiddenTipo || !hiddenTipo.value) {
            alert("Por favor selecciona el Tipo de Reclamación.");
            return false;
        }
        const area = document.getElementById("area");
        if (!area || !area.value) {
            area?.focus();
            alert("Por favor selecciona el Área Relacionada.");
            return false;
        }
        return true;
    }

    if (currentStep === 3) {
        const asunto = document.getElementById("asunto");
        const desc = document.getElementById("descripcion");
        if (!asunto || !asunto.value.trim()) {
            asunto?.focus();
            alert("Ingresa el asunto.");
            return false;
        }
        if (!desc || !desc.value.trim()) {
            desc?.focus();
            alert("Ingresa una descripción.");
            return false;
        }
        return true;
    }

    return true;
}

/* 8) Listado visual de archivos (safe si no existe el input) */
const fileInput = document.getElementById("documentos");
if (fileInput) {
    fileInput.addEventListener("change", (e) => {
        const list = document.getElementById("fileList");
        if (!list) return;
        list.innerHTML = "";

        Array.from(e.target.files || []).forEach((file) => {
            const item = document.createElement("div");
            item.className =
                "flex items-center justify-between p-3 bg-gray-50 rounded-lg";
            item.innerHTML = `
          <div class="flex items-center gap-3">
            <i data-lucide="file" class="h-4 w-4 text-gray-500"></i>
            <span class="text-sm">${file.name}</span>
            <span class="text-xs text-gray-500">(${(
                    file.size /
                    1024 /
                    1024
                ).toFixed(2)} MB)</span>
          </div>
          <button type="button" class="text-[#E27227] hover:text-[#00264B]">
            <i data-lucide="x" class="h-4 w-4"></i>
          </button>`;
            item.querySelector("button")?.addEventListener("click", () =>
                item.remove()
            );
            list.appendChild(item);
        });

        if (window.lucide?.createIcons) lucide.createIcons();
    });
}

/* 9) Utilidades de estado visual */
function estadoBadgeClass(name) {
    const s = (name || "").toLowerCase();
    if (s.includes("pend")) return "bg-amber-100 text-amber-800";
    if (s.includes("proc")) return "bg-blue-100 text-blue-800";
    if (s.includes("resu")) return "bg-green-100 text-green-800";
    if (s.includes("cerr") || s.includes("rech"))
        return "bg-red-100 text-red-800";
    return "bg-gray-100 text-gray-800";
}

/* 10) Búsqueda por documento (con tarjetas clickeables y modal detalle) */
async function buscarReclamacion() {
    const documento = document
        .getElementById("documentoBusqueda")
        ?.value?.trim();
    const codigo = document.getElementById("codigoBusqueda")?.value?.trim();
    const box = document.getElementById("resultadoBusqueda");
    if (!documento || !codigo) {
        alert("Ingresa tu número de documento y el código de reclamo.");
        return;
    }
    if (!box) return;

    box.classList.remove("hidden");
    box.innerHTML = `
      <div class="border-t border-gray-200 pt-8">
        <div class="text-center text-gray-600">Buscando reclamaciones...</div>
      </div>
    `;

    try {
        const url = `${window.LIBRO_CFG.searchUrl
            }?documento=${encodeURIComponent(
                documento
            )}&codigo=${encodeURIComponent(codigo)}`;
        const res = await fetch(url, {
            headers: { Accept: "application/json" },
        });
        if (!res.ok) throw new Error("No se pudo realizar la búsqueda.");
        const data = await res.json();

        if (!data.items || data.items.length === 0) {
            box.innerHTML = `
          <div class="border-t border-gray-200 pt-8">
            <div class="text-center text-gray-500">
              No se encontraron reclamaciones para el documento <b>${documento}</b>.
            </div>
          </div>`;
            return;
        }

        // Contenedor superior
        box.innerHTML = `
        <div class="border-t border-gray-200 pt-8">
          <div class="mb-4 text-sm text-gray-600">
            Se encontraron <span class="font-semibold">${data.total}</span> reclamación(es) para el documento <b>${documento}</b>.
          </div>
          <div id="listaResultados" class="space-y-4"></div>
        </div>`;
        const listContainer = document.getElementById("listaResultados");

        // Crea cada tarjeta (sin innerHTML con datos del backend)
        data.items.forEach((it) => {
            const card = document.createElement("div");
            card.className =
                "p-5 rounded-xl border border-gray-200 bg-white hover:shadow transition cursor-pointer";
            card.setAttribute("role", "button");
            card.setAttribute("tabindex", "0");

            const top = document.createElement("div");
            top.className = "flex items-start justify-between gap-4";

            const left = document.createElement("div");

            const l1 = document.createElement("div");
            l1.className = "text-sm text-gray-500";
            l1.textContent = `Reclamación #${String(it.id)} • ${it.fecha ?? ""
                }`;

            const l2 = document.createElement("div");
            l2.className = "font-semibold text-lg";
            l2.textContent = it.asunto ?? "-";

            const l3 = document.createElement("div");
            l3.className = "text-sm text-gray-600";
            l3.textContent = `Tipo: ${it.tipo ?? "-"} • Área: ${it.area ?? "-"
                }`;

            left.append(l1, l2, l3);

            const badge = document.createElement("span");
            badge.className = `px-3 py-1 rounded-full text-xs font-semibold ${estadoBadgeClass(
                it.estado
            )} whitespace-nowrap`;
            badge.textContent = it.estado ?? "—";

            top.append(left, badge);
            card.append(top);

            // Click/tecla -> abrir modal con detalle
            card.addEventListener("click", () => openDetailModal(it));
            card.addEventListener("keydown", (e) => {
                if (e.key === "Enter" || e.key === " ") openDetailModal(it);
            });

            listContainer.append(card);
        });

        if (window.lucide?.createIcons) lucide.createIcons();
        box.scrollIntoView({ behavior: "smooth" });
    } catch (err) {
        box.innerHTML = `
        <div class="border-t border-gray-200 pt-8">
          <div class="text-red-600">${err.message || "Ocurrió un error al buscar."
            }</div>
        </div>`;
    }
}
window.buscarReclamacion = buscarReclamacion;

/* 11) Envío del formulario (usa modal de éxito) */
const form = document.getElementById("complaintForm");
if (form) {
    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        if (!validateCurrentStep()) return;

        const payload = {
            nombres: document.getElementById("nombres").value.trim(),
            apellidos: document.getElementById("apellidos").value.trim(),
            tipo_documento_id: Number(
                document.getElementById("tipoDocumento").value || 0
            ),
            numero_documento: document
                .getElementById("numeroDocumento")
                .value.trim(),
            telefono: document.getElementById("telefono").value.trim(),
            email: document.getElementById("email").value.trim(),
            tipo_reclamacion_id: Number(
                document.getElementById("tipoReclamacion").value || 0
            ),
            area_relacionada: document.getElementById("area").value,
            fecha_incidente:
                document.getElementById("fechaIncidente").value || null,
            asunto: document.getElementById("asunto").value.trim(),
            descripcion: document.getElementById("descripcion").value.trim(),
        };

        if (!payload.tipo_documento_id || !payload.tipo_reclamacion_id) {
            alert("Selecciona Tipo de documento y Tipo de reclamación.");
            return;
        }
        if (!payload.descripcion.trim()) {
            alert("La descripción es obligatoria.");
            return;
        }

        try {
            const url =
                window.LIBRO_CFG && window.LIBRO_CFG.storeUrl
                    ? window.LIBRO_CFG.storeUrl
                    : "/libro/store";
            const token =
                document
                    .querySelector('meta[name="csrf-token"]')
                    ?.getAttribute("content") || "";

            const res = await fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    ...(token ? { "X-CSRF-TOKEN": token } : {}),
                },
                body: JSON.stringify(payload),
            });

            if (!res.ok) {
                let msg = "No se pudo registrar tu reclamación.";
                try {
                    const dataErr = await res.json();
                    msg = dataErr.message || msg;
                } catch (_) { }
                throw new Error(msg);
            }

            // Mostrar modal de éxito con datos
            const data = await res.json();
            openSuccessModal({
                id: data?.id,
                asunto: payload.asunto,
                email: payload.email,
                documento: payload.numero_documento,
                codigo: data?.codigo, // <-- nuevo campo
            });

            // Reset UI a Paso 1
            form.reset();
            const hidden = document.getElementById("tipoReclamacion");
            if (hidden) hidden.value = "";
            document
                .querySelectorAll(".complaint-type-card")
                .forEach((c) => c.classList.remove("border-[#E27227]"));
            document
                .getElementById(`step${currentStep}`)
                ?.classList.add("hidden");
            document.getElementById("step1")?.classList.remove("hidden");
            document.getElementById("prevBtn")?.classList.add("hidden");
            document.getElementById("nextBtn")?.classList.remove("hidden");
            document.getElementById("submitBtn")?.classList.add("hidden");
            const stepText = document.getElementById("step-text");
            if (stepText) stepText.textContent = "Paso 1: Información Personal";
            document.querySelectorAll(".progress-step").forEach((el, i) => {
                el.classList.remove("active", "completed");
                if (i === 0) el.classList.add("active");
            });
            currentStep = 1;
        } catch (err) {
            alert(err.message || "Ocurrió un error.");
        }
    });
}

/* ===== Modal de éxito ===== */
function openSuccessModal(info = {}) {
    const m = document.getElementById("successModal");
    const p = document.getElementById("successPanel");
    if (!m || !p) return;

    // completa resumen
    document.getElementById("sm-id").textContent = info.id
        ? `#${info.id}`
        : "—";
    document.getElementById("sm-asunto").textContent = info.asunto || "—";
    document.getElementById("sm-email").textContent = info.email || "—";
    document.getElementById("sm-codigo").textContent = info.codigo || "—";

    // muestra + pequeña animación
    m.classList.remove("hidden");
    requestAnimationFrame(() => {
        p.classList.remove("opacity-0", "scale-95");
    });

    // acciones
    const goTrack = document.getElementById("sm-track");
    const newBtn = document.getElementById("sm-new");

    goTrack.onclick = () => {
        const docInput = document.getElementById("documentoBusqueda");
        if (docInput && info.documento) {
            docInput.value = info.documento;
        }
        closeSuccessModal();
        scrollToSection("seguimiento");
        if (docInput && docInput.value.trim()) {
            setTimeout(() => window.buscarReclamacion?.(), 200);
        }
    };

    newBtn.onclick = () => {
        closeSuccessModal();
        scrollToSection("formulario");
    };

    if (window.lucide?.createIcons) lucide.createIcons();
}

function closeSuccessModal() {
    const m = document.getElementById("successModal");
    const p = document.getElementById("successPanel");
    if (!m || !p) return;
    p.classList.add("opacity-0", "scale-95");
    setTimeout(() => m.classList.add("hidden"), 180);
}

// cerrar por overlay, botón X y tecla Esc
(() => {
    const overlay = document.getElementById("successOverlay");
    const closeBtn = document.getElementById("sm-close");
    overlay?.addEventListener("click", closeSuccessModal);
    closeBtn?.addEventListener("click", closeSuccessModal);
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") closeSuccessModal();
    });
})();

/* ===== Modal de detalle ===== */
function badgeClassByEstado(name) {
    return estadoBadgeClass(name);
}

// Referencias de la sección Respuesta/Documento del modal
const dmRespuestaWrap = document.getElementById("dm-respuesta-wrap");
const dmFechaResp = document.getElementById("dm-fecha-respuesta");
const dmRespuesta = document.getElementById("dm-respuesta");
const dmVerDocBtn = document.getElementById("dm-ver-doc");

function openDetailModal(item) {
    const m = document.getElementById("detailModal");
    const p = document.getElementById("detailPanel");
    if (!m || !p) return;

    // Rellena datos principales
    document.getElementById("dm-id").textContent = `#${item?.id ?? "—"}`;
    document.getElementById("dm-fecha").textContent = item?.fecha ?? "—";
    document.getElementById("dm-tipo").textContent = item?.tipo ?? "—";
    document.getElementById("dm-area").textContent = item?.area ?? "—";
    document.getElementById("dm-asunto").textContent = item?.asunto ?? "—";
    document.getElementById("dm-descripcion").textContent =
        item?.descripcion ?? "—";

    const est = document.getElementById("dm-estado");
    est.textContent = item?.estado ?? "—";
    est.className = `px-2 py-0.5 rounded-full text-xs font-semibold ${badgeClassByEstado(
        item?.estado
    )}`;

    // ---- Respuesta / Documento ----
    const tieneAlgoDeRespuesta =
        item &&
        ((item.respuesta && String(item.respuesta).trim().length) ||
            (item.fecha_respuesta &&
                String(item.fecha_respuesta).trim().length) ||
            item.documento_ver_url ||
            item.documento_url);

    if (tieneAlgoDeRespuesta) {
        dmRespuestaWrap?.classList.remove("hidden");

        dmFechaResp &&
            (dmFechaResp.textContent = item.fecha_respuesta
                ? item.fecha_respuesta
                : "—");
        dmRespuesta &&
            (dmRespuesta.textContent = item.respuesta ? item.respuesta : "—");

        const docLink = item.documento_ver_url || item.documento_url || null;
        if (docLink && dmVerDocBtn) {
            dmVerDocBtn.classList.remove("hidden");
            dmVerDocBtn.onclick = () =>
                window.open(docLink, "_blank", "noopener,noreferrer");
        } else if (dmVerDocBtn) {
            dmVerDocBtn.classList.add("hidden");
            dmVerDocBtn.onclick = null;
        }
    } else {
        dmRespuestaWrap?.classList.add("hidden");
        if (dmVerDocBtn) dmVerDocBtn.onclick = null;
    }

    // Mostrar modal + animación
    m.classList.remove("hidden");
    requestAnimationFrame(() => {
        p.classList.remove("opacity-0", "scale-95");
    });

    if (window.lucide?.createIcons) lucide.createIcons();
}
window.openDetailModal = openDetailModal;

function closeDetailModal() {
    const m = document.getElementById("detailModal");
    const p = document.getElementById("detailPanel");
    if (!m || !p) return;
    p.classList.add("opacity-0", "scale-95");
    setTimeout(() => m.classList.add("hidden"), 180);
}

// Listeners de cierre para el modal de detalle
(() => {
    document
        .getElementById("detailOverlay")
        ?.addEventListener("click", closeDetailModal);
    document
        .getElementById("dm-close")
        ?.addEventListener("click", closeDetailModal);
    document
        .getElementById("dm-ok")
        ?.addEventListener("click", closeDetailModal);
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") closeDetailModal();
    });
})();
