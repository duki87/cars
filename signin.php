<?php
  require_once('db/db.php');
  include('parts/header.php');

  include_once 'googleLoginConfig.php';
  include_once 'class/GoogleLogin.php';
  $authUrl = '';
  $output = '';

  // if(isset($_GET['code'])){
  // 	$gClient->authenticate($_GET['code']);
  // 	$_SESSION['token'] = $gClient->getAccessToken();
  // 	header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
  // }
  //
  // if(isset($_SESSION['token'])) {
  // 	$gClient->setAccessToken($_SESSION['token']);
  // }
  //
  // if($gClient->getAccessToken()) {
  // 	//Get user profile data from google
  // 	$gpUserProfile = $google_oauthV2->userinfo->get();
  //
  // 	//Initialize User class
  // 	$user = new GoogleLogin();
  //
  //   //Insert or update user data to the database
  //   $gpUserData = array(
  //       'oauth_provider'=> 'google',
  //       'oauth_uid'     => $gpUserProfile['id'],
  //       'first_name'    => $gpUserProfile['given_name'],
  //       'last_name'     => $gpUserProfile['family_name'],
  //       'email'         => $gpUserProfile['email'],
  //       'gender'        => $gpUserProfile['gender'],
  //       'locale'        => $gpUserProfile['locale'],
  //       'picture'       => $gpUserProfile['picture'],
  //       'link'          => $gpUserProfile['link']
  //   );
  //   $userData = $user->checkUser($gpUserData);
  //
  //   //Storing user data into session
  //   $_SESSION['userData'] = $userData;
  //} else {
  	$authUrl = $gClient->createAuthUrl();
    $output = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'"><img src="images/glogin.png" width="100%" height="auto" alt=""/></a>';
  //}
?>
<div class="row">
  <div class="col-md-6">
    <br>
    <div id="login_message"></div>
    <form class="user_signin" id="user_signin" name="user_signin" method="post">
      <h3 style="color:gold">Prijavi se</h3><hr style="border-bottom:1px gold solid">
      <div class="form-group">
        <label for="exampleInputEmail1" style="color:white">Email adresa</label>
        <input type="email" name="sign_email" class="form-control" id="sign_email" placeholder="Unesite email">
        <div id="sign_email_err"></div>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1" style="color:white">Lozinka</label>
        <input type="password" name="sign_password" class="form-control" id="sign_password" placeholder="Unesite lozinku">
        <div id="sign_password_err"></div>
      </div>
      <div class="row" id="buttons">
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-4">
              <button type="submit" class="btn btn-success">Prijavi se</button>
            </div>
            <div class="col-md-3">
              <?=$output;?>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>

  <div class="col-md-6">
    <br>
    <div id="user_success"></div>
    <form class="user_registration" id="user_registration" name="user_registration" method="post">
      <h3 style="color:gold">Nemas nalog? Registruj se!</h3><hr style="border-bottom:1px gold solid">
      <div class="form-group">
        <label for="reg_email" style="color:white">Email adresa</label>
        <input type="text" name="reg_email" class="form-control" id="reg_email" placeholder="Unesite email">
        <small id="email_err" class="text-danger form-errors"></small>
      </div>
      <div class="form-group">
        <label for="reg_password" style="color:white">Lozinka</label>
        <input type="password" name="reg_password" class="form-control" id="reg_password" placeholder="Unesite lozinku">
        <small id="pass_err" class="text-danger form-errors"></small>
      </div>
      <div class="form-group">
        <label for="check_password" style="color:white">Ponovi lozinku</label>
        <input type="password" name="check_password" class="form-control" id="check_password" placeholder="Ponovite lozinku">
        <small id="check_err" class="text-danger form-errors"></small>
      </div>
      <div class="form-group">
        <label for="reg_name" style="color:white">Ime</label>
        <input type="text" name="reg_name" class="form-control" id="reg_name" placeholder="Unesite ime">
        <small id="name_err" class="text-danger form-errors"></small>
      </div>
      <div class="form-group">
        <label for="reg_last_name" style="color:white">Prezime</label>
        <input type="text" name="reg_last_name" class="form-control" id="reg_last_name" placeholder="Unesite prezime" >
        <small id="reg_last_name_err" class="text-danger form-errors"></small>
      </div>
      <div class="form-group">
        <div class="row">
          <div class="col-md-8">
            <label for="street" style="color:white">Ulica</label>
            <input type="text" name="street" class="form-control" id="street" placeholder="Unesite ulicu" >
            <small id="street_err" class="text-danger form-errors"></small>
          </div>
          <div class="col-md-4">
            <label for="street_num" style="color:white">Broj</label>
            <input type="text" name="street_num" class="form-control" id="street_num" placeholder="Unesite ulicni broj" >
            <small id="street_num_err" class="text-danger form-errors"></small>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="city" style="color:white">Mesto</label>
        <input type="text" name="city" class="form-control" id="city" placeholder="Unesite mesto stanovanja" >
        <small id="city_err" class="text-danger form-errors"></small>
      </div>
      <div class="form-group">
        <label for="phone" style="color:white">Telefon</label>
        <input type="text" name="phone" class="form-control" id="phone" placeholder="Unesite telefon" >
        <small id="phone_err" class="text-danger form-errors"></small>
      </div>
      <div class="row" id="buttons">
        <div class="col-md-6">
          <button type="submit" name="reg_user" class="btn btn-success">Registruj se</button>
        </div>
      </div>
    </form>
    <br>
  </div>
</div>

<script src="assets/js/user.js"></script>
<?php
  include('parts/footer.php');
?>
