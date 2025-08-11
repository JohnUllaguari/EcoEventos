<?php
require_once __DIR__ . '/../helpers.php';

# EventModel.php

class EventModel {

  
  # leer todos los eventos
  public static function all(){
    return read_csv_assoc(EVENTS_CSV);
  }

  # filtrar eventos por tipo y búsqueda
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

  # buscar un evento por id
  public static function find($id){
    foreach (self::all() as $e){ if (($e['id']??'')===$id) return $e; }
    return null;
  }

  # crear un evento
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
      'detalle'=>$data['detalle'] ?? ''
    ];
    $events[] = $ev;
    write_csv_assoc(EVENTS_CSV, $events);
    return $ev;
  }

  # incrementar el número de inscritos de un evento
  public static function incrementInscritos($id){
    $events = self::all();
    for($i=0;$i<count($events);$i++){
      if ($events[$i]['id']===$id){
        $events[$i]['inscritos'] = (string) (intval($events[$i]['inscritos']) + 1);
        break;
      }
    }
    write_csv_assoc(EVENTS_CSV, $events);
  }
}
