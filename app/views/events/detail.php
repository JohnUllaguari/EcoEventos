<?php // app/views/events/detail.php ?>
<div class="card">
  <h2><?php echo e($event['titulo']); ?></h2>
  <p><?php echo e($event['descripcion']); ?></p>
  <ul>
    <li>Fecha: <?php echo e($event['fecha']); ?> <?php echo e($event['hora']); ?></li>
    <li>Ubicación: <?php echo e($event['ubicacion']); ?></li>
    <li>Participantes: <?php echo e($event['inscritos']); ?>/<?php echo e($event['cupo']); ?></li>
    <li>Tipo: <?php echo e($event['tipo']); ?></li>
  </ul>
  <h3>Inscribirse</h3>
  <form method="post" action="?action=registerSubmit&id=<?php echo urlencode($event['id']); ?>">
    <input name="nombre" placeholder="Tu nombre" required>
    <input type="email" name="email" placeholder="Tu email" required>
    <button class="btn">Inscribirme</button>
  </form>
</div>

<div class="card">
  <h3>Inscritos (<?php echo count($regs); ?>)</h3>
  <?php if (count($regs)===0) { ?>
    <p>Aún no hay inscritos para este evento.</p>
  <?php } else { ?>
    <ul>
      <?php foreach ($regs as $r) {
        $ts = isset($r['timestamp']) ? date('d/m/Y H:i', strtotime($r['timestamp'])) : '';
      ?>
        <li><strong><?php echo e($r['nombre']); ?></strong> — <?php echo e($r['email']); ?> <?php if ($ts) echo ' · '.e($ts); ?></li>
      <?php } ?>
    </ul>
  <?php } ?>
</div>
