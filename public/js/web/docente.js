// public/js/web/docentes.js

// =========================
// Inicializa íconos
// =========================
if (window.lucide && typeof lucide.createIcons === "function") {
  lucide.createIcons();
}

// =========================
// Helpers de rutas inyectadas desde el HTML
// =========================
const PERSONAL_URL_TEMPLATE = document.body.dataset.personalUrlTemplate || "";
const DOCENTE_BASE_URL = document.body.dataset.docenteBaseUrl || "";

// =========================
/** Navegación lateral */
// =========================
let activeSection = "";

function scrollToSection(sectionId) {
  const el = document.getElementById(sectionId);
  if (!el) return;
  const y = el.getBoundingClientRect().top + window.pageYOffset - 80;
  window.scrollTo({ top: y, behavior: "smooth" });
}
window.scrollToSection = scrollToSection; // expone para los botones onclick

function updateActiveNavigation() {
  const sections = document.querySelectorAll("section[id]");
  let current = activeSection;

  sections.forEach((s) => {
    const top = s.offsetTop;
    const h = s.clientHeight;
    if (window.scrollY >= top - 200 && window.scrollY < top + h - 200) {
      current = s.getAttribute("id");
    }
  });

  if (current && current !== activeSection) {
    document.querySelectorAll(".nav-dot").forEach((b) => {
      b.classList.remove("bg-brand-orange");
      b.classList.add("hover:bg-brand-blue/90");
    });
    const btn = document.querySelector(`[data-section="${current}"]`);
    if (btn) {
      btn.classList.add("bg-brand-orange");
      btn.classList.remove("hover:bg-brand-blue/90");
    }
    activeSection = current;
  }
}
window.addEventListener("scroll", updateActiveNavigation);
window.addEventListener("load", updateActiveNavigation);

// =========================
/** Modal genérico */
// =========================
function closeTeacherModal() {
  document.getElementById("teacherModal")?.classList.add("hidden");
}
window.closeTeacherModal = closeTeacherModal;

// =======================================================
// NUEVO: Utilidades para tablas responsive dentro del modal
// - Aplica clase base "rt" y "rt-stack" (stacked en ≤640px)
// - Inserta wrapper con overflow-x auto (fallback)
// - Copia los títulos de <th> a data-label de cada <td>
// =======================================================
function applyResponsiveTables(root = document) {
  root.querySelectorAll("table").forEach((t) => {
    const heads = Array.from(t.querySelectorAll("thead th")).map((th) =>
      th.textContent.trim()
    );

    // clases para estilos base y stacked
    t.classList.add("rt", "rt-stack");

    // envolver con scroll horizontal como fallback
    if (!t.parentElement.classList.contains("rt-wrapper")) {
      const wrap = document.createElement("div");
      wrap.className = "rt-wrapper";
      t.parentElement.insertBefore(wrap, t);
      wrap.appendChild(t);
    }

    // setear data-label en cada celda
    t.querySelectorAll("tbody tr").forEach((tr) => {
      Array.from(tr.cells).forEach((td, i) => {
        if (!td.hasAttribute("data-label") && heads[i]) {
          td.setAttribute("data-label", heads[i]);
        }
      });
    });
  });
}

function hydrateModalTables() {
  const content = document.getElementById("modalContent");
  applyResponsiveTables(content);
  window.lucide && lucide.createIcons();
}
// =======================================================

