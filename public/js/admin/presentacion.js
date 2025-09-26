// public/js/admin/presentacion.js

document.addEventListener("DOMContentLoaded", () => {
    // --- TinyMCE ---
    const initTiny = () => {
        // espera a que la librería esté disponible (por si el orden cambia)
        if (!window.tinymce) {
            setTimeout(initTiny, 50);
            return;
        }

        const textarea = document.getElementById("palabrasDirector");
        if (!textarea) return;

        // evita doble inicialización si vuelves a esta vista con turbo/pjax, etc.
        if (tinymce.get(textarea.id)) return;

        tinymce.init({
            selector: "#palabrasDirector",
            height: 320,
            menubar: "file edit view insert format",
            plugins: "lists link",
            toolbar:
                "undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
            branding: false,
            promotion: false,
            content_style:
                "body{font-family:Inter,system-ui,Segoe UI,Roboto,Arial,sans-serif;font-size:14px}",
        });
    };
    initTiny();

    // --- Mostrar nombre del archivo seleccionado ---
    const inputFile = document.getElementById("fotoDirector");
    const fileName = document.getElementById("fileName");
    if (inputFile && fileName) {
        inputFile.addEventListener("change", () => {
            fileName.textContent = inputFile.files.length
                ? inputFile.files[0].name
                : "Sin archivos seleccionados";
        });
    }
});
