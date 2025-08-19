<?php
require_once __DIR__ . '/../helpers.php';

class ImpactModel {
  public static function all(){ return read_csv_assoc(DATA_DIR.'/impacts.csv'); }

  // Devuelve la fila de impacto para un evento (o null si no existe)
  public static function forEvent($eventId){
    foreach (self::all() as $row) {
      if (($row['event_id'] ?? '') === $eventId) return $row;
    }
    return null;
  }

  public static function upsert($eventId,$organizerId,$data){
    $rows = self::all();
    $found = False;
    for ($i=0;$i<count($rows);$i++){
      if (($rows[$i]['event_id'] ?? '') === $eventId) {
        $rows[$i] = array_merge($rows[$i], [
          'plastico'     => (string)intval($data['plastico'] ?? 0),
          'metal'        => (string)intval($data['metal'] ?? 0),
          'papel_carton' => (string)intval($data['papel_carton'] ?? 0),
          'otros'        => (string)intval($data['otros'] ?? 0),
          'arboles'      => (string)intval($data['arboles'] ?? 0),
          'timestamp'    => date('c'),
          'notas'        => $data['notas'] ?? ''
        ]);
        $found = True; break;
      }
    }
    if (!$found){
      $rows[] = [
        'id'           => gen_id('im'),
        'event_id'     => $eventId,
        'organizer_id' => $organizerId,
        'plastico'     => (string)intval($data['plastico'] ?? 0),
        'metal'        => (string)intval($data['metal'] ?? 0),
        'papel_carton' => (string)intval($data['papel_carton'] ?? 0),
        'otros'        => (string)intval($data['otros'] ?? 0),
        'arboles'      => (string)intval($data['arboles'] ?? 0),
        'timestamp'    => date('c'),
        'notas'        => $data['notas'] ?? ''
      ];
    }
    write_csv_assoc(DATA_DIR.'/impacts.csv', $rows);
    return true;
  }
}
