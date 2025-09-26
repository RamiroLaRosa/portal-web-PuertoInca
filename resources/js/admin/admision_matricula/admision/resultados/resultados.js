document.addEventListener('DOMContentLoaded', () => {
    // Preview PDF
    const pdfModal = new bootstrap.Modal('#modalPreviewPdf');
    const pdfFrame = document.getElementById('pdfFrame');
    const pdfTitle = document.getElementById('pdfTitle');
    const pdfNewTab = document.getElementById('pdfNewTab');

    document.querySelectorAll('.btn-preview-pdf').forEach(btn => {
        btn.addEventListener('click', () => {
            const url = btn.dataset.src || '#';
            const title = btn.dataset.title || 'Vista previa';
            pdfFrame.src = url;
            pdfTitle.textContent = title;
            pdfNewTab.href = url;
            pdfModal.show();
        });
    });

    // Editar
    const editModal = new bootstrap.Modal('#modalEditar');
    const formEdit = document.getElementById('formEditar');
    const eProg = document.getElementById('editPrograma');
    const eTurno = document.getElementById('editTurno');
    const eActive = document.getElementById('editActive');
    const eDocLink = document.getElementById('editDocLink');

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const prog = btn.dataset.programa;
            const turn = btn.dataset.turno;
            const doc = btn.dataset.doc || '#';
            const act = parseInt(btn.dataset.active, 10) === 1;

            eProg.value = prog;
            eTurno.value = turn;
            eActive.checked = act;
            eDocLink.href = doc;

            formEdit.action = `/admin/admision/resultados/${id}`;
            editModal.show();
        });
    });

    // Mostrar modalNuevo si hay errores y se intentó crear
    if (window.showModalNuevoOnError) {
        new bootstrap.Modal('#modalNuevo').show();
    }
});
