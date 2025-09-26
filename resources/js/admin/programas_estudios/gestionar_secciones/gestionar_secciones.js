/* ======================================================================
   Gestionar Secciones – Programa de Estudio (versión depurada)
   Archivo: resources/js/admin/programas_estudios/gestionar_secciones/gestionar_secciones.js
   ====================================================================== */

/* -------------------- Tabs -------------------- */
document.querySelectorAll('.pe-tab').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.pe-tab').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('show'));
    btn.classList.add('active');
    const tabId = btn.dataset.tab;
    document.getElementById(tabId)?.classList.add('show');
  });
});

/* -------------------- Utils -------------------- */
const frmPrograma = document.getElementById('frmPrograma');
const programSelect = document.getElementById('programSelect');

const NO_PHOTO = (document.getElementById('viewImgEl')?.getAttribute('src')) || '/images/no-photo.jpg';
const getCsrf = () => frmPrograma?.querySelector('input[name="_token"]')?.value || '';

/* Rutas (según web.php) */
const routes = {
  estudiosList: `/admin/programas/estudios`,

  // Coordinadores
  coordIndex: (pid) => `/admin/programas/${pid}/coordinadores`,
  coordSync: (pid) => `/admin/programas/${pid}/coordinadores/sync`,

  // Perfil
  perfilShow: (pid) => `/admin/programas/${pid}/perfil`,
  perfilSave: (pid) => `/admin/programas/${pid}/perfil`,

  // Áreas
  areasIndex: (pid) => `/admin/programas/${pid}/areas`,
  areasStore: (pid) => `/admin/programas/${pid}/areas`,
  areasShow: (pid, id) => `/admin/programas/${pid}/areas/${id}`,
  areasUpdate: (pid, id) => `/admin/programas/${pid}/areas/${id}`,
  areasDestroy: (pid, id) => `/admin/programas/${pid}/areas/${id}`,

  // Egresados
  egreIndex: (pid) => `/admin/programas/${pid}/egresados`,
  egreStore: (pid) => `/admin/programas/${pid}/egresados`,
  egreShow: (pid, id) => `/admin/programas/${pid}/egresados/${id}`,
  egreUpdate: (pid, id) => `/admin/programas/${pid}/egresados/${id}`, // POST
  egreDestroy: (pid, id) => `/admin/programas/${pid}/egresados/${id}`,

  // Convenios
  convIndex: (pid) => `/admin/programas/${pid}/convenios`,
  convStore: (pid) => `/admin/programas/${pid}/convenios`,
  convShow: (pid, id) => `/admin/programas/${pid}/convenios/${id}`,
  convUpdate: (pid, id) => `/admin/programas/${pid}/convenios/${id}`, // POST
  convDestroy: (pid, id) => `/admin/programas/${pid}/convenios/${id}`,

  // Galería
  galIndex: (pid) => `/admin/programas/${pid}/galeria`,
  galStore: (pid) => `/admin/programas/${pid}/galeria`,
  galShow: (pid, id) => `/admin/programas/${pid}/galeria/${id}`,
  galUpdate: (pid, id) => `/admin/programas/${pid}/galeria/${id}`,  // POST
  galDestroy: (pid, id) => `/admin/programas/${pid}/galeria/${id}`,

  // Malla
  mallaIndex: (pid) => `/admin/programas/${pid}/malla`,
  // módulos
  modStore: (pid) => `/admin/programas/${pid}/malla/modulos`,
  modUpdate: (pid, id) => `/admin/programas/${pid}/malla/modulos/${id}`,
  modDestroy: (pid, id) => `/admin/programas/${pid}/malla/modulos/${id}`,
  // semestres
  semStore: (pid) => `/admin/programas/${pid}/malla/semestres`,
  semUpdate: (pid, id) => `/admin/programas/${pid}/malla/semestres/${id}`,
  semDestroy: (pid, id) => `/admin/programas/${pid}/malla/semestres/${id}`,
  // cursos
  curStore: (pid) => `/admin/programas/${pid}/malla/cursos`,
  curUpdate: (pid, id) => `/admin/programas/${pid}/malla/cursos/${id}`,
  curDestroy: (pid, id) => `/admin/programas/${pid}/malla/cursos/${id}`,
};

/* Helpers fetch */
async function getJSON(url) {
  const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
  if (!res.ok) throw new Error(`GET ${url} -> ${res.status}`);
  return res.json();
}
async function postForm(url, formData) {
  const res = await fetch(url, {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': getCsrf() },
    body: formData
  });
  if (!res.ok) throw new Error(`POST ${url} -> ${res.status}`);
  return res.json();
}
async function putForm(url, formData) {
  formData.append('_method', 'PUT');
  return postForm(url, formData);
}
async function deleteForm(url) {
  const fd = new FormData();
  fd.append('_method', 'DELETE');
  return postForm(url, fd);
}

/* -------------------- Anti-submit involuntario dentro del form -------------------- */
frmPrograma?.addEventListener('click', (e) => {
  const btn = e.target.closest('button');
  if (!btn) return;
  if (btn.closest('#modalModulo, #modalSemestre, #modalCurso, #modalArea, #modalEgresado, #modalConvenio, #modalGaleria')) return;
  const type = (btn.getAttribute('type') || '').toLowerCase();
  if (!type || type === 'submit') e.preventDefault();
});

/* =================== PROGRAMAS =================== */
(async function loadProgramas() {
  try {
    const data = await getJSON(routes.estudiosList);
    (data || []).forEach(p => {
      const opt = document.createElement('option');
      opt.value = p.id;
      opt.textContent = p.nombre;
      programSelect.appendChild(opt);
    });
  } catch (err) {
    console.error('Error cargando programas:', err);
  }
})();

/* =================== COORDINADORES =================== */
const coordList = document.getElementById('coordList');
const tplCoordEl = document.getElementById('tplCoord');

function coordCardFromTemplate(idx) {
  const html = tplCoordEl.innerHTML.replace(/__INDEX__/g, String(idx));
  const wrap = document.createElement('div');
  wrap.innerHTML = html.trim();
  return wrap.firstElementChild; // .coord-item
}

