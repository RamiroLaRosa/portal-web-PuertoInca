// Initialize Lucide icons
lucide.createIcons();

// Variables globales
let activeSection = 'organigrama';
let currentZoom = 100;
let isFullscreen = false;

// PDF loading simulation and error handling
function initializePDF() {
    const iframe = document.getElementById('pdfIframe');
    const loading = document.getElementById('pdfLoading');
    const error = document.getElementById('pdfError');
    const frame = document.getElementById('pdfFrame');
    const status = document.getElementById('documentStatus');

    // Simulate loading time
    setTimeout(() => {
        // Try to load PDF
        iframe.onload = function() {
            loading.classList.add('hidden');
            frame.classList.remove('hidden');
            updateStatus('success', 'Cargado correctamente');
        };

        iframe.onerror = function() {
            loading.classList.add('hidden');
            error.classList.remove('hidden');
            updateStatus('error', 'Error de carga');
        };

        // Force load after timeout if no response
        setTimeout(() => {
            if (!frame.classList.contains('hidden')) return;

            loading.classList.add('hidden');
            frame.classList.remove('hidden');
            updateStatus('success', 'Cargado correctamente');
        }, 2000);
    }, 1500);
}

// Update document status
function updateStatus(type, message) {
    const status = document.getElementById('documentStatus');
    const dot = status.querySelector('div');
    const text = status.querySelector('span');

    dot.className = `w-2 h-2 rounded-full ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
    text.textContent = message;
}

// Zoom functionality
function zoomIn() {
    if (currentZoom < 200) {
        currentZoom += 25;
        updateZoom();
    }
}

function zoomOut() {
    if (currentZoom > 50) {
        currentZoom -= 25;
        updateZoom();
    }
}

function updateZoom() {
    const iframe = document.getElementById('pdfIframe');
    const zoomLevel = document.getElementById('zoomLevel');

    iframe.style.transform = `scale(${currentZoom / 100})`;
    iframe.style.transformOrigin = 'top left';

    if (currentZoom !== 100) {
        iframe.style.width = `${100 * (100 / currentZoom)}%`;
        iframe.style.height = `${600 * (100 / currentZoom)}px`;
    } else {
        iframe.style.width = '100%';
        iframe.style.height = '600px';
    }

    zoomLevel.textContent = `${currentZoom}%`;
}

// Download PDF
function downloadPDF() {
    const link = document.createElement('a');
    link.href = '/assets/Organigrama.pdf';
    link.download = 'Organigrama_NOVA_Academia.pdf';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Fullscreen toggle
function toggleFullscreen() {
    const container = document.getElementById('pdfContainer');
    const icon = document.getElementById('fullscreenIcon');

    if (!isFullscreen) {
        container.classList.add('fullscreen-mode');
        icon.setAttribute('data-lucide', 'minimize');
        isFullscreen = true;
    } else {
        container.classList.remove('fullscreen-mode');
        icon.setAttribute('data-lucide', 'maximize');
        isFullscreen = false;
    }

    lucide.createIcons();
}

// Retry loading PDF
function retryLoad() {
    const loading = document.getElementById('pdfLoading');
    const error = document.getElementById('pdfError');
    const frame = document.getElementById('pdfFrame');

    error.classList.add('hidden');
    frame.classList.add('hidden');
    loading.classList.remove('hidden');

    initializePDF();
}

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
    let currentSection = 'organizacion';

    sections.forEach((section) => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (window.scrollY >= sectionTop - 200 && window.scrollY < sectionTop + sectionHeight - 200) {
            currentSection = section.getAttribute('id') || 'organizacion';
        }
    });

    if (currentSection !== activeSection) {
        // Remover clase activa de navegación anterior
        const prevActive = document.querySelector(`[data-section="${activeSection}"]`);
        if (prevActive) {
            prevActive.classList.remove('bg-orange-500');
            prevActive.classList.add('hover:bg-[#343a40]');
        }

        // Agregar clase activa a navegación actual
        const currentActive = document.querySelector(`[data-section="${currentSection}"]`);
        if (currentActive) {
            currentActive.classList.add('bg-orange-500');
            currentActive.classList.remove('hover:bg-[#343a40]');
        }

        activeSection = currentSection;
    }
}

// Función para animar elementos fade-in
function animateFadeInElements() {
    const fadeElements = document.querySelectorAll('.fade-in');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1
    });

    fadeElements.forEach(element => {
        observer.observe(element);
    });
}

// Datos para el modal
const orgData = {
    'consejo': {
        title: 'Consejo Directivo',
        content: `
            <p class="text-gray-600 mb-4">El Consejo Directivo es el máximo órgano de gobierno de NOVA Academia, responsable de la dirección estratégica y supervisión institucional.</p>
            <h4 class="font-bold mb-2">Composición:</h4>
            <ul class="list-disc list-inside text-gray-600 mb-4">
                <li>Presidente del Consejo</li>
                <li>Representante de los fundadores</li>
                <li>Representante académico externo</li>
                <li>Representante de padres de familia</li>
                <li>Rector (con voz pero sin voto)</li>
            </ul>
            <h4 class="font-bold mb-2">Responsabilidades principales:</h4>
            <ul class="list-disc list-inside text-gray-600">
                <li>Definir la visión y estrategia institucional</li>
                <li>Aprobar presupuestos y planes de inversión</li>
                <li>Nombrar y evaluar al Rector</li>
                <li>Supervisar el cumplimiento de la misión</li>
            </ul>
        `
    },
    'rectoria': {
        title: 'Rectoría',
        content: `
            <p class="text-gray-600 mb-4">La Rectoría es la máxima autoridad ejecutiva de la institución, responsable de la implementación de las políticas y la dirección operativa.</p>
            <h4 class="font-bold mb-2">Funciones principales:</h4>
            <ul class="list-disc list-inside text-gray-600 mb-4">
                <li>Representación legal de la institución</li>
                <li>Dirección general de operaciones</li>
                <li>Coordinación de vicerrectorías</li>
                <li>Relaciones institucionales y alianzas</li>
                <li>Supervisión del cumplimiento de objetivos</li>
            </ul>
            <h4 class="font-bold mb-2">Perfil del Rector:</h4>
            <ul class="list-disc list-inside text-gray-600">
                <li>Formación en educación o administración</li>
                <li>Experiencia mínima de 10 años en liderazgo educativo</li>
                <li>Visión estratégica e innovadora</li>
                <li>Habilidades de comunicación y liderazgo</li>
            </ul>
        `
    },
    'viceacademica': {
        title: 'Vicerrectoría Académica',
        content: `
            <p class="text-gray-600 mb-4">Responsable de liderar la gestión académica institucional y garantizar la excelencia educativa.</p>
            <h4 class="font-bold mb-2">Áreas de responsabilidad:</h4>
            <ul class="list-disc list-inside text-gray-600 mb-4">
                <li>Desarrollo y supervisión curricular</li>
                <li>Coordinación de niveles educativos</li>
                <li>Evaluación y mejora académica</li>
                <li>Formación y desarrollo docente</li>
                <li>Innovación pedagógica</li>
            </ul>
            <h4 class="font-bold mb-2">Departamentos bajo su supervisión:</h4>
            <ul class="list-disc list-inside text-gray-600">
                <li>Coordinaciones académicas por nivel</li>
                <li>Departamento de Innovación Educativa</li>
                <li>Biblioteca y Recursos de Aprendizaje</li>
                <li>Evaluación y Calidad Académica</li>
            </ul>
        `
    }
};

// Función para mostrar detalles en modal
function showDetails(orgUnit) {
    const modal = document.getElementById('orgModal');
    const title = document.getElementById('modalTitle');
    const content = document.getElementById('modalContent');

    if (orgData[orgUnit]) {
        title.textContent = orgData[orgUnit].title;
        content.innerHTML = orgData[orgUnit].content;
        modal.classList.remove('hidden');
    }
}

// Función para cerrar modal
function closeModal() {
    const modal = document.getElementById('orgModal');
    modal.classList.add('hidden');
}

// Event listeners
window.addEventListener('scroll', updateActiveNavigation);
window.addEventListener('load', () => {
    updateActiveNavigation();
    animateFadeInElements();
    initializePDF(); // Initialize enhanced PDF functionality
});

// Cerrar menú móvil al hacer clic fuera
document.addEventListener('click', (e) => {
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuButton = document.getElementById('mobile-menu-button');

    if (!mobileMenu.contains(e.target) && !mobileMenuButton.contains(e.target)) {
        closeMobileMenu();
    }
});

// Cerrar modal al hacer clic fuera
document.getElementById('orgModal').addEventListener('click', (e) => {
    if (e.target.id === 'orgModal') {
        closeModal();
    }
});

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && isFullscreen) {
        toggleFullscreen();
    }
});

// Smooth scroll para navegación
document.addEventListener('DOMContentLoaded', function() {
    const navButtons = document.querySelectorAll('[onclick^="scrollToSection"]');
    navButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const sectionId = this.getAttribute('onclick').match(/'([^']+)'/)[1];
            scrollToSection(sectionId);
        });
    });
});