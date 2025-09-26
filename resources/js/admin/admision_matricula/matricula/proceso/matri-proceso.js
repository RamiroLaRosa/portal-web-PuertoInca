document.addEventListener('DOMContentLoaded', () => {
    const editModal = new bootstrap.Modal('#modalEditar');
    const formEdit = document.getElementById('formEditar');
    const eNum = document.getElementById('editNumero');
    const eTit = document.getElementById('editTitulo');
    const eDesc = document.getElementById('editDesc');
    const eAct = document.getElementById('editActive');

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            eNum.value = btn.dataset.numero || 1;
            eTit.value = btn.dataset.titulo || '';
            eDesc.value = btn.dataset.desc || '';
            eAct.checked = parseInt(btn.dataset.active, 10) === 1;

            // URL PUT correcta
            formEdit.action = '/admin/matricula/pasos/' + id;

            editModal.show();
        });
    });

    // Mostrar modal de nuevo si hay errores y viene de create
    if (window.matriPasosShowNuevoModal) {
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
