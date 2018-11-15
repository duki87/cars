<?php
  require_once('../db/db.php');
  require_once('../db/baseurl.php');
  include('../class/categories.php');

  //submit category
  if(isset($_POST['category_name'])) {
    $category = new Categories();
    $result = $category->add_category($_POST['category_name']);
    echo $result;
    exit();
  }

  //get all categories
  if(isset($_POST['load_all_categories'])) {
    $category = new Categories();
    $result = $category->load_all_categories();
    echo $result;
    exit();
  }

  //delete category
  if(isset($_POST['delete_category'])) {
    $category = new Categories();
    $result = $category->delete_category($_POST['category_id']);
    echo $result;
    exit();
  }

?>
