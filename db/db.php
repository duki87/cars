<?php
  session_start();
//   $hostname = 'localhost';
//   $username = 'root';
//   $password = '';
//   $database = 'homoljsko';
//   $connect = '';
//   $options = [
//     \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
// ];
//
// try {
//   if ($connect = new PDO("mysql:host=$hostname; dbname=$database", "$username", "", $options)) {
//     echo '';
//   } else {
//     throw new Exception('Povezivanje nije uspelo!');
//   }
// }
//
// catch(Exception $e) {
//   echo $e->getMessage();
// }

class Database {
  private $hostname = 'localhost';
  private $username = 'root';
  private $password = '';
  private $database = 'cars';
  private $connect = '';
  private $options = [
    \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
  ];

  public function connect() {
    $this->connect = new PDO("mysql:host=$this->hostname; dbname=$this->database", "$this->username", "", $this->options);
    if($this->connect) {
      return $this->connect;
    }
    return "DATABASE_CONNECTION_FAIL";
  }
}
$db = new Database();
$db->connect();

// class Database {
//   private $hostname = 'localhost';
//   private $username = 'root';
//   private $password = '';
//   private $database = 'homoljsko';
//   private $connect = '';
//   private $options = [
//     \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
//   ];
//
//   public function connect() {
//     try {
//       if ($this->connect = new PDO("mysql:host=$this->hostname; dbname=$this->database", "$this->username", "", $this->options)) {
//         echo '';
//       } else {
//         throw new Exception('Povezivanje nije uspelo!');
//       }
//     }
//     catch(Exception $e) {
//     echo $e->getMessage();
//     }
//   }
// }
// $db = new Database();
// $db->connect();
?>
