// resources/js/resenia.js

document.addEventListener('DOMContentLoaded', function () {
    // Preview imagen
    document.querySelectorAll('.btn-preview-img').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('previewImg').src = btn.dataset.src || '';
            document.getElementById('previewTitle').textContent = btn.dataset.title || 'Vista previa';
            new bootstrap.Modal(document.getElementById('modalPreviewImg')).show();
        });
    });

    // Editar
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('editTitulo').value = btn.dataset.titulo || '';
            document.getElementById('editDescripcion').value = btn.dataset.descripcion || '';
            document.getElementById('editImgPreview').src = btn.dataset.img || '';
            document.getElementById('editActive').checked = btn.dataset.active == '1';
            document.getElementById('formEditar').action = `${document.body.dataset.reseniaBaseUrl}/${btn.dataset.id}`;

            // ⬅️ Esto faltaba
            new bootstrap.Modal(document.getElementById('modalEditar')).show();
        });
    });

    // Eliminar
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('delTitulo').textContent = btn.dataset.titulo || '';
            document.getElementById('formEliminar').action = `${document.body.dataset.reseniaBaseUrl}/${btn.dataset.id}`;

            new bootstrap.Modal(document.getElementById('modalEliminar')).show();
        });
    });

    // Reabrir modal "Nuevo" si hubo errores
    if (document.body.dataset.openNew === '1') {
        new bootstrap.Modal(document.getElementById('modalNuevo')).show();
    }
});
