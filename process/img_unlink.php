<?php
  if(isset($_POST['unlink_path'])) {
    $path = '../images/vehicle_images/' . $_POST['unlink_path'];
    if(unlink($path)) {
      echo 'IMG_DELETED';
    }
  }
?>
