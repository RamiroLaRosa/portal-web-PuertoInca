// ============================
//  Iconos (Lucide)
// ============================
lucide.createIcons();

// ============================
//  Navegación suave a secciones
// ============================
function scrollToSection(id) {
    const el = document.getElementById(id);
    if (!el) return;
    const y = el.getBoundingClientRect().top + window.pageYOffset - 80;
    window.scrollTo({ top: y, behavior: 'smooth' });
}

// ============================
//  Visor de PDF (responsive)
// ============================
let currentZoom = 100;
let isFullscreen = false;

// Breakpoint móvil: igual que tu CSS (<= 768px)
const isMobile = () => window.matchMedia('(max-width: 768px)').matches;

/**
 * Aplica/actualiza el zoom del visor.
 * - En móvil: NO aplicar transform; dejar zoom nativo (pinch-zoom).
 * - En desktop: usar transform + resize compensado como ya hacías.
 */
function updateZoom() {
    const iframe = document.getElementById('pdfIframe');
    const zoomLevel = document.getElementById('zoomLevel');
    if (!iframe) return;

    if (isMobile()) {
        // Restablece estilos para permitir zoom nativo
        iframe.style.transform = '';
        iframe.style.transformOrigin = '';
        iframe.style.width = '100%';

        // Altura la maneja el CSS (80vh). No mostramos nivel de zoom distinto.
        if (zoomLevel) zoomLevel.textContent = '100%';
        return;
    }

    // Desktop: tu lógica de escala
    iframe.style.transform = `scale(${currentZoom / 100})`;
    iframe.style.transformOrigin = 'top left';

    if (currentZoom !== 100) {
        iframe.style.width = `${100 * (100 / currentZoom)}%`;
        iframe.style.height = `${600 * (100 / currentZoom)}px`;
    } else {
        iframe.style.width = '100%';
        iframe.style.height = '600px';
    }

    if (zoomLevel) zoomLevel.textContent = `${currentZoom}%`;
}

function zoomIn() {
    if (isMobile()) return; // en móvil usamos pinch-zoom
    if (currentZoom < 200) {
        currentZoom += 25;
        updateZoom();
    }
}

function zoomOut() {
    if (isMobile()) return; // en móvil usamos pinch-zoom
    if (currentZoom > 50) {
        currentZoom -= 25;
        updateZoom();
    }
}

function downloadPDF() {
    const iframe = document.getElementById('pdfIframe');
    if (!iframe || !iframe.src) return;
    const a = document.createElement('a');
    a.href = iframe.src;
    a.download = 'Organigrama_NOVA_Academia.pdf';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}

function toggleFullscreen() {
    const container = document.getElementById('pdfContainer');
    const icon = document.getElementById('fullscreenIcon');
    if (!container) return;

    if (!isFullscreen) {
        container.classList.add('fullscreen-mode');
        icon && icon.setAttribute('data-lucide', 'minimize');
        isFullscreen = true;
    } else {
        container.classList.remove('fullscreen-mode');
        icon && icon.setAttribute('data-lucide', 'maximize');
        isFullscreen = false;
    }
    // Re-render de íconos por cambio de data-lucide
    lucide.createIcons();

    // Recalcular zoom al cambiar layout
    setTimeout(updateZoom, 0);
}

// ============================
//  Inicialización
// ============================
window.addEventListener('DOMContentLoaded', () => {
    const iframe = document.getElementById('pdfIframe');

    // En móvil, intenta abrir el PDF ajustado a ancho de página (#zoom=page-width)
    if (iframe && isMobile()) {
        try {
            const u = new URL(iframe.src, window.location.href);
            if (!u.hash) u.hash = '#zoom=page-width'; // algunos visores lo soportan
            // Solo re-asigna si cambió algo para evitar recargar de más
            if (u.toString() !== iframe.src) iframe.src = u.toString();
        } catch {
            // Si el src es relativo extraño o data URL, ignorar
        }
    }

    updateZoom();
});

// Recalcular al cambiar tamaño de ventana (pasa de móvil a desktop y viceversa)
window.addEventListener('resize', updateZoom);
