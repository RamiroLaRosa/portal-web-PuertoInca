document.addEventListener('DOMContentLoaded', () => {
    // --------- Preview estrellas (Nuevo) ----------
    const selCreate = document.getElementById('puntuacionCreate');
    const prevCreate = document.getElementById('ratingCreatePreview');
    function paintStars(el, n) {
        el.innerHTML = '';
        for (let i = 1; i <= 5; i++) {
            el.innerHTML += `<i class="${i <= n ? 'fa-solid' : 'fa-regular'} fa-star"></i>`;
        }
    }
    if (selCreate && prevCreate) {
        paintStars(prevCreate, Number(selCreate.value || 5));
        selCreate.addEventListener('change', () => paintStars(prevCreate, Number(selCreate.value)));
    }

    // --------- Preview imagen (tabla) ----------
    const modalPrev = new bootstrap.Modal(document.getElementById('modalPreviewImg'));
    const imgPrevEl = document.getElementById('previewImgEl');
    const titlePrev = document.getElementById('modalPreviewImgLabel');
    document.querySelectorAll('.btn-preview-img').forEach(a => {
        a.addEventListener('click', () => {
            imgPrevEl.src = a.dataset.src || '';
            titlePrev.textContent = a.dataset.title || 'Vista previa';
            modalPrev.show();
        });
    });
    document.getElementById('modalPreviewImg').addEventListener('hidden.bs.modal', () => {
        imgPrevEl.src = '';
    });

    // --------- Editar ----------
    const modalEdit = new bootstrap.Modal(document.getElementById('modalEditar'));
    const formEdit = document.getElementById('formEditar');
    const eNombre = document.getElementById('editNombre');
    const eDesc = document.getElementById('editDescripcion');
    const eImgPrev = document.getElementById('editImgPreview');
    const ePuntSel = document.getElementById('puntuacionEdit');
    const ePuntPrev = document.getElementById('ratingEditPreview');
    const eActive = document.getElementById('editActive');
    function paintEdit() {
        paintStars(ePuntPrev, Number(ePuntSel.value || 5));
    }
    if (ePuntSel) ePuntSel.addEventListener('change', paintEdit);
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const nom = btn.dataset.nombre || '';
            const des = btn.dataset.descripcion || '';
            const img = btn.dataset.img || '';
            const pun = Number(btn.dataset.puntuacion || 5);
            const act = btn.dataset.active === '1';
            eNombre.value = nom;
            eDesc.value = des;
            eImgPrev.src = img;
            [...ePuntSel.options].forEach(o => o.selected = (Number(o.value) === pun));
            eActive.checked = act;
            paintEdit();
            formEdit.action = window.testimoniosEditUrlBase + '/' + id;
            modalEdit.show();
        });
    });

    // --------- Eliminar ----------
    const modalDel = new bootstrap.Modal(document.getElementById('modalEliminar'));
    const formDel = document.getElementById('formEliminar');
    const delName = document.getElementById('delNombre');
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const nm = btn.dataset.nombre || '';
            delName.textContent = nm;
            formDel.action = window.testimoniosEditUrlBase + '/' + id;
            modalDel.show();
        });
    });

    // Mostrar modalNuevo si hay errores y se intentó crear
    if (window.showModalNuevoOnError) {
        new bootstrap.Modal(document.getElementById('modalNuevo')).show();
    }
});
