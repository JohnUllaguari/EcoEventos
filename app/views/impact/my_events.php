<?php // app/views/impact/my_events.php ?>
<div class="card"><h2>Mis eventos</h2></div>
<?php if (empty($events)) { ?>
  <div class="card"><p>Aún no has creado eventos.</p></div>
<?php } else { foreach($events as $e){ ?>
  <div class="card">
    <h3><?php echo e($e['titulo']); ?></h3>
    <p>📅 <?php echo e($e['fecha']); ?> <?php echo e($e['hora']); ?> — 📍 <?php echo e($e['ubicacion']); ?></p>
    <a class="btn" href="?action=impactForm&id=<?php echo urlencode($e['id']); ?>">Registrar impacto</a>
  </div>
<?php } } ?>
