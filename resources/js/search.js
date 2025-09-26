document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.search-input').forEach(input => {
        input.addEventListener('input', function() {
            // Encuentra la tabla más cercana al buscador
            let table = input.closest('.card-body')?.querySelector('.content-table');
            if (!table) return;
            let filter = input.value.trim().toLowerCase();
            let rows = table.querySelectorAll('tbody tr');
            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    });
});