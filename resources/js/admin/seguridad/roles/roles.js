// resources/js/roles.js

document.addEventListener('DOMContentLoaded', function() {
    // Abrir modal de edición con datos
    document.querySelectorAll('.btn-edit-role').forEach(btn => {
        btn.addEventListener('click', function(ev) {
            ev.preventDefault();
            const modal = new bootstrap.Modal(document.getElementById('modalEditarRol'));
            document.getElementById('editRolNombre').value = btn.dataset.nombre || '';
            document.getElementById('editRolDescripcion').value = btn.dataset.descripcion || '';
            document.getElementById('formEditarRol').action = `/admin/seguridad/roles/${btn.dataset.id}`;
            modal.show();
        });
    });

    // Abrir modal de eliminación con nombre
    document.querySelectorAll('.btn-delete-role').forEach(btn => {
        btn.addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('modalEliminarRol'));
            document.getElementById('deleteRoleName').textContent = btn.dataset.name || '—';
            document.getElementById('deleteRoleForm').action = `/admin/seguridad/roles/${btn.dataset.id}`;
            modal.show();
        });
    });

    // Reabrir modal de "Nuevo rol" si hubo errores al crear
    if (document.body.innerHTML.includes('name="_from" value="create"') && document.body.innerHTML.includes('is-invalid')) {
        const modal = new bootstrap.Modal(document.getElementById('modalNuevoRol'));
        modal.show();
    }

});
