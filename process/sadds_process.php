<?php
  require_once('../db/db.php');
  require_once('../db/baseurl.php');
  include('../class/selling_adds.php');

  //get_selling_adds
  if(isset($_POST['get_selling_adds'])) {
    $sadds = new SellingAdds();
    $result = $sadds->get_selling_adds();
    echo $result;
    exit();
  }

  //get_selling_add
  if(isset($_GET['id'])) {
    $sadds = new SellingAdds();
    $result = $sadds->get_selling_add_details($_GET['id']);
    echo $result;
    exit();
  }

?>
