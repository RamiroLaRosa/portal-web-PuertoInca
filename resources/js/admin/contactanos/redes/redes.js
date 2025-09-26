// resources/js/admin/contactanos/redes/redes.js
'use strict';

document.addEventListener('DOMContentLoaded', () => {
    // ======= Bootstrap Modals =======
    const modalEditEl = document.getElementById('modalEditar');
    const modalEdit = modalEditEl ? new bootstrap.Modal(modalEditEl) : null;
    const modalNuevoEl = document.getElementById('modalNuevo');
    const modalNuevo = modalNuevoEl ? new bootstrap.Modal(modalNuevoEl) : null;

    // ======= Formularios / Inputs =======
    const formEdit = document.getElementById('formEditar');
    const eNombre = document.getElementById('eNombre');
    const eEnlace = document.getElementById('eEnlace');
    const eIconoSel = document.getElementById('eIcono');       // SELECT en Editar
    const eActivo = document.getElementById('eActivo');
    const prevEdit = document.getElementById('iconPreviewEdit');

    const nIconoSel = document.getElementById('nIcono');        // SELECT en Nuevo
    const prevNew = document.getElementById('iconPreviewNew');

    // ======= Preview: NUEVO =======
    if (nIconoSel && prevNew) {
        // inicial
        prevNew.className = nIconoSel.value || '';
        // on change
        nIconoSel.addEventListener('change', () => {
            prevNew.className = nIconoSel.value || '';
        });
    }

    // ======= Abrir modal EDITAR (botones amarillos) =======
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const nombre = btn.dataset.nombre || '';
            const enlace = btn.dataset.enlace || '';
            const icono = btn.dataset.icono || '';   // valor: "fa-brands fa-facebook-f"
            const isAct = parseInt(btn.dataset.active || '0', 10) === 1;

            if (eNombre) eNombre.value = nombre;
            if (eEnlace) eEnlace.value = enlace;

            // Setear SELECT del icono (y crear opción temporal si no existe)
            if (eIconoSel) {
                eIconoSel.value = icono;
                if (eIconoSel.value !== icono && icono) {
                    // no existe en el catálogo -> crea opción temporal para no perder el valor actual
                    const opt = document.createElement('option');
                    opt.value = icono;
                    opt.textContent = '(Personalizado)';
                    opt.dataset.temp = '1';
                    eIconoSel.appendChild(opt);
                    eIconoSel.value = icono;
                }
            }

            if (prevEdit) prevEdit.className = (eIconoSel?.value || '');

            if (eActivo) eActivo.checked = isAct;

            // Ruta de update: usa data-edit-url si viene desde Blade, si no fallback
            const editUrl = btn.dataset.editUrl || ('/admin/redes/' + id);
            if (formEdit) formEdit.action = editUrl;

            modalEdit?.show();
        });
    });

    // Preview en EDITAR al cambiar el select
    if (eIconoSel && prevEdit) {
        eIconoSel.addEventListener('change', () => {
            prevEdit.className = eIconoSel.value || '';
        });
    }

    // ======= Mostrar modal NUEVO si hubo errores de validación en create =======
    if (window.redesShowNuevoModal && modalNuevo) {
        modalNuevo.show();
    }

    // ======= Modal ELIMINAR: set action + título =======
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-delete');
        if (!btn) return;

        const url = btn.getAttribute('data-delete-url');
        const title = btn.getAttribute('data-title') || 'este registro';

        const form = document.getElementById('formEliminar');
        const delTitle = document.getElementById('delTitulo');

        if (form && url) form.setAttribute('action', url);
        if (delTitle) delTitle.textContent = title;
    });
});
