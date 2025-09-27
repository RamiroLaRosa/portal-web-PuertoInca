<footer class="bg-[#00264B] text-white pt-20 pb-10 md:pl-20">
    <div class="container mx-auto px-4 md:px-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 mb-16">

            <!-- Columna 1: Logo + redes -->
            <div>
                <div class="flex items-center space-x-2 mb-6">
                    <div class="bg-[#E27227] text-white p-2 rounded-full">
                        <i data-lucide="graduation-cap" class="h-6 w-6"></i>
                    </div>
                    <span class="text-2xl font-bold">IESTP PUERTO INCA</span>
                </div>
                <p class="text-white/60 mb-6" style="text-align: justify;">
                    En el IESTP PUERTO INCA formamos profesionales con valores, innovación y compromiso con el desarrollo, ofreciendo educación técnica de calidad al servicio de la Amazonía y del Perú. Reimaginamos la educación para los retos del mundo digital, impulsando el conocimiento, la sostenibilidad y el liderazgo de nuestros estudiantes, quienes se convierten en agentes de transformación social y constructores de un futuro mejor desde Puerto Inca hacia el mundo.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-[#1A4FD3] flex items-center justify-center hover:bg-[#4A84F7] transition-colors">
                        <i data-lucide="twitter" class="w-5 h-5 text-white/80"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-[#1A4FD3] flex items-center justify-center hover:bg-[#4A84F7] transition-colors">
                        <i data-lucide="facebook" class="w-5 h-5 text-white/80"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-[#1A4FD3] flex items-center justify-center hover:bg-[#4A84F7] transition-colors">
                        <i data-lucide="instagram" class="w-5 h-5 text-white/80"></i>
                    </a>
                </div>
            </div>

            <!-- Columna 2: Nosotros + Servicios agrupados -->
            <div class="grid grid-cols-2 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-6">Nosotros</h3>
                    <ul class="space-y-4">
                        <li><a href="{{ url('/presentacion') }}" class="text-white/60 hover:text-[#4A84F7] transition-colors">Presentación</a></li>
                        <li><a href="{{ url('/mision') }}" class="text-white/60 hover:text-[#4A84F7] transition-colors">Misión, visión y valores</a></li>
                        <li><a href="{{ url('/organigrama') }}" class="text-white/60 hover:text-[#4A84F7] transition-colors">Organización institucional</a></li>
                        <li><a href="{{ url('/jerarquica') }}" class="text-white/60 hover:text-[#4A84F7] transition-colors">Plana jerárquica</a></li>
                        <li><a href="{{ url('/docente') }}" class="text-white/60 hover:text-[#4A84F7] transition-colors">Plana docente</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-6">Servicios</h3>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-white/60 hover:text-[#4A84F7] transition-colors">Biblioteca Virtual</a></li>
                        <li><a href="#" class="text-white/60 hover:text-[#4A84F7] transition-colors">Bolsa Laboral</a></li>
                    </ul>
                </div>
            </div>

            <!-- Columna 3: Ubicación con mapa más ancho -->
            <div>
                <h3 class="text-xl font-bold mb-6">Ubicación</h3>
                <div class="rounded-xl overflow-hidden shadow-lg">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3936.4973863027276!2d-74.9661138258509!3d-9.37766689796095!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91a133b3588fae47%3A0x98aa79757f8e8024!2sIESTP%20%22PUERTO%20INCA%22!5e0!3m2!1ses!2spe!4v1758949527441!5m2!1ses!2spe"
                        width="100%"
                        height="300"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>

        <div class="bg-[#F0F4F8] py-6 mt-8">
            <div class="flex flex-wrap justify-center items-center gap-x-12 gap-y-6 px-6">
                <a href="https://www.minedu.gob.pe/superiortecnologica/" target="_blank" rel="noopener">
                    <img src="{{ asset('images/minedu.png') }}" alt="MINEDU" class="h-14 object-contain" />
                </a>
                <a href="https://avanza.minedu.gob.pe/" target="_blank" rel="noopener">
                    <img src="{{ asset('images/avanza.png') }}" alt="Avanza" class="h-14 object-contain" />
                </a>
                <a href="https://conecta.minedu.gob.pe/" target="_blank" rel="noopener">
                    <img src="{{ asset('images/conecta.png') }}" alt="Conecta" class="h-14 object-contain" />
                </a>
                <a href="https://registra.minedu.gob.pe/" target="_blank" rel="noopener">
                    <img src="{{ asset('images/registra.png') }}" alt="Registra" class="h-14 object-contain" />
                </a>
                <a href="https://titula.minedu.gob.pe/" target="_blank" rel="noopener">
                    <img src="{{ asset('images/titula.png') }}" alt="Titula" class="h-14 object-contain" />
                </a>
            </div>
        </div>

        <!-- Pie de página -->
        <div class="border-t border-[#DDE3E8]/20 pt-8 text-center text-white/40">
            Copyright © Diseñado & Desarrollado por Faresoft-Solutions 2025
        </div>
    </div>
</footer>
