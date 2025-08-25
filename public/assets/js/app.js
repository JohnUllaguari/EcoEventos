/* public/assets/js/app.js */
function qs(sel, root=document){ return root.querySelector(sel); }
function qsa(sel, root=document){ return root.querySelectorAll(sel); }
function toast(msg){ 
  // Crear un toast más elegante
  const toastEl = document.createElement('div');
  toastEl.className = 'toast';
  toastEl.textContent = msg;
  toastEl.style.cssText = `
    position: fixed; top: 20px; right: 20px; z-index: 1000;
    background: #16a34a; color: white; padding: 12px 20px;
    border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    font-size: 14px; max-width: 300px;
  `;
  document.body.appendChild(toastEl);
  setTimeout(() => toastEl.remove(), 3000);
}

function setLoading(formOrBtn, on){
  const btn = formOrBtn.tagName==='BUTTON' ? formOrBtn : qs('button[type="submit"]', formOrBtn);
  if (!btn) return;
  btn.disabled = !!on;
  btn.dataset._label = btn.dataset._label || btn.textContent;
  btn.textContent = on ? 'Procesando…' : btn.dataset._label;
}

function escapeHtml(s=''){ 
  return s.replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c])); 
}

function fmt(d){ return d.toLocaleString(); }

// Función mejorada para renderizar eventos con el nuevo diseño
function renderEvents(events) {
  const list = qs('#events-list');
  if (!list) return;
  
  const eventsCount = qs('.events-count');
  if (eventsCount) {
    eventsCount.textContent = `${events.length} evento(s) encontrado(s)`;
  }
  
  if (events.length === 0) {
    list.innerHTML = `
      <div class="no-events">
        <h3>No se encontraron eventos</h3>
        <p>No hay eventos que coincidan con tu búsqueda. Intenta con otros filtros o <a href="?action=createForm">crea un nuevo evento</a>.</p>
      </div>
    `;
    return;
  }
  
  list.innerHTML = events.map(e => {
    const isOwner = e.organizer_id && window.currentUserId && e.organizer_id === window.currentUserId;
    const editButton = isOwner ? `<a class="btn btn-edit" href="?action=updateForm&id=${encodeURIComponent(e.id)}">✏️ Editar</a>` : '';
    
    return `
      <div class="event-card">
        <div class="event-type-badge ${escapeHtml(e.tipo || '').toLowerCase()}">
          ${escapeHtml(e.tipo || '')}
        </div>
        
        <h3 class="event-title">${escapeHtml(e.titulo || '')}</h3>
        <p class="event-description">${escapeHtml(e.descripcion || '')}</p>
        
        <div class="event-meta">
          <div class="meta-item">
            <span class="icon">📅</span>
            <span>${escapeHtml(e.fecha || '')} ${escapeHtml(e.hora || '')}</span>
          </div>
          <div class="meta-item">
            <span class="icon">📍</span>
            <span>${escapeHtml(e.ubicacion || '')}</span>
          </div>
          <div class="meta-item">
            <span class="icon">👥</span>
            <span>${e.inscritos || 0}/${e.cupo > 0 ? e.cupo : '∞'} participantes</span>
          </div>
        </div>
        
        <div class="event-actions">
          <a class="btn btn-primary" href="?action=detail&id=${encodeURIComponent(e.id)}">Ver detalles</a>
          ${editButton}
        </div>
      </div>
    `;
  }).join('');
}

async function handleIndex(){
  const form = qs('#filtersForm');
  if (!form) return;
  
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const submitBtn = qs('button[type="submit"]', form);
    setLoading(submitBtn, true);
    
    try {
      const params = new URLSearchParams(new FormData(form));
      params.set('action', 'api_events');
      
      const res = await fetch('/?' + params.toString(), {
        headers: { 'Accept': 'application/json' }
      });
      
      const raw = await res.text();
      let data;
      try { 
        data = JSON.parse(raw); 
      } catch (err) {
        throw new Error('Respuesta no es JSON válido');
      }
      
      renderEvents(data);
    } catch (err) {
      toast('Error cargando eventos: ' + err.message);
      console.error(err);
    } finally {
      setLoading(submitBtn, false);
    }
  });
}

async function handleCreate(){
  const form = qs('#createForm');
  if (!form) return;
  
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    setLoading(form, true);
    
    try {
      const payload = Object.fromEntries(new FormData(form).entries());
      payload.cupo = Number(payload.cupo || 0);
      
      const res = await fetch('/?action=api_event_create', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      });
      
      if (!res.ok) { 
        const j = await res.json().catch(() => ({})); 
        throw new Error(j.message || 'Error creando evento'); 
      }
      
      toast('Evento creado exitosamente');
      setTimeout(() => location.href = '?action=index', 1000);
    } catch (err) { 
      toast(err.message); 
    } finally { 
      setLoading(form, false); 
    }
  });
}

