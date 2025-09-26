// public/js/web/estadisticas.js

// --------- Helpers UI ---------
if (window.lucide && typeof lucide.createIcons === "function") {
    lucide.createIcons();
}

function scrollToSection(id) {
    const el = document.getElementById(id);
    if (!el) return;
    const y = el.getBoundingClientRect().top + window.pageYOffset - 80;
    window.scrollTo({ top: y, behavior: "smooth" });
}
window.scrollToSection = scrollToSection;

// Resalta botón activo en la barra lateral
let activeSection = "hero";
function updateActiveNavigation() {
    const sections = document.querySelectorAll("section[id]");
    let current = "hero";
    sections.forEach((s) => {
        const top = s.offsetTop,
            h = s.clientHeight;
        if (window.scrollY >= top - 200 && window.scrollY < top + h - 200) {
            current = s.id;
        }
    });
    if (current !== activeSection) {
        const prev = document.querySelector(`[data-section="${activeSection}"]`);
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

// --------- Datos desde el body ---------
// Pasados como data-* para evitar Blade dentro del JS
const YEARS = JSON.parse(document.body.dataset.years || "[]");
const SECTIONS = JSON.parse(document.body.dataset.sections || "[]");

// Paleta de colores para Chart.js
const COLORS = [
    "#1A4FD3",
    "#4A84F7",
    "#E27227",
    "#00264B",
    "#10b981",
    "#ef4444",
    "#6366f1",
    "#f59e0b",
    "#0ea5e9",
    "#a855f7",
];

// Construye los gráficos por sección
function buildCharts() {
    if (!window.Chart) return;
    SECTIONS.forEach((sec, idx) => {
        const ctx = document.getElementById(`chart-${sec.id}`).getContext("2d");
        const datasets = sec.datasets.map((d, i) => ({
            label: d.label,
            data: d.data,
            backgroundColor: COLORS[i % COLORS.length],
            borderColor: COLORS[i % COLORS.length],
            borderWidth: 1,
        }));

        new Chart(ctx, {
            type: "bar",
            data: {
                labels: YEARS,
                datasets,
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: "top",
                    },
                },
                scales: {
                    y: { beginAtZero: true },
                },
            },
        });
    });
}
window.addEventListener("load", buildCharts);

// Scroll directo al gráfico
function openAllDatasets(id) {
    const el = document.getElementById(`chart-${id}`);
    if (!el) return;
    const wrapper = el.closest(".stats-card");
    const y = wrapper.getBoundingClientRect().top + window.pageYOffset - 80;
    window.scrollTo({ top: y, behavior: "smooth" });
}
window.openAllDatasets = openAllDatasets;

// Exportar tabla (placeholder)
function exportTable(id) {
    alert(
        `Exportando tabla de la sección: ${id}\n\nAquí puedes implementar exportación CSV/Excel.`
    );
}
window.exportTable = exportTable;
