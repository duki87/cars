<?php

require_once('db/db.php');
require_once('db/baseurl.php');
include_once 'googleLoginConfig.php';
include_once 'class/GoogleLogin.php';
$baseurl = baseurl();
$form = '';

if(isset($_GET['code'])){
  $gClient->authenticate($_GET['code']);
  $_SESSION['token'] = $gClient->getAccessToken();
  header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
}

if(isset($_SESSION['token'])) {
  $gClient->setAccessToken($_SESSION['token']);
}

if($gClient->getAccessToken()) {
  //Get user profile data from google
  $gpUserProfile = $google_oauthV2->userinfo->get();

  //Initialize User class
  $user = new GoogleLogin();

  //Insert or update user data to the database
  $gpUserData = array(
      'oauth_provider'=> 'google',
      'oauth_uid'     => $gpUserProfile['id'],
      'first_name'    => $gpUserProfile['given_name'],
      'last_name'     => $gpUserProfile['family_name'],
      'email'         => $gpUserProfile['email'],
      'gender'        => $gpUserProfile['gender'],
      'locale'        => $gpUserProfile['locale'],
      'picture'       => $gpUserProfile['picture'],
      'link'          => $gpUserProfile['link']
  );
  $userData = $user->checkUser($gpUserData);

  if($userData == 'EXISTS') {
    $form = '<a href="user_profile.php" class="btn btn-success">Nastavi na sajt</a>';
  } else {
    $form = '
    <p>Potrebno je da unesete sledece podatke da zavrsite registraciju: </p>
    <div class="" id="data_message"></div>
    <form class="form" method="post" id="data_form">
      <div class="col-md-8">
        <div class="form-group">
          <div class="row">
            <div class="col-md-10">
              <label for="street">Ulica</label>
              <input type="text" name="street" id="street" class="form-control" value="">
            </div>
            <div class="col-md-2">
              <label for="street_no">Kucni broj</label>
              <input type="text" name="street_no" id="street_no" class="form-control" value="">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="">
            <label for="city">Mesto</label>
            <input type="text" name="city" id="city" class="form-control" value="">
          </div>
        </div>
        <div class="form-group">
          <div class="">
            <label for="phone">Telefon</label>
            <input type="text" name="phone" id="phone" class="form-control" value="" onkeypress="return isNumberKey(event)">
          </div>
        </div>
        <input type="submit" name="submit" class="btn btn-success" value="Posalji">
      </div>
    </form>
    ';
  }
  //echo $userData;
  //Storing user data into session
  $_SESSION['userData'] = $gpUserData;
}
?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Dusan Marinkovic">
  <title>Auto berza</title>
  <link rel="shortcut icon" type="image/jpg" href="images/porsche.jpg">
  <script src="<?=$baseurl.'assets/jquery/jquery-3.3.1.min.js';?>"></script>
  <link rel="stylesheet" href="<?=$baseurl.'assets/bootstrap/css/bootstrap.min.css';?>">
  <link rel="stylesheet" href="<?=$baseurl.'assets/bootstrap/css/bootstrap-grid.min.css';?>">
  <link rel="stylesheet" href="<?=$baseurl.'assets/styles/style.css';?>">
  <link rel="stylesheet" href="<?=$baseurl.'assets/styles/vehicle_gallery.css';?>">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
</head>
<div class="container"><br>
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">Auto berza</h2><hr>
      <h3>prijava putem Google-a</h3>
    </div>
    <div class="card-body">
      <?=$form;?>
    </div>
    <div class="card-footer" id="proceed">

    </div>
  </div>
</div>

<script src="<?=$baseurl.'assets/jquery/jquery-3.3.1.min.js';?>"></script>
<script src="<?=$baseurl.'assets/bootstrap/js/bootstrap.min.js';?>"></script>
<script src="<?=$baseurl.'assets/js/messages.js';?>"></script>
<script type="text/javascript">
$(document).ready(function() {
  function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
  }
});

$(document).on('submit', '#data_form', function(e) {
  e.preventDefault();
  var address = $('#street').val() +' '+ $('#street_no').val();
  var city = $('#city').val();
  var phone = $('#phone').val();
  var data_details = {
    "address" : address,
    "city" : city,
    "phone" : phone
  };
  var add_user_data = true;
  var add_data = JSON.stringify(data_details);
  $.ajax({
    url: "process/user_process.php",
    method: 'post',
    data: {add_user_data:add_user_data,add_data:add_data},
    success: function(data) {
      if(data == 'CHANGED') {
        var data_message ='<div class="alert alert-success alert-dismissible fade show" role="alert">'+
        '<strong>Uspesno ste uneli podatke!</strong> Sada mozete pristupiti sajtu.'+
         '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
        '<span aria-hidden="true">&times;</span>'+
          '</button>'+
        '</div>';
        $('#data_message').html('<p>'+data_message+'</p>');
        $('#proceed').html('<a href="user_profile.php" class="btn btn-success">Nastavi na sajt</a>');
      } else {
        var data_message ='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
        '<strong>Nesto se iskundacilo!</strong>'+
         '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
        '<span aria-hidden="true">&times;</span>'+
          '</button>'+
        '</div>';
        $('#data_message').html('<p>'+data_message+'</p>');
      }
    }
  });
  $('#password_form').hide();
});

</script>

<footer>

</footer>
