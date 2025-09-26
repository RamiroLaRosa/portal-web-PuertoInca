// Initialize Lucide icons
lucide.createIcons();

let activeSection = 'sede-principal';

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
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');
    if (!mobileMenu) return;
    mobileMenu.classList.add('hidden');
    if (menuIcon) menuIcon.classList.remove('hidden');
    if (closeIcon) closeIcon.classList.add('hidden');
}

function updateActiveNavigation() {
    const sections = document.querySelectorAll('section[id]');
    let currentSection = 'sede-principal'; // Sección predeterminada

    sections.forEach((section) => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (window.scrollY >= sectionTop - 200 && window.scrollY < sectionTop + sectionHeight - 200) {
            currentSection = section.getAttribute('id') || 'sede-principal'; // Actualiza la sección activa
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
    fadeElements.forEach(el => observer.observe(el));
}

function openMap(location) {
    const locations = {
        'sede-principal': 'Avenida Innovación Educativa 1234, San Isidro, Lima',
        'filial-norte': 'Av. Alfredo Mendiola 2856, Los Olivos, Lima',
        'filial-sur': 'Av. El Sol 1847, Villa El Salvador, Lima'
    };
    const address = locations[location];
    if (address) {
        const encoded = encodeURIComponent(address);
        window.open(`https://www.google.com/maps/search/?api=1&query=${encoded}`, '_blank');
    }
}

const locationData = {
    'filial-norte': {
        title: 'NOVA Academia - Filial Norte',
        subtitle: 'Campus Los Olivos',
        description: 'Nuestra filial norte se especializa en Educación Inicial y Primaria, ofreciendo un ambiente cálido y seguro para los más pequeños.',
        details: {
            address: 'Av. Alfredo Mendiola N° 2856, Urbanización Pro, Manzana C, Lote 8, Los Olivos, Lima',
            registry: 'Partida Registral N° 11045789',
            area: '4,200 m²',
            students: '850 estudiantes',
            levels: 'Inicial (3-5 años) y Primaria (6-11 años)',
            facilities: [
                '20 aulas especializadas para inicial y primaria',
                'Patio de juegos con equipos seguros',
                'Biblioteca infantil',
                'Laboratorio de ciencias básicas',
                'Sala de psicomotricidad',
                'Comedor escolar',
                'Enfermería',
                'Estacionamiento para 60 vehículos'
            ],
            contact: {
                phone: '+51 1 567-8901',
                email: 'norte@novaacademia.edu',
                hours: 'Lunes a Viernes: 7:00 - 17:00'
            }
        }
    },
    'filial-sur': {
        title: 'NOVA Academia - Filial Sur',
        subtitle: 'Campus Villa El Salvador',
        description: 'Nuestra filial sur se enfoca en Educación Secundaria y Bachillerato Internacional, preparando a los estudiantes para la universidad.',
        details: {
            address: 'Av. El Sol N° 1847, Sector 2, Grupo 15, Manzana K, Lote 3, Villa El Salvador, Lima',
            registry: 'Partida Registral N° 11067234',
            area: '5,800 m²',
            students: '1,200 estudiantes',
            levels: 'Secundaria (12-16 años) y Bachillerato Internacional (17-18 años)',
            facilities: [
                '30 aulas equipadas con tecnología avanzada',
                'Laboratorios de física, química y biología',
                'Centro de cómputo con 40 estaciones',
                'Biblioteca con más de 15,000 volúmenes',
                'Auditorio para 200 personas',
                'Canchas deportivas',
                'Cafetería moderna',
                'Estacionamiento para 100 vehículos'
            ],
            contact: {
                phone: '+51 1 789-0123',
                email: 'sur@novaacademia.edu',
                hours: 'Lunes a Viernes: 7:00 - 18:00'
            }
        }
    }
};

function showLocationDetails(locationId) {
    const modal = document.getElementById('locationModal');
    const title = document.getElementById('locationModalTitle');
    const content = document.getElementById('locationModalContent');

    if (locationData[locationId]) {
        const l = locationData[locationId];
        title.textContent = l.title;

        content.innerHTML = `
  <div class="grid md:grid-cols-2 gap-8">
    <div class="space-y-6">
      <div>
        <h4 class="text-xl font-bold mb-2">${l.subtitle}</h4>
        <p class="text-brand-navy/80">${l.description}</p>
      </div>

      <div class="bg-brand-gray rounded-2xl p-6">
        <h5 class="font-bold mb-4 flex items-center">
          <i data-lucide="map-pin" class="h-5 w-5 mr-2 text-brand-orange"></i>
          Información Registral
        </h5>
        <div class="space-y-2 text-sm text-brand-navy/90">
          <p><strong>Dirección:</strong> ${l.details.address}</p>
          <p><strong>Partida Registral:</strong> ${l.details.registry}</p>
          <p><strong>Área Total:</strong> ${l.details.area}</p>
          <p><strong>Estudiantes:</strong> ${l.details.students}</p>
          <p><strong>Niveles:</strong> ${l.details.levels}</p>
        </div>
      </div>

      <div class="bg-brand-gray rounded-2xl p-6">
        <h5 class="font-bold mb-4 flex items-center">
          <i data-lucide="phone" class="h-5 w-5 mr-2 text-brand-orange"></i>
          Contacto
        </h5>
        <div class="space-y-2 text-sm text-brand-navy/90">
          <p><strong>Teléfono:</strong> ${l.details.contact.phone}</p>
          <p><strong>Email:</strong> ${l.details.contact.email}</p>
          <p><strong>Horarios:</strong> ${l.details.contact.hours}</p>
        </div>
      </div>
    </div>

    <div>
      <h5 class="font-bold mb-4 flex items-center">
        <i data-lucide="building" class="h-5 w-5 mr-2 text-brand-orange"></i>
        Instalaciones y Servicios
      </h5>
      <div class="space-y-2">
        ${l.details.facilities.map(f => `
                  <div class="flex items-start gap-3 p-3 bg-white border border-brand-gray rounded-lg">
                    <i data-lucide="check" class="h-4 w-4 text-brand-blue mt-0.5 flex-shrink-0"></i>
                    <span class="text-sm text-brand-navy/90">${f}</span>
                  </div>
                `).join('')}
      </div>
    </div>
  </div>
`;
        modal.classList.remove('hidden');
        lucide.createIcons();
    }
}

function showImageGallery(location, type) {
    const modal = document.getElementById('imageModal');
    const title = document.getElementById('imageModalTitle');
    const content = document.getElementById('imageModalContent');

    const galleries = {
        'sede-principal': {
            'acceso': {
                title: 'Acceso Principal - Sede Principal',
                images: [{
                    src: './images/no-photo.jpg?height=400&width=600&text=Entrada+Principal',
                    alt: 'Entrada principal con portón automático'
                },
                {
                    src: './images/no-photo.jpg?height=400&width=600&text=Recepción',
                    alt: 'Área de recepción moderna'
                },
                {
                    src: './images/no-photo.jpg?height=400&width=600&text=Hall+Principal',
                    alt: 'Hall principal con diseño contemporáneo'
                }
                ]
            },
            'aulas': {
                title: 'Aulas Inteligentes - Sede Principal',
                images: [{
                    src: './images/no-photo.jpg?height=400&width=600&text=Aula+Tecnológica',
                    alt: 'Aula con pizarra interactiva'
                },
                {
                    src: './images/no-photo.jpg?height=400&width=600&text=Mobiliario+Moderno',
                    alt: 'Mobiliario ergonómico y funcional'
                },
                {
                    src: './images/no-photo.jpg?height=400&width=600&text=Iluminación+Natural',
                    alt: 'Aulas con excelente iluminación natural'
                }
                ]
            },
            'laboratorios': {
                title: 'Laboratorios - Sede Principal',
                images: [{
                    src: './images/no-photo.jpg?height=400&width=600&text=Lab+Ciencias',
                    alt: 'Laboratorio de ciencias completamente equipado'
                },
                {
                    src: './images/no-photo.jpg?height=400&width=600&text=Lab+Computación',
                    alt: 'Laboratorio de computación con equipos modernos'
                },
                {
                    src: './images/no-photo.jpg?height=400&width=600&text=Lab+Robótica',
                    alt: 'Laboratorio de robótica e innovación'
                }
                ]
            }
        }
    };

    if (galleries[location] && galleries[location][type]) {
        const g = galleries[location][type];
        title.textContent = g.title;
        content.innerHTML = `
  <div class="grid gap-4 p-6">
    ${g.images.map(img => `
              <div class="relative">
                <img src="${img.src}" alt="${img.alt}" class="w-full h-64 object-cover rounded-lg">
                <div class="absolute bottom-0 left-0 right-0 bg-black/60 text-white p-4 rounded-b-lg">
                  <p class="text-sm">${img.alt}</p>
                </div>
              </div>
            `).join('')}
  </div>
`;
        modal.classList.remove('hidden');
    }
}

function closeLocationModal() {
    document.getElementById('locationModal').classList.add('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

window.addEventListener('scroll', updateActiveNavigation);
window.addEventListener('load', () => {
    updateActiveNavigation();
    animateFadeInElements();
});

document.addEventListener('click', (e) => {
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    if (mobileMenu && mobileMenuButton && !mobileMenu.contains(e.target) && !mobileMenuButton.contains(e
        .target)) {
        closeMobileMenu();
    }
});

document.getElementById('locationModal').addEventListener('click', (e) => {
    if (e.target.id === 'locationModal') {
        closeLocationModal();
    }
});
document.getElementById('imageModal').addEventListener('click', (e) => {
    if (e.target.id === 'imageModal') {
        closeImageModal();
    }
});

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