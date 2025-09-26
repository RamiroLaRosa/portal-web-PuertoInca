document.addEventListener('DOMContentLoaded', () => {
    /* ---------- rutas dinámicas desde Blade ---------- */
    const URL_UPDATE_TPL = "{{ route('links.update', '__ID__') }}";

    /* ---------- modales / form ---------- */
    const modalEdit = new bootstrap.Modal('#modalEditar');
    const formEdit = document.getElementById('formEditar');
    const eNombre = document.getElementById('eNombre');
    const eEnlace = document.getElementById('eEnlace');
    const eActivo = document.getElementById('eActivo');

    /* ---------- delegación de clicks ---------- */
    document.addEventListener('click', e => {
        const btn = e.target.closest('.btn-edit');
        if (!btn) return;

        const id = btn.dataset.id;
        const nombre = btn.dataset.nombre || '';
        const enlace = btn.dataset.enlace || '';
        const activo = parseInt(btn.dataset.active, 10) === 1;

        eNombre.value = nombre;
        eEnlace.value = enlace;
        eActivo.checked = activo;

        formEdit.action = URL_UPDATE_TPL.replace('__ID__', id);
        modalEdit.show();
    });

    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-delete');
        if (!btn) return;

        const url = btn.getAttribute('data-delete-url');
        const title = btn.getAttribute('data-title') || 'este registro';

        const form = document.getElementById('formEliminar');
        const delTitle = document.getElementById('delTitulo');

        if (form) form.setAttribute('action', url);
        if (delTitle) delTitle.textContent = title;
    });
});