document.addEventListener('DOMContentLoaded', () => {
    const editModal = new bootstrap.Modal('#modalEditar');
    const formEdit = document.getElementById('formEditar');
    const eProg = document.getElementById('editPrograma');
    const eTipo = document.getElementById('editTipo');
    const eNombre = document.getElementById('editNombre');
    const eActive = document.getElementById('editActive');

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            eProg.value = btn.dataset.programa || '';
            eTipo.value = btn.dataset.tipo || '';
            eNombre.value = btn.dataset.nombre || '';
            eActive.checked = parseInt(btn.dataset.active, 10) === 1;

            formEdit.action = '/admin/beca/beneficiario/' + id;

            editModal.show();
        });
    });

    // Mostrar modal de nuevo si hay errores y viene de create
    if (window.becaBeneficiarioShowNuevoModal) {
        new bootstrap.Modal('#modalNuevo').show();
    }

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-delete');
        if (!btn) return;

        const url   = btn.getAttribute('data-url');
        const title = btn.getAttribute('data-title') || 'este beneficiario';

        const form = document.getElementById('formEliminar');
        const delTitle = document.getElementById('delTitulo');

        if (form && url) form.setAttribute('action', url);
        if (delTitle) delTitle.textContent = title;
    });
});
