document.addEventListener('DOMContentLoaded', function() {
    // Modal functionality
    const editModal = new bootstrap.Modal(document.getElementById('modalEditar'));
    const formEdit = document.getElementById('formEditar');
    const eConcepto = document.getElementById('editConcepto');
    const eMonto = document.getElementById('editMonto');
    const eActive = document.getElementById('editActive');

    // Edit button functionality
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const concepto = btn.dataset.concepto || '';
            const monto = btn.dataset.monto || 0;
            const active = parseInt(btn.dataset.active, 10) === 1;

            if (eConcepto) eConcepto.value = concepto;
            if (eMonto) eMonto.value = monto;
            if (eActive) eActive.checked = active;

            if (formEdit) {
                // Construir la URL correcta para el formulario
                const baseUrl = window.location.origin;
                formEdit.action = `${baseUrl}/admin/tupa/${id}`;
            }
            editModal.show();
        });
    });

    // Pagination functionality
    const table = document.querySelector('.content-table tbody');
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

        // Remove existing pagination
        const existingPagination = document.querySelector('.tupa-pagination');
        if (existingPagination) {
            existingPagination.remove();
        }

        // Create pagination container
        const paginationDiv = document.createElement('div');
        paginationDiv.className = 'tupa-pagination mt-3 d-flex justify-content-end';

        const totalPages = Math.ceil(allRows.length / itemsPerPage);
        let paginationHTML = `
            <nav>
                <ul class="pagination justify-content-end mb-0">
                    <li class="page-item" id="tupa-prev">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
        `;

        // Generar números de página
        for (let i = 1; i <= totalPages; i++) {
            paginationHTML += `
                    <li class="page-item ${i === 1 ? 'active' : ''}" data-page="${i}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>
            `;
        }

        paginationHTML += `
                    <li class="page-item" id="tupa-next">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        `;

        paginationDiv.innerHTML = paginationHTML;

        tableContainer.appendChild(paginationDiv);

        // Add event listeners
        document.getElementById('tupa-prev').addEventListener('click', function(e) {
            e.preventDefault();
            if (currentPage > 1) {
                showPage(currentPage - 1);
            }
        });

        document.getElementById('tupa-next').addEventListener('click', function(e) {
            e.preventDefault();
            const totalPages = Math.ceil(allRows.length / itemsPerPage);
            if (currentPage < totalPages) {
                showPage(currentPage + 1);
            }
        });

        // Event listeners para números de página
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
        const prevBtn = document.getElementById('tupa-prev');
        const nextBtn = document.getElementById('tupa-next');

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

        // Actualizar estado activo de los números de página
        document.querySelectorAll('.page-item[data-page]').forEach(item => {
            const page = parseInt(item.getAttribute('data-page'));
            if (page === currentPage) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    }

    // Initialize pagination
    initPagination();
});