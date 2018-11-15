<?php
  require_once('../db/db.php');
  require_once('../db/baseurl.php');
  $baseurl = baseurl();

  class Profile {
    private $connect;
    private $url = 'http://localhost/cars/';

    function __construct() {
      $db = new Database();
      $this->connect = $db->connect();
    }

    public function load_user_data() {
      $user_id = $_SESSION['user']['user_id'];
      $button = '';
      $user_data = array();
      $query = "SELECT * FROM users WHERE user_id = '$user_id'";
      $statement = $this->connect->prepare($query);
      $statement->execute();
      $result = $statement->fetch();
      $originalDate = $result['date_joined'];
      $newDate = date("d.m.Y.", strtotime($originalDate));
      if($result['photo'] == 'default.jpg') {
        $button = 'Dodaj fotografiju';
      } else {
        $button = 'Izmeni fotografiju';
      }

      $user_data['name'] = $result['name'];
      $user_data['last_name'] = $result['last_name'];
      $user_data['email'] = $result['email'];
      $user_data['address'] = $result['address'];
      $user_data['city'] = $result['city'];
      $user_data['phone'] = $result['phone'];
      $user_data['photo'] = $result['photo'];
      $user_data['button'] = $button;
      $user_data['date_joined'] = $newDate;
      return json_encode($user_data);
    }

    // public function img_preview($form_data) {
    //   $user_id = $_SESSION['user']['user_id'];
    //   $file_name = $_FILES['file']['name'];
    //   $tmp_name = $_FILES['file']['tmp_name'];
    //   $file_array = explode('.', $file_name);
    //   $file_extension = end($file_array);
    //   $file_name = 'profileid' . '-' . $user_id . '.' . $file_extension;
    //   $location = 'images/user_images/' . $file_name;
    //
    //   $query = "UPDATE users SET photo = '$file_name' WHERE user_id = '$user_id'";
    //   $statement = $this->connect->prepare($query);
    //   $statement->execute();
    //   $result = $statement->fetch();
    //   $move = move_uploaded_file($tmp_name, $location);
    //   if($result && $move) {
    //     echo $file_name;
    //   }
    // }
  }
?>
