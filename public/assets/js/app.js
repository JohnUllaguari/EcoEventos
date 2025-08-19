/* public/assets/js/app.js */
function qs(sel, root=document){ return root.querySelector(sel); }
function toast(msg){ alert(msg); }
function setLoading(formOrBtn, on){
  const btn = formOrBtn.tagName==='BUTTON' ? formOrBtn : qs('button[type="submit"]', formOrBtn);
  if (!btn) return;
  btn.disabled = !!on;
  btn.dataset._label = btn.dataset._label || btn.textContent;
  btn.textContent = on ? 'Procesando…' : btn.dataset._label;
}
function escapeHtml(s=''){ return s.replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c])); }
function fmt(d){ return d.toLocaleString(); }



// Busca el formulario de filtros (ajusta el selector si el tuyo es otro)
const filterForm = document.querySelector('form[action=""][method="get"]') || document.querySelector('form');

if (filterForm) {
  filterForm.addEventListener('submit', async (e) => {
    e.preventDefault();               // 🔴 evita recarga
    await loadEventsFromForm(filterForm);
  });
}

async function loadEventsFromForm(form) {
  const params = new URLSearchParams(new FormData(form));
  params.set('action', 'api_events'); // 🔹 fuerza endpoint JSON

  try {
    const res = await fetch('/?' + params.toString(), {
      headers: { 'Accept': 'application/json' }
    });

    // lee como texto primero para poder diagnosticar si no es JSON
    const raw = await res.text();

    let data;
    try { data = JSON.parse(raw); }
    catch (err) {
      // 🔴 Muestra qué devolvió realmente el backend (primeros 300 chars)
      throw new Error('Respuesta no es JSON. Recibido:\n' + raw.slice(0, 300));
    }

    renderEvents(data); // 👉 tu función que pinta #events-list
  } catch (err) {
    alert('Error cargando eventos:\n' + (err.message || err));
    console.error(err);
  }
}

// ejemplo simple de render
function renderEvents(events) {
  const list = document.querySelector('#events-list');
  list.innerHTML = events.map(e => `
    <div class="card">
      <h3>${escapeHtml(e.titulo)} <small>(${escapeHtml(e.tipo)})</small></h3>
      <p>${escapeHtml(e.descripcion||'')}</p>
      <p>📅 ${escapeHtml(e.fecha||'')} ${escapeHtml(e.hora||'')} — 📍 ${escapeHtml(e.ubicacion||'')}</p>
      <p>👥 ${e.inscritos}/${e.cupo} participantes</p>
      <a class="btn" href="?action=detail&id=${encodeURIComponent(e.id)}">Ver detalles</a>
    </div>
  `).join('');
}

function escapeHtml(s=''){
  return s.replace(/[&<>"]/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));
}


async function handleIndex(){
  const form = qs('#filtersForm');
  if (!form) return;
  form.addEventListener('submit', async (e)=>{
    e.preventDefault();
    const params = Object.fromEntries(new FormData(form).entries());
    try{
      const qsParams = new URLSearchParams({ action:'api_events', ...params });
      const res = await fetch('/?'+qsParams.toString());
      const data = await res.json();
      const list = qs('#events-list');
      list.innerHTML = data.map(e => `
        <div class="card">
          <h3>${escapeHtml(e.titulo)} <small>(${escapeHtml(e.tipo)})</small></h3>
          <p>${escapeHtml(e.descripcion || '')}</p>
          <p>📅 ${escapeHtml(e.fecha || '')} ${escapeHtml(e.hora || '')} — 📍 ${escapeHtml(e.ubicacion || '')}</p>
          <p>👥 ${e.inscritos}/${e.cupo} participantes</p>
          <a class="btn" href="?action=detail&id=${encodeURIComponent(e.id)}">Ver detalles</a>
        </div>
      `).join('');
    }catch(err){ toast('Error cargando eventos'); }
  });
}

async function handleCreate(){
  const form = qs('#createForm');
  if (!form) return;
  form.addEventListener('submit', async (e)=>{
    e.preventDefault();
    setLoading(form, true);
    try{
      const payload = Object.fromEntries(new FormData(form).entries());
      payload.cupo = Number(payload.cupo || 0);
      const res = await fetch('/?action=api_event_create', {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body: JSON.stringify(payload)
      });
      if (!res.ok){ const j=await res.json().catch(()=>({})); throw new Error(j.message||'Error'); }
      toast('Evento creado');
      location.href='?action=index';
    }catch(err){ toast(err.message); }
    finally{ setLoading(form, false); }
  });
}

async function handleDetail(){
  const card = qs('#eventDetail');
  const form = qs('#registerForm');
  if (!card || !form) return;
  const id = card.dataset.eventId;
  form.addEventListener('submit', async (e)=>{
    e.preventDefault();
    setLoading(form, true);
    try{
      const body = {
        nombre: form.nombre.value.trim(),
        email: form.email.value.trim()
      };
      const res = await fetch(`/?action=api_register&id=${encodeURIComponent(id)}`, {
        method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify(body)
      });
      const j = await res.json().catch(()=>({}));
      if (!res.ok) throw new Error(j.message || 'Error');
      const c = qs('#inscritosCount');
      if (c) c.textContent = String(Number(c.textContent||'0')+1);
      const ul = qs('#inscritosList');
      if (ul){
        const li = document.createElement('li');
        li.innerHTML = `<strong>${body.nombre.replace(/</g,'&lt;')}</strong> — ${body.email.replace(/</g,'&lt;')} · ${fmt(new Date())}`;
        ul.prepend(li);
      }
      toast('Inscripción registrada');
      form.reset();
    }catch(err){ toast(err.message); }
    finally{ setLoading(form, false); }
  });
}

async function handleImpact(){
  const card = qs('#impactFormCard');
  const form = qs('#impactForm');
  if (!card || !form) return;
  const id = card.dataset.eventId;
  form.addEventListener('submit', async (e)=>{
    e.preventDefault();
    setLoading(form, true);
    try{
      const payload = Object.fromEntries(new FormData(form).entries());
      ['plastico','metal','papel_carton','otros','arboles'].forEach(k => payload[k]=Number(payload[k]||0));
      const res = await fetch(`/?action=api_impact_save&id=${encodeURIComponent(id)}`, {
        method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify(payload)
      });
      const j = await res.json().catch(()=>({}));
      if (!res.ok) throw new Error(j.message || 'Error');
      let last = qs('#impactLastUpdate');
      if (!last){
        last = document.createElement('p'); last.id='impactLastUpdate'; form.parentElement.appendChild(last);
      }
      last.textContent = 'Última actualización: ' + new Date().toISOString();
      toast('Impacto guardado');
    }catch(err){ toast(err.message); }
    finally{ setLoading(form, false); }
  });
}

document.addEventListener('DOMContentLoaded', () => {
  const page = document.body.dataset.page || '';
  if (page==='index') handleIndex();
  if (page==='createForm') handleCreate();
  if (page==='detail') handleDetail();
  if (page==='impactForm') handleImpact();
});
