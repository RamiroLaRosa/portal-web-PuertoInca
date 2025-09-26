import html2pdf from 'html2pdf.js';

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-export-pdf]').forEach(btn => {
        btn.addEventListener('click', function() {
            const table = btn.closest('.card-body')?.querySelector('.content-table');
            if (!table) return;

            // Clona la tabla y elimina la columna de acciones si existe
            const clone = table.cloneNode(true);
            clone.querySelectorAll('thead th:last-child, tbody td:last-child').forEach(el => el.remove());

            // Muestra todas las filas (quita display:none)
            clone.querySelectorAll('tbody tr').forEach(tr => {
                tr.style.display = 'table-row'; // por si el buscador ocultó algo
                tr.removeAttribute('data-pg');  // para ignorar el CSS !important de paginación
            });

            // Crea el contenedor con título y fecha
            const container = document.createElement('div');
            container.style.fontFamily = 'Arial, Helvetica, sans-serif';
            container.style.textAlign = 'center';

            // Título genérico
            const title = document.createElement('h2');
            title.textContent = 'Reporte de Roles';
            title.style.color = '#2563eb';
            title.style.marginBottom = '8px';
            container.appendChild(title);

            // Fecha de exportación
            const date = document.createElement('div');
            const now = new Date();
            const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            date.textContent = 'Fecha de exportación: ' + now.toLocaleDateString('es-PE', options);
            date.style.fontSize = '1.05rem';
            date.style.marginBottom = '18px';
            date.style.color = '#3b4453';
            date.style.fontWeight = 'bold';
            container.appendChild(date);

            // Tabla centrada y con borde
            clone.style.margin = '0 auto';
            clone.style.borderCollapse = 'collapse';
            clone.style.width = '95%';
            clone.querySelectorAll('th, td').forEach(cell => {
                cell.style.border = '1px solid #2563eb';
                cell.style.padding = '8px';
                cell.style.fontSize = '0.95rem';
            });
            clone.querySelectorAll('thead th').forEach(th => {
                th.style.background = 'linear-gradient(90deg, #3b82f6 0%, #2563eb 100%)';
                th.style.color = '#fff';
                th.style.fontWeight = 'bold';
            });

            container.appendChild(clone);

            const opt = {
                margin:       0.5,
                filename:     'reporte_pdf.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'a4', orientation: 'landscape' }
            };

            html2pdf().set(opt).from(container).save();
        });
    });
});
