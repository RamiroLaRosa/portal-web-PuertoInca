document.addEventListener('DOMContentLoaded', () => {
    const editModal = new bootstrap.Modal('#modalEditar');
    const formEdit = document.getElementById('formEditar');
    const eProg = document.getElementById('editPrograma');
    const eVac = document.getElementById('editVacantes');
    const eAct = document.getElementById('editActive');

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            eProg.value = btn.dataset.programa || '';
            eVac.value = btn.dataset.vacantes || 0;
            eAct.checked = parseInt(btn.dataset.active, 10) === 1;

            // URL PUT correcta
            formEdit.action = `/admin/admision/vacantes/${id}`;
            editModal.show();
        });
    });

    // Mostrar modalNuevo si hay errores y se intentó crear
    if (window.showModalNuevoOnError) {
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
