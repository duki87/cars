<?php
  require_once('../db/db.php');
  require_once('../db/baseurl.php');
  $baseurl = baseurl();
  $connect;

  $db = new Database();
  $connect = $db->connect();

  $data = array();
  $user_id = $_SESSION['user']['user_id'];
  $file_name = $_FILES['file']['name'];
  $tmp_name = $_FILES['file']['tmp_name'];
  $file_array = explode('.', $file_name);
  $file_extension = end($file_array);
  $file_name = 'profilepic' . '-' . rand(10,1000) . '.' . $file_extension;
  $location = '../images/user_images/' . $file_name;
  $data['file_name'] = $file_name;

  if($_POST['delete_photo'] != 'default') {
    $delete_photo = $_POST['delete_photo'];
    $path = '../images/user_images/' . $delete_photo;
    if($path) {
      unlink($path);
    }
  }

  $query = "UPDATE users SET photo = '$file_name' WHERE user_id = '$user_id'";
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $move = move_uploaded_file($tmp_name, $location);
  echo json_encode($data);
?>
