// resources/js/noticias.js

document.addEventListener('DOMContentLoaded', () => {
    // Preview imagen
    const modalImg = new bootstrap.Modal('#modalImg');
    const imgEl = document.getElementById('imgPreview');
    const openNewTab = document.getElementById('openImgNewTab');

    document.querySelectorAll('.img-thumb').forEach(el => {
        el.addEventListener('click', () => {
            const src = el.dataset.src;
            if (!src) return;
            imgEl.src = src;
            openNewTab.href = src;
            modalImg.show();
        });
    });

    // Editar
    const modalEdit = new bootstrap.Modal('#modalEditar');
    const formEdit = document.getElementById('formEditar');
    const eTitulo = document.getElementById('eTitulo');
    const eDesc = document.getElementById('eDescripcion');
    const eFecha = document.getElementById('eFecha');
    const eActivo = document.getElementById('eActivo');

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            eTitulo.value = btn.dataset.titulo || '';
            eDesc.value = btn.dataset.descripcion || '';
            eFecha.value = btn.dataset.fecha || '';
            eActivo.checked = parseInt(btn.dataset.active, 10) === 1;

            formEdit.action = `/admin/noticias/${id}`;
            modalEdit.show();
        });
    });

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-delete');
        if (!btn) return;

        const url = btn.getAttribute('data-delete-url');
        const title = btn.getAttribute('data-title') || 'esta noticia';

        const form = document.getElementById('formEliminar');
        const delTitle = document.getElementById('delTitulo');

        if (form) form.setAttribute('action', url);
        if (delTitle) delTitle.textContent = title;
    });
});

document.addEventListener('click', (e) => {
    const btn = e.target.closest('.btn-edit');
    if (!btn) return;

    const f = document.getElementById('formEditar');
    f.action = btn.dataset.updateUrl;

    document.getElementById('eTitulo').value = btn.dataset.titulo || '';
    document.getElementById('eDescripcion').value = btn.dataset.descripcion || '';
    document.getElementById('eFecha').value = btn.dataset.fecha || '';
    document.getElementById('eActivo').checked = btn.dataset.active === '1';

    // Documento actual
    const link = document.getElementById('eDocumentoLink');
    const noDoc = document.getElementById('eSinDocumento');
    const url = btn.dataset.documentoUrl;

    if (url) {
        link.href = url;
        link.classList.remove('d-none');
        noDoc.classList.add('d-none');
    } else {
        link.classList.add('d-none');
        noDoc.classList.remove('d-none');
    }

    new bootstrap.Modal(document.getElementById('modalEditar')).show();
});

// Preview de imagen que ya tenías
document.addEventListener('click', (e) => {
    const thumb = e.target.closest('.img-thumb');
    if (!thumb || !thumb.dataset.src) return;
    const src = thumb.dataset.src;
    document.getElementById('imgPreview').src = src;
    document.getElementById('openImgNewTab').href = src;
    new bootstrap.Modal(document.getElementById('modalImg')).show();
});

document.addEventListener('DOMContentLoaded', () => {
    const modalEl = document.getElementById('modalEliminar');
    const modal = new bootstrap.Modal(modalEl);
    const formDel = document.getElementById('formEliminar');
    const delTitle = document.getElementById('delTitulo');

    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.btn-delete');
        if (!btn) return;

        const url = btn.getAttribute('data-delete-url');
        const title = btn.getAttribute('data-title') || 'esta noticia';

        // setea la acción del form del modal y el título mostrado
        formDel.setAttribute('action', url);
        delTitle.textContent = title;

        modal.show();
    });
});
