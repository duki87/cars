<?php
  require_once('../db/db.php');
  require_once('../db/baseurl.php');
  $baseurl = baseurl();

  class User {
    private $connect;
    private $url = 'http://localhost/cars/images/brand_logos/';

    function __construct() {
      $db = new Database();
      $this->connect = $db->connect();
    }

    //User is already registered or not
    private function emailExists($email) {
      $query = "SELECT * FROM users WHERE email = '$email' ";
      $statement = $this->connect->prepare($query);
      $statement->execute();
      $result = $statement->rowCount();
      if($result > 0) {
        return 1;
      } else {
        return 0;
      }
    }

    public function add_user($user) {
      $user_details = json_decode($user);

      if($this->emailExists($user_details->email) == 1) {
        return "EMAIL_ALREADY_EXISTS";
      } else {
        $last_login = date('Y-m-d h:i:sa');
        $date_joined = date("Y-m-d h:i:s");
        $active = 0;
        $password_hash = password_hash($user_details->password,PASSWORD_BCRYPT);
        $query = "INSERT INTO users (email, password, name, last_name, address, city, phone, active, date_joined, last_login) VALUES (:email, :password, :name, :last_name, :address, :city, :phone, :active, :date_joined, :last_login)";
        $statement = $this->connect->prepare($query);
        $statement->execute(
          array(
            ':email'              =>  $user_details->email,
            ':password'           =>  $password_hash,
            ':name'               =>  $user_details->name,
            ':last_name'          =>  $user_details->last_name,
            ':address'            =>  $user_details->address,
            ':city'               =>  $user_details->city,
            ':phone'              =>  $user_details->phone,
            ':active'             =>  $active,
            ':date_joined'        =>  $date_joined,
            ':last_login'         =>  $last_login
          )
        );
        $result = $statement->fetchAll();
        if(isset($result)) {
          return 'USER_ADDED';
        } else {
          return 'ERROR';
        }
      }
    }

    public function login($login) {
      $user_array = array();
      $login_details = json_decode($login);
      $query = "SELECT * FROM users WHERE email = '$login_details->email' LIMIT 1";
      $statement = $this->connect->prepare($query);
      $statement->execute();
      $result = $statement->rowCount();
      if($result < 1) {
        return "NOT_REGISTERED";
      } else {
        $row = $statement->fetch();
        if($row['active'] == 0) {
          return "NOT_ACTIVE";
        }
        if(password_verify($login_details->password, $row['password'])) {
          $user_array['user_id'] = $row["user_id"];
          $user_array['email'] = $row["email"];
          $user_array['user_name'] = $row["name"];
          $user_array["user_last_name"] = $row["last_name"];
          $user_array["user_address"] = $row["address"];
          $user_array["user_city"] = $row["city"];
          $user_array["user_phone"] = $row["phone"];
          $user_array["user_last_login"] = $row["last_login"];

          $_SESSION['user'] = $user_array;
          //Updating user last login time
          $last_login = date("Y-m-d h:i:s");
          $query = "UPDATE users SET last_login = '$last_login' WHERE email = '$login_details->email'";
          $statement = $this->connect->prepare($query);
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

    public function logout_user() {
      // unset($_SESSION['user']);
      unset($_SESSION['user']['user_id']);
      unset($_SESSION['user']['email']);
      unset($_SESSION['user']['user_name']);
      unset($_SESSION['user']['user_last_name']);
      unset($_SESSION['user']['user_address']);
      unset($_SESSION['user']['user_city']);
      unset($_SESSION['user']['user_phone']);
      unset($_SESSION['user']['user_last_login']);
      header("Location: http://localhost/cars/index.php");
    }

    public function get_session_message() {
      if(!empty($_SESSION['message']['error'])) {
        echo $_SESSION['message']['error'];
        unset($_SESSION['message']['error']);
      } else {
        return false;
      }
    }

    public function edit_user_data($edit_data) {
      $user_edit_details = json_decode($edit_data);
      $response = array();
      $user_id = $_SESSION['user']['user_id'];
      $query = "UPDATE users SET name = '$user_edit_details->name', last_name = '$user_edit_details->last_name', email = '$user_edit_details->email', address = '$user_edit_details->address', city = '$user_edit_details->city', phone = '$user_edit_details->phone' WHERE user_id = '$user_id'";
      $statement = $this->connect->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll();
      if(isset($result)) {
        return 'USER_EDIT';
      }
    }

    public function check_password($password) {
      $user_id = $_SESSION['user']['user_id'];
      $old_password_obj = json_decode($password);
      $old_password = $old_password_obj->old_password;
      $query = "SELECT * FROM users WHERE user_id = '$user_id'";
      $statement = $this->connect->prepare($query);
      $statement->execute();
      $result = $statement->fetch();
      if(password_verify($old_password, $result['password'])) {
        return 'MATCH';
      } else {
        return 'NOT_MATCH';
      }
    }

    public function change_password($new_password) {
      $user_id = $_SESSION['user']['user_id'];
      $password_hash = password_hash($new_password,PASSWORD_BCRYPT);
      $query = "UPDATE users SET password = '$password_hash' WHERE user_id = '$user_id'";
      $statement = $this->connect->prepare($query);
      $statement->execute();
      $result = $statement->fetch();
      if(isset($result)) {
        return 'CHANGED';
      } else {
        return 'NOT_CHANGED';
      }
    }

    public function additional_data($add_data) {
      $user_id = $_SESSION['user']['user_id'];
      $data = json_decode($add_data);
      $address = $data->address;
      $city = $data->city;
      $phone = $data->phone;
      $query = "UPDATE users SET address = '$address', city = '$city', phone = '$phone' WHERE user_id = '$user_id'";
      $statement = $this->connect->prepare($query);
      $statement->execute();
      $result = $statement->fetch();
      if(isset($result)) {
        return 'CHANGED';
      } else {
        return 'NOT_CHANGED';
      }
    }
  }
