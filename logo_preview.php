<?php

//Get image
  if(isset($_FILES["image_file"]["name"]) && $_FILES["image_file"]["name"] != '') {
    $name = $_FILES["image_file"]["name"];
    $explode = explode(".", $name);
    $extension = end($explode);
    $newName = rand(10,10000) . "." . $extension;
    $location = "images/brandLogos/" . $newName;
    move_uploaded_file($_FILES['image_file']['tmp_name'], $location);
    echo '
    <div class="image-content">
    <img src="'.$location.'" class="form-control img-responsive" id="brand_logo" alt="" width="100%" height="auto">
    <button type="button" name="location" data-location="'.$location.'" class="btn btn-danger " id="remove_button" name="button">x</button>
    </div>';
  }

  //Get image for edit modal
    if(isset($_FILES["image_file_edit"]["name"]) && $_FILES["image_file_edit"]["name"] != '') {
      $name = $_FILES["image_file_edit"]["name"];
      $explode = explode(".", $name);
      $extension = end($explode);
      $newName = rand(10,10000) . "." . $extension;
      $location = "images/brandLogos/" . $newName;
      move_uploaded_file($_FILES['image_file_edit']['tmp_name'], $location);
      echo '
      <div class="image-content">
      <img src="'.$location.'" class="form-control img-responsive" id="brand_logo_edit" alt="" width="100%" height="auto">
      <button type="button" name="location_edit" data-locationEdit="'.$location.'" class="btn btn-danger" id="remove_button_edit" name="button">x</button>
      </div>';
    }

//Delete image
if(!empty($_POST['location'])) {
  if(unlink($_POST['location'])) {
    echo 'Image deleted!';
  }
}

//Delete image in edit modal
if(!empty($_POST['locationEdit'])) {
  if(unlink($_POST['locationEdit'])) {
    echo 'Image deleted!';
  }
}
?>