function addCoordCard(idx, data = {}) {
  const card = coordCardFromTemplate(idx);

  card.querySelector(`[name="coordinadores[${idx}][id]"]`).value = data.id ?? '';
  card.querySelector(`[name="coordinadores[${idx}][nombres]"]`).value = data.nombres ?? '';
  card.querySelector(`[name="coordinadores[${idx}][apellidos]"]`).value = data.apellidos ?? '';
  card.querySelector(`[name="coordinadores[${idx}][cargo]"]`).value = data.cargo ?? '';
  card.querySelector(`[name="coordinadores[${idx}][mensaje]"]`).value = data.mensaje ?? data.palabras ?? '';

  const imgPrev = card.querySelector(`img.coord-preview[data-index="${idx}"]`);
  imgPrev.src = data.foto_url || NO_PHOTO;

  coordList.appendChild(card);
}

function clearCoords() { coordList.innerHTML = ''; }

function rebindFilePreview(root = document) {
  root.querySelectorAll('.coord-file').forEach(input => {
    input.addEventListener('change', e => {
      const idx = e.target.dataset.index;
      const img = root.querySelector(`img.coord-preview[data-index="${idx}"]`) || document.querySelector(`img.coord-preview[data-index="${idx}"]`);
      img.src = (e.target.files && e.target.files[0]) ? URL.createObjectURL(e.target.files[0]) : NO_PHOTO;
    });
  });
}

document.getElementById('btnAddCoord')?.addEventListener('click', () => {
  const idx = coordList.querySelectorAll('.coord-item').length;
  addCoordCard(idx);
  rebindFilePreview(coordList);

  const cards = coordList.querySelectorAll('.coord-item');
  cards.forEach((c, i) => c.querySelector('.btnRemoveCoord')?.classList.toggle('d-none', (i === 0 && cards.length === 1)));
});

coordList?.addEventListener('click', (e) => {
  const btn = e.target.closest('.btnRemoveCoord');
  if (!btn) return;
  btn.closest('.coord-item')?.remove();

  const cards = coordList.querySelectorAll('.coord-item');
  if (cards.length === 1) cards[0].querySelector('.btnRemoveCoord')?.classList.add('d-none');
});

/* =================== PERFIL =================== */
const perfilTextarea = document.getElementById('perfilDescripcion');
function clearPerfil() { if (perfilTextarea) perfilTextarea.value = ''; }

async function loadPerfil(pid) {
  clearPerfil();
  if (!pid) return;
  try {
    const data = await getJSON(routes.perfilShow(pid));
    if (data?.perfil?.descripcion) perfilTextarea.value = data.perfil.descripcion;
  } catch (e) { console.error('Error cargando perfil:', e); }
}

async function savePerfil(pid) {
  if (!pid) return alert('Selecciona un programa');
  const descripcion = (perfilTextarea?.value ?? '').trim();
  if (!descripcion) return alert('Escribe la descripción del perfil');

  try {
    const fd = new FormData();
    fd.append('descripcion', descripcion);
    const out = await postForm(routes.perfilSave(pid), fd);
    if (!out?.ok) throw new Error('Respuesta no OK');
    alert('Perfil actualizado correctamente');
  } catch (e) {
    console.error(e);
    alert('Ocurrió un error al guardar el perfil');
  }
}
document.getElementById('btnUpdatePerfil')?.addEventListener('click', () => savePerfil(programSelect.value));

/* =================== ÁREAS =================== */
const tblAreasBody = document.getElementById('tblAreasBody');
const modalArea = new bootstrap.Modal(document.getElementById('modalArea'));
const areaIdEl = document.getElementById('areaId');
const areaNombreEl = document.getElementById('areaNombre');
const areaDescEl = document.getElementById('areaDescripcion');
const areaImgEl = document.getElementById('areaImagen');
const areaPrevEl = document.getElementById('areaPreview');
const modalAreaTitle = document.getElementById('modalAreaTitle');

