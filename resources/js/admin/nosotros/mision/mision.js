// resources/js/mision.js

document.addEventListener('DOMContentLoaded', function () {
    // Vista previa de ícono en modal nuevo
    const newIcono = document.getElementById('newIcono');
    const newIconPreview = document.getElementById('newIconPreview');
    if (newIcono && newIconPreview) {
        newIcono.addEventListener('change', function () {
            newIconPreview.className = this.value;
        });
    }

    // Vista previa de ícono en modal editar
    const editIconoSelect = document.getElementById('editIconoSelect');
    const editIconPreview = document.getElementById('editIconPreview');
    const editIconCode = document.getElementById('editIconCode');
    if (editIconoSelect && editIconPreview && editIconCode) {
        editIconoSelect.addEventListener('change', function () {
            editIconPreview.className = this.value;
            editIconCode.textContent = this.value;
        });
    }

    // Editar valor: rellena los campos
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('editNombre').value = btn.dataset.nombre || '';
            document.getElementById('editDescripcion').value = btn.dataset.descripcion || '';
            editIconoSelect.value = btn.dataset.icono || '';
            editIconPreview.className = btn.dataset.icono || '';
            editIconCode.textContent = btn.dataset.icono || '';
            document.getElementById('editActive').checked = btn.dataset.active == '1';
            document.getElementById('formEditarValor').action = `${document.body.dataset.valoresBaseUrl}/${btn.dataset.id}`;
            new bootstrap.Modal(document.getElementById('modalEditarValor')).show();

        });
    });

    // Eliminar valor: rellena el nombre y acción
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('delNombre').textContent = btn.dataset.nombre || '';
            document.getElementById('formEliminarValor').action = `${document.body.dataset.valoresBaseUrl}/${btn.dataset.id}`;
            new bootstrap.Modal(document.getElementById('modalEliminarValor')).show();
        });
    });

});