// =========================
/** MODAL: Datos personales (AJAX) */
// =========================
async function openPersonal(docenteId) {
  const modal = document.getElementById("teacherModal");
  const titleEl = document.getElementById("modalTitle");
  const bodyEl = document.getElementById("modalContent");

  try {
    const url = PERSONAL_URL_TEMPLATE.replace("DOC_ID", String(docenteId));
    const res = await fetch(url, { headers: { Accept: "application/json" } });
    if (!res.ok) throw new Error("No se pudo cargar la información.");
    const data = await res.json();
    if (!data.ok) throw new Error("Respuesta inválida.");

    const t = data.docente;
    const p = data.personal;

    titleEl.textContent = `${t.nombre} — Datos personales`;

    if (!p) {
      bodyEl.innerHTML = `
        <div class="text-center py-10">
          <div class="w-20 h-20 mx-auto rounded-full bg-brand-gray flex items-center justify-center mb-4">
            <i data-lucide="user" class="h-10 w-10 text-brand-blue/60"></i>
          </div>
          <p class="text-brand-navy/70">Este docente aún no tiene datos personales registrados.</p>
        </div>`;
    } else {
      bodyEl.innerHTML = `
        <div class="grid md:grid-cols-3 gap-6 items-start">
          <div class="md:col-span-1">
            <div class="w-40 h-40 rounded-2xl overflow-hidden bg-brand-gray shadow">
              <img src="${t.foto}" alt="${t.nombre}" class="w-full h-full object-cover">
            </div>
            <div class="mt-4">
              <p class="font-bold text-lg">${t.nombre}</p>
              <p class="text-brand-navy/70">${t.cargo}</p>
              <div class="mt-2 text-sm text-brand-navy/70 flex items-center">
                <i data-lucide="mail" class="h-4 w-4 mr-2"></i>${t.correo}
              </div>
            </div>
          </div>

          <div class="md:col-span-2 bg-white rounded-xl border border-brand-gray p-6 space-y-6">
            <div class="grid md:grid-cols-2 gap-6">
              <div>
                <label class="text-xs font-semibold uppercase text-brand-navy/70">Nombres</label>
                <div class="mt-1 bg-brand-gray/40 rounded-md p-3 border-l-4 border-brand-blue">
                  <p class="font-medium">${p.nombres ?? "-"}</p>
                </div>
              </div>
              <div>
                <label class="text-xs font-semibold uppercase text-brand-navy/70">Apellidos</label>
                <div class="mt-1 bg-brand-gray/40 rounded-md p-3 border-l-4 border-brand-blue">
                  <p class="font-medium">${p.apellidos ?? "-"}</p>
                </div>
              </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
              <div>
                <label class="text-xs font-semibold uppercase text-brand-navy/70">Correo personal</label>
                <div class="mt-1 bg-brand-gray/40 rounded-md p-3 border-l-4 border-brand-orange">
                  <p class="font-medium">${p.correo ?? "-"}</p>
                </div>
              </div>
              <div>
                <label class="text-xs font-semibold uppercase text-brand-navy/70">Teléfono</label>
                <div class="mt-1 bg-brand-gray/40 rounded-md p-3 border-l-4 border-brand-orange">
                  <p class="font-medium">${p.telefono ?? "-"}</p>
                </div>
              </div>
            </div>
          </div>
        </div>`;
    }

    modal.classList.remove("hidden");
    lucide.createIcons();
  } catch (e) {
    titleEl.textContent = "Datos personales";
    bodyEl.innerHTML = `
      <div class="text-center py-10">
        <div class="w-20 h-20 mx-auto rounded-full bg-brand-gray flex items-center justify-center mb-4">
          <i data-lucide="alert-circle" class="h-10 w-10 text-red-500"></i>
        </div>
        <p class="text-brand-navy/70">Hubo un problema al cargar la información.</p>
      </div>`;
    document.getElementById("teacherModal").classList.remove("hidden");
    lucide.createIcons();
  }
}
window.openPersonal = openPersonal;

