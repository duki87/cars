<?php
  require_once('../db/db.php');
  require_once('../db/baseurl.php');
  include('../class/profile.php');

  //load_user_data
  if(isset($_POST['load_user_data'])) {
    $profile = new Profile();
    $result = $profile->load_user_data();
    echo $result;
    exit();
  }

  // //add photo of user
  // if(isset($_POST['img_preview'])) {
  //   $profile = new Profile();
  //   $result = $profile->img_preview($_POST['form_data']);
  //   echo $result;
  //   exit();
  // }

?>
