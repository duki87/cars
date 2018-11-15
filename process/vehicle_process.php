<?php
  require_once('../db/db.php');
  require_once('../db/baseurl.php');
  include('../class/vehicle.php');

  //get_categories
  if(isset($_POST['get_categories'])) {
    $vehicle = new Vehicle();
    $result = $vehicle->get_categories();
    echo $result;
    exit();
  }

  //get_brands
  if(isset($_POST['get_brands'])) {
    $vehicle = new Vehicle();
    $result = $vehicle->get_brands($_POST['category_id']);
    echo $result;
    exit();
  }

  //get_models
  if(isset($_POST['get_models'])) {
    $vehicle = new Vehicle();
    $result = $vehicle->get_models($_POST['brand_id']);
    echo $result;
    exit();
  }

  //add_vehicle
  if(isset($_POST['new_vehicle'])) {
    $vehicle = new Vehicle();
    $result = $vehicle->add_vehicle($_POST['vehicle_details']);
    echo $result;
    exit();
  }

  // //img_preview
  // if(isset($_POST['img_preview'])) {
  //   $vehicle = new Vehicle();
  //   $result = $vehicle->img_preview();
  //   echo $result;
  //   exit();
  // }

?>
