// Initialize Lucide icons
lucide.createIcons();

// Variables globales
let activeSection = 'hero';
let currentChartType = 'line';

function scrollToSection(sectionId) {
    const element = document.getElementById(sectionId);
    if (element) {
        const yOffset = -80;
        const y = element.getBoundingClientRect().top + window.pageYOffset + yOffset;
        window.scrollTo({
            top: y,
            behavior: 'smooth'
        });
    }
    closeMobileMenu();
}

function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');

    if (mobileMenu.classList.contains('hidden')) {
        mobileMenu.classList.remove('hidden');
        menuIcon.classList.add('hidden');
        closeIcon.classList.remove('hidden');
    } else {
        mobileMenu.classList.add('hidden');
        menuIcon.classList.remove('hidden');
        closeIcon.classList.add('hidden');
    }
}

function closeMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');

    mobileMenu.classList.add('hidden');
    menuIcon.classList.remove('hidden');
    closeIcon.classList.add('hidden');
}

function applyFilters() {
    const periodo = document.getElementById('periodoFilter')?.value || '';
    const programa = document.getElementById('programaFilter')?.value || '';
    const tipo = document.getElementById('tipoFilter')?.value || '';
    alert(`Filtros aplicados:
Período: ${periodo}
Programa: ${programa}
Tipo: ${tipo}

En un entorno real, esto actualizaría todos los gráficos y tablas con los datos filtrados.`);
    updateCharts();
}

function changeChartType(type) {
    currentChartType = type;
    updateEvolutionChart();
}

function exportData(type) {
    alert(`Exportando datos de ${type}...

En un entorno real, esto generaría y descargaría un archivo Excel/CSV con los datos seleccionados.`);
}

function exportAllData() {
    alert(`Generando reporte completo...

En un entorno real, esto generaría un reporte PDF completo con todas las estadísticas, gráficos y análisis.`);
}

function updateActiveNavigation() {
    const sections = document.querySelectorAll('section[id]');
    let currentSection = 'hero';

    sections.forEach((section) => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (window.scrollY >= sectionTop - 200 && window.scrollY < sectionTop + sectionHeight - 200) {
            currentSection = section.getAttribute('id') || 'hero';
        }
    });

    if (currentSection !== activeSection) {
        const prevActive = document.querySelector(`[data-section="${activeSection}"]`);
        if (prevActive) {
            prevActive.classList.remove('bg-[#E27227]');
            prevActive.classList.add('hover:bg-[#1A4FD3]');
        }

        const currentActive = document.querySelector(`[data-section="${currentSection}"]`);
        if (currentActive) {
            currentActive.classList.add('bg-[#E27227]');
            currentActive.classList.remove('hover:bg-[#1A4FD3]');
        }

        activeSection = currentSection;
    }
}

function initCharts() {
    // Paleta para gráficos
    const C1 = '#00264B';
    const C2 = '#1A4FD3';
    const C3 = '#4A84F7';
    const C4 = '#E27227';
    const C5 = '#DDE3E8';

    // Ingresantes (barra)
    const ingresantesCtx = document.getElementById('ingresantesChart').getContext('2d');
    new Chart(ingresantesCtx, {
        type: 'bar',
        data: {
            labels: ['2023-I', '2023-II', '2024-I', '2024-II', '2025-I'],
            datasets: [{
                label: 'Ing. Sistemas',
                data: [298, 312, 344, 356, 387],
                backgroundColor: C2
            },
            {
                label: 'Ing. Industrial',
                data: [245, 258, 275, 284, 298],
                backgroundColor: C3
            },
            {
                label: 'Administración',
                data: [198, 205, 232, 238, 245],
                backgroundColor: C4
            },
            {
                label: 'Contabilidad',
                data: [165, 172, 192, 195, 198],
                backgroundColor: C1
            },
            {
                label: 'Marketing',
                data: [134, 128, 122, 125, 119],
                backgroundColor: C5
            }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Matriculados (doughnut)
    const matriculadosCtx = document.getElementById('matriculadosChart').getContext('2d');
    new Chart(matriculadosCtx, {
        type: 'doughnut',
        data: {
            labels: ['Ing. Sistemas', 'Ing. Industrial', 'Administración', 'Contabilidad', 'Marketing'],
            datasets: [{
                data: [1844, 1359, 987, 493, 209],
                backgroundColor: [C2, C3, C4, C1, C5],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Egresados (línea)
    const egresadosCtx = document.getElementById('egresadosChart').getContext('2d');
    new Chart(egresadosCtx, {
        type: 'line',
        data: {
            labels: ['2021', '2022', '2023', '2024'],
            datasets: [{
                label: 'Ing. Sistemas',
                data: [234, 267, 289, 312],
                borderColor: C2,
                backgroundColor: 'rgba(26,79,211,0.12)',
                tension: 0.4,
                fill: true
            },
            {
                label: 'Ing. Industrial',
                data: [178, 195, 212, 234],
                borderColor: C3,
                backgroundColor: 'rgba(74,132,247,0.12)',
                tension: 0.4,
                fill: true
            },
            {
                label: 'Administración',
                data: [145, 156, 167, 178],
                borderColor: C4,
                backgroundColor: 'rgba(226,114,39,0.12)',
                tension: 0.4,
                fill: true
            },
            {
                label: 'Contabilidad',
                data: [89, 95, 102, 98],
                borderColor: C1,
                backgroundColor: 'rgba(0,38,75,0.12)',
                tension: 0.4,
                fill: true
            },
            {
                label: 'Marketing',
                data: [45, 42, 38, 34],
                borderColor: C5,
                backgroundColor: 'rgba(221,227,232,0.4)',
                tension: 0.4,
                fill: true
            }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Titulados (barra)
    const tituladosCtx = document.getElementById('tituladosChart').getContext('2d');
    new Chart(tituladosCtx, {
        type: 'bar',
        data: {
            labels: ['2021', '2022', '2023', '2024'],
            datasets: [{
                label: 'Ing. Sistemas',
                data: [198, 223, 245, 267],
                backgroundColor: C2
            },
            {
                label: 'Ing. Industrial',
                data: [145, 167, 178, 195],
                backgroundColor: C3
            },
            {
                label: 'Administración',
                data: [123, 134, 145, 156],
                backgroundColor: C4
            },
            {
                label: 'Contabilidad',
                data: [76, 82, 89, 85],
                backgroundColor: C1
            },
            {
                label: 'Marketing',
                data: [34, 32, 29, 27],
                backgroundColor: C5
            }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function updateCharts() {
    console.log('Actualizando gráficos con filtros aplicados...');
}

function updateEvolutionChart() {
    if (window.evolutionChart) {
        window.evolutionChart.config.type = currentChartType;
        window.evolutionChart.update();
    }
}

window.addEventListener('scroll', updateActiveNavigation);
window.addEventListener('load', () => {
    updateActiveNavigation();
    initCharts();
});

document.addEventListener('click', (e) => {
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    if (mobileMenu && mobileMenuButton && !mobileMenu.contains(e.target) && !mobileMenuButton.contains(e
        .target)) {
        closeMobileMenu();
    }
});