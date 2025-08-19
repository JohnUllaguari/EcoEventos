<?php
require_once __DIR__ . '/../models/EventModel.php';
require_once __DIR__ . '/../models/ImpactModel.php';

class ImpactController {
  public function myEvents(){
    require_auth();
    $events = EventModel::forOrganizer(current_user()['id']);
    $PAGE = 'myEvents';
    require __DIR__.'/../views/layout/header.php';
    require __DIR__.'/../views/impact/my_events.php';
    require __DIR__.'/../views/layout/footer.php';
  }

  
  public function form(){
    require_auth();
    $id = $_GET['id'] ?? '';
    $event = EventModel::find($id);
    if (!$event || !is_owner($event)) { http_response_code(403); echo "No autorizado"; return; }
    $impact = ImpactModel::forEvent($id);
    $PAGE = 'impactForm';
    require __DIR__.'/../views/layout/header.php';
    require __DIR__.'/../views/impact/form.php';
    require __DIR__.'/../views/layout/footer.php';
  }
  public function save(){
    require_auth();
    $id = $_GET['id'] ?? '';
    $event = EventModel::find($id);
    if (!$event || !is_owner($event)) { http_response_code(403); echo "No autorizado"; return; }
    ImpactModel::upsert($id, current_user()['id'], $_POST);
    header("Location: ?action=impactForm&id=".$id);
  }

  public function apiDetail(){
    // limpia cualquier salida previa que rompa el JSON
    if (function_exists('ob_get_length') && ob_get_length()) { @ob_clean(); }
    header('Content-Type: application/json; charset=utf-8');

    $id = $_GET['id'] ?? '';
    if (!$id) { http_response_code(400); echo json_encode(['message'=>'Falta id']); exit; }

    $impact = ImpactModel::forEvent($id);
    if (!$impact) {
      http_response_code(404);
      echo json_encode(['message' => 'No hay impacto registrado para este evento']);
      exit;
    }

    // Opcional: incluir título del evento
    $event = EventModel::find($id);
    if ($event) $impact['event_title'] = $event['titulo'];

    echo json_encode($impact, JSON_UNESCAPED_UNICODE);
    exit;
  }


  
  public function apiSave(){
    require_auth();
    header('Content-Type: application/json; charset=utf-8');
    $id = $_GET['id'] ?? '';
    $event = EventModel::find($id);
    if (!$event || !is_owner($event)) { http_response_code(403); echo json_encode(['message'=>'No autorizado']); return; }
    $body = json_decode(file_get_contents('php://input'), true) ?: [];
    ImpactModel::upsert($id, current_user()['id'], $body);
    echo json_encode(['message'=>'Impacto registrado']);
  }
}