function renderAreas(list) {
  tblAreasBody.innerHTML = '';
  (list ?? []).forEach((a, i) => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${i + 1}</td>
      <td class="text-muted fw-semibold">${a.nombre ?? ''}</td>
      <td class="text-muted">${a.descripcion ?? ''}</td>
      <td class="text-center">
        <button type="button" class="btn btn-link p-0 btnAreaImg" data-url="${a.imagen_url || ''}" title="Ver imagen">
          <span class="img-thumb">${a.imagen_url ? `<img src="${a.imagen_url}" style="max-width:100%;max-height:34px">` : '<i class="fa-regular fa-image"></i>'}</span>
        </button>
      </td>
      <td class="text-center">
        <div class="d-inline-flex gap-1">
          <button type="button" class="btn btn-warning btn-sm text-white btnAreaEdit" data-id="${a.id}"><i class="fa-regular fa-pen-to-square"></i></button>
          <button type="button" class="btn btn-danger btn-sm btnAreaDel" data-id="${a.id}"><i class="fa-regular fa-trash-can"></i></button>
        </div>
      </td>`;
    tblAreasBody.appendChild(tr);
  });
}

async function loadAreas(pid) {
  tblAreasBody.innerHTML = '';
  if (!pid) return;
  try {
    const data = await getJSON(routes.areasIndex(pid));
    renderAreas(data?.areas ?? []);
  } catch (e) { console.error('Error cargando áreas:', e); }
}

function resetAreaForm() {
  areaIdEl.value = '';
  areaNombreEl.value = '';
  areaDescEl.value = '';
  areaImgEl.value = '';
  areaPrevEl.src = NO_PHOTO;
}

areaImgEl?.addEventListener('change', e => {
  const f = e.target.files?.[0];
  areaPrevEl.src = f ? URL.createObjectURL(f) : NO_PHOTO;
});

document.getElementById('btnAddArea')?.addEventListener('click', () => {
  resetAreaForm();
  modalAreaTitle.textContent = 'Nueva área';
  modalArea.show();
});
document.getElementById('btnReloadAreas')?.addEventListener('click', () => loadAreas(programSelect.value));

/* Modal ver imagen global */
const modalViewImg = new bootstrap.Modal(document.getElementById('modalViewImg'));
const viewImgEl = document.getElementById('viewImgEl');

tblAreasBody?.addEventListener('click', async (e) => {
  const btnImg = e.target.closest('.btnAreaImg');
  const btnE = e.target.closest('.btnAreaEdit');
  const btnD = e.target.closest('.btnAreaDel');
  const pid = programSelect.value;

  if (btnImg) {
    viewImgEl.src = btnImg.dataset.url || NO_PHOTO;
    modalViewImg.show();
    return;
  }
  if (btnE) {
    const id = btnE.dataset.id;
    try {
      const data = await getJSON(routes.areasShow(pid, id));
      resetAreaForm();
      modalAreaTitle.textContent = 'Editar área';
      areaIdEl.value = data?.area?.id ?? '';
      areaNombreEl.value = data?.area?.nombre ?? '';
      areaDescEl.value = data?.area?.descripcion ?? '';
      areaPrevEl.src = data?.area?.imagen_url || NO_PHOTO;
      modalArea.show();
    } catch (err) {
      console.error(err);
      toastError('No se pudo cargar el área');
    }
  }
  if (btnD) {
    const id = btnD.dataset.id;
    //if (!confirm('¿Eliminar esta área?')) return;
    //try {
    //const out = await deleteForm(routes.areasDestroy(pid, id));
    //if (!out?.ok) throw new Error();
    //await loadAreas(pid);
  } //catch (err) {
  //console.error(err);
  //alert('No se pudo eliminar');
  //}
  //}
});

document.getElementById('frmArea')?.addEventListener('submit', async (e) => {
  e.preventDefault();
  const pid = programSelect.value;
  if (!pid) return alert('Selecciona un programa');

  const id = areaIdEl.value;
  const fd = new FormData();
  fd.append('nombre', areaNombreEl.value.trim());
  fd.append('descripcion', areaDescEl.value.trim());
  if (areaImgEl.files?.[0]) fd.append('imagen', areaImgEl.files[0]);

  try {
    const out = id
      ? await putForm(routes.areasUpdate(pid, id), fd)
      : await postForm(routes.areasStore(pid), fd);

    if (!out?.ok) throw new Error();
    modalArea.hide();
    await loadAreas(pid);
  } catch (err) {
    console.error(err);
    toastError('No se pudo guardar el área');
  }
});

/* =================== EGRESADOS =================== */
const tblEgresadosBody = document.getElementById('tblEgresadosBody');
const modalEgresado = new bootstrap.Modal(document.getElementById('modalEgresado'));
const egreIdEl = document.getElementById('egreId');
const egreNombreEl = document.getElementById('egreNombre');
const egreCargoEl = document.getElementById('egreCargo');
const egreImagenEl = document.getElementById('egreImagen');
const egrePreviewEl = document.getElementById('egrePreview');
const modalEgresadoTitle = document.getElementById('modalEgresadoTitle');

function renderEgresados(list) {
  tblEgresadosBody.innerHTML = '';
  (list ?? []).forEach((g, i) => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${i + 1}</td>
      <td class="text-muted fw-semibold">${g.nombre ?? ''}</td>
      <td class="text-muted">${g.cargo ?? ''}</td>
      <td class="text-center">
        <button type="button" class="btn btn-link p-0 btnEgreImg" data-url="${g.imagen_url || ''}" title="Ver imagen">
          <span class="img-thumb"><i class="fa-regular fa-image"></i></span>
        </button>
      </td>
      <td class="text-center">
        <div class="d-inline-flex gap-1">
          <button type="button" class="btn btn-warning btn-sm text-white btnEgreEdit" data-id="${g.id}"><i class="fa-regular fa-pen-to-square"></i></button>
          <button type="button" class="btn btn-danger btn-sm btnEgreDel" data-id="${g.id}"><i class="fa-regular fa-trash-can"></i></button>
        </div>
      </td>`;
    tblEgresadosBody.appendChild(tr);
  });
}

async function loadEgresados(pid) {
  tblEgresadosBody.innerHTML = '';
  if (!pid) return;
  try {
    const data = await getJSON(routes.egreIndex(pid));
    renderEgresados(data?.egresados ?? []);
  } catch (e) { console.error('Error cargando egresados:', e); }
}

function resetEgreForm() {
  egreIdEl.value = '';
  egreNombreEl.value = '';
  egreCargoEl.value = '';
  egreImagenEl.value = '';
  egrePreviewEl.src = NO_PHOTO;
}

egreImagenEl?.addEventListener('change', e => {
  const f = e.target.files?.[0];
  egrePreviewEl.src = f ? URL.createObjectURL(f) : NO_PHOTO;
});

document.getElementById('btnAddEgresado')?.addEventListener('click', () => {
  resetEgreForm();
  modalEgresadoTitle.textContent = 'Nuevo egresado';
  modalEgresado.show();
});
document.getElementById('btnReloadEgresados')?.addEventListener('click', () => loadEgresados(programSelect.value));

tblEgresadosBody?.addEventListener('click', async (e) => {
  const btnImg = e.target.closest('.btnEgreImg');
  const btnE = e.target.closest('.btnEgreEdit');
  const btnD = e.target.closest('.btnEgreDel');
  const pid = programSelect.value;

  if (btnImg) {
    viewImgEl.src = btnImg.dataset.url || NO_PHOTO;
    modalViewImg.show();
    return;
  }
  if (btnE) {
    const id = btnE.dataset.id;
    try {
      const data = await getJSON(routes.egreShow(pid, id));
      resetEgreForm();
      modalEgresadoTitle.textContent = 'Editar egresado';
      const g = data?.egresado || {};
      egreIdEl.value = g.id || '';
      egreNombreEl.value = g.nombre || '';
      egreCargoEl.value = g.cargo || '';
      egrePreviewEl.src = g.imagen_url || NO_PHOTO;
      modalEgresado.show();
    } catch (err) {
      console.error(err);
      alert('No se pudo cargar el egresado');
    }
  }
  if (btnD) {
    const id = btnD.dataset.id;
    //if (!confirm('¿Eliminar este egresado?')) return;
    //try {
    //const out = await deleteForm(routes.egreDestroy(pid, id));
    //if (!out?.ok) throw new Error();
    //await loadEgresados(pid);
  } //catch (err) {
  //console.error(err);
  //alert('No se pudo eliminar');
  //}
  //}
});

