<?php // app/views/impact/form.php ?>
<div class="card" id="impactFormCard" data-event-id="<?php echo e($event['id']); ?>">
  <h2>Impacto: <?php echo e($event['titulo']); ?></h2>
  <form id="impactForm" class="grid" method="post" action="?action=impactSave&id=<?php echo urlencode($event['id']); ?>">
    <input type="number" min="0" name="plastico"     placeholder="Plásticos (kg)"     value="<?php echo e($impact['plastico'] ?? ''); ?>">
    <input type="number" min="0" name="metal"        placeholder="Metales (kg)"       value="<?php echo e($impact['metal'] ?? ''); ?>">
    <input type="number" min="0" name="papel_carton" placeholder="Papel/Cartón (kg)"  value="<?php echo e($impact['papel_carton'] ?? ''); ?>">
    <input type="number" min="0" name="otros"        placeholder="Otros (kg)"         value="<?php echo e($impact['otros'] ?? ''); ?>">
    <input type="number" min="0" name="arboles"      placeholder="Árboles plantados"  value="<?php echo e($impact['arboles'] ?? ''); ?>">
    <textarea name="notas" class="full" placeholder="Notas u observaciones"><?php echo e($impact['notas'] ?? ''); ?></textarea>
    <button class="btn full">Guardar impacto</button>
  </form>
  <?php if(!empty($impact)){ ?>
    <p id="impactLastUpdate">Última actualización: <?php echo e($impact['timestamp']); ?></p>
  <?php } ?>
</div>
