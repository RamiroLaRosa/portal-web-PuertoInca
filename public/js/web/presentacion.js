/*************  ICONOS (seguro)  *************/
if (window.lucide && typeof lucide.createIcons === "function") {
    lucide.createIcons();
}

/*************  CONFIG *************/
const HEADER_OFFSET = 80; // ajusta si tu header mide distinto

/*************  NAV / SECCIONES *************/
const navBtns = Array.from(document.querySelectorAll("[data-section]"));
const sections = navBtns
    .map((btn) => document.getElementById(btn.dataset.section))
    .filter(Boolean); // ignora ids que no existen

// Aviso en consola si algún botón apunta a una sección inexistente
navBtns.forEach((btn) => {
    if (!document.getElementById(btn.dataset.section)) {
        console.warn(
            `No existe la sección #${btn.dataset.section}. ` +
            `Asegúrate de que el id del <section> coincida con data-section del botón.`
        );
    }
});

let activeSectionId = sections[0]?.id || null;

function setActive(id) {
    if (!id || id === activeSectionId) return;
    // quita estilo activo a todos
    navBtns.forEach((b) => {
        b.classList.remove("bg-brand-orange");
        b.classList.add("hover:bg-brand-blue/90");
    });
    // aplica al actual (si existe botón)
    const btn = document.querySelector(`[data-section="${id}"]`);
    if (btn) {
        btn.classList.add("bg-brand-orange");
        btn.classList.remove("hover:bg-brand-blue/90");
    }
    activeSectionId = id;
}

/*************  SCROLLSPY (con rAF) *************/
let ticking = false;
function updateActiveNavigation() {
    if (ticking) return;
    ticking = true;

    requestAnimationFrame(() => {
        const y = window.scrollY + HEADER_OFFSET + 1; // +1 para evitar empates en bordes
        let current = activeSectionId;

        for (const s of sections) {
            const top = s.offsetTop;
            const bottom = top + s.offsetHeight;
            if (y >= top && y < bottom) {
                current = s.id;
                break;
            }
        }

        setActive(current);
        ticking = false;
    });
}

/*************  SCROLL A SECCIÓN *************/
function scrollToSection(id) {
    const el = document.getElementById(id);
    if (!el) return;
    const y = el.getBoundingClientRect().top + window.pageYOffset - HEADER_OFFSET;
    window.scrollTo({ top: y, behavior: "smooth" });
    // actualiza estado activo tras el scroll (pequeño delay para que avance)
    setTimeout(updateActiveNavigation, 200);
}

// expón si lo llamas desde HTML (onclick)
window.scrollToSection = scrollToSection;

/*************  LISTENERS *************/
window.addEventListener("scroll", updateActiveNavigation, { passive: true });
document.addEventListener("DOMContentLoaded", updateActiveNavigation);
