lucide.createIcons();

let activeSection = 'hero';
let currentFilter = 'all';

function scrollToSection(id) {
    const el = document.getElementById(id);
    if (!el) return;
    const y = el.getBoundingClientRect().top + window.pageYOffset - 80;
    window.scrollTo({
        top: y,
        behavior: 'smooth'
    });
}

function filterDocuments(filter) {
    currentFilter = filter;
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('filter-active');
        btn.classList.add('bg-white/10', 'hover:bg-white/20');
    });
    const activeBtn = document.querySelector(`[data-filter="${filter}"]`);
    if (activeBtn) {
        activeBtn.classList.add('filter-active');
        activeBtn.classList.remove('bg-white/10', 'hover:bg-white/20');
    }
    document.querySelectorAll('.document-card').forEach(card => {
        const cat = card.getAttribute('data-cat');
        card.style.display = (filter === 'all' || filter === cat) ? 'block' : 'none';
    });
}

function searchDocuments() {
    const term = document.getElementById('searchInput')?.value.toLowerCase().trim() ?? '';
    const cards = document.querySelectorAll('.document-card');
    cards.forEach(card => {
        const name = card.getAttribute('data-name');
        const desc = card.getAttribute('data-desc');
        card.style.display = (name.includes(term) || desc.includes(term)) ? 'block' : 'none';
    });
    if (term === '') {
        filterDocuments(currentFilter);
    }
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
window.addEventListener('load', () => {
    const initial = document.querySelector('[data-section="hero"]');
    if (initial) initial.classList.add('bg-[#E27227]');
    updateActiveNavigation();
});