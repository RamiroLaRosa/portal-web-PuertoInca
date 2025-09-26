document.addEventListener('DOMContentLoaded', () => {
    // Preview de icono en "Nuevo"
    const createIconSelect = document.getElementById('createIcono');
    const createIconPreview = document.getElementById('createIconPreview');
    if (createIconSelect) {
        const upd = () => {
            createIconPreview.innerHTML = `<i class="${createIconSelect.value}"></i>`;
        };
        createIconSelect.addEventListener('change', upd);
    }

    // Editar
    const editModal = new bootstrap.Modal('#modalEditar');
    const formEdit = document.getElementById('formEditar');
    const eTitulo = document.getElementById('editTitulo');
    const eDesc = document.getElementById('editDescripcion');
    const eIcon = document.getElementById('editIcono');
    const eIconPrev = document.getElementById('editIconPreview');
    const eActive = document.getElementById('editActive');

    if (eIcon) {
        const upd2 = () => {
            eIconPrev.innerHTML = `<i class="${eIcon.value}"></i>`;
        };
        eIcon.addEventListener('change', upd2);
    }

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const titulo = btn.dataset.titulo || '';
            const desc = btn.dataset.descripcion || '';
            const icono = btn.dataset.icono || '';
            const act = parseInt(btn.dataset.active, 10) === 1;

            eTitulo.value = titulo;
            eDesc.value = desc;
            eIcon.value = icono;
            eIconPrev.innerHTML = icono ? `<i class="${icono}"></i>` :
                '<i class="fa-regular fa-circle-question"></i>';
            eActive.checked = act;

            formEdit.action = `/admin/admision/modalidades/${id}`;
            editModal.show();
        });
    });

    // Mostrar modal de nuevo si hay errores y viene de create
    if (window.adminModalidadesShowNuevoModal) {
        new bootstrap.Modal('#modalNuevo').show();
    }
});
