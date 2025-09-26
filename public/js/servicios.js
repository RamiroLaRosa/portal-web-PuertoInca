// Initialize Lucide icons
lucide.createIcons();

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

// Cerrar menú móvil al hacer clic fuera
document.addEventListener('click', (e) => {
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    if (mobileMenu && mobileMenuButton && !mobileMenu.contains(e.target) && !mobileMenuButton.contains(e
        .target)) {
        closeMobileMenu();
    }
});

// Inicializar animaciones
window.addEventListener('load', () => {
    const serviceCards = document.querySelectorAll('.service-card');
    serviceCards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('fade-in');
        }, index * 200);
    });
});

// Actualizar navegación activa al hacer scroll (usa la nueva paleta)
function updateActiveNavigation() {
    const sections = document.querySelectorAll('section[id]');
    let currentSection = 'servicios';

    sections.forEach((section) => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (window.scrollY >= sectionTop - 200 && window.scrollY < sectionTop + sectionHeight - 200) {
            currentSection = section.getAttribute('id') || 'servicios';
        }
    });

    const navButtons = document.querySelectorAll('.nav-dot');
    navButtons.forEach(btn => {
        btn.classList.remove('bg-[#E27227]');
        btn.classList.add('hover:bg-[#1A4FD3]');
    });

    const activeButton = document.querySelector(`[onclick="scrollToSection('${currentSection}')"]`);
    if (activeButton) {
        activeButton.classList.add('bg-[#E27227]');
        activeButton.classList.remove('hover:bg-[#1A4FD3]');
    }
}

window.addEventListener('scroll', updateActiveNavigation);
window.addEventListener('load', updateActiveNavigation);