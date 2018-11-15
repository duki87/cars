<?php
  require_once('../db/db.php');
  require_once('../db/baseurl.php');
  $baseurl = baseurl();
  $connect;

  $db = new Database();
  $connect = $db->connect();

  if(isset($_POST['delete_img'])) {
    $user_id = $_SESSION['user']['user_id'];
    $img = $_POST['photo'];
    $path = '../images/user_images/' . $img;
    $query = "UPDATE users SET photo = 'default.jpg' WHERE user_id = '$user_id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    if(unlink($path)) {
      echo 'IMG_DELETED';
    }
  }
?>
