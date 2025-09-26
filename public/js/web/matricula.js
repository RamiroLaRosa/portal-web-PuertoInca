// Initialize Lucide icons
lucide.createIcons();

// Variables globales
let activeSection = 'hero';

// Scroll a sección
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

function closeMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    if (!mobileMenu) return;
    mobileMenu.classList.add('hidden');
    if (document.getElementById('menu-icon')) document.getElementById('menu-icon').classList.remove('hidden');
    if (document.getElementById('close-icon')) document.getElementById('close-icon').classList.add('hidden');
}

// Simulador (si está presente en el DOM)
function updateSimulator() {
    const tipoEstudiante = document.getElementById('tipoEstudiante')?.value || 'regular';
    const programa = document.getElementById('programa')?.value || 'industrial';
    const numCursos = Number(document.getElementById('numCursos')?.value || 5);

    if (document.getElementById('cursosValue')) {
        document.getElementById('cursosValue').textContent = numCursos + ' cursos';
    }

    let costoMatricula, costoPension;
    switch (programa) {
        case 'sistemas':
            costoMatricula = 800;
            costoPension = 1200;
            break;
        case 'industrial':
            costoMatricula = 750;
            costoPension = 1100;
            break;
        case 'administracion':
            costoMatricula = 700;
            costoPension = 950;
            break;
        default:
            costoMatricula = 750;
            costoPension = 1100;
    }
    const factorCursos = numCursos / 5;
    costoPension = Math.round(costoPension * factorCursos);
    if (tipoEstudiante === 'traslado') costoMatricula += 100;

    const costoTotal = costoMatricula + costoPension + 80 + 25;
    if (document.getElementById('costoMatricula')) document.getElementById('costoMatricula').textContent = 'S/ ' +
        costoMatricula;
    if (document.getElementById('costoPension')) document.getElementById('costoPension').textContent = 'S/ ' +
        costoPension;
    if (document.getElementById('costoTotal')) document.getElementById('costoTotal').textContent = 'S/ ' +
        costoTotal.toLocaleString();
}

// Navegación activa
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
            prevActive.classList.add('hover:bg-[#0F3B73]');
        }

        const currentActive = document.querySelector(`[data-section="${currentSection}"]`);
        if (currentActive) {
            currentActive.classList.add('bg-[#E27227]');
            currentActive.classList.remove('hover:bg-[#0F3B73]');
        }

        activeSection = currentSection;
    }
}

window.addEventListener('scroll', updateActiveNavigation);
window.addEventListener('load', () => {
    updateActiveNavigation();
    updateSimulator();
});

// Cerrar menú móvil al hacer clic fuera
document.addEventListener('click', (e) => {
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    if (!mobileMenu || !mobileMenuButton) return;
    if (!mobileMenu.contains(e.target) && !mobileMenuButton.contains(e.target)) {
        closeMobileMenu();
    }
});