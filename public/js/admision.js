// Initialize Lucide icons
lucide.createIcons();

// Variables globales
let activeSection = 'hero';

// Función para hacer scroll a una sección
function scrollToSection(sectionId) {
    const element = document.getElementById(sectionId);
    if (element) {
        const yOffset = -80;
        const y = element.getBoundingClientRect().top + window.pageYOffset + yOffset;
        window.scrollTo({
            top: y,
            behavior: 'smooth'
        });
    }
    closeMobileMenu();
    closeMobileMenu();
}

// Función para toggle del menú móvil
function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');

    if (mobileMenu.classList.contains('hidden')) {
        mobileMenu.classList.remove('hidden');
        menuIcon.classList.add('hidden');
        closeIcon.classList.remove('hidden');
    } else {
        mobileMenu.classList.add('hidden');
        menuIcon.classList.remove('hidden');
        closeIcon.classList.add('hidden');
    }
}

// Función para cerrar el menú móvil
function closeMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');

    mobileMenu.classList.add('hidden');
    menuIcon.classList.remove('hidden');
    closeIcon.classList.add('hidden');
}

// Función para toggle de submenús móviles
function toggleSubmenu(submenuId) {
    const submenu = document.getElementById(submenuId + '-submenu');
    const chevron = document.getElementById(submenuId + '-chevron');

    if (submenu.classList.contains('hidden')) {
        submenu.classList.remove('hidden');
        chevron.style.transform = 'rotate(180deg)';
    } else {
        submenu.classList.add('hidden');
        chevron.style.transform = 'rotate(0deg)';
    }
}

// Función para descargar PDF
function downloadPDF(filename) {
    alert(`Descargando resultados: ${filename}.pdf`);
    // window.open(`/downloads/${filename}.pdf`, '_blank');
}

// Función para actualizar navegación activa
function updateActiveNavigation() {
    const sections = document.querySelectorAll('section[id]');
    let currentSection = 'hero';

    sections.forEach((section) => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (window.scrollY >= sectionTop - 200 && window.scrollY < sectionTop + sectionHeight - 200) {
            currentSection = section.getAttribute('id') || 'hero';
        }
    });

    if (currentSection !== activeSection) {
        const prevActive = document.querySelector(`[data-section="${activeSection}"]`);
        if (prevActive) {
            prevActive.classList.remove('bg-brand-orange');
            prevActive.classList.add('hover:bg-brand-blue/70');
        }

        const currentActive = document.querySelector(`[data-section="${currentSection}"]`);
        if (currentActive) {
            currentActive.classList.add('bg-brand-orange');
            currentActive.classList.remove('hover:bg-brand-blue/70');
        }

        activeSection = currentSection;
    }
}

// Event listeners
window.addEventListener('scroll', updateActiveNavigation);
window.addEventListener('load', () => {
    updateActiveNavigation();
});

// Cerrar menú móvil al hacer clic fuera
document.addEventListener('click', (e) => {
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    if (mobileMenu && mobileMenuButton && !mobileMenu.contains(e.target) && !mobileMenuButton.contains(e
        .target)) {
        closeMobileMenu();
    }
});