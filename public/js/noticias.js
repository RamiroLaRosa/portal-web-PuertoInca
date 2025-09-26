// Inicia Lucide cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    if (window.lucide?.createIcons) lucide.createIcons();
    updateActiveNavigation();
});

// Estado de activo actual
let activeSection = 'noticias-destacadas';

// Scroll suave con offset por header
function scrollToSection(sectionId) {
    const el = document.getElementById(sectionId);
    if (el) {
        const yOffset = -80;
        const y = el.getBoundingClientRect().top + window.pageYOffset + yOffset;
        window.scrollTo({
            top: y,
            behavior: 'smooth'
        });
        setActiveDot(sectionId);
    }
    closeMobileMenu?.();
}

// Aplica la clase activa (círculo de acento) al botón correspondiente
function setActiveDot(sectionId) {
    const prev = document.querySelector(`[data-section="${activeSection}"]`);
    if (prev) prev.classList.remove('bg-[#E27227]');

    const curr = document.querySelector(`[data-section="${sectionId}"]`);
    if (curr) curr.classList.add('bg-[#E27227]');

    activeSection = sectionId;
}

// Detecta la sección visible y actualiza el activo
function updateActiveNavigation() {
    const candidates = ['noticias-destacadas', 'todas-noticias', 'categorias'];
    let current = activeSection;

    for (const id of candidates) {
        const sec = document.getElementById(id);
        if (!sec) continue;
        const top = sec.offsetTop;
        const height = sec.clientHeight || 0;
        if (window.scrollY >= top - 200 && window.scrollY < top + height - 200) {
            current = id;
            break;
        }
    }

    if (current !== activeSection) setActiveDot(current);
}

window.addEventListener('scroll', updateActiveNavigation);

// === Guards para el menú móvil si el header no está presente ===
function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');
    if (!mobileMenu || !menuIcon || !closeIcon) return;

    const isHidden = mobileMenu.classList.contains('hidden');
    mobileMenu.classList.toggle('hidden', !isHidden ? true : false);
    menuIcon.classList.toggle('hidden', isHidden);
    closeIcon.classList.toggle('hidden', !isHidden);
}

function closeMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');
    if (!mobileMenu || !menuIcon || !closeIcon) return;

    mobileMenu.classList.add('hidden');
    menuIcon.classList.remove('hidden');
    closeIcon.classList.add('hidden');
}