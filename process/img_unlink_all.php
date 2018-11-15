<?php
  if(isset($_POST['unlink_all'])) {
    $folder = '../images/vehicle_images/'.$_POST['unlink_folder'];
    $scan_folder = array_diff(scandir($folder), array('..', '.'));
    foreach ($scan_folder as $image) {
      unlink($folder.'/'.$image);
    }
    if(rmdir($folder)) {
      echo 'FOLDER_DELETED';
    }
  }
?>
