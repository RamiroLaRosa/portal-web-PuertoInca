// resources/js/admin/nosotros/local/locales.js
document.addEventListener('DOMContentLoaded', () => {
    // ===== Modales existentes =====
    const modalEditEl = document.getElementById('modalEditar');
    const modalViewEl = document.getElementById('modalVerImagen');

    const editModal = modalEditEl ? new bootstrap.Modal(modalEditEl) : null;
    const viewModal = modalViewEl ? new bootstrap.Modal(modalViewEl) : null;

    // ===== Referencias EDITAR =====
    const formE = document.getElementById('formEditar');
    const eDireccion = document.getElementById('eDireccion');
    const eTelefono = document.getElementById('eTelefono');
    const eCorreo = document.getElementById('eCorreo');
    const eHorario = document.getElementById('eHorario');
    const eLink = document.getElementById('eLink');
    const eActive = document.getElementById('eActive');
    const eFoto = document.getElementById('eFoto');
    const eFotoPrev = document.getElementById('eFotoPreview');

    // ===== Abrir modal EDITAR =====
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            if (!editModal) return;
            eDireccion.value = btn.dataset.direccion || '';
            eTelefono.value = btn.dataset.telefono || '';
            eCorreo.value = btn.dataset.correo || '';
            eHorario.value = btn.dataset.horario || '';
            eLink.value = decodeHtml(btn.dataset.link || '');
            eActive.checked = (btn.dataset.active === '1');
            formE.action = btn.dataset.updateUrl || '#';
            if (eFotoPrev) eFotoPrev.src = btn.dataset.foto || '';
            if (eFoto) eFoto.value = '';
            editModal.show();
        });
    });

    // Preview imagen NUEVA (editar)
    if (eFoto && eFotoPrev) {
        eFoto.addEventListener('change', () => previewFile(eFoto, eFotoPrev));
    }

    // ===== Ver imagen en grande =====
    if (viewModal) {
        const imgFull = document.getElementById('imgPreviewFull');
        document.querySelectorAll('.btn-view-img').forEach(btn => {
            btn.addEventListener('click', () => {
                const src = btn.dataset.img || '';
                if (imgFull) imgFull.src = src;
                viewModal.show();
            });
        });
    }

    // ======== CREAR ========
    const btnNuevo = document.getElementById('btnNuevoLocal');
    const modalCrearEl = document.getElementById('modalCrear');
    const crearModal = modalCrearEl ? new bootstrap.Modal(modalCrearEl) : null;

    const cDireccion = document.getElementById('cDireccion');
    const cTelefono = document.getElementById('cTelefono');
    const cCorreo = document.getElementById('cCorreo');
    const cHorario = document.getElementById('cHorario');
    const cLink = document.getElementById('cLink');
    const cActive = document.getElementById('cActive');
    const cFoto = document.getElementById('cFoto');
    const cFotoPrev = document.getElementById('cFotoPreview');

    if (btnNuevo && crearModal) {
        btnNuevo.addEventListener('click', () => {
            // limpiar campos
            cDireccion.value = '';
            cTelefono.value = '';
            cCorreo.value = '';
            cHorario.value = '';
            cLink.value = '';
            cActive.checked = true;
            if (cFoto) cFoto.value = '';
            if (cFotoPrev) cFotoPrev.src = '';
            crearModal.show();
        });
    }

    if (cFoto && cFotoPrev) {
        cFoto.addEventListener('change', () => previewFile(cFoto, cFotoPrev));
    }

    // ======== ELIMINAR ========
    const delModalEl = document.getElementById('modalEliminar');
    const delModal = delModalEl ? new bootstrap.Modal(delModalEl) : null;
    const delName = document.getElementById('delNombre');
    const delForm = document.getElementById('formEliminar');

    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', () => {
            if (!delModal) return;
            const name = btn.dataset.name || 'el registro';
            const url = btn.dataset.deleteUrl || '#';
            if (delName) delName.textContent = name;
            if (delForm) delForm.action = url;
            delModal.show();
        });
    });

    // ===== Utils =====
    function decodeHtml(html) {
        const txt = document.createElement('textarea');
        txt.innerHTML = html;
        return txt.value;
    }
    function previewFile(input, img) {
        const f = input.files && input.files[0];
        if (!f) return;
        const allowed = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        if (!allowed.includes(f.type)) {
            alert('Formato no permitido. Usa JPG, PNG o WEBP.');
            input.value = '';
            return;
        }
        if (f.size > 4 * 1024 * 1024) {
            alert('La imagen supera el máximo de 4MB.');
            input.value = '';
            return;
        }
        const reader = new FileReader();
        reader.onload = ev => img.src = ev.target.result;
        reader.readAsDataURL(f);
    }
});
