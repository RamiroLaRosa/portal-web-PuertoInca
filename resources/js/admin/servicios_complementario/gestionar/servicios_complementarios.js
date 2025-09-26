// resources/js/admin/servicios_complementarios/gestionar/servicios_complementarios.js
'use strict';

document.addEventListener('DOMContentLoaded', () => {
    // ========= Helpers =========
    const $ = (sel, ctx = document) => ctx.querySelector(sel);
    const $$ = (sel, ctx = document) => Array.from(ctx.querySelectorAll(sel));

    function safeJsonParse(val, fallback = '') {
        if (val == null || val === '' || val === 'null') return fallback;
        try { return JSON.parse(val); } catch { return String(val); }
    }

    // ========= Modales / Formularios =========
    const modalEditarEl = $('#modalEditar');
    const modalEditar = modalEditarEl ? new bootstrap.Modal(modalEditarEl) : null;
    const formEdit = $('#formEditar');

    const modalImgEl = $('#modalImg');
    const modalImg = modalImgEl ? new bootstrap.Modal(modalImgEl) : null;
    const imgPrev = $('#imgPreview');
    const openImg = $('#openImgNewTab');

    // ========= Búsqueda local (si no usas el search.js global) =========
    // Usa la clase del input que está en el Blade: .search-input
    const searchInput = $('.search-input');
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const q = searchInput.value.trim().toLowerCase();
            $$('#tabla tbody tr').forEach(tr => {
                tr.style.display = tr.innerText.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    }

    // ========= Delegación de eventos =========
    document.addEventListener('click', (e) => {
        // --- Abrir modal EDITAR ---
        const editBtn = e.target.closest('.btn-edit');
        if (editBtn) {
            const id = editBtn.dataset.id;
            const nombre = editBtn.dataset.nombre || '';
            const subnombre = editBtn.dataset.subnombre || '';
            const descripcion = safeJsonParse(editBtn.dataset.descripcion, '');
            const ubicacion = editBtn.dataset.ubicacion || '';
            const personal = editBtn.dataset.personal || '';
            const isActive = parseInt(editBtn.dataset.active || '0', 10) === 1;

            // Si en Blade agregas: data-edit-url="{{ route('servicios.update', $row) }}"
            // tomará esa ruta; si no, usará el fallback de tu estructura actual.
            const editUrl = editBtn.dataset.editUrl || `/admin/servicios/gestionar/${id}`;

            const eNombre = $('#eNombre');
            const eSubnombre = $('#eSubnombre');
            const eDescripcion = $('#eDescripcion');
            const eUbicacion = $('#eUbicacion');
            const ePersonal = $('#ePersonal');
            const eActivo = $('#eActivo');

            if (eNombre) eNombre.value = nombre;
            if (eSubnombre) eSubnombre.value = subnombre;
            if (eDescripcion) eDescripcion.value = descripcion;
            if (eUbicacion) eUbicacion.value = ubicacion;
            if (ePersonal) ePersonal.value = personal;
            if (eActivo) eActivo.checked = isActive;

            if (formEdit) formEdit.action = editUrl;

            modalEditar?.show();
            return;
        }

        // --- Preparar modal ELIMINAR ---
        const delBtn = e.target.closest('.btn-delete');
        if (delBtn) {
            const url = delBtn.getAttribute('data-delete-url');
            const title = delBtn.getAttribute('data-title') || 'este servicio';

            const formEliminar = $('#formEliminar');
            const delTitle = $('#delTitulo');

            if (formEliminar && url) formEliminar.setAttribute('action', url);
            if (delTitle) delTitle.textContent = title;
            return;
        }

        // --- Ver IMAGEN ---
        const imgThumb = e.target.closest('.img-thumb');
        if (imgThumb) {
            const url = imgThumb.dataset.src || '';
            if (imgPrev) imgPrev.src = url;
            if (openImg) openImg.href = url || '#';
            modalImg?.show();
            return;
        }
    });

    // ========= (Opcional) Hook para DELETE vía fetch/AJAX =========
    // Si en el futuro quieres eliminar sin recargar y cerrar el modal manualmente:
    /*
    const formEliminar = $('#formEliminar');
    if (formEliminar) {
      formEliminar.addEventListener('submit', async (ev) => {
        ev.preventDefault();
        const url = formEliminar.action;
        const fd  = new FormData(formEliminar); // incluye _method=DELETE y CSRF
        const res = await fetch(url, { method: 'POST', body: fd });
        if (res.ok) {
          // Cierra el modal
          const modalEliminarEl = document.getElementById('modalEliminar');
          const modalEliminar = bootstrap.Modal.getInstance(modalEliminarEl);
          modalEliminar?.hide();
  
          // Quita la fila afectada (si pasas algún data-row-id, etc.)
          // document.querySelector(`[data-row="${id}"]`)?.remove();
          // O recarga:
          // location.reload();
        } else {
          console.error('Error al eliminar', await res.text());
        }
      });
    }
    */
});
