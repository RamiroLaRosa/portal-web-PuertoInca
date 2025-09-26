document.addEventListener('DOMContentLoaded', () => {
    const modalEdit = new bootstrap.Modal('#modalEditar');
    const formEdit = document.getElementById('formEditar');
    const eTel = document.getElementById('eTelefono');
    const eWsp = document.getElementById('eWhatsapp');
    const eMail = document.getElementById('eCorreo');
    const eEme = document.getElementById('eEmergencia');
    const eDir = document.getElementById('eDireccion');
    const eAct = document.getElementById('eActivo');

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            eTel.value = btn.dataset.telefono || '';
            eWsp.value = btn.dataset.whatsapp || '';
            eMail.value = btn.dataset.correo || '';
            eEme.value = btn.dataset.emergencia || '';
            eDir.value = btn.dataset.direccion || '';
            eAct.checked = parseInt(btn.dataset.active, 10) === 1;

            formEdit.action = '/admin/contactanos/' + id;

            modalEdit.show();
        });
    });

    // Mostrar modal de nuevo si hay errores y viene de create
    if (window.contactanosShowNuevoModal) {
        new bootstrap.Modal('#modalCrear').show();
    }

    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-delete');
        if (!btn) return;

        const url = btn.getAttribute('data-delete-url');
        const title = btn.getAttribute('data-title') || 'este registro';

        const form = document.getElementById('formEliminar');
        const delTitle = document.getElementById('delTitulo');

        form.setAttribute('action', url);
        delTitle.textContent = title;
    });
});