async function handleDetail(){
  const card = qs('#eventDetail');
  const form = qs('#registerForm');
  if (!card || !form) return;
  
  const id = card.dataset.eventId;
  
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    setLoading(form, true);
    
    try {
      const body = {
        nombre: form.nombre.value.trim(),
        email: form.email.value.trim()
      };
      
      if (!body.nombre || !body.email) {
        throw new Error('Por favor completa todos los campos');
      }
      
      const res = await fetch(`/?action=api_register&id=${encodeURIComponent(id)}`, {
        method: 'POST', 
        headers: { 'Content-Type': 'application/json' }, 
        body: JSON.stringify(body)
      });
      
      const j = await res.json().catch(() => ({}));
      if (!res.ok) throw new Error(j.message || 'Error en la inscripción');
      
      // Actualizar contador
      const c = qs('#inscritosCount');
      if (c) c.textContent = String(Number(c.textContent || '0') + 1);
      
      // Agregar a la lista
      const ul = qs('#inscritosList');
      if (ul) {
        const li = document.createElement('li');
        li.innerHTML = `<strong>${escapeHtml(body.nombre)}</strong> — ${escapeHtml(body.email)} · ${fmt(new Date())}`;
        ul.prepend(li);
      }
      
      toast('¡Inscripción registrada exitosamente!');
      form.reset();
    } catch (err) { 
      toast(err.message); 
    } finally { 
      setLoading(form, false); 
    }
  });
}

async function handleImpact(){
  const card = qs('#impactFormCard');
  const form = qs('#impactForm');
  if (!card || !form) return;
  
  const id = card.dataset.eventId;
  
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    setLoading(form, true);
    
    try {
      const payload = Object.fromEntries(new FormData(form).entries());
      ['plastico','metal','papel_carton','otros','arboles'].forEach(k => 
        payload[k] = Number(payload[k] || 0)
      );
      
      const res = await fetch(`/?action=api_impact_save&id=${encodeURIComponent(id)}`, {
        method: 'POST', 
        headers: { 'Content-Type': 'application/json' }, 
        body: JSON.stringify(payload)
      });
      
      const j = await res.json().catch(() => ({}));
      if (!res.ok) throw new Error(j.message || 'Error guardando impacto');
      
      let last = qs('#impactLastUpdate');
      if (!last) {
        last = document.createElement('p'); 
        last.id = 'impactLastUpdate'; 
        last.style.cssText = 'color: #16a34a; font-size: 14px; margin-top: 10px;';
        form.parentElement.appendChild(last);
      }
      last.textContent = 'Última actualización: ' + new Date().toLocaleString();
      
      toast('Impacto guardado exitosamente');
    } catch (err) { 
      toast(err.message); 
    } finally { 
      setLoading(form, false); 
    }
  });
}

// Función para manejar formularios de actualización
async function handleUpdate(){
  const form = qs('form[action*="updateSubmit"]');
  if (!form) return;
  
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    setLoading(form, true);
    
    try {
      const formData = new FormData(form);
      const response = await fetch(form.action, {
        method: 'POST',
        body: formData
      });
      
      if (response.ok) {
        toast('Evento actualizado exitosamente');
        // Redirigir después de un breve delay
        setTimeout(() => {
          window.location.href = response.url || form.action.replace('updateSubmit', 'detail');
        }, 1000);
      } else {
        throw new Error('Error actualizando el evento');
      }
    } catch (err) {
      toast(err.message);
    } finally {
      setLoading(form, false);
    }
  });
}

// Inicialización cuando el DOM está listo
document.addEventListener('DOMContentLoaded', () => {
  const page = document.body.dataset.page || '';
  
  // Configurar el usuario actual para verificar permisos
  const userMeta = qs('meta[name="current-user-id"]');
  if (userMeta) {
    window.currentUserId = userMeta.content;
  }
  
  // Manejar diferentes páginas
  if (page === 'index') handleIndex();
  if (page === 'createForm') handleCreate();
  if (page === 'detail') handleDetail();
  if (page === 'impactForm') handleImpact();
  if (page === 'updateForm') handleUpdate();
  
  // Agregar animaciones suaves a los botones
  qsa('.btn').forEach(btn => {
    btn.addEventListener('mouseenter', () => {
      btn.style.transform = 'translateY(-1px)';
    });
    btn.addEventListener('mouseleave', () => {
      btn.style.transform = 'translateY(0)';
    });
  });
});
