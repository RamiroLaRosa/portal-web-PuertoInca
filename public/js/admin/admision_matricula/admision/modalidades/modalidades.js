document.addEventListener('DOMContentLoaded', () => {
    // Preview de icono en "Nuevo"
    const createIconSelect = document.getElementById('createIcono');
    const createIconPreview = document.getElementById('createIconPreview');
    if (createIconSelect) {
        const upd = () => {
            createIconPreview.innerHTML = `<i class="${createIconSelect.value}"></i>`;
        };
        createIconSelect.addEventListener('change', upd);
    }

    // Editar
    const editModal = new bootstrap.Modal('#modalEditar');
    const formEdit = document.getElementById('formEditar');
    const eTitulo = document.getElementById('editTitulo');
    const eDesc = document.getElementById('editDescripcion');
    const eIcon = document.getElementById('editIcono');
    const eIconPrev = document.getElementById('editIconPreview');
    const eActive = document.getElementById('editActive');

    if (eIcon) {
        const upd2 = () => {
            eIconPrev.innerHTML = `<i class="${eIcon.value}"></i>`;
        };
        eIcon.addEventListener('change', upd2);
    }

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const titulo = btn.dataset.titulo || '';
            const desc = btn.dataset.descripcion || '';
            const icono = btn.dataset.icono || '';
            const act = parseInt(btn.dataset.active, 10) === 1;

            eTitulo.value = titulo;
            eDesc.value = desc;
            eIcon.value = icono;
            eIconPrev.innerHTML = icono ? `<i class="${icono}"></i>` :
                '<i class="fa-regular fa-circle-question"></i>';
            eActive.checked = act;

            formEdit.action = window.adminModalidadesUpdateRoute.replace('__ID__', id);
            editModal.show();
        });
    });

    // -------- Paginación tabla modalidades ----------
    const tableBody = document.querySelector('.modalidades-table tbody');
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
            let pagination = document.querySelector('.modalidades-pagination');
            if (pagination) pagination.remove();
            pagination = document.createElement('nav');
            pagination.className = 'modalidades-pagination mt-3';
            let prevDisabled = currentPage === 1 ? ' disabled' : '';
            let nextDisabled = currentPage === totalPages ? ' disabled' : '';
            pagination.innerHTML = `<ul class="pagination justify-content-end">
                <li class="page-item${prevDisabled}"><a class="page-link" href="#" aria-label="Anterior"><span aria-hidden="true">&laquo;</span></a></li>
                ${Array.from({ length: totalPages }, (_, i) => `<li class="page-item${i+1===currentPage?' active':''}"><a class="page-link" href="#">${i+1}</a></li>`).join('')}
                <li class="page-item${nextDisabled}"><a class="page-link" href="#" aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a></li>
            </ul>`;
            const table = tableBody.closest('table');
            if (table) {
                const prevPaginations = table.parentElement.querySelectorAll('.modalidades-pagination');
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
    if (window.adminModalidadesShowNuevoModal) {
        new bootstrap.Modal('#modalNuevo').show();
    }
});
