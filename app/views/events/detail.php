<?php // app/views/events/detail.php ?>

<?php if (!isset($event) || !$event): ?>
  <div class="card">
    <p>⚠️ Error: No se encontró información del evento solicitado.</p>
  </div>
<?php else: ?>

<div class="card" id="eventDetail" data-event-id="<?php echo htmlspecialchars($event['id']); ?>">
  <div class="event-header">
    <h2><?php echo htmlspecialchars($event['titulo']); ?></h2>

    <?php if (function_exists('is_owner') && is_owner($event)): ?>
      <div class="owner-actions">
        <a href="?action=updateForm&id=<?php echo urlencode($event['id']); ?>" class="btn btn-edit">✏️ Editar</a>
        <a href="?action=impactForm&id=<?php echo urlencode($event['id']); ?>" class="btn btn-impact">📊 Registrar Impacto</a>
      </div>
    <?php endif; ?>
  </div>

  <p><?php echo htmlspecialchars($event['descripcion']); ?></p>

  <?php if (!empty($event['detalle'])): ?>
    <div class="event-details">
      <h4>Detalles adicionales:</h4>
      <p><?php echo nl2br(htmlspecialchars($event['detalle'])); ?></p>
    </div>
  <?php endif; ?>

  <ul class="event-info">
    <li>📅 Fecha: <?php echo htmlspecialchars($event['fecha']); ?> <?php echo htmlspecialchars($event['hora']); ?></li>
    <li>📍 Ubicación: <?php echo htmlspecialchars($event['ubicacion']); ?></li>
    <li id="participantsLine">
      👥 Participantes: 
      <span id="inscritosCount"><?php echo htmlspecialchars($event['inscritos']); ?></span>
      /<?php echo ($event['cupo'] > 0) ? htmlspecialchars($event['cupo']) : 'Ilimitado'; ?>
    </li>
    <li>🏷️ Tipo: <?php echo htmlspecialchars($event['tipo']); ?></li>
  </ul>

  <?php if (!function_exists('current_user') || !current_user()): ?>
    <div class="login-prompt">
      <p>Para inscribirte en este evento, necesitas 
         <a href="?action=loginForm">iniciar sesión</a> o 
         <a href="?action=registerForm">registrarte</a>.</p>
    </div>
  <?php else: ?>
    <h3>Inscribirse</h3>
    <form id="registerForm" method="post" 
          action="?action=registerSubmit&id=<?php echo urlencode($event['id']); ?>">
      <div class="form-row">
        <input name="nombre" placeholder="Tu nombre" 
               value="<?php echo htmlspecialchars(current_user()['nombre']); ?>" required>
        <input type="email" name="email" placeholder="Tu email" 
               value="<?php echo htmlspecialchars(current_user()['email']); ?>" required>
      </div>
      <button class="btn btn-primary">Inscribirme</button>
    </form>
  <?php endif; ?>
</div>

<div class="card">
  <h3>Inscritos (<?php echo isset($regs) ? count($regs) : 0; ?>)</h3>
  <?php if (empty($regs)) { ?>
    <p>Aún no hay inscritos para este evento.</p>
  <?php } else { ?>
    <ul id="inscritosList">
      <?php foreach ($regs as $r): 
        $ts = isset($r['timestamp']) ? date('d/m/Y H:i', strtotime($r['timestamp'])) : ''; ?>
        <li>
          <strong><?php echo htmlspecialchars($r['nombre']); ?></strong> — 
          <?php echo htmlspecialchars($r['email']); ?> 
          <?php if ($ts) echo ' · '.htmlspecialchars($ts); ?>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php } ?>
</div>

<?php endif; ?>


<style>
.event-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 20px;
  flex-wrap: wrap;
  gap: 15px;
}

.event-header h2 {
  margin: 0;
  color: #111827;
  flex: 1;
  min-width: 250px;
}

.owner-actions {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}

.btn-edit {
  background-color: #f59e0b;
  color: white;
  font-size: 12px;
  padding: 8px 12px;
  text-decoration: none;
  border-radius: 6px;
}

.btn-edit:hover {
  background-color: #d97706;
}

.btn-impact {
  background-color: #8b5cf6;
  color: white;
  font-size: 12px;
  padding: 8px 12px;
  text-decoration: none;
  border-radius: 6px;
}

.btn-impact:hover {
  background-color: #7c3aed;
}

.event-details {
  background-color: #f9fafb;
  padding: 15px;
  border-radius: 8px;
  margin: 15px 0;
}

.event-details h4 {
  margin: 0 0 10px 0;
  color: #374151;
  font-size: 14px;
  font-weight: 600;
}

.event-info {
  list-style: none;
  padding: 0;
  margin: 15px 0;
}

.event-info li {
  display: flex;
  align-items: center;
  margin: 10px 0;
  color: #374151;
  font-size: 14px;
}

.login-prompt {
  background-color: #fef3c7;
  border: 1px solid #f59e0b;
  border-radius: 8px;
  padding: 15px;
  margin: 20px 0;
  text-align: center;
}

.login-prompt p {
  margin: 0;
  color: #92400e;
}

.login-prompt a {
  color: #d97706;
  text-decoration: none;
  font-weight: 600;
}

.login-prompt a:hover {
  text-decoration: underline;
}

.form-row {
  display: flex;
  gap: 12px;
  margin-bottom: 15px;
}

.form-row input {
  flex: 1;
}

.btn-primary {
  background-color: #16a34a;
  color: white;
  padding: 12px 24px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 600;
}

.btn-primary:hover {
  background-color: #15803d;
}

@media (max-width: 768px) {
  .event-header {
    flex-direction: column;
    align-items: stretch;
  }
  
  .owner-actions {
    justify-content: center;
  }
  
  .form-row {
    flex-direction: column;
  }
}
</style>

