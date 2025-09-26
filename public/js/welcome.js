// Initialize Lucide icons
lucide.createIcons();

// Variables globales
let activeSection = 'home';
let expandedReason = null;

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

// Función para toggle de submenús móviles
function toggleSubmenu(submenuName) {
    const submenu = document.getElementById(submenuName + '-submenu');
    const chevron = document.getElementById(submenuName + '-chevron');

    if (submenu.classList.contains('hidden')) {
        submenu.classList.remove('hidden');
        chevron.style.transform = 'rotate(180deg)';
    } else {
        submenu.classList.add('hidden');
        chevron.style.transform = 'rotate(0deg)';
    }
}

// Función para filtrar programas
function filterPrograms(category, event) {
    const programs = document.querySelectorAll('.program-card');
    const filterBtns = document.querySelectorAll('.filter-btn');

    // Actualizar botones activos
    filterBtns.forEach(btn => {
        btn.classList.remove('active', 'bg-brand-orange', 'text-white');
        btn.classList.add('bg-gray-100', 'text-gray-700');
    });

    event.target.classList.add('active', 'bg-brand-orange', 'text-white');
    event.target.classList.remove('bg-gray-100', 'text-gray-700');

    // Filtrar programas
    programs.forEach(program => {
        if (category === 'all' || program.dataset.category === category) {
            program.style.display = 'block';
            setTimeout(() => {
                program.style.opacity = '1';
                program.style.transform = 'translateY(0)';
            }, 100);
        } else {
            program.style.opacity = '0';
            program.style.transform = 'translateY(20px)';
            setTimeout(() => {
                program.style.display = 'none';
            }, 300);
        }
    });
}

// Función para toggle de razones
function toggleReason(reasonIndex) {
    const icon = document.getElementById('reason-' + reasonIndex + '-icon');
    const content = document.getElementById('reason-' + reasonIndex + '-content');

    if (expandedReason === reasonIndex) {
        icon.style.transform = 'rotate(0deg)';
        content.querySelector('p').classList.add('line-clamp-2');
        expandedReason = null;
    } else {
        if (expandedReason !== null) {
            const prevIcon = document.getElementById('reason-' + expandedReason + '-icon');
            const prevContent = document.getElementById('reason-' + expandedReason + '-content');
            prevIcon.style.transform = 'rotate(0deg)';
            prevContent.querySelector('p').classList.add('line-clamp-2');
        }

        icon.style.transform = 'rotate(45deg)';
        content.querySelector('p').classList.remove('line-clamp-2');
        expandedReason = reasonIndex;
    }
}

// Función para actualizar navegación activa
function updateActiveNavigation() {
    const sections = document.querySelectorAll('section[id]');
    let currentSection = 'home';

    sections.forEach((section) => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (window.scrollY >= sectionTop - 200 && window.scrollY < sectionTop + sectionHeight - 200) {
            currentSection = section.getAttribute('id') || 'home';
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

// Función para animar contadores
function animateCounters() {
    const counters = document.querySelectorAll('.animate-count');

    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const prefix = counter.getAttribute('data-prefix') || '';
        const suffix = counter.getAttribute('data-suffix') || '';
        const duration = 2000;

        let current = 0;
        const increment = target / (duration / 16);

        const updateCounter = () => {
            current += increment;
            if (current < target) {
                counter.textContent = prefix + Math.floor(current) + suffix;
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = prefix + target + suffix;
            }
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    updateCounter();
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });

        observer.observe(counter);
    });
}

// Event listeners
window.addEventListener('scroll', updateActiveNavigation);
window.addEventListener('load', () => {
    animateCounters();
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