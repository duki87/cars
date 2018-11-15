<?php
  require_once('../db/db.php');
  require_once('../db/baseurl.php');
  include('../class/user.php');

  //register
  if(isset($_POST['new_user'])) {
    $user = new User();
    $result = $user->add_user($_POST['user']);
    echo $result;
    exit();
  }

  //login
  if(isset($_POST['login_user'])) {
    $user = new User();
    $result = $user->login($_POST['login']);
    echo $result;
    exit();
  }

  if(isset($_POST["logout_user"])) {
    $user = new User();
    $result = $user->logout_user();
    exit();
  }

  if(isset($_POST["get_session_message"])) {
    $user = new User();
    $result = $user->get_session_message();
    exit();
  }

  if(isset($_POST["edit_user_data"])) {
    $user = new User();
    $result = $user->edit_user_data($_POST['edit_data']);
    echo $result;
    exit();
  }

  if(isset($_POST["check_old_password"])) {
    $user = new User();
    $result = $user->check_password($_POST['password_data']);
    echo $result;
    exit();
  }

  if(isset($_POST["change_password"])) {
    $user = new User();
    $result = $user->change_password($_POST['new_password']);
    echo $result;
    exit();
  }

  if(isset($_POST["add_user_data"])) {
    $user = new User();
    $result = $user->additional_data($_POST['add_data']);
    echo $result;
    exit();
  }

?>
