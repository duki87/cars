<?php
  require_once('../db/db.php');
  require_once('../db/baseurl.php');
  include('../class/brands.php');

  //add logo
  if(isset($_FILES["brand_logo"]["name"]) && $_FILES["brand_logo"]["name"] != '') {
    $brand = new Brands();
    $result = $brand->logo_preview($_FILES["brand_logo"]["name"]);
    echo $result;
    exit();
  }

  //delete logo
  if(isset($_POST['delete_logo'])) {
    $brand = new Brands();
    $result = $brand->logo_preview_delete($_POST['location']);
    echo $result;
    exit();
  }

  //add new brand
  if(isset($_POST['brand_name']) && $_POST['brand_name'] != '') {
    $brand = new Brands();
    $result = $brand->add_brand($_POST['category_id'], $_POST['brand_name'], $_POST['logo'], $_POST['brand_description']);
    echo $result;
    exit();
  }

  //get all brands - datatables
  if(isset($_POST['get_brands'])) {
    $brand = new Brands();
    $result = $brand->get_brands();
    echo $result;
    exit();
  }

  //Change status
  if(isset($_POST['brand_status'])) {
    $brand = new Brands();
    $result = $brand->change_brand_status($_POST['brand_id']);
    echo $result;
    exit();
  }

  //Delete brand
  if(isset($_POST['brand_delete'])) {
    $brand = new Brands();
    $result = $brand->delete_brand($_POST['brand_id']);
    echo $result;
    exit();
  }

  //Get brand data for editing
  if(isset($_POST['brand_edit'])) {
    $brand = new Brands();
    $result = $brand->get_brand_data($_POST['brand_id']);
    echo $result;
    exit();
  }

  //Update data
  if(isset($_POST['brand_update'])) {
    $brand = new Brands();
    $result = $brand->update_brand($_POST['brand_id'], $_POST['new_category'], $_POST['brand_new_name'], $_POST['logo'],$_POST['brand_new_description']);
    echo $result;
    exit();
  }

  //Get categories
  if(isset($_POST['get_categories'])) {
    $brand = new Brands();
    $result = $brand->get_categories();
    echo $result;
    exit();
  }
?>
