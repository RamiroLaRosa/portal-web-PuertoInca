// Paginación para la tabla de servicios en la vista de administración
// Refactorizado para mantener el código limpio y modular

document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('.content-table tbody');
    if (!tableBody) return;

    // Extraer las filas existentes
    const rows = Array.from(tableBody.querySelectorAll('tr'));
    // Excluir la fila de "Sin registros" si existe
    const dataRows = rows.filter(row => !row.classList.contains('no-data') && row.children.length === 5);

    // Configuración de paginación
    const pageSize = 5;
    let currentPage = 1;
    const totalPages = Math.ceil(dataRows.length / pageSize);

    // Renderizar las filas de la página actual
    function renderPage(page) {
        tableBody.innerHTML = '';
        const start = (page - 1) * pageSize;
        const end = start + pageSize;
        const pageRows = dataRows.slice(start, end);
        pageRows.forEach(row => tableBody.appendChild(row));
        if (pageRows.length === 0) {
            const noDataRow = document.createElement('tr');
            noDataRow.innerHTML = '<td colspan="5" class="text-center text-muted">Sin registros.</td>';
            tableBody.appendChild(noDataRow);
        }
    }

    // Crear controles de paginación
    function createPagination() {
        let pagination = document.querySelector('.servicios-pagination');
        if (pagination) pagination.remove();
        pagination = document.createElement('nav');
        pagination.className = 'servicios-pagination mt-3';
        let prevDisabled = currentPage === 1 ? ' disabled' : '';
        let nextDisabled = currentPage === totalPages ? ' disabled' : '';
        pagination.innerHTML = `<ul class="pagination justify-content-end">
            <li class="page-item${prevDisabled}"><a class="page-link" href="#" aria-label="Anterior"><span aria-hidden="true">&laquo;</span></a></li>
            ${Array.from({ length: totalPages }, (_, i) => `<li class="page-item${i+1===currentPage?' active':''}"><a class="page-link" href="#">${i+1}</a></li>`).join('')}
            <li class="page-item${nextDisabled}"><a class="page-link" href="#" aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a></li>
        </ul>`;
        // Mover la paginación fuera del tbody y justo después de la tabla
        const table = tableBody.closest('table');
        if (table) {
            // Eliminar paginaciones previas fuera del tbody
            const prevPaginations = table.parentElement.querySelectorAll('.servicios-pagination');
            prevPaginations.forEach(p => p.remove());
            table.parentElement.appendChild(pagination);
        } else {
            // Fallback: mantener el comportamiento anterior
            tableBody.parentElement.appendChild(pagination);
        }
        const pageLinks = pagination.querySelectorAll('.page-link');
        // Flecha anterior
        pageLinks[0].addEventListener('click', function(e){
            e.preventDefault();
            if(currentPage > 1){
                currentPage--;
                renderPage(currentPage);
                createPagination();
            }
        });
        // Números
        pageLinks.forEach((link, idx) => {
            if(idx > 0 && idx < totalPages+1){
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    currentPage = idx;
                    renderPage(currentPage);
                    createPagination();
                });
            }
        });
        // Flecha siguiente
        pageLinks[totalPages+1].addEventListener('click', function(e){
            e.preventDefault();
            if(currentPage < totalPages){
                currentPage++;
                renderPage(currentPage);
                createPagination();
            }
        });
    }

    // Inicializar paginación
    renderPage(currentPage);
    if (totalPages > 1) createPagination();
});
