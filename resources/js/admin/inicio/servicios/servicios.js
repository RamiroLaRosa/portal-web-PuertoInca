document.addEventListener('DOMContentLoaded', () => {
    // Preview ícono en nuevo servicio
    const select = document.getElementById('iconoSelect');
    const preview = document.getElementById('iconPreview');
    if (select) {
        select.addEventListener('change', () => {
            const cls = select.value || '';
            preview.innerHTML = cls ? `<i class="${cls}"></i>` : '';
        });
    }

    // Editar servicio
    const modalEdit = new bootstrap.Modal(document.getElementById('modalEditarServicio'));
    const formEdit = document.getElementById('formEditarServicio');
    const nombreInp = document.getElementById('editNombre');
    const descInp = document.getElementById('editDescripcion');
    const iconSel = document.getElementById('iconoEditSelect');
    const iconPrev = document.getElementById('iconoEditPreview');
    const activoChk = document.getElementById('editActivo');

    if (iconSel) {
        iconSel.addEventListener('change', () => {
            const cls = iconSel.value || '';
            iconPrev.innerHTML = cls ? `<i class="${cls}"></i>` : '';
        });
    }

    document.querySelectorAll('.btn-edit-servicio').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const nom = btn.dataset.nombre || '';
            const des = btn.dataset.descripcion || '';
            const ico = btn.dataset.icono || '';
            const act = btn.dataset.active === '1';

            nombreInp.value = nom;
            descInp.value = des;
            [...iconSel.options].forEach(opt => opt.selected = (opt.value === ico));
            iconPrev.innerHTML = ico ? `<i class="${ico}"></i>` : '';
            activoChk.checked = act;

            formEdit.action = window.serviciosEditUrlBase + '/' + id;
            modalEdit.show();
        });
    });

    // Eliminar servicio
    const modalDel = new bootstrap.Modal(document.getElementById('modalEliminarServicio'));
    const formDel = document.getElementById('formDeleteServicio');
    const nameSpan = document.getElementById('delServicioNombre');

    document.querySelectorAll('.btn-delete-servicio').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const name = btn.dataset.nombre || '';
            nameSpan.textContent = name;
            formDel.action = window.serviciosEditUrlBase + '/' + id;
            modalDel.show();
        });
    });

    // Mostrar modalNuevo si hay errores y se intentó crear
    if (window.showModalNuevoOnError) {
        const modal = new bootstrap.Modal(document.getElementById('modalNuevoServicio'));
        modal.show();
    }
});
