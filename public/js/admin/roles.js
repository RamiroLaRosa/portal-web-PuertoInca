document.addEventListener('DOMContentLoaded', () => {
    // ----- EDITAR (si ya lo tienes, puedes mantener tu bloque) -----
    const editButtons = document.querySelectorAll('.btn-edit-role');
    if (editButtons.length) {
        const formEditar = document.getElementById('formEditarRol');
        const inputNombre = document.getElementById('editRolNombre');
        const inputDesc = document.getElementById('editRolDescripcion');
        const modalEditEl = document.getElementById('modalEditarRol');
        const editModal = modalEditEl ? new bootstrap.Modal(modalEditEl) : null;

        editButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                if (!editModal) return;

                const id = btn.dataset.id;
                const name = btn.dataset.nombre || '';
                const desc = btn.dataset.descripcion || '';

                inputNombre.value = name;
                inputDesc.value = desc;

                // Acción PUT por ID
                formEditar.action = `{{ url('/admin/seguridad/roles') }}/${id}`;

                editModal.show();
            });
        });
    }

    // ----- ELIMINAR (modal de confirmación) -----
    const deleteButtons = document.querySelectorAll('.btn-delete-role');
    if (deleteButtons.length) {
        const deleteForm = document.getElementById('deleteRoleForm');
        const deleteNameSpan = document.getElementById('deleteRoleName');
        const modalDelEl = document.getElementById('modalEliminarRol');
        const deleteModal = modalDelEl ? new bootstrap.Modal(modalDelEl) : null;

        deleteButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                if (!deleteModal || !deleteForm) return;

                const id = btn.dataset.id;
                const name = btn.dataset.name || '';

                deleteNameSpan.textContent = name;
                // Acción DELETE por ID
                deleteForm.action = `{{ url('/admin/seguridad/roles') }}/${id}`;

                deleteModal.show();
            });
        });
    }
});