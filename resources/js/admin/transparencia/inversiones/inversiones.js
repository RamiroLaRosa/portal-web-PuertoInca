// resources/js/inversiones.js

document.addEventListener('DOMContentLoaded', () => {
    const modalEdit = new bootstrap.Modal(document.getElementById('modalEditar'));
    const formEdit = document.getElementById('formEditar');
    const eNombre = document.getElementById('eNombre');
    const eDesc = document.getElementById('eDescripcion');
    const eTipo = document.getElementById('eTipo');
    const eActivo = document.getElementById('eActivo');

    // abrir modal de editar
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            eNombre.value = btn.dataset.nombre || '';
            eDesc.value = btn.dataset.descripcion || '';
            eTipo.value = btn.dataset.tipo || '';
            eActivo.checked = parseInt(btn.dataset.active, 10) === 1;

            formEdit.action = `/admin/transparencia/inversiones/${id}`;

            modalEdit.show();
        });
    });

    // preview PDF
    const pdfFrame = document.getElementById('pdfFrame');
    const openPdfBtn = document.getElementById('openPdfNewTab');
    const modalPdf = new bootstrap.Modal(document.getElementById('modalPdf'));

    document.querySelectorAll('.pdf-thumb.clickable').forEach(el => {
        el.addEventListener('click', () => {
            const url = el.dataset.src;
            pdfFrame.src = url;
            openPdfBtn.href = url;
            modalPdf.show();
        });
    });

    // preview Imagen
    const imgEl = document.getElementById('imgPreview');
    const openImg = document.getElementById('openImgNewTab');
    const modalImg = new bootstrap.Modal(document.getElementById('modalImg'));

    document.querySelectorAll('.img-thumb.clickable').forEach(el => {
        el.addEventListener('click', () => {
            const url = el.dataset.src;
            imgEl.src = url;
            openImg.href = url;
            modalImg.show();
        });
    });

});
