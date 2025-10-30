<?php // app/views/impact/form.php ?>

<?php if (!isset($event) || !$event): ?>
  <div class="card">
    <p>⚠️ Error: No se encontró el evento para registrar impacto.</p>
  </div>
<?php else: ?>
  <div class="card" id="impactFormCard" data-event-id="<?php echo htmlspecialchars($event['id']); ?>">
    <h2>Impacto: <?php echo htmlspecialchars($event['titulo']); ?></h2>
    
    <form id="impactForm" class="grid" method="post" 
          action="?action=impactSave&id=<?php echo urlencode($event['id']); ?>">
      <input type="number" min="0" name="plastico" placeholder="Plásticos (kg)" 
             value="<?php echo htmlspecialchars($impact['plastico'] ?? ''); ?>">
      <input type="number" min="0" name="metal" placeholder="Metales (kg)" 
             value="<?php echo htmlspecialchars($impact['metal'] ?? ''); ?>">
      <input type="number" min="0" name="papel_carton" placeholder="Papel/Cartón (kg)" 
             value="<?php echo htmlspecialchars($impact['papel_carton'] ?? ''); ?>">
      <input type="number" min="0" name="otros" placeholder="Otros (kg)" 
             value="<?php echo htmlspecialchars($impact['otros'] ?? ''); ?>">
      <input type="number" min="0" name="arboles" placeholder="Árboles plantados" 
             value="<?php echo htmlspecialchars($impact['arboles'] ?? ''); ?>">
      <textarea name="notas" class="full" placeholder="Notas u observaciones"><?php echo htmlspecialchars($impact['notas'] ?? ''); ?></textarea>
      <button class="btn full">Guardar impacto</button>
    </form>

    <?php if (!empty($impact) && !empty($impact['timestamp'])): ?>
      <p id="impactLastUpdate">Última actualización: 
        <?php echo htmlspecialchars($impact['timestamp']); ?>
      </p>
    <?php endif; ?>
  </div>
<?php endif; ?>