// Inicializar iconos de Lucide
lucide.createIcons();

// Variables globales
let activeSection = 'hero';
let isMobileMenuOpen = false;

// Función para scroll suave a secciones
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

// Función para cerrar menú móvil
function closeMobileMenu() {
    isMobileMenuOpen = false;
    document.getElementById('mobile-menu').classList.add('hidden');
    document.getElementById('menu-icon').classList.remove('hidden');
    document.getElementById('close-icon').classList.add('hidden');
}

// Función para alternar menú móvil
function toggleMobileMenu() {
    isMobileMenuOpen = !isMobileMenuOpen;
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');

    if (isMobileMenuOpen) {
        mobileMenu.classList.remove('hidden');
        menuIcon.classList.add('hidden');
        closeIcon.classList.remove('hidden');
    } else {
        mobileMenu.classList.add('hidden');
        menuIcon.classList.remove('hidden');
        closeIcon.classList.add('hidden');
    }
}

// Función para actualizar navegación activa
function updateActiveNavigation() {
    const sections = ['hero', 'inversiones', 'reinversiones', 'donaciones', 'infraestructura'];
    let currentSection = 'hero';

    sections.forEach(sectionId => {
        const element = document.getElementById(sectionId);
        if (element) {
            const rect = element.getBoundingClientRect();
            if (rect.top <= 200 && rect.bottom >= 200) {
                currentSection = sectionId;
            }
        }
    });

    // Actualizar botones de navegación
    document.querySelectorAll('.nav-btn').forEach(btn => {
        const section = btn.getAttribute('data-section');
        if (section === currentSection) {
            btn.classList.add('bg-[#E27227]');
            btn.classList.remove('hover:bg-[#1A4FD3]/20');
        } else {
            btn.classList.remove('bg-[#E27227]');
            btn.classList.add('hover:bg-[#1A4FD3]/20');
        }
    });

    activeSection = currentSection;
}

// Event listeners
document.getElementById('mobile-menu-btn').addEventListener('click', toggleMobileMenu);
window.addEventListener('scroll', updateActiveNavigation);

// Cerrar menú móvil al hacer clic en enlaces del menú móvil
document.querySelectorAll('#mobile-menu button').forEach(btn => {
    btn.addEventListener('click', closeMobileMenu);
});

// Inicializar navegación activa
updateActiveNavigation();