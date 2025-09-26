// resources/js/locales.js

document.addEventListener('DOMContentLoaded', () => {
    const editModal = new bootstrap.Modal('#modalEditar');
    const form = document.getElementById('formEditar');

    const eDireccion = document.getElementById('eDireccion');
    const eTelefono = document.getElementById('eTelefono');
    const eCorreo = document.getElementById('eCorreo');
    const eHorario = document.getElementById('eHorario');
    const eLink = document.getElementById('eLink');
    const eActive = document.getElementById('eActive');

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;

            eDireccion.value = btn.dataset.direccion || '';
            eTelefono.value = btn.dataset.telefono || '';
            eCorreo.value = btn.dataset.correo || '';
            eHorario.value = btn.dataset.horario || '';
            // el link llega con entidades HTML, lo revertimos para edición
            eLink.value = decodeHtml(btn.dataset.link || '');
            eActive.checked = (btn.dataset.active === '1');

            form.action = `/admin/nosotros/locales/${id}`;
            editModal.show();
        });
    });

    function decodeHtml(html) {
        const txt = document.createElement('textarea');
        txt.innerHTML = html;
        return txt.value;
    }
});
