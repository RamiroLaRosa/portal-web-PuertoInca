// Asegúrate de que estas variables estén definidas globalmente antes de cargar este archivo
// (las definimos en el Blade más abajo)

document.addEventListener('DOMContentLoaded', () => {
    const CSRF = document.querySelector('meta[name="csrf-token"]').content;

    // Chart
    const YEARS = window.YEARS || [];
    const yearsFull = window.yearsFull || [];
    let chartCtx = document.getElementById('chart');
    let chart = new Chart(chartCtx, {
        type: 'line',
        data: {
            labels: YEARS,
            datasets: [{
                label: 'Sin datos',
                data: YEARS.map(() => 0),
                borderWidth: 2,
                tension: .25
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    function updateChartFromRow(row) {
        let serie = yearsFull.map(y => row[y.id]?.cantidad ?? 0);
        chart.data.datasets[0].data = serie;
        chart.data.datasets[0].label = 'Serie seleccionada';
        chart.update();
    }

    // GRID (Inferior)
    const thead = document.getElementById('theadAnios');
    const tbody = document.getElementById('tbodyGrid');
    const buscarProg = document.getElementById('buscarProg');

    let GRID = { years: [], programs: [], cells: {} };

    function renderHead() {
        thead.innerHTML = '';
        let tr = document.createElement('tr');
        tr.innerHTML = `<th>Programa de Estudio</th>` + GRID.years.map(y => `<th class="text-center">${y.anio}</th>`).join('');
        thead.appendChild(tr);
    }

    function renderBody(filterText = '') {
        tbody.innerHTML = '';
        let any = false;
        GRID.programs.forEach(p => {
            const name = p.nombre || '';
            if (filterText && !name.toLowerCase().includes(filterText)) return;
            any = true;
            let tds = GRID.years.map(y => {
                const key = `${p.id}-${y.id}`;
                const cell = GRID.cells[key] || null;
                const cantidad = cell ? cell.cantidad : 0;
                const id = cell ? cell.id : null;
                let actions = '';
                if (id) {
                    actions = `
                    <div class="cell-actions">
                        <button type="button" class="btn btn-warning btn-sm text-white btn-edit" data-id="${id}" data-cantidad="${cantidad}" title="Editar"><i class="fa-regular fa-pen-to-square"></i></button>
                        <button type="button" class="btn btn-danger btn-sm btn-del" data-id="${id}" title="Eliminar"><i class="fa-regular fa-trash-can"></i></button>
                    </div>`;
                }
                return `<td class="text-center"><div>${cantidad}</div>${actions}</td>`;
            }).join('');
            tbody.insertAdjacentHTML('beforeend', `<tr data-prog="${p.id}"><td class="fw-semibold">${name}</td>${tds}</tr>`);
        });
        if (!any) tbody.innerHTML = `<tr class="empty-row"><td colspan="${1 + GRID.years.length}">La tabla está vacía.</td></tr>`;

        // Bind edit/delete
        tbody.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                const cant = btn.dataset.cantidad;
                document.getElementById('formEditar').action = `/admin/transparencia/estadistica/${id}`;
                document.getElementById('editId').value = id;
                document.getElementById('editCantidad').value = cant;
                new bootstrap.Modal(document.getElementById('modalEditar')).show();
            });
        });
        tbody.querySelectorAll('.btn-del').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                document.getElementById('formEliminar').action = `/admin/transparencia/estadistica/${id}`;
                document.getElementById('delId').value = id;
                new bootstrap.Modal(document.getElementById('modalEliminar')).show();
            });
        });
        tbody.querySelectorAll('tr[data-prog]').forEach(tr => {
            tr.addEventListener('click', () => {
                const progId = tr.getAttribute('data-prog');
                const rowObj = {};
                GRID.years.forEach(y => {
                    const k = `${progId}-${y.id}`;
                    if (GRID.cells[k]) rowObj[y.id] = GRID.cells[k];
                });
                updateChartFromRow(rowObj);
            });
        });
    }

    async function loadGrid(temaId) {
        if (!temaId) {
            tbody.innerHTML = `<tr class="empty-row"><td>La tabla está vacía.</td></tr>`;
            return;
        }
        const url = `${window.ESTADISTICA_GRID_URL}?tema_id=${temaId}`;
        const res = await fetch(url);
        const json = await res.json();
        GRID = json;
        renderHead();
        renderBody(buscarProg.value.trim().toLowerCase());
    }

    buscarProg.addEventListener('input', e => {
        renderBody(e.target.value.trim().toLowerCase());
    });

    document.getElementById('temaInf').addEventListener('change', e => {
        loadGrid(e.target.value);
    });

    renderHead();
    renderBody();
    chart.update();
});