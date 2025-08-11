<?php 
// public/index.php - Front Controller
require __DIR__ . '/../app/controllers/EventController.php';

// Si no hay acción en la URL, redirigir a la página principal
if (!isset($_GET['action'])) {
    header("Location: ?action=index");
    exit;
}

$action = $_GET['action'];
$ctrl = new EventController();

switch ($action) {
    // VISTAS
    case 'index':           $ctrl->index(); break;
    case 'detail':          $ctrl->detail(); break;
    case 'createForm':      $ctrl->createForm(); break;
    case 'createSubmit':    $ctrl->createSubmit(); break;
    case 'registerSubmit':  $ctrl->registerSubmit(); break;

    // API
    case 'api_events':        $ctrl->apiEvents(); break;
    case 'api_event_detail':  $ctrl->apiEventDetail(); break;
    case 'api_event_create':  $ctrl->apiEventCreate(); break;
    case 'api_register':      $ctrl->apiRegister(); break;

    default:
        http_response_code(404);
        echo "Not Found";
}


?>