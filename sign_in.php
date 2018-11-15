<?php
  require_once('db/db.php');
  include('parts/header.php');
?>
<div class="row">
  <div class="col-md-6">
    <br>
    <form class="user_signin" id="user_signin" name="user_signin" method="post">
      <h3 style="color:gold">Prijavi se</h3><hr style="border-bottom:1px gold solid">
      <div class="form-group">
        <label for="exampleInputEmail1" style="color:white">Email adresa</label>
        <input type="email" name="sign_email" class="form-control" id="sign_email" aria-describedby="emailHelp" placeholder="Unesite email" required>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1" style="color:white">Lozinka</label>
        <input type="password" name="sign_password" class="form-control" id="sign_password" placeholder="Unesite lozinku" required>
      </div>
      <div class="row" id="buttons">
        <div class="col-md-6">
          <button type="submit" class="btn btn-success">Prijavi se</button>
        </div>
      </div>
    </form>
  </div>

  <div class="col-md-6">
    <br>
    <form class="user_registration" id="user_registration" name="user_registration" method="post">
      <h3 style="color:gold">Nemas nalog? Registruj se!</h3><hr style="border-bottom:1px gold solid">
      <div class="form-group">
        <label for="exampleInputEmail1" style="color:white">Email adresa</label>
        <input type="email" name="reg_email" class="form-control" id="reg_email" aria-describedby="emailHelp" placeholder="Unesite email" required>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1" style="color:white">Lozinka</label>
        <input type="password" name="reg_password" class="form-control" id="reg_password" placeholder="Unesite lozinku" required>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1" style="color:white">Ponovi lozinku</label>
        <input type="password" name="check_password" class="form-control" id="check_password" placeholder="Unesite lozinku" required>
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1" style="color:white">Ime</label>
        <input type="text" name="reg_name" class="form-control" id="reg_name" aria-describedby="emailHelp" placeholder="Unesite ime" required>
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1" style="color:white">Prezime</label>
        <input type="text" name="reg_last_name" class="form-control" id="reg_last_name" aria-describedby="emailHelp" placeholder="Unesite prezime" required>
      </div>
      <div class="form-group">
        <div class="row">
          <div class="col-md-8">
            <label for="exampleInputEmail1" style="color:white">Ulica</label>
            <input type="text" name="street" class="form-control" id="street" aria-describedby="emailHelp" placeholder="Unesite ulicu" required>
          </div>
          <div class="col-md-4">
            <label for="exampleInputEmail1" style="color:white">Broj</label>
            <input type="text" name="street_num" class="form-control" id="street_num" aria-describedby="emailHelp" placeholder="Unesite ulicni broj" required>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1" style="color:white">Mesto</label>
        <input type="text" name="city" class="form-control" id="city" aria-describedby="emailHelp" placeholder="Unesite mesto stanovanja" required>
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1" style="color:white">Telefon</label>
        <input type="text" name="phone" class="form-control" id="phone" aria-describedby="emailHelp" placeholder="Unesite telefon" required>
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
