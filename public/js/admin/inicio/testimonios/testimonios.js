document.addEventListener('DOMContentLoaded', () => {
    // --------- Preview estrellas (Nuevo) ----------
    const selCreate = document.getElementById('puntuacionCreate');
    const prevCreate = document.getElementById('ratingCreatePreview');
    function paintStars(el, n) {
        el.innerHTML = '';
        for (let i = 1; i <= 5; i++) {
            el.innerHTML += `<i class="${i<=n ? 'fa-solid' : 'fa-regular'} fa-star"></i>`;
        }
    }
    if (selCreate && prevCreate) {
        paintStars(prevCreate, Number(selCreate.value || 5));
        selCreate.addEventListener('change', () => paintStars(prevCreate, Number(selCreate.value)));
    }

    // --------- Preview imagen (tabla) ----------
    const modalPrev = new bootstrap.Modal(document.getElementById('modalPreviewImg'));
    const imgPrevEl = document.getElementById('previewImgEl');
    const titlePrev = document.getElementById('modalPreviewImgLabel');
    document.querySelectorAll('.btn-preview-img').forEach(a => {
        a.addEventListener('click', () => {
            imgPrevEl.src = a.dataset.src || '';
            titlePrev.textContent = a.dataset.title || 'Vista previa';
            modalPrev.show();
        });
    });
    document.getElementById('modalPreviewImg').addEventListener('hidden.bs.modal', () => {
        imgPrevEl.src = '';
    });

    // --------- Editar ----------
    const modalEdit = new bootstrap.Modal(document.getElementById('modalEditar'));
    const formEdit = document.getElementById('formEditar');
    const eNombre = document.getElementById('editNombre');
    const eDesc = document.getElementById('editDescripcion');
    const eImgPrev = document.getElementById('editImgPreview');
    const ePuntSel = document.getElementById('puntuacionEdit');
    const ePuntPrev = document.getElementById('ratingEditPreview');
    const eActive = document.getElementById('editActive');
    function paintEdit() {
        paintStars(ePuntPrev, Number(ePuntSel.value || 5));
    }
    if (ePuntSel) ePuntSel.addEventListener('change', paintEdit);
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const nom = btn.dataset.nombre || '';
            const des = btn.dataset.descripcion || '';
            const img = btn.dataset.img || '';
            const pun = Number(btn.dataset.puntuacion || 5);
            const act = btn.dataset.active === '1';
            eNombre.value = nom;
            eDesc.value = des;
            eImgPrev.src = img;
            [...ePuntSel.options].forEach(o => o.selected = (Number(o.value) === pun));
            eActive.checked = act;
            paintEdit();
            formEdit.action = window.testimoniosEditUrlBase + '/' + id;
            modalEdit.show();
        });
    });

    // --------- Eliminar ----------
    const modalDel = new bootstrap.Modal(document.getElementById('modalEliminar'));
    const formDel = document.getElementById('formEliminar');
    const delName = document.getElementById('delNombre');
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const nm = btn.dataset.nombre || '';
            delName.textContent = nm;
            formDel.action = window.testimoniosEditUrlBase + '/' + id;
            modalDel.show();
        });
    });

    // -------- Paginación tabla testimonios ----------
    const tableBody = document.querySelector('.testimonios-table tbody');
    if (tableBody) {
        const rows = Array.from(tableBody.querySelectorAll('tr'));
        const dataRows = rows.filter(row => !row.classList.contains('no-data') && row.children.length === 6);
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
            let pagination = document.querySelector('.testimonios-pagination');
            if (pagination) pagination.remove();
            pagination = document.createElement('nav');
            pagination.className = 'testimonios-pagination mt-3';
            let prevDisabled = currentPage === 1 ? ' disabled' : '';
            let nextDisabled = currentPage === totalPages ? ' disabled' : '';
            pagination.innerHTML = `<ul class="pagination justify-content-end">
                <li class="page-item${prevDisabled}"><a class="page-link" href="#" aria-label="Anterior"><span aria-hidden="true">&laquo;</span></a></li>
                ${Array.from({ length: totalPages }, (_, i) => `<li class="page-item${i+1===currentPage?' active':''}"><a class="page-link" href="#">${i+1}</a></li>`).join('')}
                <li class="page-item${nextDisabled}"><a class="page-link" href="#" aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a></li>
            </ul>`;
            const table = tableBody.closest('table');
            if (table) {
                const prevPaginations = table.parentElement.querySelectorAll('.testimonios-pagination');
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

    // Mostrar modalNuevo si hay errores y se intentó crear
    if (window.showModalNuevoOnError) {
        new bootstrap.Modal(document.getElementById('modalNuevo')).show();
    }
});
