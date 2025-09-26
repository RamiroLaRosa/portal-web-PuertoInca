document.addEventListener('DOMContentLoaded', function() {
    // Inicializar lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Variables de paginación
    let allTableRows = [];
    let currentPage = 1;
    const itemsPerPage = 5;

    console.log('Iniciando script de paginación TUPA...');

    // Función para inicializar las filas de la tabla
    function initializeTableRows() {
        const tableBody = document.getElementById('table-body');
        console.log('Buscando table-body:', tableBody);
        
        if (tableBody) {
            allTableRows = Array.from(tableBody.querySelectorAll('.table-row'));
            console.log('Filas encontradas:', allTableRows.length);
            console.log('Primeras filas:', allTableRows.slice(0, 3));
        } else {
            console.error('No se encontró el elemento table-body');
        }
        return allTableRows.length;
    }

    // Función para mostrar página específica
    function showPage(page) {
        console.log('Mostrando página:', page);
        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;

        // Ocultar todas las filas primero
        allTableRows.forEach((row, index) => {
            if (index >= startIndex && index < endIndex) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        currentPage = page;
        updatePaginationState();
    }

    // Función para crear controles de paginación
    function createPaginationControls() {
        console.log('Creando controles de paginación...');
        
        // Buscar el contenedor de la tabla
        const tableContainer = document.querySelector('.bg-white.rounded-3xl');
        console.log('Contenedor de tabla encontrado:', tableContainer);
        
        if (!tableContainer) {
            console.error('No se encontró el contenedor de la tabla');
            return;
        }

        // Eliminar paginación existente si existe
        const existingPagination = document.querySelector('.tupa-pagination');
        if (existingPagination) {
            existingPagination.remove();
        }

        // Crear nueva paginación
        const paginationDiv = document.createElement('div');
        paginationDiv.className = 'tupa-pagination flex justify-end px-6 pb-6 mt-4';
        
        paginationDiv.innerHTML = `
            <nav class="flex items-center gap-2">
                <button id="tupa-prev" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    ← Anterior
                </button>
                <span id="tupa-page-info" class="px-3 py-2 text-sm text-gray-700 font-medium"></span>
                <button id="tupa-next" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    Siguiente →
                </button>
            </nav>
        `;

        // Insertar la paginación
        tableContainer.appendChild(paginationDiv);
        console.log('Paginación insertada:', paginationDiv);

        // Agregar event listeners
        const prevBtn = document.getElementById('tupa-prev');
        const nextBtn = document.getElementById('tupa-next');

        if (prevBtn && nextBtn) {
            prevBtn.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Click en anterior, página actual:', currentPage);
                if (currentPage > 1) {
                    showPage(currentPage - 1);
                }
            });

            nextBtn.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Click en siguiente, página actual:', currentPage);
                const totalPages = Math.ceil(allTableRows.length / itemsPerPage);
                if (currentPage < totalPages) {
                    showPage(currentPage + 1);
                }
            });

            console.log('Event listeners agregados correctamente');
        } else {
            console.error('No se pudieron encontrar los botones de paginación');
        }
    }

    // Función para actualizar el estado de los botones de paginación
    function updatePaginationState() {
        const totalPages = Math.ceil(allTableRows.length / itemsPerPage);
        
        const prevBtn = document.getElementById('tupa-prev');
        const nextBtn = document.getElementById('tupa-next');
        const pageInfo = document.getElementById('tupa-page-info');

        console.log('Actualizando estado - Página:', currentPage, 'de', totalPages);

        if (prevBtn && nextBtn && pageInfo) {
            prevBtn.disabled = currentPage <= 1;
            nextBtn.disabled = currentPage >= totalPages;
            pageInfo.textContent = `Página ${currentPage} de ${totalPages}`;
        }
    }

    // Función para inicializar la paginación
    function initializePagination() {
        console.log('Inicializando paginación con', allTableRows.length, 'filas');
        
        if (allTableRows.length > itemsPerPage) {
            createPaginationControls();
            showPage(1);
            console.log('Paginación inicializada correctamente');
        } else {
            console.log('No se necesita paginación - solo', allTableRows.length, 'filas');
        }
    }

    // Función principal de inicialización
    function init() {
        console.log('Ejecutando inicialización...');
        const rowCount = initializeTableRows();
        
        if (rowCount > 0) {
            initializePagination();
        } else {
            console.warn('No se encontraron filas en la tabla');
        }
    }

    // Inicializar con múltiples intentos para asegurar que el DOM esté listo
    setTimeout(function() {
        init();
    }, 100);

    // Backup: intentar de nuevo después de un tiempo más largo
    setTimeout(function() {
        if (allTableRows.length === 0) {
            console.log('Reintentando inicialización...');
            init();
        }
    }, 500);
});