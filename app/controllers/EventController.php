<?php
// app/controllers/EventController.php
require_once __DIR__ . '/../models/EventModel.php';
require_once __DIR__ . '/../models/RegistrationModel.php';

class EventController {
  /* VISTAS */

  # lista + filtros (Requisito: Ver eventos).
  public function index(){
    $tipo   = $_GET['tipo']   ?? '';
    $search = $_GET['search'] ?? '';
    $events = EventModel::filter($tipo, $search);
    $view = __DIR__ . '/../views/events/index.php';
    require __DIR__ . '/../views/layout/header.php';
    require $view;
    require __DIR__ . '/../views/layout/footer.php';
  }

  # detalle + lista de inscritos + form de inscripción. (Requisito: Ver detalles de un evento).
  public function detail(){
    $id = $_GET['id'] ?? '';
    $event = EventModel::find($id);
    if (!$event){ http_response_code(404); echo "<p>No encontrado</p>"; return; }
    $regs = RegistrationModel::forEvent($id);
    $view = __DIR__ . '/../views/events/detail.php';
    require __DIR__ . '/../views/layout/header.php';
    require $view;
    require __DIR__ . '/../views/layout/footer.php';
  }

  # formulario de creación de evento (Requisito: Crear un evento).
  
  public function createForm(){
    $view = __DIR__ . '/../views/events/create.php';
    require __DIR__ . '/../views/layout/header.php';
    require $view;
    require __DIR__ . '/../views/layout/footer.php';
  }

  # procesar formulario de creación de evento (Requisito: Crear un evento).
  public function createSubmit(){
    try{
      EventModel::create($_POST);
      header("Location: ?action=index");
    } catch (Exception $e){
      http_response_code(400);
      echo "<p>Error: ".htmlspecialchars($e->getMessage())."</p>";
    }
  }

  # procesar formulario de inscripción a evento (Requisito: Inscribirse a un evento).
  public function registerSubmit(){
    $id = $_GET['id'] ?? '';
    $event = EventModel::find($id);
    if (!$event){ echo "<p>No encontrado</p>"; return; }
    try{
      RegistrationModel::create($event, $_POST['nombre'] ?? '', $_POST['email'] ?? '');
      EventModel::incrementInscritos($id);
      echo "<script>alert('Inscripción registrada');location='?action=detail&id=".htmlspecialchars($id,ENT_QUOTES,'UTF-8')."';</script>";
    } catch (Exception $e){
      echo "<p>Error: ".htmlspecialchars($e->getMessage())."</p>";
    }
  }

  /* API  */
  
  # listar eventos (Requisito: Ver eventos).
  
  public function apiEvents(){
    header('Content-Type: application/json; charset=utf-8');
    $tipo   = $_GET['tipo']   ?? '';
    $search = $_GET['search'] ?? '';
    echo json_encode(EventModel::filter($tipo,$search), JSON_UNESCAPED_UNICODE);
  }

  # detalle de evento (Requisito: Ver detalles de un evento).
  public function apiEventDetail(){
    header('Content-Type: application/json; charset=utf-8');
    $id = $_GET['id'] ?? '';
    $ev = EventModel::find($id);
    if (!$ev){ http_response_code(404); echo json_encode(['message'=>'No encontrado'], JSON_UNESCAPED_UNICODE); return; }
    echo json_encode($ev, JSON_UNESCAPED_UNICODE);
  }

  # crear evento (Requisito: Crear un evento).
  public function apiEventCreate(){
    header('Content-Type: application/json; charset=utf-8');
    $input = json_decode(file_get_contents('php://input'), true) ?: [];
    try{
      $ev = EventModel::create($input);
      echo json_encode($ev, JSON_UNESCAPED_UNICODE);
    } catch (Exception $e){
      http_response_code(400); echo json_encode(['message'=>$e->getMessage()], JSON_UNESCAPED_UNICODE);
    }
  }

  # inscribirse a evento (Requisito: Inscribirse a un evento).
  public function apiRegister(){
    header('Content-Type: application/json; charset=utf-8');
    $id = $_GET['id'] ?? '';
    $event = EventModel::find($id);
    if (!$event){ http_response_code(404); echo json_encode(['message'=>'No encontrado'], JSON_UNESCAPED_UNICODE); return; }
    $input = json_decode(file_get_contents('php://input'), true) ?: [];
    try{
      RegistrationModel::create($event, $input['nombre'] ?? '', $input['email'] ?? '');
      EventModel::incrementInscritos($id);
      echo json_encode(['message'=>'Inscripción registrada','eventId'=>$id], JSON_UNESCAPED_UNICODE);
    } catch (Exception $e){
      $code = ($e->getMessage()==='Cupo lleno') ? 409 : 400;
      http_response_code($code); echo json_encode(['message'=>$e->getMessage()], JSON_UNESCAPED_UNICODE);
    }
  }
}
