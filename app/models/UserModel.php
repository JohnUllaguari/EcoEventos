<?php
require_once __DIR__ . '/../helpers.php';

class UserModel {
  public static function all(){ return read_csv_assoc(DATA_DIR.'/users.csv'); }

  public static function findByEmail($email){
    foreach (self::all() as $u) if (isset($u['email']) && strtolower($u['email'])===strtolower($email)) return $u;
    return null;
  }

  public static function create($nombre,$email,$password){
    if (self::findByEmail($email)) throw new Exception("Email ya registrado");
    if (trim($nombre)==='' || trim($email)==='' || trim($password)==='') throw new Exception("Datos incompletos");
    $rows = self::all();
    $rows[] = [
      'id'=>gen_id('us'),
      'nombre'=>$nombre,
      'email'=>$email,
      'password_hash'=>password_hash($password, PASSWORD_DEFAULT),
    ];
    write_csv_assoc(DATA_DIR.'/users.csv', $rows);
    return end($rows);
  }

  public static function verify($email,$password){
    $u = self::findByEmail($email);
    if (!$u || !password_verify($password, $u['password_hash'])) return null;
    return $u;
  }
}
