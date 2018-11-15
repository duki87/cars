<?php
  if(count($_FILES['file']['name']) > 0) {
    $data = array();
    $folder_name = 'images' . rand(10,10000);
    $data['folder_name'] = $folder_name;
    $vehicle_img_path = '../images/vehicle_images/'.$folder_name;
    $location_array = array();
    if(mkdir($vehicle_img_path)) {
      for($count=0; $count<count($_FILES['file']['name']); $count++) {
        $file_name = $_FILES['file']['name'][$count];
        $tmp_name = $_FILES['file']['tmp_name'][$count];
        $file_array = explode('.', $file_name);
        $file_extension = end($file_array);
        $file_name = 'img' . '-' . rand() . '.' . $file_extension;
        $location = $vehicle_img_path . '/' . $file_name;
        if(move_uploaded_file($tmp_name, $location)) {
          $location_array[] = $folder_name . '/' . $file_name;
        }
      }
      $data['images'] = $location_array;
      echo json_encode($data);
    } else {
      echo 'ERROR';
    }
  }
?>
