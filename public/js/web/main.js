// public/js/web/documentos.js
// ---------------------------------------------------------
// JS unificado para la página de Documentos Institucionales
// Incluye fix: scrollToSection SIEMPRE cierra el menú móvil
// ---------------------------------------------------------

(() => {
    'use strict';

    // ===== Utilidades
    const qs = (sel, ctx = document) => ctx.querySelector(sel);
    const qsa = (sel, ctx = document) => Array.from(ctx.querySelectorAll(sel));

    // ===== Inicializar Lucide
    document.addEventListener('DOMContentLoaded', () => {
        if (window.lucide && typeof window.lucide.createIcons === 'function') {
            window.lucide.createIcons();
        }
    });

    // ===== Estado local
    let activeSection = 'home';
    let expandedReason = null;

    // ====== Menú móvil
    function toggleMobileMenu() {
        const mobileMenu = qs('#mobile-menu');
        const menuIcon = qs('#menu-icon');
        const closeIcon = qs('#close-icon');
        if (!mobileMenu || !menuIcon || !closeIcon) return;

        const isHidden = mobileMenu.classList.contains('hidden');
        mobileMenu.classList.toggle('hidden', !isHidden);
        menuIcon.classList.toggle('hidden', isHidden);
        closeIcon.classList.toggle('hidden', !isHidden);
    }

    function closeMobileMenu() {
        const mobileMenu = qs('#mobile-menu');
        const menuIcon = qs('#menu-icon');
        const closeIcon = qs('#close-icon');
        if (!mobileMenu || !menuIcon || !closeIcon) return;

        mobileMenu.classList.add('hidden');
        menuIcon.classList.remove('hidden');
        closeIcon.classList.add('hidden');
    }

    // Exponer para uso desde HTML
    window.toggleMobileMenu = toggleMobileMenu;
    window.closeMobileMenu = closeMobileMenu;

    // ====== Scroll a sección (FIX aplicado aquí)
    // Si ya existe una versión global, la parcheamos para forzar cierre del menú.
    (function ensureScrollClosesMenu() {
        const baseScroll = function (id) {
            const el = document.getElementById(id);
            if (!el) return;
            const y = el.getBoundingClientRect().top + window.pageYOffset - 80;
            window.scrollTo({ top: y, behavior: 'smooth' });
        };

        if (typeof window.scrollToSection === 'function') {
            const prev = window.scrollToSection;
            window.scrollToSection = function (id) {
                try { prev(id); } catch (_) { baseScroll(id); }
                if (typeof window.closeMobileMenu === 'function') window.closeMobileMenu();
            };
        } else {
            window.scrollToSection = function (id) {
                baseScroll(id);
                if (typeof window.closeMobileMenu === 'function') window.closeMobileMenu();
            };
        }
    })();

    // ====== Submenús móviles
    function toggleSubmenu(submenuName) {
        const submenu = qs(`#${submenuName}-submenu`);
        const chevron = qs(`#${submenuName}-chevron`);
        if (!submenu || !chevron) return;

        const isHidden = submenu.classList.contains('hidden');
        submenu.classList.toggle('hidden', !isHidden);
        chevron.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
    }
    window.toggleSubmenu = toggleSubmenu;

    // ====== Filtro de programas (si aplica en esta vista compartida)
    function filterPrograms(category, event) {
        const programs = qsa('.program-card');
        const filterBtns = qsa('.filter-btn');

        filterBtns.forEach(btn => {
            btn.classList.remove('active', 'bg-brand-orange', 'text-white');
            btn.classList.add('bg-gray-100', 'text-gray-700');
        });

        if (event && event.target) {
            event.target.classList.add('active', 'bg-brand-orange', 'text-white');
            event.target.classList.remove('bg-gray-100', 'text-gray-700');
        }

        programs.forEach(program => {
            const show = category === 'all' || program.dataset.category === category;
            if (show) {
                program.style.display = 'block';
                requestAnimationFrame(() => {
                    program.style.opacity = '1';
                    program.style.transform = 'translateY(0)';
                });
            } else {
                program.style.opacity = '0';
                program.style.transform = 'translateY(20px)';
                setTimeout(() => { program.style.display = 'none'; }, 300);
            }
        });
    }
    window.filterPrograms = filterPrograms;

    // ====== Toggle de razones (acordeón)
    function toggleReason(reasonIndex) {
        const icon = qs(`#reason-${reasonIndex}-icon`);
        const content = qs(`#reason-${reasonIndex}-content`);
        if (!icon || !content) return;

        if (expandedReason === reasonIndex) {
            icon.style.transform = 'rotate(0deg)';
            const p = qs('p', content);
            if (p) p.classList.add('line-clamp-2');
            expandedReason = null;
        } else {
            if (expandedReason !== null) {
                const prevIcon = qs(`#reason-${expandedReason}-icon`);
                const prevContent = qs(`#reason-${expandedReason}-content`);
                if (prevIcon) prevIcon.style.transform = 'rotate(0deg)';
                const prevP = prevContent ? qs('p', prevContent) : null;
                if (prevP) prevP.classList.add('line-clamp-2');
            }
            icon.style.transform = 'rotate(45deg)';
            const p = qs('p', content);
            if (p) p.classList.remove('line-clamp-2');
            expandedReason = reasonIndex;
        }
    }
    window.toggleReason = toggleReason;

    // ====== Navegación activa por scroll
    function updateActiveNavigation() {
        const sections = qsa('section[id]');
        let currentSection = 'home';

        const y = window.scrollY;
        sections.forEach(section => {
            const top = section.offsetTop;
            const h = section.clientHeight;
            if (y >= top - 200 && y < top + h - 200) {
                currentSection = section.getAttribute('id') || 'home';
            }
        });

        if (currentSection !== activeSection) {
            const prevActive = qs(`[data-section="${activeSection}"]`);
            if (prevActive) {
                prevActive.classList.remove('bg-brand-orange');
                prevActive.classList.add('hover:bg-brand-blue/90');
            }
            const currentActive = qs(`[data-section="${currentSection}"]`);
            if (currentActive) {
                currentActive.classList.add('bg-brand-orange');
                currentActive.classList.remove('hover:bg-brand-blue/90');
            }
            activeSection = currentSection;
        }
    }

    // ====== Contadores animados (si existen en la página)
    function animateCounters() {
        const counters = qsa('.animate-count');
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target') || '0', 10);
            const prefix = counter.getAttribute('data-prefix') || '';
            const locale = counter.getAttribute('data-format') || 'es-PE';
            const duration = 1600;
            const startTs = performance.now();

            const update = (ts) => {
                const progress = Math.min((ts - startTs) / duration, 1);
                const val = Math.floor(progress * target);
                counter.textContent = prefix + val.toLocaleString(locale);
                if (progress < 1) requestAnimationFrame(update);
            };

            const obs = new IntersectionObserver((entries) => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        requestAnimationFrame(update);
                        obs.unobserve(counter);
                    }
                });
            }, { threshold: 0.2 });

            obs.observe(counter);
        });
    }

    // ====== Listeners globales
    window.addEventListener('scroll', updateActiveNavigation);

    window.addEventListener('load', () => {
        animateCounters();
        updateActiveNavigation();
    });

    // Cerrar menú móvil al hacer clic fuera
    document.addEventListener('click', (e) => {
        const mobileMenu = qs('#mobile-menu');
        const mobileMenuButton = qs('#mobile-menu-button');
        if (!mobileMenu || !mobileMenuButton) return;

        const clickedInsideMenu = mobileMenu.contains(e.target);
        const clickedToggleBtn = mobileMenuButton.contains(e.target);

        if (!clickedInsideMenu && !clickedToggleBtn) {
            closeMobileMenu();
        }
    });

    // ====== Exponer helpers clave (por si son llamados desde HTML)
    window.scrollToSection = window.scrollToSection; // ya parcheado arriba
})();
