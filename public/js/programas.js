lucide.createIcons();
let activeSection = 'hero';

function scrollToSection(sectionId) {
    const el = document.getElementById(sectionId);
    if (!el) return;
    const yOffset = -80;
    const y = el.getBoundingClientRect().top + window.pageYOffset + yOffset;
    window.scrollTo({
        top: y,
        behavior: 'smooth'
    });
}

function updateActiveNavigation() {
    const sections = document.querySelectorAll('section[id]');
    let current = 'hero';
    sections.forEach(s => {
        const top = s.offsetTop,
            h = s.clientHeight;
        if (window.scrollY >= top - 200 && window.scrollY < top + h - 200) {
            current = s.getAttribute('id') || 'hero';
        }
    });
    if (current !== activeSection) {
        const prev = document.querySelector(`[data-section="${activeSection}"]`);
        if (prev) {
            prev.classList.remove('bg-brand-orange');
            prev.classList.add('hover:bg-brand-blue/70');
        }
        const curr = document.querySelector(`[data-section="${current}"]`);
        if (curr) {
            curr.classList.add('bg-brand-orange');
            curr.classList.remove('hover:bg-brand-blue/70');
        }
        activeSection = current;
    }
}

window.addEventListener('scroll', updateActiveNavigation);
window.addEventListener('load', updateActiveNavigation);