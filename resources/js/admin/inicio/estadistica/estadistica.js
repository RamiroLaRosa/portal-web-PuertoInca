document.addEventListener('DOMContentLoaded', () => {
    // ----- Preview de íconos -----
    const iconCreate = document.getElementById('iconCreate');
    const iconCreatePreview = document.getElementById('iconCreatePreview');
    if (iconCreate) {
        iconCreate.addEventListener('change', () => {
            const cls = iconCreate.value || '';
            iconCreatePreview.innerHTML = cls ? `<i class="${cls}"></i>` : '';
        });
    }
    const iconEdit = document.getElementById('iconEdit');
    const iconEditPreview = document.getElementById('iconEditPreview');
    if (iconEdit) {
        iconEdit.addEventListener('change', () => {
            const cls = iconEdit.value || '';
            iconEditPreview.innerHTML = cls ? `<i class="${cls}"></i>` : '';
        });
    }

    // ----- Editar -----
    const modalEditar = new bootstrap.Modal(document.getElementById('modalEditar'));
    const formEditar = document.getElementById('formEditar');
    const editDesc = document.getElementById('editDescripcion');
    const editCant = document.getElementById('editCantidad');
    const editActive = document.getElementById('editActive');

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const ico = btn.dataset.icono || '';
            const des = btn.dataset.descripcion || '';
            const cant = btn.dataset.cantidad || 0;
            const act = btn.dataset.active === '1';

            [...iconEdit.options].forEach(o => o.selected = (o.value === ico));
            iconEditPreview.innerHTML = ico ? `<i class="${ico}"></i>` : '';
            editDesc.value = des;
            editCant.value = cant;
            editActive.checked = act;

            formEditar.action = '/admin/inicio/estadistica/' + id;

            modalEditar.show();

        });
    });

    // ----- Eliminar -----
    const modalEliminar = new bootstrap.Modal(document.getElementById('modalEliminar'));
    const formEliminar = document.getElementById('formEliminar');
    const delNombre = document.getElementById('delNombre');

    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const name = btn.dataset.descripcion || '';
            delNombre.textContent = name;

            formEliminar.action = '/admin/inicio/estadistica/' + id;
            modalEliminar.show();
        });
    });

    // Mostrar modalNuevo si hay errores y se intentó crear
    if (window.showModalNuevoOnError) {
        new bootstrap.Modal(document.getElementById('modalNuevo')).show();
    }
});
