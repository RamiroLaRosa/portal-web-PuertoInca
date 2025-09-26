import * as XLSX from 'xlsx';

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-export-excel]').forEach(btn => {
        btn.addEventListener('click', function() {
            let table = btn.closest('.card-body')?.querySelector('.content-table');
            if (!table) {
                alert('No se encontró la tabla .content-table');
                return;
            }

            let data = [];
            // Encabezados
            const headerCells = Array.from(table.querySelectorAll('thead tr th'));
            const headers = headerCells.length > 1
                ? headerCells.slice(0, -1).map(th => th.textContent.trim())
                : headerCells.map(th => th.textContent.trim());
            data.push(headers);

            // TODAS las filas (no solo visibles)
            const rows = Array.from(table.querySelectorAll('tbody tr')).filter(row => {
                const cells = row.querySelectorAll('td');
                // Excluye la fila de "No hay roles registrados"
                return cells.length > 1;
            });

            rows.forEach(row => {
                const cells = Array.from(row.querySelectorAll('td'));
                const dataCells = cells.length > 1 ? cells.slice(0, -1) : cells;
                const rowData = dataCells.map(td => td.textContent.trim());
                data.push(rowData);
            });

            if (data.length <= 1) {
                alert('No hay datos para exportar.');
                return;
            }

            // Crea el libro y la hoja
            const ws = XLSX.utils.aoa_to_sheet(data);

            // Mejorar el diseño: ancho de columnas y encabezado en negrita
            ws['!cols'] = headers.map(() => ({ wch: 25 }));

            // Opcional: formato de encabezado (solo compatible con algunos visores)
            headers.forEach((header, idx) => {
                const cellRef = XLSX.utils.encode_cell({ r: 0, c: idx });
                if (ws[cellRef]) {
                    ws[cellRef].s = {
                        font: { bold: true, color: { rgb: "2563eb" } },
                        fill: { fgColor: { rgb: "e0e7ef" } },
                        alignment: { horizontal: "center" }
                    };
                }
            });

            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Roles');

            // Exporta el archivo con el nombre solicitado
            XLSX.writeFile(wb, 'reporte_excel.xlsx');
        });
    });
});