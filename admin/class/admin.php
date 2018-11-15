<?php
  require_once('../db/db.php');
  require_once('../db/baseurl.php');
  $baseurl = baseurl();

  class Admin {

    private $connect;
    function __construct() {
      $db = new Database();
      $this->connect = $db->connect();
    }

    public function login($email, $password) {
      $admin_array = array();
      $query = "SELECT user_id, username, email, password, status, last_login FROM admin WHERE email = '$email' LIMIT 1";
      $statement = $this->connect->prepare($query);
      $statement->execute();
      $result = $statement->rowCount();
      if($result < 1) {
        return "NOT_REGISTERED";
      } else {
        $row = $statement->fetch();
        if($row['status'] == 0) {
          return "NOT_ACTIVE";
        }
        if(password_verify($password, $row['password'])) {
          $admin_array['admin_id'] = $row["user_id"];
          $admin_array['admin_username'] = $row["username"];
          $admin_array["last_login"] = $row["last_login"];
          // $_SESSION["user_id"] = $row["user_id"];
          // $_SESSION["username"] = $row["username"];
          // $_SESSION["last_login"] = $row["last_login"];
          $_SESSION['admin'] = $admin_array;
          //Updating user last login time
          $last_login = date("Y-m-d h:i:s");
          $query = "UPDATE admin SET last_login = '$last_login' WHERE email = '$email'";
          $statement = $connect->prepare($query);
          $result = $statement->execute();
          if($result) {
            return 'USER_LOGGED_IN';
          } else {
            return 'LOGIN_FAIL';
          }
        } else {
          return "PASSWORD_NOT_MATCHED";
        }
      }
    }

    //Admin is already registered or not
    private function emailExists($email) {
      $query = "SELECT * FROM admin WHERE email = '$email' ";
      $statement = $this->connect->prepare($query);
      $statement->execute();
      $result = $statement->rowCount();
      if($result > 0) {
        return 1;
      } else {
        return 0;
      }
    }

    public function admin_auth($auth_code) {
      $query = "SELECT * FROM admin_auth WHERE auth_code = '$auth_code'";
      $statement = $this->connect->prepare($query);
      $statement->execute();
      $result = $statement->rowCount();
      if($result < 1) {
        return "INVALID_CODE";
      } else {
        return "VALID_CODE";
      }
    }

    public function admin_registration($email, $password, $username) {
      if($this->emailExists($email) == 1) {
        return "EMAIL_ALREADY_EXISTS";
      } else {
        $password_hash = password_hash($password,PASSWORD_BCRYPT);
        $date = date("Y-m-d h:i:s");
        $query = "INSERT INTO admin (username, email, password, last_login) VALUES (:username, :email, :password_hash, :date)";
        $statement = $this->connect->prepare($query);
        $statement->execute(
          array(
            ':username'       =>  $username,
            ':email'          =>  $email,
            ':password_hash'  =>  $password_hash,
            ':date'           =>  $date
          )
        );
        $result = $statement->fetchAll();
        if(isset($result)) {
          return $this->connect->lastInsertId();
        } else {
          return "SOME_ERROR";
        }
      }
    }

    public function logout() {
      unset($_SESSION['admin']['admin_id']);
      unset($_SESSION['admin']['admin_username']);
      unset($_SESSION['admin']['last_login']);
      header("Location: http://localhost/cars/admin/admin.php");
    }
  }
?>