document.getElementById('frmEgresado')?.addEventListener('submit', async (e) => {
  e.preventDefault();
  const pid = programSelect.value;
  if (!pid) return alert('Selecciona un programa');

  const id = egreIdEl.value;
  const fd = new FormData();
  fd.append('nombre', egreNombreEl.value.trim());
  fd.append('cargo', egreCargoEl.value.trim());
  if (egreImagenEl.files?.[0]) fd.append('imagen', egreImagenEl.files[0]);

  try {
    const out = id
      ? await postForm(routes.egreUpdate(pid, id), fd) // POST de compatibilidad
      : await postForm(routes.egreStore(pid), fd);

    if (!out?.ok) throw new Error();
    modalEgresado.hide();
    await loadEgresados(pid);
  } catch (err) {
    console.error(err);
    alert('No se pudo guardar el egresado');
  }
});

/* =================== CONVENIOS =================== */
const tblConveniosBody = document.getElementById('tblConveniosBody');
const modalConvenio = new bootstrap.Modal(document.getElementById('modalConvenio'));
const convIdEl = document.getElementById('convId');
const convEntidadEl = document.getElementById('convEntidad');
const convImagenEl = document.getElementById('convImagen');
const convPreviewEl = document.getElementById('convPreview');
const modalConvenioTitle = document.getElementById('modalConvenioTitle');

function renderConvenios(list) {
  tblConveniosBody.innerHTML = '';
  (list ?? []).forEach((c, i) => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${i + 1}</td>
      <td class="text-muted fw-semibold">${c.entidad ?? ''}</td>
      <td class="text-center">
        <button type="button" class="btn btn-link p-0 btnConvImg" data-url="${c.imagen_url || ''}" title="Ver imagen">
          <span class="img-thumb"><i class="fa-regular fa-image"></i></span>
        </button>
      </td>
      <td class="text-center">
        <div class="d-inline-flex gap-1">
          <button type="button" class="btn btn-warning btn-sm text-white btnConvEdit" data-id="${c.id}"><i class="fa-regular fa-pen-to-square"></i></button>
          <button type="button" class="btn btn-danger btn-sm btnConvDel" data-id="${c.id}"><i class="fa-regular fa-trash-can"></i></button>
        </div>
      </td>`;
    tblConveniosBody.appendChild(tr);
  });
}

async function loadConvenios(pid) {
  tblConveniosBody.innerHTML = '';
  if (!pid) return;
  try {
    const data = await getJSON(routes.convIndex(pid));
    renderConvenios(data?.convenios ?? []);
  } catch (e) { console.error('Error cargando convenios:', e); }
}

function resetConvForm() {
  convIdEl.value = '';
  convEntidadEl.value = '';
  convImagenEl.value = '';
  convPreviewEl.src = NO_PHOTO;
}

convImagenEl?.addEventListener('change', e => {
  const f = e.target.files?.[0];
  convPreviewEl.src = f ? URL.createObjectURL(f) : NO_PHOTO;
});

document.getElementById('btnAddConvenio')?.addEventListener('click', () => {
  resetConvForm();
  modalConvenioTitle.textContent = 'Nuevo convenio';
  modalConvenio.show();
});
document.getElementById('btnReloadConvenios')?.addEventListener('click', () => loadConvenios(programSelect.value));

tblConveniosBody?.addEventListener('click', async (e) => {
  const btnImg = e.target.closest('.btnConvImg');
  const btnE = e.target.closest('.btnConvEdit');
  const btnD = e.target.closest('.btnConvDel');
  const pid = programSelect.value;

  if (btnImg) {
    viewImgEl.src = btnImg.dataset.url || NO_PHOTO;
    modalViewImg.show();
    return;
  }
  if (btnE) {
    const id = btnE.dataset.id;
    try {
      const data = await getJSON(routes.convShow(pid, id));
      const c = data?.convenio || {};
      resetConvForm();
      modalConvenioTitle.textContent = 'Editar convenio';
      convIdEl.value = c.id || '';
      convEntidadEl.value = c.entidad || '';
      convPreviewEl.src = c.imagen_url || NO_PHOTO;
      modalConvenio.show();
    } catch (err) {
      console.error(err);
      alert('No se pudo cargar el convenio');
    }
  }
  if (btnD) {
    const id = btnD.dataset.id;
    //if (!confirm('¿Eliminar este convenio?')) return;
    //try {
    //const out = await deleteForm(routes.convDestroy(pid, id));
    //if (!out?.ok) throw new Error();
    //await loadConvenios(pid);
  } //catch (err) {
  //console.error(err);
  //alert('No se pudo eliminar');
  //}
  //}
});

document.getElementById('frmConvenio')?.addEventListener('submit', async (e) => {
  e.preventDefault();
  const pid = programSelect.value;
  if (!pid) return alert('Selecciona un programa');

  const id = convIdEl.value;
  const fd = new FormData();
  fd.append('entidad', convEntidadEl.value.trim());
  if (convImagenEl.files?.[0]) fd.append('imagen', convImagenEl.files[0]);

  try {
    const out = id
      ? await postForm(routes.convUpdate(pid, id), fd) // POST
      : await postForm(routes.convStore(pid), fd);

    if (!out?.ok) throw new Error();
    modalConvenio.hide();
    await loadConvenios(pid);
  } catch (err) {
    console.error(err);
    alert('No se pudo guardar el convenio');
  }
});

/* =================== GALERÍA =================== */
const tblGaleriaBody = document.getElementById('tblGaleria')?.querySelector('tbody');
const modalGaleria = new bootstrap.Modal(document.getElementById('modalGaleria'));
const galIdEl = document.getElementById('galId');
const galNombreEl = document.getElementById('galNombre');
const galImagenEl = document.getElementById('galImagen');
const galPreviewEl = document.getElementById('galPreview');
const modalGaleriaTitle = document.getElementById('modalGaleriaTitle');

function renderGaleria(list) {
  tblGaleriaBody.innerHTML = '';
  (list ?? []).forEach((g, i) => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${i + 1}</td>
      <td class="text-muted fw-semibold">${g.nombre ?? ''}</td>
      <td class="text-center">
        <button type="button" class="btn btn-link p-0 btnGalImg" data-url="${g.imagen_url || ''}" title="Ver imagen">
          <span class="img-thumb"><i class="fa-regular fa-image"></i></span>
        </button>
      </td>
      <td class="text-center">
        <div class="d-inline-flex gap-1">
          <button type="button" class="btn btn-warning btn-sm text-white btnGalEdit" data-id="${g.id}"><i class="fa-regular fa-pen-to-square"></i></button>
          <button type="button" class="btn btn-danger btn-sm btnGalDel" data-id="${g.id}"><i class="fa-regular fa-trash-can"></i></button>
        </div>
      </td>`;
    tblGaleriaBody.appendChild(tr);
  });
}

