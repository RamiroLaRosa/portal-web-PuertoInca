document.addEventListener('DOMContentLoaded', () => {
    window.lucide?.createIcons?.();
});

function scrollToSection(id) {
    const el = document.getElementById(id);
    if (!el) return;
    const y = el.getBoundingClientRect().top + window.pageYOffset - 80;
    window.scrollTo({
        top: y,
        behavior: 'smooth'
    });
}