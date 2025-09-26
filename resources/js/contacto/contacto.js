// resources/js/contacto.js

document.addEventListener('DOMContentLoaded', function() {
    // Scroll a secciones desde la navegación lateral
    window.scrollToSection = function(id) {
        const el = document.getElementById(id);
        if (el) {
            el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    };

    // Activar iconos Lucide
    if (window.lucide) {
        lucide.createIcons();
    }

    // Navegación lateral: resalta el punto activo al hacer scroll
    const navDots = document.querySelectorAll('.nav-dot, .sidebar-fixed nav button');
    const sections = ['contacto-principal','formulario','ubicacion'];
    function updateActiveNav() {
        let found = false;
        sections.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                const rect = el.getBoundingClientRect();
                if (!found && rect.top < window.innerHeight/2 && rect.bottom > 100) {
                    navDots.forEach(dot => dot.classList.remove('bg-[#1A4FD3]'));
                    const activeDot = document.querySelector(`.nav-dot[data-section="${id}"]`);
                    if (activeDot) activeDot.classList.add('bg-[#1A4FD3]');
                    found = true;
                }
            }
        });
        if (!found) navDots.forEach(dot => dot.classList.remove('bg-[#1A4FD3]'));
    }
    window.addEventListener('scroll', updateActiveNav);
    updateActiveNav();
});
