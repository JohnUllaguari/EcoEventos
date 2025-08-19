<?php
require_once __DIR__ . '/../app/controllers/EventController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/ImpactController.php';
require_once __DIR__ . '/../app/helpers.php';

$action = $_GET['action'] ?? 'index';
$ev = new EventController();
$au = new AuthController();
$im = new ImpactController();

switch ($action) {
  case 'index':           $ev->index(); break;
  case 'detail':          $ev->detail(); break;
  case 'createForm':      require_auth(); $ev->createForm(); break;
  case 'createSubmit':    require_auth(); $ev->createSubmit(); break;
  case 'registerSubmit':  $ev->registerSubmit(); break;

  case 'loginForm':       $au->loginForm(); break;
  case 'registerForm':    $au->registerForm(); break;
  case 'login':           $au->login(); break;
  case 'register':        $au->register(); break;
  case 'logout':          $au->logout(); break;

  case 'myEvents':        $im->myEvents(); break;
  case 'impactForm':      $im->form(); break;
  case 'impactSave':      $im->save(); break;
  case 'api_impact_save': $im->apiSave(); break;

  case 'api_events':        $ev->apiEvents(); break;
  case 'api_event_detail':  $ev->apiEventDetail(); break;
  case 'api_event_create':  require_auth(); $ev->apiEventCreate(); break;
  case 'api_register':      $ev->apiRegister(); break;
  case 'api_impact_detail': $im->apiDetail(); break;

  default:
    http_response_code(404);
    echo "Not Found";
}
