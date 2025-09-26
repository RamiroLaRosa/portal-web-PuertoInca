// resources/js/gestionar_programa.js

document.addEventListener('DOMContentLoaded', () => {
    // Ver imagen
    const imgModal = new bootstrap.Modal('#modalImagen');
    const vistaImg = document.getElementById('vistaImg');
    const tituloImg = document.getElementById('tituloImg');
    document.querySelectorAll('.btn-show-img').forEach(b => {
        b.addEventListener('click', () => {
            vistaImg.src = b.dataset.img || '';
            tituloImg.textContent = 'Imagen — ' + (b.dataset.nombre || '');
            imgModal.show();
        });
    });

    // Editar
    const editModal = new bootstrap.Modal('#modalEditar');
    const formEdit = document.getElementById('formEditar');
    const eNombre = document.getElementById('eNombre');
    const eDesc = document.getElementById('eDescripcion');
    const ePrev = document.getElementById('ePreview');
    const eActivo = document.getElementById('eActivo');

    document.querySelectorAll('.btn-edit').forEach(b => {
        b.addEventListener('click', () => {
            const id = b.dataset.id;
            eNombre.value = b.dataset.nombre || '';
            eDesc.value = b.dataset.descripcion || '';
            ePrev.src = b.dataset.img || '';
            eActivo.checked = true; // marca por defecto (ajusta si quieres pasar el flag real)
            formEdit.action = `{{ url('/admin/programas') }}/${id}`;
            editModal.show();
        });
    });

    // Eliminar
    const delModal = new bootstrap.Modal('#modalEliminar');
    const formDel = document.getElementById('formEliminar');
    const delName = document.getElementById('delNombre');
    document.querySelectorAll('.btn-delete').forEach(b => {
        b.addEventListener('click', () => {
            const id = b.dataset.id;
            delName.textContent = b.dataset.nombre || '';
            formDel.action = `{{ url('/admin/programas') }}/${id}`;
            delModal.show();
        });
    });

    // -------- Paginación tabla programas ----------
    const tableBody = document.querySelector('.programa-table tbody');
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
            let pagination = document.querySelector('.programa-pagination');
            if (pagination) pagination.remove();
            pagination = document.createElement('nav');
            pagination.className = 'programa-pagination mt-3';
            let prevDisabled = currentPage === 1 ? ' disabled' : '';
            let nextDisabled = currentPage === totalPages ? ' disabled' : '';
            pagination.innerHTML = `<ul class="pagination justify-content-end">
                <li class="page-item${prevDisabled}"><a class="page-link" href="#" aria-label="Anterior"><span aria-hidden="true">&laquo;</span></a></li>
                ${Array.from({ length: totalPages }, (_, i) => `<li class="page-item${i+1===currentPage?' active':''}"><a class="page-link" href="#">${i+1}</a></li>`).join('')}
                <li class="page-item${nextDisabled}"><a class="page-link" href="#" aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a></li>
            </ul>`;
            const table = tableBody.closest('table');
            if (table) {
                const prevPaginations = table.parentElement.querySelectorAll('.programa-pagination');
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
