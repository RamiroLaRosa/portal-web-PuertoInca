// Iconos
lucide.createIcons();

// Navegación activa simple
function updateActiveNavigation() {
    const sections = document.querySelectorAll('section[id]');
    let current = 'mision';
    sections.forEach(s => {
        const top = s.offsetTop,
            h = s.clientHeight;
        if (window.scrollY >= top - 200 && window.scrollY < top + h - 200) current = s.id;
    });
    document.querySelectorAll('[data-section]').forEach(btn => {
        btn.classList.remove('bg-brand-orange');
        btn.classList.add('hover:bg-brand-blue/90');
    });
    const active = document.querySelector(`[data-section="${current}"]`);
    if (active) {
        active.classList.add('bg-brand-orange');
        active.classList.remove('hover:bg-brand-blue/90');
    }
}

function scrollToSection(id) {
    const el = document.getElementById(id);
    if (!el) return;
    const y = el.getBoundingClientRect().top + window.pageYOffset - 80;
    window.scrollTo({
        top: y,
        behavior: 'smooth'
    });
    updateActiveNavigation();
}
window.addEventListener('scroll', updateActiveNavigation);
window.addEventListener('load', updateActiveNavigation);