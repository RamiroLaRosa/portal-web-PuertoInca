document.addEventListener('DOMContentLoaded', () => {
    const editModal = new bootstrap.Modal(document.getElementById('modalEditar'));
    const formEdit = document.getElementById('formEditar');
    const eConcepto = document.getElementById('editConcepto');
    const eMonto = document.getElementById('editMonto');
    const eActive = document.getElementById('editActive');

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const concepto = btn.dataset.concepto || '';
            const monto = btn.dataset.monto || 0;
            const active = parseInt(btn.dataset.active, 10) === 1;

            eConcepto.value = concepto;
            eMonto.value = monto;
            eActive.checked = active;

            formEdit.action = `/admin/transparencia/tupa/${id}`;
            editModal.show();
        });
    });

    // Funcionalidad de paginación
    const table = document.querySelector('.content-table tbody');
    const itemsPerPage = 5;
    let allRows = [];
    let currentPage = 1;

    function initPagination() {
        allRows = Array.from(table.querySelectorAll('tr'));
        renderPage(1);
        createPagination();
    }

    function renderPage(page) {
        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;

        allRows.forEach((row, index) => {
            row.style.display = (index >= startIndex && index < endIndex) ? '' : 'none';
        });

        currentPage = page;
        updatePaginationButtons();
    }

    function createPagination() {
        const totalPages = Math.ceil(allRows.length / itemsPerPage);
        let paginationContainer = document.querySelector('.pagination-container');

        if (!paginationContainer) {
            paginationContainer = document.createElement('div');
            paginationContainer.className = 'pagination-container mt-3';
            table.parentNode.insertAdjacentElement('afterend', paginationContainer);
        }

        paginationContainer.innerHTML = `
            <nav>
                <ul class="pagination justify-content-end mb-0">
                    <li class="page-item" id="prevPage">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item" id="nextPage">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        `;

        document.getElementById('prevPage').addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage > 1) renderPage(currentPage - 1);
        });

        document.getElementById('nextPage').addEventListener('click', (e) => {
            e.preventDefault();
            const totalPages = Math.ceil(allRows.length / itemsPerPage);
            if (currentPage < totalPages) renderPage(currentPage + 1);
        });
    }

    function updatePaginationButtons() {
        const totalPages = Math.ceil(allRows.length / itemsPerPage);
        const prevBtn = document.getElementById('prevPage');
        const nextBtn = document.getElementById('nextPage');

        if (prevBtn && nextBtn) {
            prevBtn.classList.toggle('disabled', currentPage === 1);
            nextBtn.classList.toggle('disabled', currentPage === totalPages || totalPages === 0);
        }
    }
});
