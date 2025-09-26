document.addEventListener('DOMContentLoaded', () => {
    const editModal = new bootstrap.Modal('#modalEditar');
    const formEdit = document.getElementById('formEditar');

    const eTitulo = document.getElementById('editTitulo');
    const eDescripcion = document.getElementById('editDescripcion');
    const eIcono = document.getElementById('editIcono');
    const eActive = document.getElementById('editActive');

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id     = btn.dataset.id;
            const titulo = btn.dataset.titulo || '';
            const desc   = btn.dataset.descripcion || '';
            const icono  = btn.dataset.icono || '';
            const active = parseInt(btn.dataset.active, 10) === 1;

            eTitulo.value = titulo;
            eDescripcion.value = desc;
            eIcono.value = icono;
            eActive.checked = active;

            // Acción PUT al recurso (id)
            formEdit.action = '/admin/matricula/tipos/' + id;

            editModal.show();
        });
    });

    // Mostrar modal de nuevo si hay errores y viene de create
    if (window.matriTiposShowNuevoModal) {
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
