<div class="footer out-footer style-2">
    <div class="copyright">
        <p>
            Copyright © Diseñado &amp; Desarrollado por
            <a class="link" href="https://faresoft-solutions.com/" target="_blank">Faresoft Solutions</a> 2025
        </p>
    </div>
</div>

<style>
    body {
        margin: 0;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        font-family: 'Poppins', sans-serif;
    }

    main {
        flex: 1;
        /* se expande y empuja el footer */
        padding: 20px;
    }

    .footer {
        background: #f9fcff;
        /* Fondo blanco grisáceo muy suave */
        padding: 15px 0;
        border-top: 1px solid #e5e7eb;
        /* Línea sutil superior */
    }

    .footer .copyright {
        text-align: center;
        font-size: 14px;
        color: #9ca3af;
        /* Gris tenue */
    }

    .footer .copyright a {
        color: #0ea5e9;
        /* Celeste */
        text-decoration: none;
        font-weight: 500;
    }

    .footer .copyright a:hover {
        text-decoration: underline;
    }

    /* wrapper para tu contenido */
    .footer.out-footer.style-2 {
            background: var(--card);
            /* que no se funda con el bg */
            border-top: 1px solid var(--border);
        }

        .footer .copyright {
            text-align: center;
            font-size: 14px;
            color: #9ca3af;
            font-family: 'Poppins', sans-serif;
        }

        .footer .copyright a {
            color: #0ea5e9;
            text-decoration: none;
            font-weight: 500;
        }

        .footer .copyright a:hover {
            text-decoration: underline;
        }

        .content-with-sidebar {
            display: flex;
            flex-direction: column;
            min-height: calc(100vh - var(--header-h));
        }

        .content-with-sidebar>.page-main {
            flex: 1 1 auto;
        }
</style>
