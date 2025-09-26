(function () {
    const ITEMS_PER_PAGE = 5;

    function initTable(table) {
        if (!table) return;

        // >>> NO paginar la malla; la pagina su propio módulo <<<
        if (table.id === 'tblMalla') return;

        const tbody = table.querySelector("tbody");
        const container = table.parentElement?.parentElement;
        if (!tbody || !container) return;

        let currentPage = 1;

        function rowsNotFiltered() {
            return Array.from(tbody.querySelectorAll("tr")).filter(
                (tr) => tr.style.display !== "none"
            );
        }

        function applyPageSlice(page) {
            const rows = rowsNotFiltered();
            const totalPages = Math.max(1, Math.ceil(rows.length / ITEMS_PER_PAGE));
            currentPage = Math.min(Math.max(page, 1), totalPages);

            const start = (currentPage - 1) * ITEMS_PER_PAGE;
            const end = start + ITEMS_PER_PAGE;

            rows.forEach((tr) => tr.removeAttribute("data-pg"));
            rows.slice(0, start).forEach((tr) => tr.setAttribute("data-pg", "0"));
            rows.slice(end).forEach((tr) => tr.setAttribute("data-pg", "0"));

            buildPagination(totalPages);
        }

        function buildPagination(totalPages) {
            container.querySelectorAll(".content-pagination").forEach((el) => el.remove());

            const paginationDiv = document.createElement("div");
            paginationDiv.className = "content-pagination mt-3 d-flex justify-content-end";

            let html = `
          <nav>
            <ul class="pagination justify-content-end mb-0">
              <li class="page-item ${currentPage <= 1 ? "disabled" : ""}" data-role="prev">
                <a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
              </li>
        `;
            for (let i = 1; i <= totalPages; i++) {
                html += `
            <li class="page-item ${i === currentPage ? "active" : ""}" data-page="${i}">
              <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>`;
            }
            html += `
              <li class="page-item ${currentPage >= totalPages ? "disabled" : ""}" data-role="next">
                <a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
              </li>
            </ul>
          </nav>`;
            paginationDiv.innerHTML = html;
            container.appendChild(paginationDiv);

            paginationDiv.querySelector('[data-role="prev"] a')?.addEventListener("click", (e) => {
                e.preventDefault();
                applyPageSlice(currentPage - 1);
            });
            paginationDiv.querySelector('[data-role="next"] a')?.addEventListener("click", (e) => {
                e.preventDefault();
                applyPageSlice(currentPage + 1);
            });
            paginationDiv.querySelectorAll(".page-link[data-page]").forEach((a) => {
                a.addEventListener("click", (e) => {
                    e.preventDefault();
                    applyPageSlice(parseInt(a.dataset.page));
                });
            });
        }

        const observer = new MutationObserver(() => {
            const rows = rowsNotFiltered();
            if (rows.length === 0) {
                container.querySelectorAll(".content-pagination").forEach((el) => el.remove());
                return;
            }
            applyPageSlice(1);
        });
        observer.observe(tbody, { childList: true, subtree: false, attributes: true, attributeFilter: ["style"] });

        applyPageSlice(1);
    }

    document.querySelectorAll(".tab-panel .content-table").forEach(initTable);

    document.querySelectorAll(".pe-tab").forEach((btn) => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.tab;
            const table = document.querySelector("#" + id + " .content-table");
            if (table) initTable(table);
        });
    });
})();
