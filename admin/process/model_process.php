<?php
  require_once('../db/db.php');
  require_once('../db/baseurl.php');
  include('../class/models.php');

  //get brands
  if(isset($_POST['get_brands'])) {
    $model = new Models();
    $result = $model->get_brands($_POST['category_id']);
    echo $result;
    exit();
  }

  //submit model
  if(isset($_POST['model_name'])) {
    $model = new Models();
    $result = $model->add_model($_POST['brand_id'], $_POST['category_id']);
    echo $result;
    exit();
  }

  //get all models
  if(isset($_POST['load_all_models'])) {
    $model = new Models();
    $result = $model->load_all_models();
    echo $result;
    exit();
  }

  //get all categories
  if(isset($_POST['get_categories'])) {
    $model = new Models();
    $result = $model->get_categories();
    echo $result;
    exit();
  }

  //delete model
  if(isset($_POST['delete_model'])) {
    $model = new Models();
    $result = $model->delete_model($_POST['model_id']);
    echo $result;
    exit();
  }

?>
