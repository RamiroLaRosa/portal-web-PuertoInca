// resources/js/organigrama.js

document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('filePdf');
    const fileName = document.getElementById('fileName');
    const pdfFrame = document.getElementById('pdfFrame');
    const pdfEmptyState = document.getElementById('pdfEmptyState');
    const pdfUrl = document.body.dataset.pdfUrl;
    const pdfjsBase = document.body.dataset.pdfjsBase || '';
    const pdfjsUse = document.body.dataset.pdfjsUse === '1';

    // Mostrar nombre de archivo seleccionado
    if (fileInput && fileName) {
        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                fileName.textContent = fileInput.files[0].name;
            } else {
                fileName.textContent = 'Sin archivos seleccionados';
            }
        });
    }

    // Previsualización PDF
    function showPdf(url) {
        if (!url) {
            pdfFrame.style.display = 'none';
            pdfEmptyState.style.display = '';
            return;
        }
        pdfEmptyState.style.display = 'none';
        pdfFrame.style.display = 'block';
        pdfFrame.src = pdfjsUse ? (pdfjsBase + encodeURIComponent(url)) : url;
    }

    showPdf(pdfUrl);
});
