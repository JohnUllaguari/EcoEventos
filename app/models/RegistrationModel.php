<?php
require_once __DIR__ . '/../helpers.php';

class RegistrationModel {
  public static function all(){
    return read_csv_assoc(REGS_CSV);
  }
  public static function forEvent($eventId){
    return array_values(array_filter(self::all(), function($r) use ($eventId){
      return isset($r['event_id']) && $r['event_id']===$eventId;
    }));
  }
  public static function create($event, $nombre, $email){
    if (trim($nombre)==='' || trim($email)==='') throw new Exception('nombre y email son obligatorios');
    $cupo = intval($event['cupo']);
    $ins  = intval($event['inscritos']);
    if ($cupo>0 && $ins >= $cupo) throw new Exception('Cupo lleno');
    $rows = self::all();
    $rows[] = ['id'=>gen_id('rg'),'event_id'=>$event['id'],'nombre'=>$nombre,'email'=>$email,'timestamp'=>date('c')];
    write_csv_assoc(REGS_CSV, $rows);
  }
}
