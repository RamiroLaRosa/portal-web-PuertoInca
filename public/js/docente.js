// Initialize Lucide icons
lucide.createIcons();

// Variables globales
let activeSection = 'inicial';

// Scroll a sección
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

// Actualizar navegación (si usas dots activos)
function updateActiveNavigation() {
    const sections = document.querySelectorAll('section[id]');
    let currentSection = 'inicial'; // Sección predeterminada

    sections.forEach((section) => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (window.scrollY >= sectionTop - 200 && window.scrollY < sectionTop + sectionHeight - 200) {
            currentSection = section.getAttribute('id') || 'inicial'; // Actualiza la sección activa
        }
    });

    if (currentSection !== activeSection) {
        // Remover la clase activa de la sección anterior
        const prevActive = document.querySelector(`[data-section="${activeSection}"]`);
        if (prevActive) {
            prevActive.classList.remove('bg-brand-orange');
            prevActive.classList.add('hover:bg-brand-blue/70');
        }

        // Agregar la clase activa a la nueva sección
        const currentActive = document.querySelector(`[data-section="${currentSection}"]`);
        if (currentActive) {
            currentActive.classList.add('bg-brand-orange');
            currentActive.classList.remove('hover:bg-brand-blue/70');
        }

        activeSection = currentSection;  // Actualizar la sección activa
    }
}

window.addEventListener('scroll', updateActiveNavigation);
window.addEventListener('load', () => {
    updateActiveNavigation();
});

// Datos (de ejemplo) para el modal
const teacherData = {
    'maria-herrera': {
        name: 'Lic. María José Herrera',
        position: 'Coordinadora de Educación Inicial',
        photo: './images/no-photo.jpg?height=150&width=150',
        personal: {
            email: 'mj.herrera@novaacademia.edu',
            phone: '+123 456 7890 ext. 501',
            birthDate: '15 de marzo de 1985',
            nationality: 'Peruana',
            languages: ['Español (nativo)', 'Inglés (intermedio)', 'Francés (básico)'],
            hobbies: ['Lectura', 'Yoga', 'Jardinería', 'Pintura']
        }
    }
};

function showPersonalInfo(teacherId) {
    const modal = document.getElementById('teacherModal');
    const title = document.getElementById('modalTitle');
    const content = document.getElementById('modalContent');

    if (teacherData[teacherId]) {
        const t = teacherData[teacherId];
        title.textContent = `${t.name} - Información Personal`;

        content.innerHTML = `
    <div class="grid md:grid-cols-3 gap-8">
        <div class="md:col-span-1">
        <div class="bg-brand-gray rounded-2xl p-6 sticky top-0">
            <div class="text-center mb-6">
            <div class="w-40 h-40 mx-auto rounded-2xl overflow-hidden bg-gradient-to-br from-brand-blue to-brand-sky mb-4 shadow-lg">
                <img src="${t.photo}" alt="${t.name}" class="w-full h-full object-cover">
            </div>
            <h4 class="text-xl font-bold mb-2">${t.name}</h4>
            <p class="text-brand-blue font-medium">${t.position}</p>
            </div>
        </div>
        </div>

        <div class="md:col-span-2 space-y-6">
        <div class="bg-white border border-brand-gray rounded-lg p-6">
            <h5 class="text-xl font-bold mb-4 flex items-center text-brand-blue">
            <i data-lucide="user" class="h-5 w-5 mr-2"></i>
            Datos Personales
            </h5>
            <div class="grid md:grid-cols-2 gap-4">
            <div>
                <p class="font-semibold text-brand-navy">Email:</p>
                <p class="text-brand-navy/80">${t.personal.email}</p>
            </div>
            <div>
                <p class="font-semibold text-brand-navy">Teléfono:</p>
                <p class="text-brand-navy/80">${t.personal.phone}</p>
            </div>
            <div>
                <p class="font-semibold text-brand-navy">Fecha de Nacimiento:</p>
                <p class="text-brand-navy/80">${t.personal.birthDate}</p>
            </div>
            <div>
                <p class="font-semibold text-brand-navy">Nacionalidad:</p>
                <p class="text-brand-navy/80">${t.personal.nationality}</p>
            </div>
            </div>
        </div>

        <div class="bg-white border border-brand-gray rounded-lg p-6">
            <h5 class="text-xl font-bold mb-4 flex items-center text-brand-blue">
            <i data-lucide="globe" class="h-5 w-5 mr-2"></i>
            Idiomas
            </h5>
            <div class="flex flex-wrap gap-2">
            ${t.personal.languages.map(lang => `
                    <span class="bg-brand-sky/10 text-brand-blue px-3 py-1 rounded-full text-sm font-medium">${lang}</span>
                `).join('')}
            </div>
        </div>

        <div class="bg-white border border-brand-gray rounded-lg p-6">
            <h5 class="text-xl font-bold mb-4 flex items-center text-brand-blue">
            <i data-lucide="heart" class="h-5 w-5 mr-2"></i>
            Intereses y Hobbies
            </h5>
            <div class="flex flex-wrap gap-2">
            ${t.personal.hobbies.map(h => `
                    <span class="bg-brand-gray text-brand-navy px-3 py-1 rounded-full text-sm font-medium">${h}</span>
                `).join('')}
            </div>
        </div>
        </div>
    </div>
`;
        modal.classList.remove('hidden');
        lucide.createIcons();
    } else {
        showGenericInfo('Información Personal', 'user');
    }
}

function showAcademicInfo() {
    showGenericInfo('Información Académica', 'graduation-cap');
}

function showWorkInfo() {
    showGenericInfo('Información Laboral', 'briefcase');
}

function showDidacticUnits() {
    showGenericInfo('Unidades Didácticas', 'book-open');
}

function showGenericInfo(type, icon) {
    const modal = document.getElementById('teacherModal');
    const title = document.getElementById('modalTitle');
    const content = document.getElementById('modalContent');

    title.textContent = type;
    content.innerHTML = `
<div class="text-center py-12">
    <div class="w-24 h-24 mx-auto rounded-full bg-brand-gray flex items-center justify-center mb-4">
        <i data-lucide="${icon}" class="h-12 w-12 text-brand-blue/60"></i>
    </div>
    <h4 class="text-xl font-bold mb-2">${type} en proceso de actualización</h4>
    <p class="text-brand-navy/70 mb-6">La información detallada estará disponible próximamente.</p>
    <button onclick="closeTeacherModal()" class="bg-brand-orange hover:bg-brand-orange/90 text-white px-6 py-2 rounded-full transition-colors">
        Cerrar
    </button>
</div>
`;
    modal.classList.remove('hidden');
    lucide.createIcons();
}

function closeTeacherModal() {
    document.getElementById('teacherModal').classList.add('hidden');
}

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