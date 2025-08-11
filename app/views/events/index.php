<?php // app/views/events/index.php ?>
<div class="card">
  <form method="get">
    <input type="hidden" name="action" value="index">
    <input name="search" placeholder="Buscar..." value="<?php echo e($_GET['search'] ?? ''); ?>">
    <select name="tipo">
      <option <?php echo (($_GET['tipo'] ?? '')==='Todos')?'selected':''; ?>>Todos</option>
      <option <?php echo (($_GET['tipo'] ?? '')==='Limpieza')?'selected':''; ?>>Limpieza</option>
      <option <?php echo (($_GET['tipo'] ?? '')==='Sembratón')?'selected':''; ?>>Sembratón</option>
      <option <?php echo (($_GET['tipo'] ?? '')==='Minga')?'selected':''; ?>>Minga</option>
    </select>
    <button class="btn">Filtrar</button>
    <a class="btn sec" href="?action=index">Limpiar</a>
  </form>
</div>

<?php foreach ($events as $e) { ?>
  <div class="card">
    <h3><?php echo e($e['titulo']); ?> <small>(<?php echo e($e['tipo']); ?>)</small></h3>
    <p><?php echo e($e['descripcion']); ?></p>
    <p>📅 <?php echo e($e['fecha']); ?> <?php echo e($e['hora']); ?> — 📍 <?php echo e($e['ubicacion']); ?></p>
    <p>👥 <?php echo e($e['inscritos']); ?>/<?php echo e($e['cupo']); ?> participantes</p>
    <a class="btn" href="?action=detail&id=<?php echo urlencode($e['id']); ?>">Ver detalles</a>
  </div>                              
<?php } ?>

