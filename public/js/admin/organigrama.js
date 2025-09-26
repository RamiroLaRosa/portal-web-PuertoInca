// public/js/admin/organigrama.js
document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("filePdf");
    const nameEl = document.getElementById("fileName");
    const frame = document.getElementById("pdfFrame");
    const empty = document.getElementById("pdfEmptyState");
    const btnAct = document.getElementById("btn-actualizar"); // opcional

    // Config desde <body data-*>
    const serverPdfUrl = document.body.dataset.pdfUrl || "";
    const usePdfJs = document.body.dataset.pdfjsUse === "1";
    const pdfjsBase = document.body.dataset.pdfjsBase || "/pdfjs/web/viewer.html?file=";

    const showEmpty = (show) => {
        if (!empty) return;
        empty.style.display = show ? "flex" : "none";
    };

    const loadPdf = (url) => {
        if (!frame) return;
        if (!url) {
            showEmpty(true);
            frame.removeAttribute("src");
            return;
        }
        showEmpty(false);
        frame.src = usePdfJs
            ? pdfjsBase + encodeURIComponent(url)
            : url + "#toolbar=1&navpanes=1&view=FitH";
    };

    // Carga inicial desde BD
    loadPdf(serverPdfUrl);

    // Preview al seleccionar archivo
    if (input) {
        input.addEventListener("change", () => {
            const file = input.files?.[0];
            if (nameEl) {
                nameEl.textContent = file ? file.name : "Sin archivos seleccionados";
            }

            if (!file) {
                loadPdf(serverPdfUrl);
                return;
            }
            if (file.type !== "application/pdf") {
                alert("Selecciona un archivo PDF.");
                input.value = "";
                if (nameEl) nameEl.textContent = "Sin archivos seleccionados";
                loadPdf(serverPdfUrl);
                return;
            }
            loadPdf(URL.createObjectURL(file));
        });
    }

    // Fallback si usas un botón manual con id="btn-actualizar"
    if (btnAct) {
        btnAct.addEventListener("click", (e) => {
            if (!input?.files?.length) {
                e.preventDefault();
                alert("Selecciona un PDF antes de actualizar.");
                return;
            }
            document.getElementById("formDoc")?.submit();
        });
    }
});
