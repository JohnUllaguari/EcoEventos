<?php // app/views/events/index.php ?>
<div class="card">
  <form id="filtersForm" method="get">
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

<div id="events-list">
  <?php if (!empty($events)) : ?>
    <?php foreach ($events as $e) : ?>
      <div class="card">
        <h3><?php echo htmlspecialchars($e['titulo']); ?> 
            <small>(<?php echo htmlspecialchars($e['tipo']); ?>)</small></h3>
        <p><?php echo htmlspecialchars($e['descripcion']); ?></p>
        <p>📅 <?php echo htmlspecialchars($e['fecha']); ?> <?php echo htmlspecialchars($e['hora']); ?> — 
           📍 <?php echo htmlspecialchars($e['ubicacion']); ?></p>
        <p>👥 <?php echo htmlspecialchars($e['inscritos']); ?>/<?php echo htmlspecialchars($e['cupo']); ?> participantes</p>
        <a class="btn" href="?action=detail&id=<?php echo urlencode($e['id']); ?>">Ver detalles</a>
      </div>
    <?php endforeach; ?>
  <?php else : ?>
    <div class="card">
      <p>⚠️ No se encontraron eventos disponibles.</p>
    </div>
  <?php endif; ?>
</div>

