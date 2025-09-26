document.addEventListener('DOMContentLoaded', () => {
    const editModal = new bootstrap.Modal('#modalEditar');
    const formEdit = document.getElementById('formEditar');
    const eTitulo = document.getElementById('editTitulo');
    const eFecha = document.getElementById('editFecha');
    const eDesc = document.getElementById('editDescripcion');
    const eIcono = document.getElementById('editIcono');
    const eActive = document.getElementById('editActive');

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            eTitulo.value = btn.dataset.titulo || '';
            eFecha.value = btn.dataset.fecha || '';
            eDesc.value = btn.dataset.descripcion || '';
            eIcono.value = btn.dataset.icono || '';
            eActive.checked = parseInt(btn.dataset.active, 10) === 1;

            // Acción PUT correcta con el id
            formEdit.action = '/admin/matricula/cronograma/' + id; // O usa una variable global si la tienes
            editModal.show();
        });
    });

    // Mostrar modal de nuevo si hay errores y viene de create
    if (window.matriCronogramaShowNuevoModal) {
        new bootstrap.Modal('#modalNuevo').show();
    }

    document.addEventListener('click', function(e) {
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
