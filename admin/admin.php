<?php
  require_once('db/db.php');
  require_once('db/baseurl.php');
  include_once('parts/admin_header.php');
?>

<div class="col-md-6" style="margin:auto">
  <br>
  <div class="card" style="background-color:#00264d">
    <div class="card-header">
      <strong style="color:white">Prijavi se</strong>
    </div>
    <div class="card-body">
      <div id="login_message"></div>
      <form class="" id="admin_login" name="admin_login" method="post">
        <div class="form-group">
          <label for="exampleInputEmail1" style="color:white">Email adresa</label>
          <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" required placeholder="Unesite email">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1" style="color:white">Lozinka</label>
          <input type="password" name="password" class="form-control" id="password" required placeholder="Unesite lozinku">
        </div>
        <div class="row">
          <div class="col-md-6">
            <button type="submit" class="btn btn-primary">Prijavi se</button>
          </div>
          <div class="col-md-6 ">
            <a href="lost_password.php" class="btn btn-danger float-right">Zaboravljena lozinka?</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="js/admin.js"></script>
<?php
  include_once('parts/admin_footer.php');
?>
