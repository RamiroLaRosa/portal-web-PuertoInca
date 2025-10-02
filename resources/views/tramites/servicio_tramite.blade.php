<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicio de Trámite - IESPP PUNO</title>
    @vite('resources/css/css_colores_administrables/css_colores_administrables.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            navy: "var(--color-primario-p1)",
                            blue: "var(--color-primario-p2)",
                            sky: "var(--color-primario-p3)",
                            orange: "var(--color-secundario-s1)",
                            gray: "var(--color-neutral)",
                        },
                    },
                },
            },
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="stylesheet" href="/css/web/servicios-tramites.css">
</head>

<body class="min-h-screen font-sans" style="background-color: var(--color-neutral); color: var(--color-primario-p1);">
    @include('header')

    <!-- Main Content -->
    <main class="pt-16">
        <!-- Hero Section -->
        <section class="min-h-screen flex items-center relative overflow-hidden">
            <!-- Background Shapes -->
            <div class="absolute inset-0 z-0">
                <!-- gradiente de p2 (5%) a p3 (10%) -->
                <div class="absolute top-0 left-0 w-full h-full"
                    style="background: linear-gradient(to bottom right, rgba(26,79,211,0.05), rgba(74,132,247,0.10));">
                </div>
                <!-- burbujas -->
                <div class="floating-shape absolute top-1/4 right-1/4 w-64 h-64 rounded-full"
                    style="background-color: rgba(74,132,247,0.20);"></div>
                <div class="floating-shape absolute bottom-1/3 left-1/6 w-80 h-80 rounded-full"
                    style="background-color: rgba(226,114,39,0.15);"></div>
                <div class="floating-shape absolute top-1/2 right-1/6 w-48 h-48 rounded-full"
                    style="background-color: rgba(26,79,211,0.10);"></div>
            </div>

            <div class="container mx-auto px-4 md:px-12 z-10">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <!-- Left Content -->
                    <div class="space-y-8 text-center md:text-left">
                        <div class="space-y-4">
                            <h1 class="text-5xl md:text-7xl font-bold leading-tight">
                                <span style="color: var(--color-primario-p2);">SERVICIO</span><br>
                                <span style="color: var(--color-primario-p2);">DE TRÁMITE</span>
                            </h1>
                        </div>

                        <!-- Virtual Desk Illustration -->
                        <div class="flex justify-center md:justify-start mb-8">
                            <div class="relative">
                                <!-- Main Document Icon -->
                                <div class="rounded-2xl p-6 shadow-lg border-2"
                                    style="background-color:#ffffff; border-color:#f3f4f6;">
                                    <div class="flex items-center space-x-4">
                                        <div class="document-icon">
                                            <i data-lucide="file-text" class="h-12 w-12" style="color:#9ca3af;"></i>
                                        </div>
                                        <div class="space-y-2">
                                            <div class="h-3 rounded-full w-16" style="background-color:#ef4444;"></div>
                                            <div class="h-2 rounded-full w-12" style="background-color:#d1d5db;"></div>
                                            <div class="h-3 rounded-full w-20" style="background-color:#ef4444;"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Side Text -->
                                <div class="absolute -right-4 top-1/2 transform -translate-y-1/2 translate-x-full">
                                    <div class="rounded-lg px-4 py-2 shadow-md border"
                                        style="background-color:#ffffff; border-color:#e5e7eb;">
                                        <p class="text-sm font-bold" style="color:#374151;">MESA DE</p>
                                        <p class="text-sm font-bold" style="color:#374151;">PARTES</p>
                                        <p class="text-sm font-bold" style="color:#374151;">VIRTUAL</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <p class="text-lg max-w-lg mx-auto md:mx-0" style="color:#4b5563;">
                                En IESPP "PUNO", el servicio de trámite se realiza mediante un correo electrónico.
                                Estaremos atentos a sus solicitudes, por favor acceda al siguiente enlace!
                            </p>

                            <div class="flex justify-center md:justify-start">
                                <button
                                    class="service-button rounded-full px-8 py-4 font-bold text-lg flex items-center space-x-3 shadow-lg"
                                    style="background-color: var(--color-primario-p2); color:#ffffff;">
                                    <span>IR AL SERVICIO</span>
                                    <i data-lucide="arrow-right" class="h-5 w-5"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Right Content - Additional Visual Elements -->
                    <div class="relative hidden md:block">
                        <div class="space-y-6">
                            <!-- Document Cards -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="rounded-xl p-4 shadow-lg hover:shadow-xl transition-shadow document-icon"
                                    style="background-color:#ffffff;">
                                    <div class="flex items-center space-x-3">
                                        <i data-lucide="file-check" class="h-8 w-8" style="color:#22c55e;"></i>
                                        <div>
                                            <p class="font-semibold text-sm">Certificados</p>
                                            <p class="text-xs" style="color:#6b7280;">Académicos</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-xl p-4 shadow-lg hover:shadow-xl transition-shadow document-icon"
                                    style="background-color:#ffffff;">
                                    <div class="flex items-center space-x-3">
                                        <i data-lucide="graduation-cap" class="h-8 w-8"
                                            style="color: var(--color-primario-p2);"></i>
                                        <div>
                                            <p class="font-semibold text-sm">Títulos</p>
                                            <p class="text-xs" style="color:#6b7280;">Profesionales</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-xl p-4 shadow-lg hover:shadow-xl transition-shadow document-icon"
                                    style="background-color:#ffffff;">
                                    <div class="flex items-center space-x-3">
                                        <i data-lucide="clipboard-list" class="h-8 w-8"
                                            style="color: var(--color-secundario-s1);"></i>
                                        <div>
                                            <p class="font-semibold text-sm">Constancias</p>
                                            <p class="text-xs" style="color:#6b7280;">de Estudio</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-xl p-4 shadow-lg hover:shadow-xl transition-shadow document-icon"
                                    style="background-color:#ffffff;">
                                    <div class="flex items-center space-x-3">
                                        <i data-lucide="award" class="h-8 w-8" style="color:#eab308;"></i>
                                        <div>
                                            <p class="font-semibold text-sm">Diplomas</p>
                                            <p class="text-xs" style="color:#6b7280;">Especiales</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('footer')

    <script src="/js/web/servicios-tramites.js"></script>
    <script src="/js/web/main.js" defer></script>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>
