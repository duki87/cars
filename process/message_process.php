<?php
  require_once('../db/db.php');
  require_once('../db/baseurl.php');
  include('../class/messages.php');

  //send message
  if(isset($_POST['new_message'])) {
    $message = new Message();
    $result = $message->send_message($_POST['message_details']);
    echo $result;
    exit();
  }

  //check for messages
  if(isset($_POST['check_messages'])) {
    $message = new Message();
    $result = $message->check_messages();
    echo $result;
    exit();
  }

  //inbox content
  if(isset($_POST['get_inbox_content'])) {
    $message = new Message();
    $result = $message->get_inbox_content();
    echo $result;
    exit();
  }

  //open chat
  if(isset($_GET['get_chat_content'])) {
    $message = new Message();
    $result = $message->get_chat_content($_GET['id']);
    echo $result;
    exit();
  }

  //send message from chat
  if(isset($_POST['send_message'])) {
    $message = new Message();
    $result = $message->send_message_from_chat($_POST['message_details']);
    echo $result;
    exit();
  }

  //load user's new message in chat
  if(isset($_POST['load_new_message'])) {
    $message = new Message();
    $result = $message->load_new_message($_POST['message_id']);
    echo $result;
    exit();
  }

  //check income messages from the other user in chat
  if(isset($_POST['check_income_messages'])) {
    $message = new Message();
    $result = $message->check_income_messages($_POST['chat_id']);
    echo $result;
    exit();
  }

  //get sender name
  if(isset($_POST['get_sender_name'])) {
    $message = new Message();
    $result = $message->get_sender_name($_POST['chat_id']);
    echo $result;
    exit();
  }

  //uncheck read messages
  if(isset($_POST['uncheck_read_messages'])) {
    $message = new Message();
    $result = $message->uncheck_read_messages($_POST['chat_id']);
    echo $result;
    exit();
  }

  //check if message is read
  if(isset($_POST['is_unread'])) {
    $message = new Message();
    $result = $message->is_unread($_POST['check_ids']);
    echo $result;
    exit();
  }
?>
