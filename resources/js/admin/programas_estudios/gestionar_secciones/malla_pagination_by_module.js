/* ============================================================================
   Malla – Paginación por Módulo (1 página = 1 módulo)
   Archivo: resources/js/admin/programas_estudios/gestionar_secciones/malla_pagination_by_module.js
   Estilo/posición: reutiliza .content-pagination (Bootstrap) en esquina inferior derecha.
   ============================================================================ */

(function () {
    const PAGER_CLASS = 'content-pagination'; // MISMO que el paginador genérico

    function q(sel, root = document) { return root.querySelector(sel); }
    function qa(sel, root = document) { return Array.from(root.querySelectorAll(sel)); }

    function groupRowsByModule(tbody) {
        const rows = qa('tr', tbody);
        const groups = [];
        let current = null;

        rows.forEach(tr => {
            const tdModulo = tr.querySelector('td.td-modulo');
            if (tdModulo) {
                const name = (tdModulo.textContent || '')
                    .split('\n')[0].trim() || `Módulo ${groups.length + 1}`;
                current = { name, rows: [] };
                groups.push(current);
            }
            if (!current) { current = { name: `Módulo ${groups.length + 1}`, rows: [] }; groups.push(current); }
            current.rows.push(tr);
        });

        return groups;
    }

    function mountControls(tableEl, onGoto, total, getLabel, current) {
        // El contenedor visual de la tabla (para colocar el pager abajo a la derecha)
        const container = tableEl.closest('.table-responsive')?.parentElement || tableEl.parentElement;

        // Borra cualquier paginador existente dentro del contenedor de Malla
        qa(`.${PAGER_CLASS}`, container).forEach(el => el.remove());

        const wrap = document.createElement('div');
        wrap.className = `${PAGER_CLASS} mt-3 d-flex justify-content-end`; // misma posición/estilo

        function render() {
            const label = getLabel(current);
            wrap.innerHTML = `
          <div class="d-flex flex-column align-items-end w-100">
            <div class="text-muted small mb-1">Mostrando <strong>${label}</strong> (${current + 1}/${total})</div>
            <nav>
              <ul class="pagination justify-content-end mb-0">
                <li class="page-item ${current <= 0 ? 'disabled' : ''}" data-role="prev">
                  <a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
                </li>
                ${Array.from({ length: total }).map((_, i) => `
                  <li class="page-item ${i === current ? 'active' : ''}" data-page="${i}">
                    <a class="page-link" href="#" data-page="${i}">${i + 1}</a>
                  </li>
                `).join('')}
                <li class="page-item ${current >= total - 1 ? 'disabled' : ''}" data-role="next">
                  <a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
                </li>
              </ul>
            </nav>
          </div>
        `;

            const prev = wrap.querySelector('[data-role="prev"] a');
            const next = wrap.querySelector('[data-role="next"] a');
            prev?.addEventListener('click', (e) => { e.preventDefault(); onGoto(current - 1); });
            next?.addEventListener('click', (e) => { e.preventDefault(); onGoto(current + 1); });
            wrap.querySelectorAll('.page-link[data-page]').forEach(a => {
                a.addEventListener('click', (e) => {
                    e.preventDefault();
                    onGoto(parseInt(a.dataset.page, 10));
                });
            });
        }

        render();
        container.appendChild(wrap);

        return { update(newIndex) { current = newIndex; render(); } };
    }

    function showModule(groups, index) {
        const all = groups.flatMap(g => g.rows);
        all.forEach(tr => tr.setAttribute('data-pg', '0'));  // oculta por paginación
        groups[index].rows.forEach(tr => tr.removeAttribute('data-pg')); // muestra módulo actual
    }

    function apply() {
        const tbody = q('#tblMallaBody');
        const table = q('#tblMalla');
        if (!tbody || !table) return;

        const groups = groupRowsByModule(tbody);

        if (groups.length <= 1) {
            // sin pager si hay 0/1 módulo
            const container = table.closest('.table-responsive')?.parentElement || table.parentElement;
            qa(`.${PAGER_CLASS}`, container).forEach(el => el.remove());
            qa('tr', tbody).forEach(tr => tr.removeAttribute('data-pg'));
            return;
        }

        let current = 0;
        const getLabel = (i) => groups[i]?.name || `Módulo ${i + 1}`;
        const goto = (i) => {
            current = Math.max(0, Math.min(i, groups.length - 1));
            showModule(groups, current);
            controls.update(current);
        };

        showModule(groups, current);
        const controls = mountControls(table, goto, groups.length, getLabel, current);
    }

    window.MallaPager = { apply };
})();
