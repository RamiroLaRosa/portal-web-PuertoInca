// Initialize Lucide icons
lucide.createIcons();

let activeSection = 'presentacion';

// Actualiza la navegación activa
function updateActiveNavigation() {
    const sections = document.querySelectorAll('section[id]');
    let currentSection = 'presentacion';

    sections.forEach((section) => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (window.scrollY >= sectionTop - 200 && window.scrollY < sectionTop + sectionHeight - 200) {
            currentSection = section.getAttribute('id') || 'presentacion';
        }
    });

    if (currentSection !== activeSection) {
        const prevActive = document.querySelector(`[data-section="${activeSection}"]`);
        if (prevActive) {
            prevActive.classList.remove('bg-brand-orange');
            prevActive.classList.add('hover:bg-brand-blue/90');
        }

        const currentActive = document.querySelector(`[data-section="${currentSection}"]`);
        if (currentActive) {
            currentActive.classList.add('bg-brand-orange');
            currentActive.classList.remove('hover:bg-brand-blue/90');
        }

        activeSection = currentSection;
    }
}

// Función para desplazar a la sección correspondiente
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

    // Después de hacer scroll, actualizar la sección activa
    updateActiveNavigation();
}

// Toggle menú móvil
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

// Cerrar menú móvil
function closeMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');

    mobileMenu.classList.add('hidden');
    menuIcon.classList.remove('hidden');
    closeIcon.classList.add('hidden');
}

// Detectar scroll y actualizar sección activa
window.addEventListener('scroll', updateActiveNavigation);

// Detectar clic en los botones de la barra lateral
document.addEventListener('DOMContentLoaded', function () {
    const navButtons = document.querySelectorAll('[onclick^="scrollToSection"]');
    navButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const sectionId = this.getAttribute('onclick').match(/'([^']+)'/)[1];
            scrollToSection(sectionId);
        });
    });
});
