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
            prevActive.classList.remove('bg-[#E27227]');
            prevActive.classList.add('hover:bg-[#1A4FD3]/20');
        }

        const currentActive = document.querySelector(`[data-section="${currentSection}"]`);
        if (currentActive) {
            currentActive.classList.add('bg-[#E27227]');
            currentActive.classList.remove('hover:bg-[#1A4FD3]/20');
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

    if (!mobileMenu.contains(e.target) && !mobileMenuButton.contains(e.target)) {
        closeMobileMenu();
    }
}); 