// =========================
/** MODAL: Formación Académica */
// =========================
async function openAcademic(docenteId) {
  const modal = document.getElementById("teacherModal");
  const titleEl = document.getElementById("modalTitle");
  const bodyEl = document.getElementById("modalContent");

  // loading
  titleEl.textContent = "Formación Académica";
  bodyEl.innerHTML = `
    <div class="py-10 text-center">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-brand-blue mx-auto mb-4"></div>
      <p class="text-brand-navy/70">Cargando información...</p>
    </div>`;
  modal.classList.remove("hidden");

  try {
    const res = await fetch(`${DOCENTE_BASE_URL}/${docenteId}/datos-academicos`);
    const json = await res.json();
    if (!json.ok) throw new Error("Respuesta no válida");

    const rows = json.data || [];
    titleEl.textContent = `${json.docente.nombre} — Formación Académica`;

    if (!rows.length) {
      bodyEl.innerHTML = `
        <div class="text-center py-12">
          <div class="w-24 h-24 mx-auto rounded-full bg-brand-gray flex items-center justify-center mb-4">
            <i data-lucide="graduation-cap" class="h-10 w-10 text-brand-blue/60"></i>
          </div>
          <h4 class="text-xl font-bold mb-2">Sin registros académicos</h4>
          <p class="text-brand-navy/70">Este docente aún no tiene información académica publicada.</p>
        </div>`;
      lucide.createIcons();
      return;
    }

    const rowsHtml = rows
      .map(
        (r, i) => `
          <tr class="${i % 2 === 0 ? "bg-white" : "bg-brand-gray/20"}">
            <td class="border border-brand-gray/30 px-4 py-3 font-medium text-brand-navy">${r.grado ?? "-"}</td>
            <td class="border border-brand-gray/30 px-4 py-3 text-brand-navy">${r.situacion_academica ?? "-"}</td>
            <td class="border border-brand-gray/30 px-4 py-3 text-brand-navy">${r.especialidad ?? "-"}</td>
            <td class="border border-brand-gray/30 px-4 py-3 text-brand-navy">${r.institucion_educativa ?? "-"}</td>
            <td class="border border-brand-gray/30 px-4 py-3 text-brand-navy">${r.fecha_emision ?? "-"}</td>
            <td class="border border-brand-gray/30 px-4 py-3 text-brand-navy">${r.registro ?? "-"}</td>
          </tr>`
      )
      .join("");

    bodyEl.innerHTML = `
      <div class="space-y-6">
        <div class="bg-white border border-brand-gray rounded-lg p-6">
          <h5 class="text-xl font-bold mb-6 flex items-center text-brand-blue">
            <i data-lucide="graduation-cap" class="h-5 w-5 mr-2"></i>
            Historial Académico
          </h5>
          <div class="overflow-x-auto">
            <table class="w-full border-collapse">
              <thead>
                <tr class="bg-brand-gray/50">
                  <th class="border border-brand-gray/30 px-4 py-3 text-left text-sm font-semibold text-brand-navy uppercase tracking-wide">Grado</th>
                  <th class="border border-brand-gray/30 px-4 py-3 text-left text-sm font-semibold text-brand-navy uppercase tracking-wide">Situación</th>
                  <th class="border border-brand-gray/30 px-4 py-3 text-left text-sm font-semibold text-brand-navy uppercase tracking-wide">Especialidad</th>
                  <th class="border border-brand-gray/30 px-4 py-3 text-left text-sm font-semibold text-brand-navy uppercase tracking-wide">Institución</th>
                  <th class="border border-brand-gray/30 px-4 py-3 text-left text-sm font-semibold text-brand-navy uppercase tracking-wide">Fecha emisión</th>
                  <th class="border border-brand-gray/30 px-4 py-3 text-left text-sm font-semibold text-brand-navy uppercase tracking-wide">Registro</th>
                </tr>
              </thead>
              <tbody>${rowsHtml}</tbody>
            </table>
          </div>
        </div>
      </div>`;

    // === NUEVO: hidratar tablas para vista responsive
    hydrateModalTables();
  } catch (e) {
    bodyEl.innerHTML = `
      <div class="text-center py-12">
        <div class="w-24 h-24 mx-auto rounded-full bg-red-100 flex items-center justify-center mb-4">
          <i data-lucide="alert-triangle" class="h-10 w-10 text-red-600"></i>
        </div>
        <h4 class="text-xl font-bold mb-2">No se pudo cargar la información</h4>
        <p class="text-brand-navy/70">Inténtalo nuevamente en unos minutos.</p>
      </div>`;
    lucide.createIcons();
  }
}
window.openAcademic = openAcademic;

