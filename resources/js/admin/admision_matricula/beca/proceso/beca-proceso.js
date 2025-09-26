document.addEventListener('DOMContentLoaded', () => {
    const editModal = new bootstrap.Modal('#modalEditar');
    const formEdit = document.getElementById('formEditar');

    const eNro = document.getElementById('editNro');
    const eTit = document.getElementById('editTitulo');
    const eDesc = document.getElementById('editDesc');
    const eAct = document.getElementById('editActive');

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            eNro.value = btn.dataset.nro_paso || 1;
            eTit.value = btn.dataset.titulo || '';
            eDesc.value = btn.dataset.descripcion || '';
            eAct.checked = parseInt(btn.dataset.active, 10) === 1;

            // Construye la URL del PUT con el ID
            formEdit.action = '/admin/beca/pasos/' + id;

            editModal.show();
        });
    });

    // Mostrar modal de nuevo si hay errores y viene de create
    if (window.becaPasosShowNuevoModal) {
        new bootstrap.Modal('#modalNuevo').show();
    }

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-delete');
        if (!btn) return;

        const url   = btn.getAttribute('data-url');
        const title = btn.getAttribute('data-title') || 'este registro';

        const form = document.getElementById('formEliminar');
        const delTitle = document.getElementById('delTitulo');

        if (form && url) form.setAttribute('action', url);
        if (delTitle) delTitle.textContent = title;
    });
});
