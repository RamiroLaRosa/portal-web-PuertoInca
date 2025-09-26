// resources/js/licenciamiento.js

document.addEventListener('DOMContentLoaded', () => {
    const modalEdit = new bootstrap.Modal(document.getElementById('modalEditar'));
    const formEdit = document.getElementById('formEditar');
    const eNombre = document.getElementById('eNombre');
    const eDesc = document.getElementById('eDescripcion');
    const eActivo = document.getElementById('eActivo');

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            eNombre.value = btn.dataset.nombre || '';
            eDesc.value = btn.dataset.descripcion || '';
            eActivo.checked = parseInt(btn.dataset.active, 10) === 1;

            formEdit.action = `/admin/transparencia/licenciamiento/${id}`;
            modalEdit.show();
        });
    });

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
