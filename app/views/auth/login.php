<?php // app/views/auth/login.php ?>
<div class="card">
  <h2>Ingresar</h2>
  <form id="loginForm" method="post" action="?action=login">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button class="btn">Entrar</button>
  </form>
</div>
