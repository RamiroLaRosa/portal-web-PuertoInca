// Initialize Lucide icons
lucide.createIcons();

// Variables globales
let activeSection = 'departamentos';
let allStaffCards = [];

// Función para hacer scroll a una sección
function scrollToSection(sectionId) {
    const element = document.getElementById(sectionId);
    if (element) {
        const yOffset = -80; // Ajuste de desplazamiento
        const y = element.getBoundingClientRect().top + window.pageYOffset + yOffset;
        window.scrollTo({
            top: y,
            behavior: 'smooth'
        });
    }
    closeMobileMenu(); // Cerrar el menú móvil después de hacer scroll
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
    let currentSection = 'departamentos'; // Sección predeterminada

    sections.forEach((section) => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (window.scrollY >= sectionTop - 200 && window.scrollY < sectionTop + sectionHeight - 200) {
            currentSection = section.getAttribute('id') || 'departamentos'; // Actualiza la sección activa
        }
    });

    if (currentSection !== activeSection) {
        // Remover la clase activa de la sección anterior
        const prevActive = document.querySelector(`[data-section="${activeSection}"]`);
        if (prevActive) {
            prevActive.classList.remove('bg-brand-orange');
            prevActive.classList.add('hover:bg-brand-blue/90');
        }

        // Agregar la clase activa a la nueva sección
        const currentActive = document.querySelector(`[data-section="${currentSection}"]`);
        if (currentActive) {
            currentActive.classList.add('bg-brand-orange');
            currentActive.classList.remove('hover:bg-brand-blue/90');
        }

        activeSection = currentSection;  // Actualizar la sección activa
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

// Función para buscar personal
function searchStaff() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const staffCards = document.querySelectorAll('.staff-card');

    staffCards.forEach(card => {
        const name = card.getAttribute('data-name')?.toLowerCase() || '';
        const position = card.getAttribute('data-position')?.toLowerCase() || '';
        const department = card.getAttribute('data-department')?.toLowerCase() || '';

        const matches = name.includes(searchTerm) ||
            position.includes(searchTerm) ||
            department.includes(searchTerm);

        if (matches || searchTerm === '') {
            card.style.display = 'block';
            card.parentElement.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });

    // Ocultar secciones vacías
    const sections = document.querySelectorAll('section[data-level]');
    sections.forEach(section => {
        const visibleCards = section.querySelectorAll(
            '.staff-card[style*="display: block"], .staff-card:not([style*="display: none"])');
        if (visibleCards.length === 0 && searchTerm !== '') {
            section.style.display = 'none';
        } else {
            section.style.display = 'block';
        }
    });
}

// Función para filtrar por nivel
function filterByLevel() {
    const levelFilter = document.getElementById('levelFilter').value;
    const sections = document.querySelectorAll('section[data-level]');

    sections.forEach(section => {
        if (levelFilter === '' || section.getAttribute('data-level') === levelFilter) {
            section.style.display = 'block';
        } else {
            section.style.display = 'none';
        }
    });
}

// Función para limpiar filtros
function clearFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('levelFilter').value = '';

    const staffCards = document.querySelectorAll('.staff-card');
    const sections = document.querySelectorAll('section[data-level]');

    staffCards.forEach(card => {
        card.style.display = 'block';
    });

    sections.forEach(section => {
        section.style.display = 'block';
    });
}

