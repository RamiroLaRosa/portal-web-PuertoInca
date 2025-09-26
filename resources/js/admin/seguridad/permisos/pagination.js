document.addEventListener('DOMContentLoaded', function() {
    const table = document.querySelector('.content-table tbody');
    const itemsPerPage = 10;
    let allRows = [];
    let currentPage = 1;

    function initPagination() {
        if (!table) return;

        allRows = Array.from(table.querySelectorAll('tr'));

        // SIEMPRE crea el paginador, aunque solo haya una página
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

        const existingPagination = document.querySelector('.content-pagination');
        if (existingPagination) {
            existingPagination.remove();
        }

        const paginationDiv = document.createElement('div');
        paginationDiv.className = 'content-pagination mt-3 d-flex justify-content-end';

        const totalPages = Math.ceil(allRows.length / itemsPerPage);
        let paginationHTML = `
            <nav>
                <ul class="pagination justify-content-end mb-0">
                    <li class="page-item" id="content-prev">
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
                    <li class="page-item" id="content-next">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        `;

        paginationDiv.innerHTML = paginationHTML;
        tableContainer.appendChild(paginationDiv);

        document.getElementById('content-prev').addEventListener('click', function(e) {
            e.preventDefault();
            if (currentPage > 1) {
                showPage(currentPage - 1);
            }
        });

        document.getElementById('content-next').addEventListener('click', function(e) {
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
        const prevBtn = document.getElementById('content-prev');
        const nextBtn = document.getElementById('content-next');

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
