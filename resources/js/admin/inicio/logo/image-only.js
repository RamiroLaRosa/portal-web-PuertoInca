document.addEventListener('DOMContentLoaded', () => {
    const base = window.heroImageUrlBase; // "/admin/inicio/hero-image"
    const modalGuardar = new bootstrap.Modal(document.getElementById('modalGuardarImagen'));
    const modalPreview = new bootstrap.Modal(document.getElementById('modalPreviewImagen'));

    // PREVIEW
    document.querySelectorAll('.btn-preview-image').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('previewImg').src = btn.dataset.src || '';
            modalPreview.show();
        });
    });

    // CREAR/EDITAR
    document.querySelectorAll('.btn-open-modal').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const foto = btn.dataset.foto;
            const active = btn.dataset.active === '1';

            const form = document.getElementById('formGuardarImagen');
            const holder = document.getElementById('methodHolder');
            const actual = document.getElementById('modalActualPreview');
            const nueva = document.getElementById('modalNuevaPreview');
            const chk = document.getElementById('inputActivo');
            const fileIn = document.getElementById('inputFoto');

            // reset
            holder.innerHTML = '';
            fileIn.value = '';
            nueva.src = nueva.dataset.default;

            if (id) {
                // EDITAR
                form.action = `${base}/${id}`;
                holder.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                if (foto) actual.src = foto;
                chk.checked = active;
            } else {
                // CREAR
                form.action = base;
                if (foto) actual.src = foto;
                chk.checked = true;
            }

            // preview instantánea
            fileIn.onchange = e => {
                const f = e.target.files?.[0];
                if (!f) return;
                const url = URL.createObjectURL(f);
                nueva.src = url;
            };

            modalGuardar.show();
        });
    });
});
