// resources/js/horarios_servicios.js

document.addEventListener('DOMContentLoaded', () => {
    const modalEdit = new bootstrap.Modal(document.getElementById('modalEditar'));
    const formEdit = document.getElementById('formEditar');
    const eServicio = document.getElementById('eServicio');
    const eLV = document.getElementById('eLV');
    const eSab = document.getElementById('eSab');
    const eDom = document.getElementById('eDom');
    const eContacto = document.getElementById('eContacto');
    const eActivo = document.getElementById('eActivo');

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            eServicio.value = btn.dataset.servicio;
            eLV.value = btn.dataset.lv || '';
            eSab.value = btn.dataset.sab || '';
            eDom.value = btn.dataset.dom || '';
            eContacto.value = btn.dataset.contacto || '';
            eActivo.checked = parseInt(btn.dataset.active, 10) === 1;

            formEdit.action = `/admin/servicios_complementario/horarios/${id}`;
            modalEdit.show();
        });
    });

    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.btn-delete');
        if (!btn) return;
        const form = document.getElementById('formEliminar');
        if (!form) return;
        form.action = btn.dataset.deleteUrl;
        const delTitle = document.getElementById('delTitulo');
        if (delTitle) delTitle.textContent = btn.dataset.title || 'este registro';
    });
});
