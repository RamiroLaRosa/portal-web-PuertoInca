lucide.createIcons();
document.getElementById('year').textContent = new Date().getFullYear();

let activeSection = 'hero';

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
    const sections = document.querySelectorAll('main section[id]');
    let current = 'hero';
    sections.forEach(section => {
        const rectTop = section.getBoundingClientRect().top + window.scrollY;
        const h = section.offsetHeight;
        if (window.scrollY >= rectTop - 200 && window.scrollY < rectTop + h - 200) {
            current = section.id;
        }
    });
    if (current !== activeSection) {
        const prev = document.querySelector(`[data-section="${activeSection}"]`);
        if (prev) {
            prev.classList.remove('bg-[#E27227]');
            prev.classList.add('hover:bg-[#1A4FD3]/20');
        }
        const now = document.querySelector(`[data-section="${current}"]`);
        if (now) {
            now.classList.add('bg-[#E27227]');
            now.classList.remove('hover:bg-[#1A4FD3]/20');
        }
        activeSection = current;
    }
}

window.addEventListener('scroll', updateActiveNavigation);
window.addEventListener('load', updateActiveNavigation);

/* Opcionales (si luego añades buscador o filtros) */
function filterDocuments(filter) {
    document.querySelectorAll('.document-card').forEach(card => {
        const cat = card.getAttribute('data-cat');
        card.style.display = (filter === 'all' || filter === cat) ? 'block' : 'none';
    });
}

function searchDocuments() {
    const term = (document.getElementById('searchInput')?.value || '').toLowerCase().trim();
    document.querySelectorAll('.document-card').forEach(card => {
        const name = card.getAttribute('data-name');
        const desc = card.getAttribute('data-desc');
        card.style.display = (name.includes(term) || desc.includes(term)) ? 'block' : 'none';
    });
}