// =========================
/** MODAL: Experiencia Laboral */
// =========================
async function openLaboral(docenteId) {
  const modal = document.getElementById("teacherModal");
  const titleEl = document.getElementById("modalTitle");
  const bodyEl = document.getElementById("modalContent");

  // loading
  titleEl.textContent = "Experiencia Laboral";
  bodyEl.innerHTML = `
    <div class="py-10 text-center">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-brand-blue mx-auto mb-4"></div>
      <p class="text-brand-navy/70">Cargando información...</p>
    </div>`;
  modal.classList.remove("hidden");

  try {
    const res = await fetch(`${DOCENTE_BASE_URL}/${docenteId}/datos-laborales`, {
      headers: { Accept: "application/json" },
    });
    const json = await res.json();
    if (!json.ok) throw new Error("Respuesta no válida");

    const rows = json.data || [];
    titleEl.textContent = `${json.docente.nombre} — Experiencia Laboral`;

    if (!rows.length) {
      bodyEl.innerHTML = `
        <div class="text-center py-12">
          <div class="w-24 h-24 mx-auto rounded-full bg-brand-gray flex items-center justify-center mb-4">
            <i data-lucide="briefcase" class="h-10 w-10 text-brand-blue/60"></i>
          </div>
          <h4 class="text-xl font-bold mb-2">Sin registros laborales</h4>
          <p class="text-brand-navy/70">Este docente aún no tiene información laboral publicada.</p>
        </div>`;
      lucide.createIcons();
      return;
    }

    const rowsHtml = rows
      .map(
        (r, i) => `
          <tr class="${i % 2 === 0 ? "bg-white" : "bg-brand-gray/20"}">
            <td class="border border-brand-gray/30 px-4 py-3 font-medium text-brand-navy">${r.institucion ?? "-"}</td>
            <td class="border border-brand-gray/30 px-4 py-3 text-brand-navy">${r.cargo ?? "-"}</td>
            <td class="border border-brand-gray/30 px-4 py-3 text-brand-navy">${r.experiencia ?? "-"}</td>
            <td class="border border-brand-gray/30 px-4 py-3 text-brand-navy">${r.inicio_labor ?? "-"}</td>
            <td class="border border-brand-gray/30 px-4 py-3 text-brand-navy">${r.termino_labor ?? "Actualidad"}</td>
            <td class="border border-brand-gray/30 px-4 py-3 text-brand-navy">${r.tiempo_cargo ?? "-"}</td>
          </tr>`
      )
      .join("");

    bodyEl.innerHTML = `
      <div class="space-y-6">
        <div class="bg-white border border-brand-gray rounded-lg p-6">
          <h5 class="text-xl font-bold mb-6 flex items-center text-brand-blue">
            <i data-lucide="briefcase" class="h-5 w-5 mr-2"></i>
            Historial Laboral
          </h5>
          <div class="overflow-x-auto">
            <table class="w-full border-collapse">
              <thead>
                <tr class="bg-brand-gray/50">
                  <th class="border border-brand-gray/30 px-4 py-3 text-left text-sm font-semibold text-brand-navy uppercase tracking-wide">Institución</th>
                  <th class="border border-brand-gray/30 px-4 py-3 text-left text-sm font-semibold text-brand-navy uppercase tracking-wide">Cargo</th>
                  <th class="border border-brand-gray/30 px-4 py-3 text-left text-sm font-semibold text-brand-navy uppercase tracking-wide">Experiencia</th>
                  <th class="border border-brand-gray/30 px-4 py-3 text-left text-sm font-semibold text-brand-navy uppercase tracking-wide">Inicio</th>
                  <th class="border border-brand-gray/30 px-4 py-3 text-left text-sm font-semibold text-brand-navy uppercase tracking-wide">Término</th>
                  <th class="border border-brand-gray/30 px-4 py-3 text-left text-sm font-semibold text-brand-navy uppercase tracking-wide">Tiempo en cargo</th>
                </tr>
              </thead>
              <tbody>${rowsHtml}</tbody>
            </table>
          </div>
        </div>
      </div>`;

    // === NUEVO: hidratar tablas para vista responsive
    hydrateModalTables();
  } catch (e) {
    bodyEl.innerHTML = `
      <div class="text-center py-12">
        <div class="w-24 h-24 mx-auto rounded-full bg-red-100 flex items-center justify-center mb-4">
          <i data-lucide="alert-triangle" class="h-10 w-10 text-red-600"></i>
        </div>
        <h4 class="text-xl font-bold mb-2">No se pudo cargar la información</h4>
        <p class="text-brand-navy/70">Inténtalo nuevamente en unos minutos.</p>
      </div>`;
    lucide.createIcons();
  }
}
window.openLaboral = openLaboral;
