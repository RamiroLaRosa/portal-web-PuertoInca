// resources/js/theme.js
(function () {
    const btn = document.getElementById('btnDarkMode');
    const iconMoon = document.getElementById('iconMoon');
    const iconSun = document.getElementById('iconSun');

    // ---- Helpers ----
    const applyTheme = (theme) => {
        const isDark = theme === 'dark';
        document.documentElement.classList.toggle('dark', isDark);
        document.body.classList.toggle('dark', isDark);
        iconMoon?.classList.toggle('d-none', isDark);
        iconSun?.classList.toggle('d-none', !isDark);
    };

    // ---- Estado inicial (lee de localStorage, o por defecto light) ----
    const savedTheme = localStorage.getItem('theme') || 'light';
    applyTheme(savedTheme);

    // ---- Toggle al hacer click ----
    btn?.addEventListener('click', () => {
        const next = document.body.classList.contains('dark') ? 'light' : 'dark';
        localStorage.setItem('theme', next);
        applyTheme(next);
    });
})();
