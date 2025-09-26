// resources/js/gestionar_programa.js

document.addEventListener('DOMContentLoaded', () => {
    // Ver imagen
    const imgModal = new bootstrap.Modal('#modalImagen');
    const vistaImg = document.getElementById('vistaImg');
    const tituloImg = document.getElementById('tituloImg');
    document.querySelectorAll('.btn-show-img').forEach(b => {
        b.addEventListener('click', () => {
            vistaImg.src = b.dataset.img || '';
            tituloImg.textContent = 'Imagen — ' + (b.dataset.nombre || '');
            imgModal.show();
        });
    });

    // Editar
    const editModal = new bootstrap.Modal('#modalEditar');
    const formEdit = document.getElementById('formEditar');
    const eNombre = document.getElementById('eNombre');
    const eDesc = document.getElementById('eDescripcion');
    const ePrev = document.getElementById('ePreview');
    const eActivo = document.getElementById('eActivo');

    document.querySelectorAll('.btn-edit').forEach(b => {
        b.addEventListener('click', () => {
            const id = b.dataset.id;
            eNombre.value = b.dataset.nombre || '';
            eDesc.value = b.dataset.descripcion || '';
            ePrev.src = b.dataset.img || '';
            eActivo.checked = true; // marca por defecto (ajusta si quieres pasar el flag real)
            formEdit.action = `/admin/programas/${id}`;
            editModal.show();
        });
    });

    // Eliminar
    const delModal = new bootstrap.Modal('#modalEliminar');
    const formDel = document.getElementById('formEliminar');
    const delName = document.getElementById('delNombre');
    document.querySelectorAll('.btn-delete').forEach(b => {
        b.addEventListener('click', () => {
            const id = b.dataset.id;
            delName.textContent = b.dataset.nombre || '';
            formDel.action = `/admin/programas/${id}`;
            delModal.show();
        });
    });
});
