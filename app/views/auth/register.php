<?php // app/views/auth/register.php ?>
<div class="card">
  <h2>Registrarse</h2>
  <form id="registerUserForm" method="post" action="?action=register">
    <input name="nombre" placeholder="Nombre" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button class="btn">Crear cuenta</button>
  </form>
</div>
