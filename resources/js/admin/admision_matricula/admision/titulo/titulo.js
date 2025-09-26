document.addEventListener('DOMContentLoaded', () => {
    // Preview imagen
    const prevModal = new bootstrap.Modal('#modalPreviewImg');
    document.querySelectorAll('.btn-preview-img').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('previewImg').src = btn.dataset.src || '';
            document.getElementById('previewTitle').textContent = btn.dataset.title || 'Vista previa';
            prevModal.show();
        });
    });

    // Editar
    const editModal = new bootstrap.Modal('#modalEditar');
    const formEdit = document.getElementById('formEditar');
    const eTitulo = document.getElementById('editTitulo');
    const eDesc = document.getElementById('editDescripcion');
    const eImgPrev = document.getElementById('editImgPreview');
    const eActive = document.getElementById('editActive');

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const title = btn.dataset.titulo || '';
            const desc = btn.dataset.descripcion || '';
            const img = btn.dataset.img || '';
            const act = parseInt(btn.dataset.active, 10) === 1;

            eTitulo.value = title;
            eDesc.value = desc;
            eImgPrev.src = img;
            eActive.checked = act;

            formEdit.action = `/admin/admision/titulo/${id}`;
            editModal.show();
        });
    });

    // Mostrar modalNuevo si hay errores y se intentó crear
    if (window.showModalNuevoOnError) {
        new bootstrap.Modal('#modalNuevo').show();
    }
});
