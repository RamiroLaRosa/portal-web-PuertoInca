// resources/js/admision.js

document.addEventListener('DOMContentLoaded', function() {
    // Scroll a secciones desde la navegación lateral
    window.scrollToSection = function(id) {
        const el = document.getElementById(id);
        if (el) {
            el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    };

    // Animación de elementos flotantes
    document.querySelectorAll('.floating-element').forEach(el => {
        el.animate([
            { transform: 'translateY(0px)' },
            { transform: 'translateY(30px)' },
            { transform: 'translateY(0px)' }
        ], {
            duration: 4000,
            iterations: Infinity
        });
    });

    // Activar iconos Lucide
    if (window.lucide) {
        lucide.createIcons();
    }

    // Navegación lateral: resalta el punto activo al hacer scroll
    const navDots = document.querySelectorAll('.nav-dot');
    const sections = ['resultados','modalidades','requisitos','cronograma','costos','exonerados','vacantes','proceso'];
    function updateActiveNav() {
        let found = false;
        sections.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                const rect = el.getBoundingClientRect();
                if (!found && rect.top < window.innerHeight/2 && rect.bottom > 100) {
                    navDots.forEach(dot => dot.classList.remove('bg-brand-blue'));
                    const activeDot = document.querySelector(`.nav-dot[data-section="${id}"]`);
                    if (activeDot) activeDot.classList.add('bg-brand-blue');
                    found = true;
                }
            }
        });
        if (!found) navDots.forEach(dot => dot.classList.remove('bg-brand-blue'));
    }
    window.addEventListener('scroll', updateActiveNav);
    updateActiveNav();
});
