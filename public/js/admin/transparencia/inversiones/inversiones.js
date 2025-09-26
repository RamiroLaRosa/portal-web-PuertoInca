document.addEventListener('DOMContentLoaded', () => {
    const modalEdit = new bootstrap.Modal(document.getElementById('modalEditar'));
    const formEdit = document.getElementById('formEditar');
    const eNombre = document.getElementById('eNombre');
    const eDesc = document.getElementById('eDescripcion');
    const eTipo = document.getElementById('eTipo');
    const eActivo = document.getElementById('eActivo');

    // abrir modal de editar
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            eNombre.value = btn.dataset.nombre || '';
            eDesc.value = btn.dataset.descripcion || '';
            eTipo.value = btn.dataset.tipo || '';
            eActivo.checked = parseInt(btn.dataset.active, 10) === 1;

            formEdit.action = "{{ route('inversiones.update', '__ID__') }}".replace('__ID__', id);
            modalEdit.show();
        });
    });

    // preview PDF
    const pdfFrame = document.getElementById('pdfFrame');
    const openPdfBtn = document.getElementById('openPdfNewTab');
    const modalPdf = new bootstrap.Modal(document.getElementById('modalPdf'));

    document.querySelectorAll('.pdf-thumb.clickable').forEach(el => {
        el.addEventListener('click', () => {
            const url = el.dataset.src;
            pdfFrame.src = url;
            openPdfBtn.href = url;
            modalPdf.show();
        });
    });

    // preview Imagen
    const imgEl = document.getElementById('imgPreview');
    const openImg = document.getElementById('openImgNewTab');
    const modalImg = new bootstrap.Modal(document.getElementById('modalImg'));

    document.querySelectorAll('.img-thumb.clickable').forEach(el => {
        el.addEventListener('click', () => {
            const url = el.dataset.src;
            imgEl.src = url;
            openImg.href = url;
            modalImg.show();
        });
    });

    // Funcionalidad de paginación
    const table = document.querySelector('.inversiones-table tbody');
    const itemsPerPage = 5;
    let allRows = [];
    let currentPage = 1;

    function initPagination() {
        if (!table) return;
        
        allRows = Array.from(table.querySelectorAll('tr'));
        
        if (allRows.length <= itemsPerPage) return;
        
        createPaginationControls();
        showPage(1);
    }

    function showPage(page) {
        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;

        allRows.forEach((row, index) => {
            if (index >= startIndex && index < endIndex) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        currentPage = page;
        updatePaginationButtons();
    }

    function createPaginationControls() {
        const tableContainer = table.parentElement.parentElement;
        
        const existingPagination = document.querySelector('.inversiones-pagination');
        if (existingPagination) {
            existingPagination.remove();
        }

        const paginationDiv = document.createElement('div');
        paginationDiv.className = 'inversiones-pagination mt-3 d-flex justify-content-end';
        
        const totalPages = Math.ceil(allRows.length / itemsPerPage);
        let paginationHTML = `
            <nav>
                <ul class="pagination justify-content-end mb-0">
                    <li class="page-item" id="inversiones-prev">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
        `;

        for (let i = 1; i <= totalPages; i++) {
            paginationHTML += `
                    <li class="page-item ${i === 1 ? 'active' : ''}" data-page="${i}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>
            `;
        }

        paginationHTML += `
                    <li class="page-item" id="inversiones-next">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        `;

        paginationDiv.innerHTML = paginationHTML;
        tableContainer.appendChild(paginationDiv);

        document.getElementById('inversiones-prev').addEventListener('click', function(e) {
            e.preventDefault();
            if (currentPage > 1) {
                showPage(currentPage - 1);
            }
        });

        document.getElementById('inversiones-next').addEventListener('click', function(e) {
            e.preventDefault();
            if (currentPage < totalPages) {
                showPage(currentPage + 1);
            }
        });

        document.querySelectorAll('.page-link[data-page]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const page = parseInt(this.getAttribute('data-page'));
                showPage(page);
            });
        });
    }

    function updatePaginationButtons() {
        const totalPages = Math.ceil(allRows.length / itemsPerPage);
        const prevBtn = document.getElementById('inversiones-prev');
        const nextBtn = document.getElementById('inversiones-next');

        if (prevBtn && nextBtn) {
            if (currentPage <= 1) {
                prevBtn.classList.add('disabled');
            } else {
                prevBtn.classList.remove('disabled');
            }

            if (currentPage >= totalPages) {
                nextBtn.classList.add('disabled');
            } else {
                nextBtn.classList.remove('disabled');
            }
        }

        document.querySelectorAll('.page-item[data-page]').forEach(item => {
            const page = parseInt(item.getAttribute('data-page'));
            if (page === currentPage) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    }

    // Inicializar paginación
    initPagination();
});
