lucide.createIcons();

        function scrollToSection(id) {
            const el = document.getElementById(id);
            if (!el) return;
            const yOffset = -80;
            const y = el.getBoundingClientRect().top + window.pageYOffset + yOffset;
            window.scrollTo({
                top: y,
                behavior: 'smooth'
            });
            closeMobileMenu();
        }

        function toggleMobileMenu() {
            const mm = document.getElementById('mobile-menu');
            const mi = document.getElementById('menu-icon');
            const ci = document.getElementById('close-icon');
            if (!mm || !mi || !ci) return;
            const show = mm.classList.contains('hidden');
            mm.classList.toggle('hidden', !show ? true : false);
            mi.classList.toggle('hidden', show);
            ci.classList.toggle('hidden', !show);
        }

        function closeMobileMenu() {
            const mm = document.getElementById('mobile-menu');
            const mi = document.getElementById('menu-icon');
            const ci = document.getElementById('close-icon');
            if (!mm || !mi || !ci) return;
            mm.classList.add('hidden');
            mi.classList.remove('hidden');
            ci.classList.add('hidden');
        }

        function updateActiveNavigation() {
            const sections = document.querySelectorAll('section[id]');
            let current = 'mision';
            sections.forEach(s => {
                const top = s.offsetTop,
                    h = s.clientHeight;
                if (window.scrollY >= top - 200 && window.scrollY < top + h - 200) {
                    current = s.getAttribute('id') || 'mision';
                }
            });
            document.querySelectorAll('.nav-dot').forEach(b => {
                b.classList.remove('bg-brand-orange');
                b.classList.add('hover:bg-brand-blue/90');
            });
            const active = document.querySelector(`[data-section="${current}"]`);
            if (active) {
                active.classList.add('bg-brand-orange');
                active.classList.remove('hover:bg-brand-blue/90');
            }
        }
        window.addEventListener('scroll', updateActiveNavigation);
        window.addEventListener('load', updateActiveNavigation);
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) e.target.classList.add('fade-in');
            });
        }, {
            threshold: .1,
            rootMargin: '0px 0px -50px 0px'
        });
        document.querySelectorAll('.value-card').forEach(c => observer.observe(c));
        window.addEventListener('scroll', () => {
            const sc = window.pageYOffset;
            document.querySelectorAll('.floating-element').forEach((el, i) => {
                const speed = 0.5 + i * 0.1;
                el.style.transform = `translateY(${-(sc * speed)}px)`;
            });
        });