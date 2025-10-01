{{-- resources/views/otros/contactanos.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contáctanos - Silfer Academia</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide para los pictogramas azules -->
    <script defer src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <!-- Font Awesome para Redes Sociales -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="/css/web/contacto.css">
</head>

<body class="min-h-screen font-sans scroll-smooth"
    style="background: var(--color-neutral); color: var(--color-primario-p1);">
    {{-- Sidebar mini --}}
    <div class="fixed top-0 left-0 h-full w-20 text-white z-50 hidden md:flex flex-col items-center py-8"
        style="background: var(--color-primario-p1);">
        <div class="mb-12">
            <a href="{{ url('/') }}">
                <div class="text-white p-2 rounded-full" style="background: var(--color-secundario-s1);">
                    <i data-lucide="graduation-cap" class="h-6 w-6"></i>
                </div>
            </a>
        </div>
        <nav class="flex flex-col items-center space-y-8 flex-grow">
            <button onclick="scrollToSection('contacto-principal')"
                class="w-12 h-12 flex items-center justify-center rounded-full"
                onmouseenter="this.style.background='var(--color-primario-p2)'"
                onmouseleave="this.style.background='transparent'">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('formulario')"
                class="w-12 h-12 flex items-center justify-center rounded-full"
                onmouseenter="this.style.background='var(--color-primario-p2)'"
                onmouseleave="this.style.background='transparent'">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
            <button onclick="scrollToSection('ubicacion')"
                class="w-12 h-12 flex items-center justify-center rounded-full"
                onmouseenter="this.style.background='var(--color-primario-p2)'"
                onmouseleave="this.style.background='transparent'">
                <div class="h-3 w-3 rounded-full bg-white"></div>
            </button>
        </nav>
    </div>

    @include('header')

    <main class="md:pl-20 pt-16">
        {{-- Hero --}}
        <section class="py-20 relative overflow-hidden">
            <div class="absolute inset-0 z-0">
                <div class="absolute inset-0"
                    style="background-image: linear-gradient(135deg,
                        color-mix(in srgb, var(--color-primario-p2) 10%, transparent),
                        color-mix(in srgb, var(--color-primario-p3) 10%, transparent)
                    );">
                </div>
            </div>
            <div class="container mx-auto px-4 md:px-12 z-10 relative text-center">
                <h1 class="text-5xl md:text-7xl font-bold mb-6">
                    <span style="color: var(--color-primario-p2);">Contáctanos</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    ¿Tienes preguntas sobre nuestros programas? Estamos aquí para ayudarte.
                </p>
            </div>
        </section>

        {{-- Información de Contacto (desde informacion_contacto) --}}
        <section id="contacto-principal" class="py-20 bg-white">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold mt-2">Información de Contacto</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
                    {{-- Teléfono principal --}}
                    <div class="contact-card rounded-3xl p-8 text-center shadow-lg"
                        style="background-image: linear-gradient(135deg, var(--color-neutral), #ffffff);">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6"
                            style="background: var(--color-primario-p2);">
                            <i data-lucide="phone" class="h-8 w-8 text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Teléfono Principal</h3>
                        <p class="font-semibold text-lg" style="color: var(--color-primario-p2);">
                            {{ $info->telefono_principal ?? '—' }}
                        </p>
                        <p class="text-gray-600 text-sm">Lunes a Viernes</p>
                        <p class="text-gray-600 text-sm">8:00 AM - 6:00 PM</p>
                    </div>

                    {{-- WhatsApp --}}
                    <div class="contact-card rounded-3xl p-8 text-center shadow-lg"
                        style="background-image: linear-gradient(135deg, var(--color-neutral), #ffffff);">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6"
                            style="background: var(--color-primario-p3);">
                            <i data-lucide="message-circle" class="h-8 w-8 text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">WhatsApp</h3>
                        <p class="font-semibold text-lg" style="color: var(--color-primario-p3);">
                            {{ $info->whatsapp ?? '—' }}
                        </p>
                        <p class="text-gray-600 text-sm">Atención inmediata</p>
                        <p class="text-gray-600 text-sm">24/7 disponible</p>
                    </div>

                    {{-- Correo --}}
                    <div class="contact-card rounded-3xl p-8 text-center shadow-lg"
                        style="background-image: linear-gradient(135deg, var(--color-neutral), #ffffff);">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6"
                            style="background: var(--color-primario-p1);">
                            <i data-lucide="mail" class="h-8 w-8 text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Correo Electrónico</h3>
                        <p class="font-semibold text-sm">
                            <a href="mailto:{{ $info->correo ?? '' }}" style="color: var(--color-primario-p2);">
                                {{ $info->correo ?? '—' }}
                            </a>
                        </p>
                        <p class="text-gray-600 text-sm">Respuesta en 24h</p>
                        <p class="text-gray-600 text-sm">Lunes a Sábado</p>
                    </div>

                    {{-- Emergencias --}}
                    <div class="contact-card rounded-3xl p-8 text-center shadow-lg"
                        style="background-image: linear-gradient(135deg, var(--color-neutral), #ffffff);">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6"
                            style="background: var(--color-secundario-s1);">
                            <i data-lucide="alert-circle" class="h-8 w-8 text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Emergencias</h3>
                        <p class="font-semibold text-lg" style="color: var(--color-secundario-s1);">
                            {{ $info->emergencia ?? '—' }}
                        </p>
                        <p class="text-gray-600 text-sm">Solo emergencias</p>
                        <p class="text-gray-600 text-sm">24/7 disponible</p>
                    </div>
                </div>

                {{-- Redes Sociales (font awesome + nueva pestaña) --}}
                <div class="rounded-3xl p-8 md:p-12"
                    style="background-image: linear-gradient(90deg, var(--color-neutral), #ffffff);">
                    <div class="text-center mb-8">
                        <h3 class="text-3xl font-bold text-gray-900 mb-4">Síguenos en Redes Sociales</h3>
                        <p class="text-gray-600 max-w-2xl mx-auto">
                            Mantente conectado con nuestras últimas noticias y actualizaciones.
                        </p>
                    </div>

                    <div class="flex flex-wrap justify-center gap-6">
                        @forelse($redes as $r)
                            <a href="{{ $r->enlace }}" target="_blank" rel="noopener noreferrer"
                                class="social-icon text-white w-16 h-16 rounded-2xl flex items-center justify-center transition-colors"
                                style="background: var(--color-primario-p2);"
                                onmouseenter="this.style.background='var(--color-primario-p3)'"
                                onmouseleave="this.style.background='var(--color-primario-p2)'"
                                title="{{ $r->nombre }}">
                                <i class="{{ $r->icono }} text-2xl"></i>
                            </a>
                        @empty
                            <p class="text-gray-600">Pronto publicaremos nuestras redes.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        {{-- Formulario (maquetado estático) --}}
        <section id="formulario" class="py-20" style="background: var(--color-neutral);">
            <div class="container mx-auto px-4 md:px-12">
                <div class="mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold mt-2">Envíanos un Mensaje</h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-lg">
                        {{-- Tu lógica de envío aquí --}}
                        <form class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre *</label>
                                    <input type="text" required
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2"
                                        style="--tw-ring-color: var(--color-primario-p2);">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Apellido *</label>
                                    <input type="text" required
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2"
                                        style="--tw-ring-color: var(--color-primario-p2);">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Correo *</label>
                                <input type="email" required
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2"
                                    style="--tw-ring-color: var(--color-primario-p2);">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Mensaje *</label>
                                <textarea rows="5" required
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 resize-none"
                                    style="--tw-ring-color: var(--color-primario-p2);"></textarea>
                            </div>

                            <button type="submit"
                                class="w-full text-white font-semibold py-4 px-8 rounded-xl transition-colors"
                                style="background: var(--color-primario-p2);"
                                onmouseenter="this.style.background='var(--color-primario-p3)'"
                                onmouseleave="this.style.background='var(--color-primario-p2)'">
                                Enviar Mensaje
                            </button>
                        </form>
                    </div>

                    {{-- Lado informativo simple --}}
                    <div class="space-y-8">
                        <div class="bg-white rounded-3xl p-8 shadow-lg">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">¿Por qué elegirnos?</h3>
                            <ul class="space-y-4 text-gray-700">
                                <li class="flex items-start">
                                    <i data-lucide="award" class="h-5 w-5 mr-3"
                                        style="color: var(--color-primario-p2);"></i>
                                    Excelencia Académica
                                </li>
                                <li class="flex items-start">
                                    <i data-lucide="users" class="h-5 w-5 mr-3"
                                        style="color: var(--color-primario-p2);"></i>
                                    Atención Personalizada
                                </li>
                                <li class="flex items-start">
                                    <i data-lucide="globe" class="h-5 w-5 mr-3"
                                        style="color: var(--color-primario-p2);"></i>
                                    Proyección Internacional
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('footer')

    @vite('resources/js/contacto/contacto.js')
    <script src="/js/web/main.js" defer></script>
</body>

</html>
