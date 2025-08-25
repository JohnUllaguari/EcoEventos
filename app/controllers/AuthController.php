<?php
require_once __DIR__ . '/../models/UserModel.php';

class AuthController {
  public function registerForm(){
    $PAGE = 'registerForm';
    require __DIR__.'/../views/layout/header.php';
    require __DIR__.'/../views/auth/register.php';
    require __DIR__.'/../views/layout/footer.php';
  }
  public function loginForm(){
    $PAGE = 'loginForm';
    require __DIR__.'/../views/layout/header.php';
    require __DIR__.'/../views/auth/login.php';
    require __DIR__.'/../views/layout/footer.php';
  }
  public function register(){
    try{
      $u = UserModel::create($_POST['nombre']??'', $_POST['email']??'', $_POST['password']??'');
      $_SESSION['user'] = $u; header("Location: ?action=index");
    } catch(Exception $e){ http_response_code(400); echo "Error: ".e($e->getMessage()); }
  }
  public function login(){
    $u = UserModel::verify($_POST['email']??'', $_POST['password']??'');
    if (!$u){ echo "Credenciales inválidas"; return; }
    $_SESSION['user'] = $u; header("Location: ?action=index");
  }
  public function logout(){ session_destroy(); header("Location: ?action=index"); }
}
