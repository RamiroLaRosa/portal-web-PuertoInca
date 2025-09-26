document.addEventListener('DOMContentLoaded', function() {
    const titulo = document.body.getAttribute('data-titulo');
    if (!titulo) return;

    // Crea el contenedor del título alineado con el contenido
    const container = document.createElement('div');
    container.className = 'page-title-container py-3 mb-4 text-center px-3 px-md-4';

    // Crea el título con estilos profesionales y animación
    const h2 = document.createElement('h2');
    h2.className = 'fw-bold mb-0';
    h2.style.color = '#2563eb';
    h2.style.letterSpacing = '1.5px';
    h2.style.fontFamily = 'Segoe UI, Arial, Helvetica, sans-serif';
    h2.style.fontSize = '2.2rem';
    h2.style.textShadow = '0 2px 8px rgba(37,99,235,0.08)';
    h2.style.transition = 'transform 0.7s cubic-bezier(.68,-0.55,.27,1.55), opacity 0.7s';
    h2.style.opacity = '0';
    h2.style.transform = 'translateY(-30px) scale(0.97)';
    h2.textContent = titulo;

    container.appendChild(h2);

    // Inserta el título justo antes del div .container-fluid
    const containerFluid = document.querySelector('.container-fluid');
    if (containerFluid && containerFluid.parentNode) {
        containerFluid.parentNode.insertBefore(container, containerFluid);
        // Animación de entrada
        setTimeout(() => {
            h2.style.opacity = '1';
            h2.style.transform = 'translateY(0) scale(1)';
        }, 100);
    }
});