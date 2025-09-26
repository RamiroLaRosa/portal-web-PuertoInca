<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicio de Trámite - IESPP PUNO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            navy: '#00264B',
                            blue: '#1A4FD3',
                            sky: '#4A84F7',
                            orange: '#E27227',
                            gray: '#DDE3E8',
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

<body class="min-h-screen bg-brand-gray text-brand-navy font-sans">
    @include('header')

    <!-- Main Content -->
    <main class="pt-16">
        <!-- Hero Section -->
        <section class="min-h-screen flex items-center relative overflow-hidden">
            <!-- Background Shapes -->
            <div class="absolute inset-0 z-0">
                <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-brand-blue/5 to-brand-sky/10"></div>
                <div class="floating-shape absolute top-1/4 right-1/4 w-64 h-64 rounded-full bg-brand-sky/20"></div>
                <div class="floating-shape absolute bottom-1/3 left-1/6 w-80 h-80 rounded-full bg-brand-orange/15"></div>
                <div class="floating-shape absolute top-1/2 right-1/6 w-48 h-48 rounded-full bg-brand-blue/10"></div>
            </div>

            <div class="container mx-auto px-4 md:px-12 z-10">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <!-- Left Content -->
                    <div class="space-y-8 text-center md:text-left">
                        <div class="space-y-4">
                            <h1 class="text-5xl md:text-7xl font-bold leading-tight">
                                <span class="text-brand-blue">SERVICIO</span><br>
                                <span class="text-brand-blue">DE TRÁMITE</span>
                            </h1>
                        </div>
                        
                        <!-- Virtual Desk Illustration -->
                        <div class="flex justify-center md:justify-start mb-8">
                            <div class="relative">
                                <!-- Main Document Icon -->
                                <div class="bg-white rounded-2xl p-6 shadow-lg border-2 border-gray-100">
                                    <div class="flex items-center space-x-4">
                                        <div class="document-icon">
                                            <i data-lucide="file-text" class="h-12 w-12 text-gray-400"></i>
                                        </div>
                                        <div class="space-y-2">
                                            <div class="h-3 bg-red-500 rounded-full w-16"></div>
                                            <div class="h-2 bg-gray-300 rounded-full w-12"></div>
                                            <div class="h-3 bg-red-500 rounded-full w-20"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Side Text -->
                                <div class="absolute -right-4 top-1/2 transform -translate-y-1/2 translate-x-full">
                                    <div class="bg-white rounded-lg px-4 py-2 shadow-md border">
                                        <p class="text-sm font-bold text-gray-700">MESA DE</p>
                                        <p class="text-sm font-bold text-gray-700">PARTES</p>
                                        <p class="text-sm font-bold text-gray-700">VIRTUAL</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <p class="text-lg text-gray-600 max-w-lg mx-auto md:mx-0">
                                En IESPP "PUNO", el servicio de trámite se realiza mediante un correo electrónico. 
                                Estaremos atentos a sus solicitudes, por favor acceda al siguiente enlace!
                            </p>
                            
                            <div class="flex justify-center md:justify-start">
                                <button class="service-button text-white rounded-full px-8 py-4 font-bold text-lg flex items-center space-x-3 shadow-lg">
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
                                <div class="bg-white rounded-xl p-4 shadow-lg hover:shadow-xl transition-shadow document-icon">
                                    <div class="flex items-center space-x-3">
                                        <i data-lucide="file-check" class="h-8 w-8 text-green-500"></i>
                                        <div>
                                            <p class="font-semibold text-sm">Certificados</p>
                                            <p class="text-xs text-gray-500">Académicos</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-white rounded-xl p-4 shadow-lg hover:shadow-xl transition-shadow document-icon">
                                    <div class="flex items-center space-x-3">
                                        <i data-lucide="graduation-cap" class="h-8 w-8 text-brand-blue"></i>
                                        <div>
                                            <p class="font-semibold text-sm">Títulos</p>
                                            <p class="text-xs text-gray-500">Profesionales</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-white rounded-xl p-4 shadow-lg hover:shadow-xl transition-shadow document-icon">
                                    <div class="flex items-center space-x-3">
                                        <i data-lucide="clipboard-list" class="h-8 w-8 text-brand-orange"></i>
                                        <div>
                                            <p class="font-semibold text-sm">Constancias</p>
                                            <p class="text-xs text-gray-500">de Estudio</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-white rounded-xl p-4 shadow-lg hover:shadow-xl transition-shadow document-icon">
                                    <div class="flex items-center space-x-3">
                                        <i data-lucide="award" class="h-8 w-8 text-yellow-500"></i>
                                        <div>
                                            <p class="font-semibold text-sm">Diplomas</p>
                                            <p class="text-xs text-gray-500">Especiales</p>
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
</body>

</html>