document.addEventListener('DOMContentLoaded', () => {
    // Preview icono en "Nuevo"
    const cSel = document.getElementById('createIcono');
    const cPrev = document.getElementById('createIconPreview');
    if (cSel) cSel.addEventListener('change', () => {
        cPrev.innerHTML = `<i class="${cSel.value}"></i>`;
    });

    // Editar
    const editModal = new bootstrap.Modal('#modalEditar');
    const formEdit = document.getElementById('formEditar');
    const eTit = document.getElementById('editTitulo');
    const eDes = document.getElementById('editDescripcion');
    const eIco = document.getElementById('editIcono');
    const ePrev = document.getElementById('editIconPreview');
    const eAct = document.getElementById('editActive');

    if (eIco) eIco.addEventListener('change', () => {
        ePrev.innerHTML = `<i class="${eIco.value}"></i>`;
    });

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            eTit.value = btn.dataset.titulo || '';
            eDes.value = btn.dataset.descripcion || '';
            eIco.value = btn.dataset.icono || '';
            ePrev.innerHTML = eIco.value ? `<i class="${eIco.value}"></i>` :
                '<i class="fa-regular fa-circle-question"></i>';
            eAct.checked = parseInt(btn.dataset.active, 10) === 1;

            formEdit.action = `/admin/admision/exonerados/${id}`;

            editModal.show();
        });
    });

    // Mostrar modal de nuevo si hay errores y viene de create
    if (window.exoneradosShowNuevoModal) {
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
