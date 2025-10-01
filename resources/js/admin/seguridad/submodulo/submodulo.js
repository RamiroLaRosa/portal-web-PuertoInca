document.addEventListener('DOMContentLoaded', () => {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const base = window.subUpdateUrlBase; // "/admin/inicio/submodulos"

    // Cambiar visibilidad con el combo
    document.querySelectorAll('.sub-visibility').forEach((sel) => {
        sel.addEventListener('change', async (e) => {
            const id = e.target.dataset.id;
            const value = e.target.value;

            try {
                const res = await fetch(`${base}/${id}/visibility`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ is_active: value === '1' }),
                });

                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                const data = await res.json();

                const row = e.target.closest('tr');
                const info = row.querySelector('small.text-muted');
                if (info) {
                    info.innerHTML = `Estado actual: ${data.is_active
                            ? '<span class="badge bg-success">Visible</span>'
                            : '<span class="badge bg-secondary">Oculto</span>'
                        }`;
                }
                toastOk(`Submódulo #${id} actualizado.`);
            } catch (err) {
                console.error(err);
                toastErr('No se pudo actualizar la visibilidad.');
                e.target.value = e.target.value === '1' ? '0' : '1';
            }
        });
    });

    function toastOk(msg) { showToast(msg, 'bg-success'); }
    function toastErr(msg) { showToast(msg, 'bg-danger'); }
    function showToast(message, cls) {
        const el = document.createElement('div');
        el.className = 'position-fixed top-0 end-0 p-3'; el.style.zIndex = 1080;
        el.innerHTML = `
        <div class="toast align-items-center text-white ${cls}" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
          </div>
        </div>`;
        document.body.appendChild(el);
        const t = new bootstrap.Toast(el.querySelector('.toast'), { delay: 2200 });
        t.show(); setTimeout(() => el.remove(), 2600);
    }
});
