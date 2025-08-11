<?php // app/views/events/create.php ?>
<div class="card">
  <h2>Crear nuevo evento</h2>
  <form class="grid" method="post" action="?action=createSubmit">
    <input name="titulo" placeholder="Título *" required class="full">
    <select name="tipo"><option>Limpieza</option><option>Sembratón</option><option>Minga</option></select>
    <input type="date" name="fecha" required>
    <input type="time" name="hora">
    <input name="ubicacion" placeholder="Ubicación *" required class="full">
    <input type="number" min="0" name="cupo" placeholder="Cupo (0 = ilimitado)">
    <textarea name="descripcion" placeholder="Descripción" class="full"></textarea>
    <textarea name="detalle" placeholder="Detalle" class="full"></textarea>
    <button class="btn full">Guardar</button>
  </form>
</div>
