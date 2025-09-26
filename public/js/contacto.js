let activeSection = 'contacto-principal';

document.addEventListener('DOMContentLoaded', () => {
    if (window.lucide?.createIcons) lucide.createIcons();
});

document.addEventListener('DOMContentLoaded', function () {
    const navButtons = document.querySelectorAll('[onclick^="scrollToSection"]');
    navButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const sectionId = this.getAttribute('onclick').match(/'([^']+)'/)[1];
            scrollToSection(sectionId);
        });
    });
});

function scrollToSection(sectionId) {
    const element = document.getElementById(sectionId);
    if (element) {
        const yOffset = -80; // Ajuste de desplazamiento
        const y = element.getBoundingClientRect().top + window.pageYOffset + yOffset;
        window.scrollTo({
            top: y,
            behavior: 'smooth'
        });
    }
    closeMobileMenu(); // Cerrar el menú móvil después de hacer scroll
}

function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');

    const isHidden = mobileMenu.classList.contains('hidden');
    if (isHidden) {
        mobileMenu.classList.remove('hidden');
        menuIcon?.classList.add('hidden');
        closeIcon?.classList.remove('hidden');
    } else {
        mobileMenu.classList.add('hidden');
        menuIcon?.classList.remove('hidden');
        closeIcon?.classList.add('hidden');
    }
}

function closeMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');

    mobileMenu?.classList.add('hidden');
    menuIcon?.classList.remove('hidden');
    closeIcon?.classList.add('hidden');
}

document.addEventListener('click', (e) => {
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileBtn = document.getElementById('mobile-menu-button');
    if (!mobileMenu || !mobileBtn) return;
    if (!mobileMenu.contains(e.target) && !mobileBtn.contains(e.target)) {
        closeMobileMenu();
    }
});

document.querySelector('form')?.addEventListener('submit', function (e) {
    e.preventDefault();

    const nombre = document.getElementById('nombre').value.trim();
    const apellido = document.getElementById('apellido').value.trim();
    const email = document.getElementById('email').value.trim();
    const asunto = document.getElementById('asunto').value;
    const mensaje = document.getElementById('mensaje').value.trim();
    const acepto = document.getElementById('acepto').checked;

    if (!nombre || !apellido || !email || !asunto || !mensaje || !acepto) {
        alert('Por favor, completa todos los campos obligatorios.');
        return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert('Por favor, ingresa un correo electrónico válido.');
        return;
    }

    const submitButton = document.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;

    submitButton.innerHTML = '<i data-lucide="loader-2" class="animate-spin mr-2 h-5 w-5"></i>Enviando...';
    submitButton.disabled = true;

    setTimeout(() => {
        alert('¡Mensaje enviado exitosamente! Nos pondremos en contacto contigo pronto.');
        e.target.reset();
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
        if (window.lucide?.createIcons) lucide.createIcons();
    }, 2000);
});

window.addEventListener('load', () => {
    document.querySelectorAll('.contact-card').forEach((card, i) => {
        setTimeout(() => card.classList.add('fade-in'), i * 100);
    });
});

window.addEventListener('scroll', updateActiveNavigation);

function updateActiveNavigation() {
    const sections = document.querySelectorAll('section[id]');
    let currentSection = 'contacto-principal'; // Sección predeterminada

    sections.forEach((section) => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (window.scrollY >= sectionTop - 200 && window.scrollY < sectionTop + sectionHeight - 200) {
            currentSection = section.getAttribute('id') ||
                'contacto-principal'; // Actualiza la sección activa
        }
    });

    if (currentSection !== activeSection) {
        // Remover la clase activa de la sección anterior
        const prevActive = document.querySelector(`[data-section="${activeSection}"]`);
        if (prevActive) {
            prevActive.classList.remove('bg-[#1A4FD3]');
            prevActive.classList.add('hover:bg-[#1A4FD3]/20');
        }

        // Agregar la clase activa a la nueva sección
        const currentActive = document.querySelector(`[data-section="${currentSection}"]`);
        if (currentActive) {
            currentActive.classList.add('bg-[#1A4FD3]');
            currentActive.classList.remove('hover:bg-[#1A4FD3]/20');
        }

        activeSection = currentSection; // Actualizar la sección activa
    }
}