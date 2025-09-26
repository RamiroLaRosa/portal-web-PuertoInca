// resources/js/jerarquica.js
// Lógica JS para la gestión de la plana jerárquica

document.addEventListener('DOMContentLoaded', function () {
    // Modal: Ver imagen
    document.querySelectorAll('.btn-view-img').forEach(btn => {
        btn.addEventListener('click', function () {
            const src = btn.getAttribute('data-src');
            const title = btn.getAttribute('data-title');
            document.getElementById('imgPreview').src = src;
            document.getElementById('imgTitle').textContent = title || 'Imagen';
            const modal = new bootstrap.Modal(document.getElementById('modalVerImagen'));
            modal.show();
        });
    });

    // Modal: Editar (rellena los campos)
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('editNombre').value = btn.getAttribute('data-nombre') || '';
            document.getElementById('editCargo').value = btn.getAttribute('data-cargo') || '';
            document.getElementById('editActive').checked = btn.getAttribute('data-active') == '1';
            document.getElementById('formEditar').action = `${document.body.dataset.jerarquicaBaseUrl}/${btn.getAttribute('data-id')}`;
        });
    });

    // Modal: Eliminar (rellena el nombre y acción)
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('delNombre').textContent = btn.getAttribute('data-nombre') || '';
            document.getElementById('formEliminar').action = `${document.body.dataset.jerarquicaBaseUrl}/${btn.getAttribute('data-id')}`;
        });
    });

    // Búsqueda en la tabla
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const term = searchInput.value.toLowerCase();
            document.querySelectorAll('tbody tr').forEach(tr => {
                if (tr.querySelector('td')) {
                    const text = tr.textContent.toLowerCase();
                    tr.style.display = text.includes(term) ? '' : 'none';
                }
            });
        });
    }

});
