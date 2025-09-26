// resources/js/presentacion.js

document.addEventListener('DOMContentLoaded', function() {
    // TinyMCE
    if (window.tinymce) {
        tinymce.init({
            selector: '#palabrasDirector',
            height: 320,
            menubar: false,
            plugins: 'lists link image table code',
            toolbar: 'undo redo | bold italic underline | bullist numlist | link image table | code',
            branding: false,
            language: 'es',
        });
    }

    // Mostrar nombre de archivo seleccionado
    const fotoInput = document.getElementById('fotoDirector');
    const fileName = document.getElementById('fileName');
    if (fotoInput && fileName) {
        fotoInput.addEventListener('change', function() {
            if (fotoInput.files.length > 0) {
                fileName.textContent = fotoInput.files[0].name;
            } else {
                fileName.textContent = 'Sin archivos seleccionados';
            }
        });
    }
});
