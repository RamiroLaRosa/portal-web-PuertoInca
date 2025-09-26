// resources/js/administradores.js

document.addEventListener('DOMContentLoaded', function() {
    // Abrir modal de edición con datos
    document.querySelectorAll('.btn-edit-administrador').forEach(btn => {
        btn.addEventListener('click', function(ev) {
            ev.preventDefault();
            const modal = new bootstrap.Modal(document.getElementById('modalEditarAdministrador'));
            document.getElementById('editAdministradorCodigo').value = btn.dataset.codigo || '';
            document.getElementById('editAdministradorApellidos').value = btn.dataset.apellidos || '';
            document.getElementById('editAdministradorNombres').value = btn.dataset.nombres || '';
            document.getElementById('editAdministradorCorreo').value = btn.dataset.correo || '';
            document.getElementById('editAdministradorCelular').value = btn.dataset.celular || '';
            document.getElementById('editAdministradorRol').value = btn.dataset.id_rol || '';
            document.getElementById('editAdministradorTipoDocumento').value = btn.dataset.id_tipo_documento || '';
            document.getElementById('editAdministradorIsActive').value = btn.dataset.is_active || '';
            document.getElementById('formEditarAdministrador').action = `/admin/seguridad/administradores/${btn.dataset.id}`;
            modal.show();
        });
    });

    // Abrir modal de eliminación con nombre
    document.querySelectorAll('.btn-delete-administrador').forEach(btn => {
        btn.addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('modalEliminarAdministrador'));
            document.getElementById('deleteAdministradorName').textContent = btn.dataset.name || '—';
            document.getElementById('deleteAdministradorForm').action = `/admin/seguridad/administradores/${btn.dataset.id}`;
            modal.show();
        });
    });

    document.querySelectorAll('.btn-password-administrador').forEach(btn => {
        btn.addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('modalPasswordAdministrador'));
            document.getElementById('passwordAdministradorName').textContent = btn.dataset.name || '—';
            document.getElementById('formPasswordAdministrador').action = `/admin/seguridad/administradores/${btn.dataset.id}/password`;
            document.getElementById('passwordAdministradorNew').value = '';
            modal.show();
        });
    });

    document.getElementById('togglePassword')?.addEventListener('click', function() {
        const input = document.getElementById('administradorPassword');
        if (input.type === 'password') {
            input.type = 'text';
            this.innerHTML = '<i class="fa fa-eye-slash"></i>';
        } else {
            input.type = 'password';
            this.innerHTML = '<i class="fa fa-eye"></i>';
        }
    });

    document.getElementById('togglePasswordNew')?.addEventListener('click', function() {
        const input = document.getElementById('passwordAdministradorNew');
        if (input.type === 'password') {
            input.type = 'text';
            this.innerHTML = '<i class="fa fa-eye-slash"></i>';
        } else {
            input.type = 'password';
            this.innerHTML = '<i class="fa fa-eye"></i>';
        }
    });

    // Reabrir modal de "Nuevo administrador" si hubo errores al crear
    if (document.body.innerHTML.includes('name="_from" value="create"') && document.body.innerHTML.includes('is-invalid')) {
        const modal = new bootstrap.Modal(document.getElementById('modalNuevoAdministrador'));
        modal.show();
    }

});
