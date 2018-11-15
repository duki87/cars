<?php
  require_once('../db/db.php');
  require_once('../db/baseurl.php');
  include('../class/search.php');

  //get_suggestions
  if(isset($_POST['get_suggestions'])) {
    $search = new Search();
    $result = $search->get_suggestions($_POST['keyword']);
    echo $result;
    exit();
  }

  //get_results
  if(isset($_POST['get_results'])) {
    $search = new Search();
    $result = $search->basic_search($_POST['findMatches']);
    echo $result;
    exit();
  }

  //get_advanced_results
  if(isset($_POST['advanced_search'])) {
    $search = new Search();
    $result = $search->advanced_search($_POST['searchData']);
    echo $result;
    exit();
  }

?>
