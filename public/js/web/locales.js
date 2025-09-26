lucide.createIcons();

let activeSection = 'sede-principal';

function scrollToSection(id) {
    const el = document.getElementById(id);
    if (!el) return;
    const y = el.getBoundingClientRect().top + window.pageYOffset - 80;
    window.scrollTo({
        top: y,
        behavior: 'smooth'
    });
}

function updateActiveNavigation() {
    const sections = document.querySelectorAll('section[id]');
    let current = activeSection;
    sections.forEach(s => {
        const top = s.offsetTop,
            h = s.clientHeight;
        if (window.scrollY >= top - 200 && window.scrollY < top + h - 200) current = s.id;
    });
    if (current && current !== activeSection) {
        document.querySelectorAll('.nav-dot').forEach(b => {
            b.classList.remove('bg-brand-orange');
            b.classList.add('hover:bg-brand-blue/70');
        });
        const btn = document.querySelector(`[data-section="${current}"]`);
        if (btn) {
            btn.classList.add('bg-brand-orange');
            btn.classList.remove('hover:bg-brand-blue/70');
        }
        activeSection = current;
    }
}
window.addEventListener('scroll', updateActiveNavigation);
window.addEventListener('load', updateActiveNavigation);