// resources/js/documentos_gestion.js

document.addEventListener('DOMContentLoaded', () => {
    // Editar
    const editModal = new bootstrap.Modal(document.getElementById('modalEditar'));
    const formEdit = document.getElementById('formEditar');
    const eNombre = document.getElementById('editNombre');
    const eDesc = document.getElementById('editDescripcion');
    const eActive = document.getElementById('editActive');

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            eNombre.value = btn.dataset.nombre || '';
            eDesc.value = btn.dataset.descripcion || '';
            eActive.checked = parseInt(btn.dataset.active, 10) === 1;

            formEdit.action = `/admin/transparencia/documentos/${id}`;
            editModal.show();
        });
    });

    // PDF Preview
    const pdfModal = new bootstrap.Modal(document.getElementById('pdfModal'));
    const frame = document.getElementById('pdfFrame');
    const link = document.getElementById('pdfNewTab');

    document.querySelectorAll('.pdf-open').forEach(btn => {
        btn.addEventListener('click', () => {
            const url = btn.dataset.url;
            frame.src = url;
            link.href = url;
            pdfModal.show();
        });
    });

});
