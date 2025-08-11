<?php
date_default_timezone_set('America/Guayaquil');

define('BASE_PATH', dirname(__DIR__));
define('DATA_DIR', BASE_PATH . '/data');
define('EVENTS_CSV', DATA_DIR . '/events.csv');
define('REGS_CSV', DATA_DIR . '/registrations.csv');


function e($s){ return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8'); }
# CSV helper 
function read_csv_assoc($file){
  $rows = [];
  if (!file_exists($file)) return $rows;
  if (($h=fopen($file,'r'))!==false){
    $headers = fgetcsv($h);
    if (!$headers){ fclose($h); return $rows; }
    while(($r=fgetcsv($h))!==false){
      while(count($r)<count($headers)) $r[]='';
      $rows[] = array_combine($headers, $r);
    }
    fclose($h);
  }
  return $rows;
}
function write_csv_assoc($file,$rows){
  if (empty($rows)) return;
  $headers = array_keys($rows[0]);
  $h = fopen($file,'w');
  fputcsv($h,$headers);
  foreach($rows as $r){ fputcsv($h, array_map('strval', $r)); }
  fclose($h);
}
function gen_id($p='id'){ return $p . substr(bin2hex(random_bytes(4)), 0, 8); }
