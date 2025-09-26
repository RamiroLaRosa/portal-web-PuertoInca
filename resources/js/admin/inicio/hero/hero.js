document.addEventListener('DOMContentLoaded', () => {
    // Preview imagen
    const modalPrev = new bootstrap.Modal(document.getElementById('modalPreviewImagen'));
    const prevImg = document.getElementById('previewImg');
    const prevTitleEl = document.getElementById('modalPreviewImagenLabel');
    document.querySelectorAll('.btn-preview-image').forEach(el => {
        el.addEventListener('click', () => {
            prevImg.src = el.dataset.src || '';
            prevTitleEl.textContent = el.dataset.title || 'Vista previa';
            modalPrev.show();
        });
    });

    // Editar
    const modalEdit = new bootstrap.Modal(document.getElementById('modalEditarHero'));
    const form = document.getElementById('formEditarHero');
    const tInput = document.getElementById('editTitulo');
    const dInput = document.getElementById('editDescripcion');
    const pImg = document.getElementById('editPreview');
    const chkActive = document.getElementById('editActivo');

    document.querySelectorAll('.btn-edit-hero').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const id = btn.dataset.id;
            const tit = btn.dataset.titulo || '';
            const des = btn.dataset.descripcion || '';
            const foto = btn.dataset.foto || '';
            const act = btn.dataset.active === '1';

            tInput.value = tit;
            dInput.value = des;
            pImg.src = foto;
            chkActive.checked = act;

            form.action = window.heroEditUrlBase + '/' + id;
            modalEdit.show();
        });
    });
});
