<?php
  // define('BASEURL', $_SERVER['HTTP_HOST'].'/cars/');

function baseurl(){
  if(isset($_SERVER['HTTPS'])){
      $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
  }
  else{
      $protocol = 'http';
  }
  return $protocol . "://" . $_SERVER['HTTP_HOST'] . '/cars/';
}
?>
