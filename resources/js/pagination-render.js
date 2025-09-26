// resources/js/pagination-render.js
(() => {
  const DEFAULT_ITEMS = 5;

  // 1) Bloquear Enter en los buscadores para evitar disparar descargas o submits
  document.addEventListener('keydown', (e) => {
    const el = e.target;
    if (el && el.classList && el.classList.contains('search-input') && e.key === 'Enter') {
      e.preventDefault();
    }
  });

  // 2) Inicializa paginación local en cada tabla .content-table de la página
  function initAllTables() {
    document.querySelectorAll('.content-table').forEach((table) => {
      const tbody = table.tBodies && table.tBodies[0];
      if (!tbody) return;

      // Evitar doble inicialización
      if (tbody.dataset.pgBound === '1') return;
      tbody.dataset.pgBound = '1';

      const itemsAttr =
        table.getAttribute('data-items-per-page') ||
        tbody.getAttribute('data-items-per-page') ||
        document.body.getAttribute('data-items-per-page');

      const ITEMS = Math.max(1, parseInt(itemsAttr || DEFAULT_ITEMS, 10));

      setupLocalPager(tbody, ITEMS);
    });
  }

  function setupLocalPager(tbody, ITEMS) {
    const table = tbody.closest('.content-table');
    // contenedor que recibirá el paginador (debajo de la tabla)
    const tableResponsive = table.closest('.table-responsive');
    const wrapper = tableResponsive ? tableResponsive : table.parentElement;

    let current = 1;

    // Filas visibles (search.js oculta con style.display='none')
    const visibleRows = () =>
      Array.from(tbody.querySelectorAll('tr')).filter((tr) => tr.style.display !== 'none');

    function render(page) {
      const rows = visibleRows();

      // Quitar paginadores previos en este wrapper y marcas de paginación
      wrapper.querySelectorAll('.content-pagination').forEach((n) => n.remove());
      rows.forEach((tr) => tr.removeAttribute('data-pg'));

      // Si no hay filas reales (solo "empty-row"), no dibujar nada
      const hasRealRows = rows.some((tr) => !tr.classList.contains('empty-row'));
      if (!hasRealRows) return;

      const total = Math.max(1, Math.ceil(rows.length / ITEMS));
      current = Math.min(Math.max(page, 1), total);

      const start = (current - 1) * ITEMS;
      const end = start + ITEMS;

      // Ocultar por paginación (sin tocar style.display que usa el buscador)
      rows.slice(0, start).forEach((tr) => tr.setAttribute('data-pg', '0'));
      rows.slice(end).forEach((tr) => tr.setAttribute('data-pg', '0'));

      // Construir paginador
      const nav = document.createElement('div');
      nav.className = 'content-pagination mt-3 d-flex justify-content-end';

      let html = `
        <nav>
          <ul class="pagination justify-content-end mb-0">
            <li class="page-item ${current <= 1 ? 'disabled' : ''}" data-role="prev">
              <a class="page-link" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
      `;
      for (let i = 1; i <= total; i++) {
        html += `
            <li class="page-item ${i === current ? 'active' : ''}" data-page="${i}">
              <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>
        `;
      }
      html += `
            <li class="page-item ${current >= total ? 'disabled' : ''}" data-role="next">
              <a class="page-link" href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
      `;
      nav.innerHTML = html;
      wrapper.appendChild(nav);

      // Eventos
      nav.querySelector('[data-role="prev"] a')?.addEventListener('click', (e) => {
        e.preventDefault();
        render(current - 1);
      });
      nav.querySelector('[data-role="next"] a')?.addEventListener('click', (e) => {
        e.preventDefault();
        render(current + 1);
      });
      nav.querySelectorAll('.page-link[data-page]').forEach((a) => {
        a.addEventListener('click', (e) => {
          e.preventDefault();
          render(parseInt(a.dataset.page, 10));
        });
      });
    }

    // Re-render cuando cambian filas (AJAX) o visibilidad por búsqueda
    // IMPORTANTE: subtree:true para captar cambios de style en <tr>
    const mo = new MutationObserver(() => render(1));
    mo.observe(tbody, {
      childList: true,
      subtree: true,
      attributes: true,
      attributeFilter: ['style']
    });

    // Primer render
    render(1);
  }

  // Iniciar al cargar el DOM (y reintentar por si se monta contenido después)
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAllTables);
  } else {
    initAllTables();
  }
  // Por si se inyectan tablas más tarde (SPA parcial), re-intentar
  setTimeout(initAllTables, 500);
  setTimeout(initAllTables, 1500);
})();
