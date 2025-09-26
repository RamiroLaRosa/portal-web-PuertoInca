document.addEventListener('DOMContentLoaded', () => {
    // Preview ícono en "Nuevo"
    const iconCreate = document.getElementById('iconCreate');
    const iconCreatePreview = document.getElementById('iconCreatePreview');
    if (iconCreate) {
        iconCreate.addEventListener('change', () => {
            const cls = iconCreate.value || '';
            iconCreatePreview.innerHTML = cls ? `<i class="${cls}"></i>` : '';
        });
    }

    // -------- Editar ----------
    const modalEdit = new bootstrap.Modal(document.getElementById('modalEditarBeneficio'));
    const formEdit = document.getElementById('formEditarBeneficio');
    const eNombre = document.getElementById('editNombre');
    const eDesc = document.getElementById('editDescripcion');
    const eIconSel = document.getElementById('iconEdit');
    const eIconPrev = document.getElementById('iconEditPreview');
    const eActive = document.getElementById('editActive');

    if (eIconSel) {
        eIconSel.addEventListener('change', () => {
            const cls = eIconSel.value || '';
            eIconPrev.innerHTML = cls ? `<i class="${cls}"></i>` : '';
        });
    }

    document.querySelectorAll('.btn-edit-beneficio').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const nom = btn.dataset.nombre || '';
            const des = btn.dataset.descripcion || '';
            const ico = btn.dataset.icono || '';
            const act = btn.dataset.active === '1';

            eNombre.value = nom;
            eDesc.value = des;
            [...eIconSel.options].forEach(o => o.selected = (o.value === ico));
            eIconPrev.innerHTML = ico ? `<i class="${ico}"></i>` : '';
            eActive.checked = act;

            // acción PUT por ID
            formEdit.action = window.beneficioUpdateRoute.replace('__ID__', id);

            modalEdit.show();
        });
    });

    // -------- Eliminar ----------
    const modalDel = new bootstrap.Modal(document.getElementById('modalEliminarBeneficio'));
    const formDel = document.getElementById('formEliminarBeneficio');
    const delName = document.getElementById('delBeneficioNombre');

    document.querySelectorAll('.btn-delete-beneficio').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const name = btn.dataset.nombre || '';
            delName.textContent = name;

            // acción DELETE por ID
            formDel.action = window.beneficioDeleteRoute.replace('__ID__', id);

            modalDel.show();
        });
    });

    // Mostrar modal de nuevo si hay errores y viene de create
    if (window.beneficioShowNuevoModal) {
        new bootstrap.Modal(document.getElementById('modalNuevoBeneficio')).show();
    }

    // -------- Paginación tabla beneficios ----------
    const tableBody = document.querySelector('.beneficios-table tbody');
    if (tableBody) {
        const rows = Array.from(tableBody.querySelectorAll('tr'));
        const dataRows = rows.filter(row => !row.classList.contains('no-data') && row.children.length === 5);
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
            let pagination = document.querySelector('.beneficios-pagination');
            if (pagination) pagination.remove();
            pagination = document.createElement('nav');
            pagination.className = 'beneficios-pagination mt-3';
            let prevDisabled = currentPage === 1 ? ' disabled' : '';
            let nextDisabled = currentPage === totalPages ? ' disabled' : '';
            pagination.innerHTML = `<ul class="pagination justify-content-end">
                <li class="page-item${prevDisabled}"><a class="page-link" href="#" aria-label="Anterior"><span aria-hidden="true">&laquo;</span></a></li>
                ${Array.from({ length: totalPages }, (_, i) => `<li class="page-item${i+1===currentPage?' active':''}"><a class="page-link" href="#">${i+1}</a></li>`).join('')}
                <li class="page-item${nextDisabled}"><a class="page-link" href="#" aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a></li>
            </ul>`;
            const table = tableBody.closest('table');
            if (table) {
                const prevPaginations = table.parentElement.querySelectorAll('.beneficios-pagination');
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
