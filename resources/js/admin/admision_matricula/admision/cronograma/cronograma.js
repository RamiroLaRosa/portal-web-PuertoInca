

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
    const eFecha = document.getElementById('editFecha');
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
            eTitulo.value = btn.dataset.titulo || '';
            eFecha.value = btn.dataset.fecha || '';
            eDesc.value = btn.dataset.descripcion || '';
            eIcon.value = btn.dataset.icono || '';
            eIconPrev.innerHTML = eIcon.value ? `<i class="${eIcon.value}"></i>` :
                '<i class="fa-regular fa-circle-question"></i>';
            eActive.checked = parseInt(btn.dataset.active, 10) === 1;

            formEdit.action = `/admin/admision/cronograma/${id}`;

            editModal.show();
        });
    });

    if (window.cronogramaShowNuevoModal) {
        new bootstrap.Modal('#modalNuevo').show();
    }

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-delete');
        if (!btn) return;

        const url = btn.getAttribute('data-url');
        const title = btn.getAttribute('data-title') || 'este registro';

        const form = document.getElementById('formEliminar');
        const delTitle = document.getElementById('delTitulo');

        if (form && url) form.setAttribute('action', url);
        if (delTitle) delTitle.textContent = title;
    });
});
