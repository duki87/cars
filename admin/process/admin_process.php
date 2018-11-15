<?php
  require_once('../db/db.php');
  require_once('../db/baseurl.php');
  include('../class/admin.php');

  if(isset($_POST["email"]) && isset($_POST["password"])) {
    $admin = new Admin();
    $result = $admin->login($_POST["email"], $_POST["password"]);
    echo $result;
    exit();
  }

  if(isset($_POST["auth_code"]) && $_POST["auth_code"] != '') {
    $admin = new Admin();
    $result = $admin->admin_auth($_POST["auth_code"]);
    echo $result;
    exit();
  }

  if(isset($_POST["reg_username"])) {
    $admin = new Admin();
    $result = $admin->admin_registration($_POST["reg_email"], $_POST["reg_password"], $_POST["reg_username"]);
    echo $result;
    exit();
  }

  if(isset($_POST["logout"])) {
    $admin = new Admin();
    $result = $admin->logout();
    exit();
  }
?>
