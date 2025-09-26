lucide.createIcons();

let activeSection = 'hero';
let currentStep = 1;
let selectedComplaintType = '';

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
        menuIcon?.classList.add('hidden');
        closeIcon?.classList.remove('hidden');
    } else {
        mobileMenu.classList.add('hidden');
        menuIcon?.classList.remove('hidden');
        closeIcon?.classList.add('hidden');
    }
}

function closeMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');
    mobileMenu.classList.add('hidden');
    menuIcon?.classList.remove('hidden');
    closeIcon?.classList.add('hidden');
}

function selectComplaintType(type, el) {
    document.querySelectorAll('.complaint-type-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    selectedComplaintType = type;
    document.getElementById('tipoReclamacion').value = type;
}

function changeStep(direction) {
    const steps = ['step1', 'step2', 'step3'];
    const progressSteps = document.querySelectorAll('.progress-step');
    const stepTexts = ['Paso 1: Información Personal', 'Paso 2: Tipo de Reclamación',
        'Paso 3: Detalle de la Reclamación'
    ];

    if (direction === 1 && !validateCurrentStep()) {
        return;
    }

    document.getElementById(steps[currentStep - 1]).classList.add('hidden');
    progressSteps[currentStep - 1].classList.remove('active');
    progressSteps[currentStep - 1].classList.add('completed');

    currentStep += direction;

    document.getElementById(steps[currentStep - 1]).classList.remove('hidden');
    progressSteps[currentStep - 1].classList.add('active');
    document.getElementById('step-text').textContent = stepTexts[currentStep - 1];

    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');

    if (currentStep === 1) {
        prevBtn.classList.add('hidden');
    } else {
        prevBtn.classList.remove('hidden');
    }
    if (currentStep === 3) {
        nextBtn.classList.add('hidden');
        submitBtn.classList.remove('hidden');
    } else {
        nextBtn.classList.remove('hidden');
        submitBtn.classList.add('hidden');
    }
}

function validateCurrentStep() {
    if (currentStep === 1) {
        const required = ['nombres', 'apellidos', 'tipoDocumento', 'numeroDocumento', 'telefono', 'email',
            'direccion', 'relacion'
        ];
        for (const id of required) {
            const el = document.getElementById(id);
            if (!el.value.trim()) {
                el.focus();
                alert('Por favor completa todos los campos obligatorios.');
                return false;
            }
        }
    } else if (currentStep === 2) {
        if (!selectedComplaintType) {
            alert('Por favor selecciona el tipo de reclamación.');
            return false;
        }
        const area = document.getElementById('area');
        if (!area.value) {
            area.focus();
            alert('Por favor selecciona el área relacionada.');
            return false;
        }
    }
    return true;
}

function buscarReclamacion() {
    const codigo = document.getElementById('codigoSeguimiento').value;
    const documento = document.getElementById('documentoBusqueda').value;
    if (!codigo && !documento) {
        alert('Por favor ingresa un código de seguimiento o número de documento.');
        return;
    }
    setTimeout(() => {
        document.getElementById('resultadoBusqueda').classList.remove('hidden');
        document.getElementById('resultadoBusqueda').scrollIntoView({
            behavior: 'smooth'
        });
    }, 1000);
}

document.getElementById('complaintForm').addEventListener('submit', function (e) {
    e.preventDefault();
    if (!validateCurrentStep()) return;
    alert('¡Reclamación enviada exitosamente!\n\nCódigo de seguimiento: REC-2025-' + Math.floor(Math
        .random() * 100000).toString().padStart(6, '0') +
        '\n\nRecibirás una confirmación por email en los próximos minutos.');
    this.reset();
    currentStep = 1;
    selectedComplaintType = '';
    document.querySelectorAll('.step-content').forEach((s, i) => {
        i === 0 ? s.classList.remove('hidden') : s.classList.add('hidden')
    });
    document.querySelectorAll('.progress-step').forEach((s, i) => {
        s.classList.remove('active', 'completed');
        if (i === 0) s.classList.add('active')
    });
    document.getElementById('step-text').textContent = 'Paso 1: Información Personal';
    document.getElementById('prevBtn').classList.add('hidden');
    document.getElementById('nextBtn').classList.remove('hidden');
    document.getElementById('submitBtn').classList.add('hidden');
});

function updateActiveNavigation() {
    const sections = document.querySelectorAll('section[id]');
    let current = 'hero';
    sections.forEach(sec => {
        const top = sec.offsetTop;
        const h = sec.clientHeight;
        if (window.scrollY >= top - 200 && window.scrollY < top + h - 200) {
            current = sec.getAttribute('id') || 'hero';
        }
    });
    if (current !== activeSection) {
        const prev = document.querySelector(`[data-section="${activeSection}"]`);
        if (prev) {
            prev.classList.remove('bg-[#E27227]');
            prev.classList.add('hover:bg-[#1A4FD3]/20');
        }
        const now = document.querySelector(`[data-section="${current}"]`);
        if (now) {
            now.classList.add('bg-[#E27227]');
            now.classList.remove('hover:bg-[#1A4FD3]/20');
        }
        activeSection = current;
    }
}
window.addEventListener('scroll', updateActiveNavigation);
window.addEventListener('load', () => {
    updateActiveNavigation();
});

document.addEventListener('click', (e) => {
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileBtn = document.getElementById('mobile-menu-button');
    if (mobileMenu && mobileBtn && !mobileMenu.contains(e.target) && !mobileBtn.contains(e.target)) {
        closeMobileMenu();
    }
});

document.getElementById('documentos').addEventListener('change', function (e) {
    const fileList = document.getElementById('fileList');
    fileList.innerHTML = '';
    Array.from(e.target.files).forEach((file) => {
        const item = document.createElement('div');
        item.className = 'flex items-center justify-between p-3 bg-gray-50 rounded-lg';
        item.innerHTML = `
          <div class="flex items-center gap-3">
            <i data-lucide="file" class="h-4 w-4 text-gray-500"></i>
            <span class="text-sm">${file.name}</span>
            <span class="text-xs text-gray-500">(${(file.size / 1024 / 1024).toFixed(2)} MB)</span>
          </div>
          <button type="button" onclick="this.parentElement.remove()" class="text-[#E27227] hover:text-[#00264B]">
            <i data-lucide="x" class="h-4 w-4"></i>
          </button>`;
        fileList.appendChild(item);
    });
    lucide.createIcons();
});