// Datos del personal para el modal
const staffData = {
    'carlos-mendoza': {
        name: 'Dr. Carlos Mendoza',
        position: 'Presidente del Consejo Directivo',
        email: 'c.mendoza@novaacademia.edu',
        phone: '+123 456 7890 ext. 100',
        bio: 'Líder empresarial con más de 25 años de experiencia en educación y gestión estratégica. Ha dirigido múltiples organizaciones educativas hacia la excelencia y la innovación.',
        education: ['MBA en Administración de Empresas - Universidad de Harvard',
            'Licenciatura en Educación - Universidad Nacional'
        ],
        experience: ['Presidente del Consejo - NOVA Academia (2020-presente)',
            'CEO - Grupo Educativo Internacional (2010-2020)',
            'Director Regional - Fundación Educativa (2005-2010)'
        ]
    },
    'elena-martinez': {
        name: 'Dra. Elena Martínez',
        position: 'Fundadora y Consejera',
        email: 'e.martinez@novaacademia.edu',
        phone: '+123 456 7890 ext. 102',
        bio: 'Visionaria educativa y fundadora de NOVA Academia. Su pasión por la innovación educativa ha transformado la manera de enseñar y aprender en el siglo XXI.',
        education: ['PhD en Pedagogía - Universidad de Cambridge', 'Maestría en Innovación Educativa - MIT',
            'Licenciatura en Psicología Educativa'
        ],
        experience: ['Fundadora - NOVA Academia (2015-presente)',
            'Consultora Internacional en Educación (2010-2015)',
            'Directora de Innovación - Instituto Educativo Global (2005-2010)'
        ]
    },
    'ana-ruiz': {
        name: 'Mg. Ana Patricia Ruiz',
        position: 'Rectora',
        email: 'rectoria@novaacademia.edu',
        phone: '+123 456 7890 ext. 101',
        bio: 'Líder educativa comprometida con la transformación digital y la excelencia académica. Su visión estratégica ha posicionado a NOVA Academia como referente en innovación educativa.',
        education: ['Magíster en Administración Educativa - Universidad de los Andes',
            'Especialización en Liderazgo Educativo - Harvard Graduate School', 'Licenciatura en Educación'
        ],
        experience: ['Rectora - NOVA Academia (2018-presente)',
            'Vicerrectora Académica - Colegio Internacional (2015-2018)',
            'Coordinadora General - Instituto Bilingüe (2012-2015)'
        ]
    }
};

function showStaffDetails(element) {
    const modal = document.getElementById('staffModal');
    const title = document.getElementById('modalTitle');
    const content = document.getElementById('modalContent');

    const name = element.getAttribute('data-name');
    const position = element.getAttribute('data-position');
    const email = element.getAttribute('data-email');
    const description = element.getAttribute('data-description');
    const image = element.getAttribute('data-image');

    title.textContent = name;

    content.innerHTML = `
        <div class="flex flex-col md:flex-row gap-6 mb-6">
            <div class="w-32 h-32 md:w-40 md:h-40 rounded-2xl overflow-hidden bg-gradient-to-br from-orange-400 to-orange-600 shadow-lg flex-shrink-0">
                <img src="${image}" alt="${name}" class="w-full h-full object-cover">
            </div>
            <div class="flex-1">
                <h4 class="text-2xl font-bold mb-2">${name}</h4>
                <p class="text-orange-600 font-medium text-lg mb-4">${position}</p>
                ${email ? `
                                    <div class="flex items-center gap-2 mb-2">
                                        <i data-lucide="mail" class="h-4 w-4 text-orange-500"></i>
                                        <a href="mailto:${email}" class="text-orange-600 hover:underline">${email}</a>
                                    </div>
                                ` : ''}
            </div>
        </div>
        
        ${description ? `
                            <div>
                                <h5 class="font-bold mb-3 text-lg">Información</h5>
                                <p class="text-gray-600 leading-relaxed">${description.replace(/\n/g, '<br>')}</p>
                            </div>
                        ` : ''}
    `;

    modal.classList.remove('hidden');
    lucide.createIcons();
}

// Función para cerrar modal del personal
function closeStaffModal() {
    const modal = document.getElementById('staffModal');
    modal.classList.add('hidden');
}

// Event listeners
window.addEventListener('scroll', updateActiveNavigation);
window.addEventListener('load', () => {
    updateActiveNavigation();
    animateFadeInElements();

    // Guardar referencia a todas las tarjetas del personal
    allStaffCards = document.querySelectorAll('.staff-card');
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
document.getElementById('staffModal').addEventListener('click', (e) => {
    if (e.target.id === 'staffModal') {
        closeStaffModal();
    }
});

// Smooth scroll para navegación
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