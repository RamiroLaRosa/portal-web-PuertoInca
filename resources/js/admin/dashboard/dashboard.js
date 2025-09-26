// resources/js/admin/dashboard/dashboard.js
document.addEventListener('DOMContentLoaded', () => {
    // ===== 1) Contador "PROGRAMAS DE ESTUDIOS" (sin ceros a la izquierda) =====
    const digitsContainer = document.getElementById('programasDigits') || document.querySelector('.digits');
    if (digitsContainer) {
        const total = (digitsContainer.dataset?.total ?? 0).toString(); // "6", "12", "4318", etc.
        digitsContainer.innerHTML = '';
        total.split('').forEach(ch => {
            const d = document.createElement('div');
            d.className = 'digit';
            d.textContent = ch;
            digitsContainer.appendChild(d);
        });
    }

    // ===== Helper: envolver etiquetas largas en varias líneas =====
    function wrapLabel(label, maxCharsPerLine = 14) {
        if (!label || typeof label !== 'string') return label;

        const words = label.split(' ');
        const lines = [];
        let line = '';

        for (let w of words) {
            if ((line + ' ' + w).trim().length <= maxCharsPerLine) {
                line = (line ? line + ' ' : '') + w;
            } else {
                if (line) lines.push(line);
                // Si una palabra por sí sola excede, cortarla en fragmentos
                while (w.length > maxCharsPerLine) {
                    lines.push(w.slice(0, maxCharsPerLine));
                    w = w.slice(maxCharsPerLine);
                }
                line = w;
            }
        }
        if (line) lines.push(line);

        // Chart.js acepta array => renderiza cada elemento en línea nueva
        return lines;
    }

    // ===== 2) Gráfico "DOCENTES POR PROGRAMAS DE ESTUDIO" =====
    const canvas = document.getElementById('chartVisitas');
    if (canvas && typeof Chart !== 'undefined' && window.DOCENTES_PROG) {
        const { labels = [], data = [] } = window.DOCENTES_PROG;
        const ctx = canvas.getContext('2d');

        // Paleta base (se recicla si hay más barras)
        const baseBg = ['#4CAF50', '#2196F3', '#FFC107', '#E91E63', '#9C27B0', '#FF5722', '#795548'];
        const baseBd = ['#388E3C', '#1976D2', '#FFA000', '#C2185B', '#7B1FA2', '#E64A19', '#5D4037'];

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Docentes',
                    data,
                    backgroundColor: labels.map((_, i) => baseBg[i % baseBg.length]),
                    borderColor: labels.map((_, i) => baseBd[i % baseBd.length]),
                    borderWidth: 1,
                    borderRadius: 6,

                    // Grosor de barras (ajusta a gusto)
                    barPercentage: 0.55,
                    categoryPercentage: 0.60,
                    // Si prefieres grosor fijo, usa:
                    // barThickness: 36,
                    // maxBarThickness: 42,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // el <canvas> llena el alto del contenedor
                indexAxis: 'x',             // mantener barras verticales
                layout: { padding: { bottom: 10 } }, // aire para etiquetas multilínea
                plugins: {
                    legend: { display: false },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            autoSkip: false,      // muestra todas (cambia a true si quieres saltar algunas)
                            maxRotation: 0,       // horizontal
                            minRotation: 0,       // horizontal
                            font: { size: 12 },
                            callback: function (value) {
                                const label = this.getLabelForValue
                                    ? this.getLabelForValue(value) // Category scale v3+
                                    : value;
                                return wrapLabel(label, 14);     // máx. ~14 chars por línea (ajústalo)
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Cantidad de Docentes' },
                        ticks: { precision: 0 }
                    }
                }
            }
        });
    }
});
