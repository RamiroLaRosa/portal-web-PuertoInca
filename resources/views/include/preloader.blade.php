<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargando...</title>
    <style>
        :root {
            --primary: #2563eb;
            /* azul principal */
            --accent: #14b8a6;
            /* teal */
            --white-30: rgba(255, 255, 255, .30);
            --white-80: rgba(255, 255, 255, .80);
        }

        .preloader {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity .5s ease-out;
        }

        .preloader.fade-out {
            opacity: 0;
            pointer-events: none;
        }

        .loader-container {
            text-align: center;
            color: #fff;
        }

        .spinner {
            width: 60px;
            height: 60px;
            border: 4px solid var(--white-30);
            border-top: 4px solid var(--accent);
            /* usa el teal */
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        .loader-text {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            animation: pulse 1.5s ease-in-out infinite;
        }

        .loader-subtitle {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            opacity: .9;
            animation: fadeInOut 2s ease-in-out infinite;
        }

        .progress-bar {
            width: 200px;
            height: 4px;
            border-radius: 2px;
            margin: 20px auto 0;
            overflow: hidden;
            background: var(--white-30);
        }

        .progress-fill {
            height: 100%;
            border-radius: 2px;
            /* degradado con los colores del tema */
            background: linear-gradient(90deg, var(--accent) 0%, var(--primary) 100%);
            animation: loading 2s ease-in-out infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0)
            }

            to {
                transform: rotate(360deg)
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: .75
            }
        }

        @keyframes fadeInOut {

            0%,
            100% {
                opacity: .9
            }

            50% {
                opacity: .6
            }
        }

        @keyframes loading {
            0% {
                width: 0%;
                transform: translateX(-100%);
            }

            50% {
                width: 100%;
                transform: translateX(0%);
            }

            100% {
                width: 100%;
                transform: translateX(100%);
            }
        }

        /* Responsive */
        @media (max-width:768px) {
            .spinner {
                width: 50px;
                height: 50px;
            }

            .loader-text {
                font-size: 16px;
            }

            .progress-bar {
                width: 150px;
            }
        }
    </style>
</head>

<body>
    <div class="preloader" id="preloader">
        <div class="loader-container">
            <div class="spinner"></div>
            <div class="loader-text">Cargando Panel Administrativo</div>
            <div class="loader-subtitle">Preparando tu experiencia...</div>
            <div class="progress-bar">
                <div class="progress-fill"></div>
            </div>
        </div>
    </div>

    <script>
        // Ocultar al cargar
        window.addEventListener('load', function() {
            setTimeout(function() {
                const pre = document.getElementById('preloader');
                pre.classList.add('fade-out');
                setTimeout(() => pre.style.display = 'none', 500);
            }, 1500);
        });

        // Fallback si tarda demasiado
        setTimeout(function() {
            const pre = document.getElementById('preloader');
            if (pre && !pre.classList.contains('fade-out')) {
                pre.classList.add('fade-out');
                setTimeout(() => pre.style.display = 'none', 500);
            }
        }, 5000);
    </script>
</body>

</html>
