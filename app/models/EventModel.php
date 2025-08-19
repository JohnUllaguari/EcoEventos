<?php
require_once __DIR__ . '/../helpers.php';

class EventModel {
  public static function all(){
    return read_csv_assoc(EVENTS_CSV);
  }
  public static function filter($tipo='', $search=''){
    $events = self::all();
    $search = mb_strtolower(trim($search), 'UTF-8');
    return array_values(array_filter($events, function($e) use($tipo,$search){
      $ok = true;
      if ($tipo && $tipo!=='Todos'){
        $ok = $ok && (mb_strtolower($e['tipo'],'UTF-8') === mb_strtolower($tipo,'UTF-8'));
      }
      if ($search){
        $hay = mb_strtolower(($e['titulo']??'') . ' ' . ($e['descripcion']??'') . ' ' . ($e['ubicacion']??''), 'UTF-8');
        $ok = $ok && (mb_strpos($hay,$search)!==false);
      }
      return $ok;
    }));
  }
  public static function find($id){
    foreach (self::all() as $e){ if (($e['id']??'')===$id) return $e; }
    return null;
  }
  public static function create($data){
    foreach (['titulo','tipo','fecha','ubicacion'] as $r){
      if (empty(trim($data[$r] ?? ''))) throw new Exception('Faltan campos obligatorios');
    }
    $events = self::all();
    $ev = [
      'id'=>gen_id('ev'),
      'titulo'=>$data['titulo'],
      'tipo'=>$data['tipo'],
      'fecha'=>$data['fecha'],
      'hora'=>$data['hora'] ?? '',
      'ubicacion'=>$data['ubicacion'],
      'cupo'=>(string) intval($data['cupo'] ?? 0),
      'inscritos'=>'0',
      'descripcion'=>$data['descripcion'] ?? '',
      'detalle'=>$data['detalle'] ?? '',
      'organizer_id'=> current_user()['id'] ?? ''
    ];
    $events[] = $ev;
    write_csv_assoc(EVENTS_CSV, $events);
    return $ev;
  }
  public static function incrementInscritos($id){
    $events = self::all();
    $changed = false;
    for($i=0;$i<count($events);$i++){
      if ($events[$i]['id']===$id){
        $events[$i]['inscritos'] = (string) (intval($events[$i]['inscritos']) + 1);
        $changed = true; break;
      }
    }
    if ($changed) write_csv_assoc(EVENTS_CSV, $events);
  }
  public static function forOrganizer($orgId){
    return array_values(array_filter(self::all(), fn($e)=> ($e['organizer_id'] ?? '') === $orgId));
  }
}
