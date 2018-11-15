<?php
  require_once('db/db.php');
  require_once('db/baseurl.php');
  include('parts/admin_header.php');
?>

<div class="col-md-6" style="margin:auto">
  <br>
  <div class="card" style="background-color:#b37700">
    <div class="card-header">
      <strong>Nov administrator</strong>
    </div>
    <div class="card-body">
      <div id="reg_message"></div>
      <div id="auth_confirm_div" class="">
        <h3>Unesite prvo kod za autentifikaciju</h3>
        <form class="" action="" method="post" name="auth_confirm" id="auth_confirm">
          <div class="form-group">
            <label for="exampleInputEmail1">Unesite kod</label>
            <input type="text" name="auth_code" id="auth_code" value="" class="form-control">
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-success" value="Posalji">
            <div id="auth_message"></div>
          </div>
        </form>
      </div>
      <br>
      <form class="admin_registration_hide" id="admin_registration" name="admin_registration" method="post">
        <h3>Registracija</h3>
        <div class="form-group">
          <label for="exampleInputEmail1">Email adresa</label>
          <input type="email" name="reg_email" class="form-control" id="reg_email" aria-describedby="emailHelp" placeholder="Unesite email" required>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Lozinka</label>
          <input type="password" name="reg_password" class="form-control" id="reg_password" placeholder="Unesite lozinku" required>
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Korisnicko ime</label>
          <input type="text" name="reg_username" class="form-control" id="reg_username" aria-describedby="emailHelp" placeholder="Unesite korisnicko ime" required>
        </div>
        <div class="row" id="buttons">
          <div class="col-md-6">
            <button type="submit" class="btn btn-success">Registruj se</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<br>

<script src="js/admin.js"></script>
<?php
  include('parts/admin_footer.php');
?>