async function loadGaleria(pid) {
  if (!tblGaleriaBody) return;
  tblGaleriaBody.innerHTML = '';
  if (!pid) return;
  try {
    const data = await getJSON(routes.galIndex(pid));
    renderGaleria(data?.galeria ?? []);
  } catch (e) { console.error('Error cargando galería:', e); }
}

function resetGalForm() {
  galIdEl.value = '';
  galNombreEl.value = '';
  galImagenEl.value = '';
  galPreviewEl.src = NO_PHOTO;
}

galImagenEl?.addEventListener('change', e => {
  const f = e.target.files?.[0];
  galPreviewEl.src = f ? URL.createObjectURL(f) : NO_PHOTO;
});

document.getElementById('btnAddImg')?.addEventListener('click', () => {
  resetGalForm();
  modalGaleriaTitle.textContent = 'Nueva imagen';
  modalGaleria.show();
});
document.getElementById('btnReloadGaleria')?.addEventListener('click', () => loadGaleria(programSelect.value));

tblGaleriaBody?.addEventListener('click', async (e) => {
  const btnImg = e.target.closest('.btnGalImg');
  const btnE = e.target.closest('.btnGalEdit');
  const btnD = e.target.closest('.btnGalDel');
  const pid = programSelect.value;

  if (btnImg) {
    viewImgEl.src = btnImg.dataset.url || NO_PHOTO;
    modalViewImg.show();
    return;
  }
  if (btnE) {
    const id = btnE.dataset.id;
    try {
      const data = await getJSON(routes.galShow(pid, id));
      const g = data?.item || data?.galeria || {};
      resetGalForm();
      modalGaleriaTitle.textContent = 'Editar imagen';
      galIdEl.value = g.id || id;
      galNombreEl.value = g.nombre || '';
      galPreviewEl.src = g.imagen_url || NO_PHOTO;
      modalGaleria.show();
    } catch (err) {
      console.error(err);
      alert('No se pudo cargar la imagen');
    }
  }
  if (btnD) {
    const id = btnD.dataset.id;
    //if (!confirm('¿Eliminar esta imagen?')) return;
    //try {
    //const out = await deleteForm(routes.galDestroy(pid, id));
    //if (!out?.ok) throw new Error();
    //await loadGaleria(pid);
  } //catch (err) {
  //console.error(err);
  //alert('No se pudo eliminar');
  //}
  //}
});

document.getElementById('frmGaleria')?.addEventListener('submit', async (e) => {
  e.preventDefault();
  const pid = programSelect.value;
  if (!pid) return alert('Selecciona un programa');

  const id = galIdEl.value;
  const fd = new FormData();
  fd.append('nombre', galNombreEl.value.trim());
  if (galImagenEl.files?.[0]) fd.append('imagen', galImagenEl.files[0]);

  try {
    const out = id
      ? await postForm(routes.galUpdate(pid, id), fd) // POST
      : await postForm(routes.galStore(pid), fd);

    if (!out?.ok) throw new Error();
    modalGaleria.hide();
    await loadGaleria(pid);
  } catch (err) {
    console.error(err);
    alert('No se pudo guardar');
  }
});

/* =================== CAMBIO DE PROGRAMA =================== */
programSelect?.addEventListener('change', async (e) => {
  const id = e.target.value;

  // Coordinadores
  clearCoords();
  if (!id) {
    addCoordCard(0, { foto_url: NO_PHOTO });
    coordList.querySelector('.btnRemoveCoord')?.classList.add('d-none');
    rebindFilePreview(coordList);
  } else {
    try {
      const data = await getJSON(routes.coordIndex(id));
      const lista = Array.isArray(data.coordinadores) ? data.coordinadores : [];
      if (lista.length === 0) {
        addCoordCard(0, { foto_url: NO_PHOTO });
        coordList.querySelector('.btnRemoveCoord')?.classList.add('d-none');
      } else {
        lista.forEach((c, i) => addCoordCard(i, c));
        coordList.querySelector('.coord-item .btnRemoveCoord')?.classList.add('d-none');
      }
      rebindFilePreview(coordList);
    } catch (err) {
      console.error('Error cargando coordinadores:', err);
      addCoordCard(0, { foto_url: NO_PHOTO });
      coordList.querySelector('.btnRemoveCoord')?.classList.add('d-none');
      rebindFilePreview(coordList);
    }
  }

  await loadPerfil(id);
  await loadAreas(id);
  await loadEgresados(id);
  await loadConvenios(id);
  await loadGaleria(id);
  await loadMalla(id);
});

/* =================== SYNC COORDINADORES =================== */
document.getElementById('btnUpdate')?.addEventListener('click', async () => {
  const pid = programSelect.value;
  if (!pid) return alert('Selecciona un programa');

  const cards = coordList.querySelectorAll('.coord-item');
  if (cards.length === 0) return alert('Agrega al menos un coordinador');

  const fd = new FormData();

  cards.forEach((card, i) => {
    const id = card.querySelector(`[name="coordinadores[${i}][id]"]`)?.value ?? '';
    const nombres = card.querySelector(`[name="coordinadores[${i}][nombres]"]`)?.value ?? '';
    const apellidos = card.querySelector(`[name="coordinadores[${i}][apellidos]"]`)?.value ?? '';
    const cargo = card.querySelector(`[name="coordinadores[${i}][cargo]"]`)?.value ?? '';
    const mensaje = card.querySelector(`[name="coordinadores[${i}][mensaje]"]`)?.value ?? '';
    const fileEl = card.querySelector(`[name="coordinadores[${i}][foto]"]`);

    fd.append(`coordinadores[${i}][id]`, id);
    fd.append(`coordinadores[${i}][nombres]`, nombres);
    fd.append(`coordinadores[${i}][apellidos]`, apellidos);
    fd.append(`coordinadores[${i}][cargo]`, cargo);
    fd.append(`coordinadores[${i}][mensaje]`, mensaje);
    if (fileEl?.files?.[0]) fd.append(`coordinadores[${i}][foto]`, fileEl.files[0]);
  });

  try {
    const out = await postForm(routes.coordSync(pid), fd);
    if (!out?.ok) throw new Error();

    clearCoords();
    const lista = out.coordinadores ?? [];
    if (lista.length === 0) {
      addCoordCard(0, { foto_url: NO_PHOTO });
      coordList.querySelector('.btnRemoveCoord')?.classList.add('d-none');
    } else {
      lista.forEach((c, i) => addCoordCard(i, c));
      coordList.querySelector('.coord-item .btnRemoveCoord')?.classList.add('d-none');
    }
    rebindFilePreview(coordList);
    toastSuccess('Cambios guardados correctamente');
  } catch (err) {
    console.error(err);
    toastSuccess('Ocurrió un error al guardar');
  }
});

