<!-- HEADER TRANSPARENTE -->
<header class="header-minimal">
    <div class="header-content d-flex justify-content-between align-items-center">
        <!-- Botón menú (opcional) -->
        <div class="left-tools">
            <button type="button" class="icon-btn" title="Menú">
                <i class="fa-solid fa-grip-dots"></i>
            </button>
        </div>

        <!-- Acciones -->
        <div class="right-tools d-flex align-items-center gap-3">
            <!-- Dark Mode -->
            <button type="button" class="icon-btn" id="btnDarkMode" title="Cambiar tema">
                <i class="fa-solid fa-moon" id="iconMoon"></i>
                <i class="fa-solid fa-sun d-none" id="iconSun"></i>
            </button>

            <!-- Fullscreen -->
            <button type="button" class="icon-btn" id="btnFullscreen" title="Pantalla completa">
                <i class="fa-solid fa-expand" id="iconFull"></i>
                <i class="fa-solid fa-compress d-none" id="iconMin"></i>
            </button>

            <!-- Avatar con menú -->
            <div class="dropdown">
                <button type="button" class="icon-btn avatar-btn dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false" title="Cuenta">
                    <img src="{{ asset('images/perfil.png') }}" alt="Usuario">
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <!-- <li>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="perfil.html">
                            <i class="fa-solid fa-user-pen"></i> Editar perfil
                        </a>
                    </li> 
                    <li>
                        <hr class="dropdown-divider">
                    </li> -->
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                <i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

<!-- ESTILOS -->
<style>
    :root {
        /* Valores por defecto para layout */
        --sidebar-w: 280px;
        --header-h: 64px;
        --toolbar-btn-size: 56px;
        --toolbar-radius: 16px;
        --toolbar-bg: #fff;
        --toolbar-bg-hover: #f2f5f9;
        --header-bg-light: #f5f9ff;
        --header-bg-dark: #0f1626;
    }

    /* Header base */
    .header-minimal {
        background-color: transparent;
        /* Fondo completamente transparente */
        border: none;
        padding: .75rem 1rem;
        position: static;
        width: 100%;
        z-index: 10;
        /* elimina o comenta las dos líneas siguientes si las tenías */
        /* backdrop-filter: blur(6px); */
        /* -webkit-backdrop-filter: blur(6px); */
    }

    /* Solo cuando el body tenga .has-sidebar se fija y se ajusta */
    body.has-sidebar .header-minimal {
        position: fixed;
        top: 0;
        left: var(--sidebar-w);
        width: calc(100% - var(--sidebar-w));
        height: var(--header-h);
        z-index: 1002;
    }

    body.dark .header-minimal {
        background-color: transparent;
        /* o rgba(15,22,38,0.5) si quieres leve velo */
    }

    /* Botón base para todos los iconos (incluye avatar) */
    .icon-btn {
        width: var(--toolbar-btn-size);
        height: var(--toolbar-btn-size);
        border-radius: var(--toolbar-radius);
        background: var(--toolbar-bg);
        border: none;
        display: grid;
        place-items: center;
        padding: 0;
        line-height: 0;
        font-size: 20px;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .06);
        transition: transform .12s ease, background .2s ease, box-shadow .2s ease;
    }

    .icon-btn:hover {
        background: var(--toolbar-bg-hover);
        box-shadow: 0 4px 10px rgba(0, 0, 0, .08);
        transform: translateY(-1px);
    }

    .avatar-btn {
        overflow: hidden;
    }

    .avatar-btn img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        object-position: center;
    }

    .avatar-btn.dropdown-toggle::after {
        display: none;
    }

    /* Dark mode */
    body.dark .icon-btn {
        background: #101826;
        color: #e5e7eb;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .35);
    }

    body.dark .icon-btn:hover {
        background: #0e1623;
    }

    body.dark .dropdown-menu {
        background: #0f1b2e;
        color: #e5e7eb;
        border-color: #18243a;
    }

    body.dark .dropdown-item {
        color: #e5e7eb;
    }

    body.dark .dropdown-item:hover {
        background: #12233a;
        color: #fff;
    }

    /* Ajustes de contenido dentro del header */
    .header-minimal .header-content {
        width: 100%;
        display: flex;
        align-items: center;
    }

    .header-minimal .right-tools {
        position: absolute;
        right: 24px;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        gap: 12px;
    }

    .header-minimal .left-tools {
        display: none !important;
    }
</style>

<!-- JS -->
<script>
    // Fullscreen toggle
    (function() {
        const btn = document.getElementById('btnFullscreen');
        if (!btn) return;
        const iconFull = document.getElementById('iconFull');
        const iconMin = document.getElementById('iconMin');
        btn.addEventListener('click', () => {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen?.();
                iconFull.classList.add('d-none');
                iconMin.classList.remove('d-none');
            } else {
                document.exitFullscreen?.();
                iconFull.classList.remove('d-none');
                iconMin.classList.add('d-none');
            }
        });
    })();
</script>
