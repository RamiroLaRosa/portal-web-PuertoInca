document.addEventListener('DOMContentLoaded', () => {
    const editModal = new bootstrap.Modal('#modalEditar');
    const formEdit = document.getElementById('formEditar');
    const eNroPaso = document.getElementById('editNroPaso');
    const eTitulo = document.getElementById('editTitulo');
    const eDescripcion = document.getElementById('editDescripcion');
    const eIcono = document.getElementById('editIcono');
    const eActive = document.getElementById('editActive');

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const nroPaso = btn.dataset.nroPaso || '1';
            const titulo = btn.dataset.titulo || '';
            const descripcion = btn.dataset.descripcion || '';
            const icono = btn.dataset.icono || '';
            const active = parseInt(btn.dataset.active, 10) === 1;

            eNroPaso.value = nroPaso;
            eTitulo.value = titulo;
            eDescripcion.value = descripcion;
            eIcono.value = icono;
            eActive.checked = active;

            formEdit.action = window.matriRequisitosUpdateRoute.replace(':id', id);
            editModal.show();
        });
    });

    // -------- Paginación tabla matricula requisitos ----------
    const tableBody = document.querySelector('.matri-requisitos-table tbody');
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
                noDataRow.innerHTML = '<td colspan="6" class="text-center text-muted">Sin registros.</td>';
                tableBody.appendChild(noDataRow);
            }
        }

        function createPagination() {
            let pagination = document.querySelector('.matri-requisitos-pagination');
            if (pagination) pagination.remove();
            pagination = document.createElement('nav');
            pagination.className = 'matri-requisitos-pagination mt-3';
            let prevDisabled = currentPage === 1 ? ' disabled' : '';
            let nextDisabled = currentPage === totalPages ? ' disabled' : '';
            pagination.innerHTML = `<ul class="pagination justify-content-end">
                <li class="page-item${prevDisabled}"><a class="page-link" href="#" aria-label="Anterior"><span aria-hidden="true">&laquo;</span></a></li>
                ${Array.from({ length: totalPages }, (_, i) => `<li class="page-item${i+1===currentPage?' active':''}"><a class="page-link" href="#">${i+1}</a></li>`).join('')}
                <li class="page-item${nextDisabled}"><a class="page-link" href="#" aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a></li>
            </ul>`;
            const table = tableBody.closest('table');
            if (table) {
                const prevPaginations = table.parentElement.querySelectorAll('.matri-requisitos-pagination');
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

    // Mostrar modal de nuevo si hay errores y viene de create
    if (window.matriRequisitosShowNuevoModal) {
        new bootstrap.Modal('#modalNuevo').show();
    }
});
