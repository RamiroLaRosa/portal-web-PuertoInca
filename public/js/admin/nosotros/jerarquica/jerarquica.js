// resources/js/jerarquica.js
// Lógica JS para la gestión de la plana jerárquica

document.addEventListener('DOMContentLoaded', function() {
    // Modal: Ver imagen
    document.querySelectorAll('.btn-view-img').forEach(btn => {
        btn.addEventListener('click', function() {
            const src = btn.getAttribute('data-src');
            const title = btn.getAttribute('data-title');
            document.getElementById('imgPreview').src = src;
            document.getElementById('imgTitle').textContent = title || 'Imagen';
            const modal = new bootstrap.Modal(document.getElementById('modalVerImagen'));
            modal.show();
        });
    });

    // Modal: Editar (rellena los campos)
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('editNombre').value = btn.getAttribute('data-nombre') || '';
            document.getElementById('editCargo').value = btn.getAttribute('data-cargo') || '';
            document.getElementById('editActive').checked = btn.getAttribute('data-active') == '1';
            document.getElementById('formEditar').action = `${document.body.dataset.jerarquicaBaseUrl}/${btn.getAttribute('data-id')}`;
        });
    });

    // Modal: Eliminar (rellena el nombre y acción)
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('delNombre').textContent = btn.getAttribute('data-nombre') || '';
            document.getElementById('formEliminar').action = `${document.body.dataset.jerarquicaBaseUrl}/${btn.getAttribute('data-id')}`;
        });
    });

    // Búsqueda en la tabla
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const term = searchInput.value.toLowerCase();
            document.querySelectorAll('tbody tr').forEach(tr => {
                if (tr.querySelector('td')) {
                    const text = tr.textContent.toLowerCase();
                    tr.style.display = text.includes(term) ? '' : 'none';
                }
            });
        });
    }

    // -------- Paginación tabla jerárquica ----------
    const tableBody = document.querySelector('.jerarquica-table tbody');
    if (tableBody) {
        const rows = Array.from(tableBody.querySelectorAll('tr'));
        const dataRows = rows.filter(row => !row.classList.contains('no-data') && row.children.length > 3);
        const pageSize = 5;
        let currentPage = 1;
        const totalPages = Math.ceil(dataRows.length / pageSize);

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

        function createPagination() {
            let pagination = document.querySelector('.jerarquica-pagination');
            if (pagination) pagination.remove();
            pagination = document.createElement('nav');
            pagination.className = 'jerarquica-pagination mt-3';
            let prevDisabled = currentPage === 1 ? ' disabled' : '';
            let nextDisabled = currentPage === totalPages ? ' disabled' : '';
            pagination.innerHTML = `<ul class="pagination justify-content-end">
                <li class="page-item${prevDisabled}"><a class="page-link" href="#" aria-label="Anterior"><span aria-hidden="true">&laquo;</span></a></li>
                ${Array.from({ length: totalPages }, (_, i) => `<li class="page-item${i+1===currentPage?' active':''}"><a class="page-link" href="#">${i+1}</a></li>`).join('')}
                <li class="page-item${nextDisabled}"><a class="page-link" href="#" aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a></li>
            </ul>`;
            const table = tableBody.closest('table');
            if (table) {
                const prevPaginations = table.parentElement.querySelectorAll('.jerarquica-pagination');
                prevPaginations.forEach(p => p.remove());
                table.parentElement.appendChild(pagination);
            } else {
                tableBody.parentElement.appendChild(pagination);
            }
            const pageLinks = pagination.querySelectorAll('.page-link');
            pageLinks[0].addEventListener('click', function(e){
                e.preventDefault();
                if(currentPage > 1){
                    currentPage--;
                    renderPage(currentPage);
                    createPagination();
                }
            });
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
            pageLinks[totalPages+1].addEventListener('click', function(e){
                e.preventDefault();
                if(currentPage < totalPages){
                    currentPage++;
                    renderPage(currentPage);
                    createPagination();
                }
            });
        }
        renderPage(currentPage);
        if (totalPages > 1) createPagination();
    }
});
