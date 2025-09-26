// resources/js/mision.js

document.addEventListener('DOMContentLoaded', function() {
    // Vista previa de ícono en modal nuevo
    const newIcono = document.getElementById('newIcono');
    const newIconPreview = document.getElementById('newIconPreview');
    if (newIcono && newIconPreview) {
        newIcono.addEventListener('change', function() {
            newIconPreview.className = this.value;
        });
    }

    // Vista previa de ícono en modal editar
    const editIconoSelect = document.getElementById('editIconoSelect');
    const editIconPreview = document.getElementById('editIconPreview');
    const editIconCode = document.getElementById('editIconCode');
    if (editIconoSelect && editIconPreview && editIconCode) {
        editIconoSelect.addEventListener('change', function() {
            editIconPreview.className = this.value;
            editIconCode.textContent = this.value;
        });
    }

    // Editar valor: rellena los campos
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('editNombre').value = btn.dataset.nombre || '';
            document.getElementById('editDescripcion').value = btn.dataset.descripcion || '';
            editIconoSelect.value = btn.dataset.icono || '';
            editIconPreview.className = btn.dataset.icono || '';
            editIconCode.textContent = btn.dataset.icono || '';
            document.getElementById('editActive').checked = btn.dataset.active == '1';
            document.getElementById('formEditarValor').action = `${document.body.dataset.valoresBaseUrl}/${btn.dataset.id}`;
        });
    });

    // Eliminar valor: rellena el nombre y acción
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('delNombre').textContent = btn.dataset.nombre || '';
            document.getElementById('formEliminarValor').action = `${document.body.dataset.valoresBaseUrl}/${btn.dataset.id}`;
        });
    });

    // -------- Paginación tabla misión ----------
    const tableBody = document.querySelector('.mision-table tbody');
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
            let pagination = document.querySelector('.mision-pagination');
            if (pagination) pagination.remove();
            pagination = document.createElement('nav');
            pagination.className = 'mision-pagination mt-3';
            let prevDisabled = currentPage === 1 ? ' disabled' : '';
            let nextDisabled = currentPage === totalPages ? ' disabled' : '';
            pagination.innerHTML = `<ul class="pagination justify-content-end">
                <li class="page-item${prevDisabled}"><a class="page-link" href="#" aria-label="Anterior"><span aria-hidden="true">&laquo;</span></a></li>
                ${Array.from({ length: totalPages }, (_, i) => `<li class="page-item${i+1===currentPage?' active':''}"><a class="page-link" href="#">${i+1}</a></li>`).join('')}
                <li class="page-item${nextDisabled}"><a class="page-link" href="#" aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a></li>
            </ul>`;
            const table = tableBody.closest('table');
            if (table) {
                const prevPaginations = table.parentElement.querySelectorAll('.mision-pagination');
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
