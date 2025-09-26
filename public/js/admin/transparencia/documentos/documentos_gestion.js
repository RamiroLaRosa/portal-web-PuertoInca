// resources/js/documentos_gestion.js

document.addEventListener('DOMContentLoaded', () => {
    // Editar
    const editModal = new bootstrap.Modal(document.getElementById('modalEditar'));
    const formEdit = document.getElementById('formEditar');
    const eNombre = document.getElementById('editNombre');
    const eDesc = document.getElementById('editDescripcion');
    const eActive = document.getElementById('editActive');

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            eNombre.value = btn.dataset.nombre || '';
            eDesc.value = btn.dataset.descripcion || '';
            eActive.checked = parseInt(btn.dataset.active, 10) === 1;

            formEdit.action = "{{ route('documentos.update', '__ID__') }}".replace('__ID__', id);
            editModal.show();
        });
    });

    // PDF Preview
    const pdfModal = new bootstrap.Modal(document.getElementById('pdfModal'));
    const frame = document.getElementById('pdfFrame');
    const link = document.getElementById('pdfNewTab');

    document.querySelectorAll('.pdf-open').forEach(btn => {
        btn.addEventListener('click', () => {
            const url = btn.dataset.url;
            frame.src = url;
            link.href = url;
            pdfModal.show();
        });
    });

    // -------- Paginación tabla documentos ----------
    const tableBody = document.querySelector('.documentos-table tbody');
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
            let pagination = document.querySelector('.documentos-pagination');
            if (pagination) pagination.remove();
            pagination = document.createElement('nav');
            pagination.className = 'documentos-pagination mt-3';
            let prevDisabled = currentPage === 1 ? ' disabled' : '';
            let nextDisabled = currentPage === totalPages ? ' disabled' : '';
            pagination.innerHTML = `<ul class="pagination justify-content-end">
                <li class="page-item${prevDisabled}"><a class="page-link" href="#" aria-label="Anterior"><span aria-hidden="true">&laquo;</span></a></li>
                ${Array.from({ length: totalPages }, (_, i) => `<li class="page-item${i+1===currentPage?' active':''}"><a class="page-link" href="#">${i+1}</a></li>`).join('')}
                <li class="page-item${nextDisabled}"><a class="page-link" href="#" aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a></li>
            </ul>`;
            const table = tableBody.closest('table');
            if (table) {
                const prevPaginations = table.parentElement.querySelectorAll('.documentos-pagination');
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