/* =================== MALLA =================== */
const tblMallaBody = document.getElementById('tblMallaBody');

function mallaEmptyRow(text = 'Sin registros para este programa.') {
  tblMallaBody.innerHTML = `<tr><td colspan="6" class="text-center text-muted py-4">${text}</td></tr>`;
}

async function fetchMalla(pid) {
  return getJSON(routes.mallaIndex(pid));
}

/** Cuenta filas que ocupa un módulo. */
function rowsInModule(mod) {
  return (mod.semestres || []).reduce((acc, s) => acc + Math.max(1, (s.cursos || []).length), 0);
}

/** Render malla con rowspans/acciones. */
function renderMalla(data) {
  const mods = data.items || [];
  if (!mods.length) return mallaEmptyRow();

  tblMallaBody.innerHTML = '';

  mods.forEach((mod) => {
    const moduleRows = Math.max(1, rowsInModule(mod));

    // ===== MÓDULO SIN SEMESTRES =====
    if (!mod.semestres || mod.semestres.length === 0) {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td class="td-modulo" rowspan="${moduleRows}">
          <div>${mod.nombre}</div>
          <div class="mod-actions">
            <button type="button" class="btn btn-warning btn-icon-xxs text-white btnModEdit" data-id="${mod.id}" data-nombre="${mod.nombre}" title="Editar módulo"><i class="fa-regular fa-pen-to-square"></i></button>
            <button type="button" class="btn btn-danger btn-icon-xxs btnModDel" data-id="${mod.id}" title="Eliminar módulo"><i class="fa-regular fa-trash-can"></i></button>
            <button type="button" class="btn btn-success btn-icon-xxs btnModAddSem" data-id="${mod.id}" title="Añadir semestre"><i class="fa-solid fa-plus"></i></button>
          </div>
        </td>
        <td class="td-periodo" rowspan="1">
          <div class="badge-periodo">—</div>
        </td>
        <!-- Curso / Crédito / Horas -->
        <td>—</td>
        <td>—</td>
        <td>—</td>
        <!-- Acciones -->
        <td class="text-center">
          <div class="d-inline-flex gap-1">
            <button type="button" class="btn btn-warning btn-sm text-white" disabled><i class="fa-regular fa-pen-to-square"></i></button>
            <button type="button" class="btn btn-danger  btn-sm" disabled><i class="fa-regular fa-trash-can"></i></button>
          </div>
        </td>`;
      tblMallaBody.appendChild(tr);
      return;
    }

    // ===== MÓDULO CON SEMESTRES =====
    mod.semestres.forEach((sem, sIdx) => {
      const semRows = Math.max(1, (sem.cursos || []).length);

      // --- Semestre sin cursos ---
      if (!sem.cursos || sem.cursos.length === 0) {
        const tr = document.createElement('tr');

        // Columna de Módulo (solo primera fila del módulo)
        if (sIdx === 0) {
          tr.innerHTML += `
            <td class="td-modulo" rowspan="${moduleRows}">
              <div>${mod.nombre}</div>
              <div class="mod-actions">
                <button type="button" class="btn btn-warning btn-icon-xxs text-white btnModEdit" data-id="${mod.id}" data-nombre="${mod.nombre}" title="Editar módulo"><i class="fa-regular fa-pen-to-square"></i></button>
                <button type="button" class="btn btn-danger btn-icon-xxs btnModDel" data-id="${mod.id}" title="Eliminar módulo"><i class="fa-regular fa-trash-can"></i></button>
                <button type="button" class="btn btn-success btn-icon-xxs btnModAddSem" data-id="${mod.id}" title="Añadir semestre"><i class="fa-solid fa-plus"></i></button>
              </div>
            </td>`;
        }

        tr.innerHTML += `
          <td class="td-periodo" rowspan="${semRows}">
            <div class="badge-periodo">${sem.nombre}</div>
            <div class="mod-actions" style="justify-content:center;">
              <button type="button" class="btn btn-warning btn-icon-xxs text-white btnSemEdit" data-id="${sem.id}" data-nombre="${sem.nombre}" title="Editar semestre"><i class="fa-regular fa-pen-to-square"></i></button>
              <button type="button" class="btn btn-danger  btn-icon-xxs btnSemDel" data-id="${sem.id}" title="Eliminar semestre"><i class="fa-regular fa-trash-can"></i></button>
              <button type="button" class="btn btn-success btn-icon-xxs btnSemAddCur" data-id="${sem.id}" title="Añadir curso"><i class="fa-solid fa-plus"></i></button>
            </div>
          </td>
          <!-- Curso / Crédito / Horas -->
          <td>—</td>
          <td>—</td>
          <td>—</td>
          <!-- Acciones -->
          <td class="text-center">
            <div class="d-inline-flex gap-1">
              <button type="button" class="btn btn-warning btn-sm text-white" disabled><i class="fa-regular fa-pen-to-square"></i></button>
              <button type="button" class="btn btn-danger  btn-sm" disabled><i class="fa-regular fa-trash-can"></i></button>
            </div>
          </td>`;
        tblMallaBody.appendChild(tr);
        return;
      }

      // --- Semestre con cursos ---
      sem.cursos.forEach((cur, cIdx) => {
        const tr = document.createElement('tr');

        // Columna de Módulo (solo primera vez del módulo)
        if (sIdx === 0 && cIdx === 0) {
          tr.innerHTML += `
            <td class="td-modulo" rowspan="${moduleRows}">
              <div>${mod.nombre}</div>
              <div class="mod-actions">
                <button type="button" class="btn btn-warning btn-icon-xxs text-white btnModEdit" data-id="${mod.id}" data-nombre="${mod.nombre}" title="Editar módulo"><i class="fa-regular fa-pen-to-square"></i></button>
                <button type="button" class="btn btn-danger btn-icon-xxs btnModDel" data-id="${mod.id}" title="Eliminar módulo"><i class="fa-regular fa-trash-can"></i></button>
                <button type="button" class="btn btn-success btn-icon-xxs btnModAddSem" data-id="${mod.id}" title="Añadir semestre"><i class="fa-solid fa-plus"></i></button>
              </div>
            </td>`;
        }

        // Columna de Semestre (solo primera fila del semestre)
        if (cIdx === 0) {
          tr.innerHTML += `
            <td class="td-periodo" rowspan="${semRows}">
              <div class="badge-periodo">${sem.nombre}</div>
              <div class="mod-actions" style="justify-content:center;">
                <button type="button" class="btn btn-warning btn-icon-xxs text-white btnSemEdit" data-id="${sem.id}" data-nombre="${sem.nombre}" title="Editar semestre"><i class="fa-regular fa-pen-to-square"></i></button>
                <button type="button" class="btn btn-danger  btn-icon-xxs btnSemDel" data-id="${sem.id}" title="Eliminar semestre"><i class="fa-regular fa-trash-can"></i></button>
                <button type="button" class="btn btn-success btn-icon-xxs btnSemAddCur" data-id="${sem.id}" title="Añadir curso"><i class="fa-solid fa-plus"></i></button>
              </div>
            </td>`;
        }

        // Curso / Crédito / Horas / Acciones (estos ya estaban bien)
        tr.innerHTML += `
          <td>${cur.nombre}</td>
          <td>${cur.creditos}</td>
          <td>${cur.horas}</td>
          <td class="text-center">
            <div class="d-inline-flex gap-1">
              <button type="button" class="btn btn-warning btn-sm text-white btnCurEdit" data-id="${cur.id}" data-nombre="${cur.nombre}" data-creditos="${cur.creditos}" data-horas="${cur.horas}" title="Editar curso"><i class="fa-regular fa-pen-to-square"></i></button>
              <button type="button" class="btn btn-danger  btn-sm btnCurDel" data-id="${cur.id}" title="Eliminar curso"><i class="fa-regular fa-trash-can"></i></button>
            </div>
          </td>`;
        tblMallaBody.appendChild(tr);
      });
    });
  });
}


async function loadMalla(pid) {
  if (!pid) return mallaEmptyRow('Seleccione un programa para ver su malla.');
  mallaEmptyRow('Cargando malla...');
  try {
    const data = await fetchMalla(pid);
    renderMalla(data);
    window.MallaPager?.apply();

  } catch (err) {
    console.error(err);
    mallaEmptyRow('Ocurrió un error al cargar la malla.');
  }
}

/* Botón “Añadir fila” (nuevo módulo) */
const modalModulo = new bootstrap.Modal(document.getElementById('modalModulo'));
const moduloIdEl = document.getElementById('moduloId');
const moduloNombreEl = document.getElementById('moduloNombre');
const modalModuloTitle = document.getElementById('modalModuloTitle');

document.getElementById('btnAddMalla')?.addEventListener('click', () => {
  moduloIdEl.value = '';
  moduloNombreEl.value = '';
  modalModuloTitle.textContent = 'Nuevo módulo';
  modalModulo.show();
});

/* Modales Semestre / Curso */
const modalSemestre = new bootstrap.Modal(document.getElementById('modalSemestre'));
const semestreIdEl = document.getElementById('semestreId');
const semestreModIdEl = document.getElementById('semestreModuloId');
const semestreNombreEl = document.getElementById('semestreNombre');
const modalSemestreTitle = document.getElementById('modalSemestreTitle');

const modalCurso = new bootstrap.Modal(document.getElementById('modalCurso'));
const cursoIdEl = document.getElementById('cursoId');
const cursoSemIdEl = document.getElementById('cursoSemestreId');
const cursoNombreEl = document.getElementById('cursoNombre');
const cursoCredEl = document.getElementById('cursoCreditos');
const cursoHorasEl = document.getElementById('cursoHoras');
const modalCursoTitle = document.getElementById('modalCursoTitle');

/* Delegación de eventos en la tabla Malla */
tblMallaBody?.addEventListener('click', async (e) => {
  const pid = programSelect.value;

  // MÓDULO
  const btnME = e.target.closest('.btnModEdit');
  const btnMD = e.target.closest('.btnModDel');
  const btnMA = e.target.closest('.btnModAddSem');

  if (btnME) {
    moduloIdEl.value = btnME.dataset.id;
    moduloNombreEl.value = btnME.dataset.nombre || '';
    modalModuloTitle.textContent = 'Editar módulo';
    modalModulo.show();
    return;
  }
  if (btnMD) {
    //if (!confirm('¿Eliminar este módulo (y sus semestres/cursos)?')) return;
    //try { await deleteForm(routes.modDestroy(pid, btnMD.dataset.id)); await loadMalla(pid); }
    //catch { alert('No se pudo eliminar el módulo'); }
    //return;
  }
  if (btnMA) {
    semestreIdEl.value = '';
    semestreModIdEl.value = btnMA.dataset.id;
    semestreNombreEl.value = '';
    modalSemestreTitle.textContent = 'Nuevo semestre';
    modalSemestre.show();
    return;
  }

  // SEMESTRE
  const btnSE = e.target.closest('.btnSemEdit');
  const btnSD = e.target.closest('.btnSemDel');
  const btnSA = e.target.closest('.btnSemAddCur');

  if (btnSE) {
    semestreIdEl.value = btnSE.dataset.id;
    semestreModIdEl.value = '';
    semestreNombreEl.value = btnSE.dataset.nombre || '';
    modalSemestreTitle.textContent = 'Editar semestre';
    modalSemestre.show();
    return;
  }
  if (btnSD) {
    //if (!confirm('¿Eliminar este semestre (y sus cursos)?')) return;
    //try { await deleteForm(routes.semDestroy(pid, btnSD.dataset.id)); await loadMalla(pid); }
    //catch { alert('No se pudo eliminar el semestre'); }
    //return;
  }
  if (btnSA) {
    cursoIdEl.value = '';
    cursoSemIdEl.value = btnSA.dataset.id;
    cursoNombreEl.value = '';
    cursoCredEl.value = 0;
    cursoHorasEl.value = 0;
    modalCursoTitle.textContent = 'Nuevo curso';
    modalCurso.show();
    return;
  }

  // CURSO
  const btnCE = e.target.closest('.btnCurEdit');
  const btnCD = e.target.closest('.btnCurDel');

  if (btnCE) {
    cursoIdEl.value = btnCE.dataset.id;
    cursoSemIdEl.value = '';
    cursoNombreEl.value = btnCE.dataset.nombre || '';
    cursoCredEl.value = btnCE.dataset.creditos ?? 0;
    cursoHorasEl.value = btnCE.dataset.horas ?? 0;
    modalCursoTitle.textContent = 'Editar curso';
    modalCurso.show();
    return;
  }
  if (btnCD) {
    //if (!confirm('¿Eliminar este curso?')) return;
    //try { await deleteForm(routes.curDestroy(pid, btnCD.dataset.id)); await loadMalla(pid); }
    //catch { alert('No se pudo eliminar el curso'); }
  }
});

/* Submit MÓDULO */
document.getElementById('frmModulo')?.addEventListener('submit', async (e) => {
  e.preventDefault();
  const pid = programSelect.value;
  const id = moduloIdEl.value;
  const fd = new FormData();
  fd.append('nombre', (moduloNombreEl.value || '').trim());

  try {
    if (id) await putForm(routes.modUpdate(pid, id), fd);
    else await postForm(routes.modStore(pid), fd);
    modalModulo.hide();
    await loadMalla(pid);
  } catch { alert('No se pudo guardar el módulo'); }
});

/* Submit SEMESTRE */
document.getElementById('frmSemestre')?.addEventListener('submit', async (e) => {
  e.preventDefault();
  const pid = programSelect.value;
  const id = semestreIdEl.value;
  const fd = new FormData();

  if (id) {
    fd.append('nombre', (semestreNombreEl.value || '').trim());
    try { await putForm(routes.semUpdate(pid, id), fd); modalSemestre.hide(); await loadMalla(pid); }
    catch { alert('No se pudo guardar el semestre'); }
  } else {
    fd.append('modulo_malla_id', semestreModIdEl.value);
    fd.append('nombre', (semestreNombreEl.value || '').trim());
    try { await postForm(routes.semStore(pid), fd); modalSemestre.hide(); await loadMalla(pid); }
    catch { alert('No se pudo guardar el semestre'); }
  }
});

/* Submit CURSO */
document.getElementById('frmCurso')?.addEventListener('submit', async (e) => {
  e.preventDefault();
  const pid = programSelect.value;
  const id = cursoIdEl.value;
  const fd = new FormData();
  fd.append('nombre', (cursoNombreEl.value || '').trim());
  fd.append('creditos', String(cursoCredEl.value || 0));
  fd.append('horas', String(cursoHorasEl.value || 0));

  try {
    if (id) {
      await putForm(routes.curUpdate(pid, id), fd);
    } else {
      fd.append('semestre_malla_id', cursoSemIdEl.value);
      await postForm(routes.curStore(pid), fd);
    }
    modalCurso.hide();
    await loadMalla(pid);
  } catch { alert('No se pudo guardar el curso'); }
});

/* -------------------- Rebind inicial -------------------- */
rebindFilePreview(document);

/* =========================================================
   MODAL GENÉRICO DE ELIMINACIÓN (reemplaza a confirm())
   ========================================================= */

const modalEliminar = new bootstrap.Modal(document.getElementById('modalEliminar'));
const formEliminar = document.getElementById('formEliminar');
const delNombreEl = document.getElementById('delNombre');

let deletePayload = null;

document.addEventListener('click', e => {
  const btn = e.target.closest('button[class*="Del"]');
  if (!btn) return;

  e.preventDefault();

  const pid = programSelect.value;
  const id = btn.dataset.id;
  const tipo = btn.className.match(/btn(\w+)Del/)?.[1] ?? 'registro'; // Area, Egre, Conv, Gal, Mod, Sem, Cur
  const nombre = btn.dataset.nombre
    ?? btn.closest('tr')?.querySelector('td:nth-child(2)')?.textContent?.trim()
    ?? 'este elemento';

  document.querySelector('#modalEliminar .modal-title').textContent = `Eliminar ${tipo.toLowerCase()}`;
  delNombreEl.textContent = nombre;

  deletePayload = { pid, id, tipo, btn };

  modalEliminar.show();
});

formEliminar.addEventListener('submit', async e => {
  e.preventDefault();
  if (!deletePayload) return;

  const { pid, id, tipo } = deletePayload;

  let url = '';
  switch (tipo) {
    case 'Area': url = routes.areasDestroy(pid, id); break;
    case 'Egre': url = routes.egreDestroy(pid, id); break;
    case 'Conv': url = routes.convDestroy(pid, id); break;
    case 'Gal': url = routes.galDestroy(pid, id); break;
    case 'Mod': url = routes.modDestroy(pid, id); break;
    case 'Sem': url = routes.semDestroy(pid, id); break;
    case 'Cur': url = routes.curDestroy(pid, id); break;
    default: alert('Tipo de eliminación no reconocido'); return;
  }

  try {
    const out = await deleteForm(url);
    if (!out?.ok) throw new Error();
    modalEliminar.hide();

    switch (tipo) {
      case 'Area': await loadAreas(pid); break;
      case 'Egre': await loadEgresados(pid); break;
      case 'Conv': await loadConvenios(pid); break;
      case 'Gal': await loadGaleria(pid); break;
      case 'Mod':
      case 'Sem':
      case 'Cur': await loadMalla(pid); break;
    }
  } catch (err) {
    console.error(err);
    alert('No se pudo eliminar el elemento');
  } finally {
    deletePayload = null;
  }
});

/* =========================================================
                MODAL GENÉRICO DE ACTUALIZACION
   ========================================================= */

function toastSuccess(title = 'Guardado correctamente') {
  Swal.fire({
    title: title,
    icon: 'success',
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 2500,
    timerProgressBar: true,
    draggable: true
  });
}

function toastError(title = 'Ocurrió un error') {
  Swal.fire({
    title: title,
    icon: 'error',
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    draggable: true
  });
}
