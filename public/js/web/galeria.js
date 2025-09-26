// Activar Lucide
document.addEventListener('DOMContentLoaded', () => {
    if (window.lucide) window.lucide.createIcons();
});

// Smooth scroll
function scrollToSection(id) {
    const el = document.getElementById(id);
    if (!el) return;
    const y = el.getBoundingClientRect().top + window.pageYOffset - (window.innerWidth >= 768 ? 12 : 72);
    window.scrollTo({
        top: y,
        behavior: 'smooth'
    });
}
window.scrollToSection = scrollToSection;

// Marcar dot activo según sección visible
const sections = Array.from(document.querySelectorAll('section[id]'));
const dots = Array.from(document.querySelectorAll('.nav-dot'));
const map = Object.fromEntries(dots.map(d => [d.dataset.section, d]));

const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            const id = e.target.getAttribute('id');
            dots.forEach(b => b.classList.remove('ring-2', 'ring-brand-orange'));
            if (map[id]) map[id].classList.add('ring-2', 'ring-brand-orange');
        }
    });
}, {
    rootMargin: '-40% 0px -55% 0px',
    threshold: 0.01
});
sections.forEach(s => io.observe(s));

// Modal functionality
function openModal(imageSrc) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    modal.classList.add('active');
    modalImg.src = imageSrc;
}

function closeModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.remove('active');
}

// Close modal when clicking outside the image
document.getElementById('imageModal').addEventListener('click', function (e) {
    if (e.target === this) {
        closeModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});