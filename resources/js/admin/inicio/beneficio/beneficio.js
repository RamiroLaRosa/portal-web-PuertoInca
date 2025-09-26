document.addEventListener('DOMContentLoaded', () => {
    // Preview ícono en "Nuevo"
    const iconCreate = document.getElementById('iconCreate');
    const iconCreatePreview = document.getElementById('iconCreatePreview');
    if (iconCreate) {
        iconCreate.addEventListener('change', () => {
            const cls = iconCreate.value || '';
            iconCreatePreview.innerHTML = cls ? `<i class="${cls}"></i>` : '';
        });
    }

    // -------- Editar ----------
    const modalEdit = new bootstrap.Modal(document.getElementById('modalEditarBeneficio'));
    const formEdit = document.getElementById('formEditarBeneficio');
    const eNombre = document.getElementById('editNombre');
    const eDesc = document.getElementById('editDescripcion');
    const eIconSel = document.getElementById('iconEdit');
    const eIconPrev = document.getElementById('iconEditPreview');
    const eActive = document.getElementById('editActive');

    if (eIconSel) {
        eIconSel.addEventListener('change', () => {
            const cls = eIconSel.value || '';
            eIconPrev.innerHTML = cls ? `<i class="${cls}"></i>` : '';
        });
    }

    document.querySelectorAll('.btn-edit-beneficio').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const nom = btn.dataset.nombre || '';
            const des = btn.dataset.descripcion || '';
            const ico = btn.dataset.icono || '';
            const act = btn.dataset.active === '1';

            eNombre.value = nom;
            eDesc.value = des;
            [...eIconSel.options].forEach(o => o.selected = (o.value === ico));
            eIconPrev.innerHTML = ico ? `<i class="${ico}"></i>` : '';
            eActive.checked = act;

            // acción PUT por ID
            formEdit.action = '/admin/inicio/beneficios/' + id;

            modalEdit.show();
        });
    });

    // -------- Eliminar ----------
    const modalDel = new bootstrap.Modal(document.getElementById('modalEliminarBeneficio'));
    const formDel = document.getElementById('formEliminarBeneficio');
    const delName = document.getElementById('delBeneficioNombre');

    document.querySelectorAll('.btn-delete-beneficio').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const name = btn.dataset.nombre || '';
            delName.textContent = name;

            // acción DELETE por ID
            formDel.action = '/admin/inicio/beneficios/' + id;

            modalDel.show();
        });
    });

    // Mostrar modal de nuevo si hay errores y viene de create
    if (window.beneficioShowNuevoModal) {
        new bootstrap.Modal(document.getElementById('modalNuevoBeneficio')).show();
    }
});
