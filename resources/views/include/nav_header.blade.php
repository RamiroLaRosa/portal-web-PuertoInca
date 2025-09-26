<div class="nav-header">
    <a href="#" class="brand-logo">
        <img src="{{ asset('images/Logo_Blanco.png') }}" alt="" width="40" height="40">
        <div class="brand-title">
            <img src="{{ asset('images/institucion/banner.png') }}" alt="" width="170" height="40">
        </div>
    </a>
</div>
<style>
    :root {
        --nav-header-h: 72px;
    }

    .nav-header {
        position: fixed;
        top: 0;
        left: 0;
        width: var(--sidebar-w);
        height: var(--nav-header-h);
        background: #00264B;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 14px;
        border-right: 1px solid rgba(221, 227, 232, .08);
        z-index: 1001;
    }

    .nav-header .brand-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }

    .nav-header .brand-title img {
        display: block;
    }

    .nav-header .nav-control {
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .nav-header .hamburger {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .nav-header .hamburger .line {
        width: 18px;
        height: 2px;
        background: #cbd5e1;
        display: block;
        border-radius: 2px;
    }
</style>
