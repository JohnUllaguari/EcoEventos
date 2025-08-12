<?php
require_once __DIR__ . '/../helpers.php';

class RegistrationModel {

  # leer todas las inscripciones
  public static function all(){
    return read_csv_assoc(REGS_CSV);
  }
  # filtrar inscripciones por evento
  public static function forEvent($eventId){
    return array_values(array_filter(self::all(), function($r) use ($eventId){
      return isset($r['event_id']) && $r['event_id']===$eventId;
    }));
  }
  
  # crear una inscripción
  public static function create($event, $nombre, $email){
    if (trim($nombre)==='' || trim($email)==='') {
      throw new Exception('nombre y email son obligatorios');
    }
    $cupo = intval($event['cupo']);
    $ins  = intval($event['inscritos']);
    if ($cupo > 0 && $ins >= $cupo) {
      throw new Exception('Cupo lleno');
    }

    // leer las inscripciones actuales
    $rows = self::all();

        //Validar que no exista ya el mismo email para este evento - john
    foreach ($rows as $r) {
      if ($r['event_id'] === $event['id'] && strtolower(trim($r['email'])) === strtolower(trim($email))) {
        throw new Exception('Ya estás inscrito en este evento');
      }
    }

    // agregar una nueva fila (PHP usa $array[] para push)
    $rows[] = [
      'id'       => gen_id('rg'),
      'event_id' => $event['id'],
      'nombre'   => $nombre,
      'email'    => $email,
      'timestamp'=> date('c')
    ];

    // guardar
    write_csv_assoc(REGS_CSV, $rows);
  }

}
