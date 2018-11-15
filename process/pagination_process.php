<?php
  require_once('../db/db.php');
  require_once('../db/baseurl.php');
  include('../class/paginations.php');

  //onload page load pagination data
  if(isset($_POST['get_pagination_data'])) {
    $pagination = new Pagination();
    $result = $pagination->request_pagination($_POST['per_page'], $_POST['chunk_to_display'], $_POST['sqlTable']);
    echo $result;
    exit();
  }

  //get specified page
  if(isset($_POST['get_pagination_page'])) {
    $pagination = new Pagination();
    $result = $pagination->request_pagination($_POST['per_page'], $_POST['chunkid'], $_POST['sqlTable']);
    echo $result;
    exit();
  }
  //
  //get next page
  if(isset($_POST['get_pagination_next'])) {
    $pagination = new Pagination();
    $result = $pagination->request_pagination($_POST['per_page'], $_POST['chunkid'], $_POST['sqlTable']);
    echo $result;
    exit();
  }
  //
  //get previous page
  if(isset($_POST['get_pagination_prev'])) {
    $pagination = new Pagination();
    $result = $pagination->request_pagination($_POST['per_page'], $_POST['chunkid'], $_POST['sqlTable']);
    echo $result;
    exit();
  }
  //
  //change records per page
  if(isset($_POST['change_records_num'])) {
    $pagination = new Pagination();
    $result = $pagination->request_pagination($_POST['per_page'], $_POST['chunkid'], $_POST['sqlTable']);
    echo $result;
    exit();
  }

?>
