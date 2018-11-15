<?php
  require_once('db/db.php');
  include('parts/header.php');
  if(!isset($_SESSION['user']['user_id'])) {
    header("Location: http://localhost/cars/signin.php");
    $_SESSION['message']['error'] = 'Morate se prijaviti da biste postavili oglas! Ukoliko nemate nalog, registrujte se.';
  }
?>

<div class=""><br>
  <div class="alert alert-success alert-dismissible fade show d-none" role="alert" id="profile_message">
    <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"> -->
    <button type="button" class="close close_message" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <h3 class="" style="color:gold; border-bottom: 1px solid gold"><i class="fas fa-user"></i> Vas profil</h3>
  <div class="container" id="user-tabs">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#user_data" role="tab" aria-controls="home" aria-selected="true">Osnovni podaci</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#selling_adds" role="tab" aria-controls="profile" aria-selected="false">Vasi oglasi</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#statistics" role="tab" aria-controls="contact" aria-selected="false">Statistika</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="rating-tab" data-toggle="tab" href="#rating" role="tab" aria-controls="contact" aria-selected="false">Ocene</a>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <br>
      <div class="tab-pane fade show active" id="user_data" role="tabpanel" aria-labelledby="home-tab">
        <form class="" method="post" id="edit_user_data" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <div class="photo_box" id="photo_box" style="position:relative">
                  <img src="" id="photo" alt="" class="" width="300px" height="300px">
                </div>
              </div>
              <div class="form-group">
                <div class="text-alert" id="error_images"></div>
                <label for="add_edit_photo" style="color:white" class="btn btn-primary" id="photo_button">Izmeni fotografiju</label>
                <input type="file" name="add_edit_photo" id="add_edit_photo" value="" style="display:none">
              </div>
            </div>
            <div class="col-md-8">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="name" style="color:yellow">Ime</label>
                  <input type="text" name="name" id="name" value="" class="form-control">
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label for="last_name" style="color:yellow">Prezime</label>
                  <input type="text" name="last_name" id="last_name" value="" class="form-control">
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label for="email" style="color:yellow">E-mail</label>
                  <input type="text" name="email" id="email" value="" class="form-control">
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label for="address" style="color:yellow">Adresa</label>
                  <input type="text" name="address" id="address" value="" class="form-control">
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label for="city" style="color:yellow">Grad</label>
                  <input type="text" name="city" id="city" value="" class="form-control">
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label for="phone" style="color:yellow">Telefon</label>
                  <input type="text" name="phone" id="phone" value="" class="form-control">
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label for="date_joined" style="color:yellow">Pridruzili ste se</label>
                  <h4 class="text-success" name="date_joined" id="date_joined"></h4>
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <button class="btn btn-success" type="submit" name="edit" id="edit"><i class="fas fa-pencil-alt"></i> Izmeni podatke</button>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#change_password">
                    <i class="fas fa-key"></i> Izmeni lozinku
                  </button>
                </div>
              </div>
            </div>

          </div>
        </form>
      </div>
      <div class="tab-pane fade" id="selling_adds" role="tabpanel" aria-labelledby="profile-tab">...</div>
      <div class="tab-pane fade" id="statistics" role="tabpanel" aria-labelledby="contact-tab">...</div>
      <div class="tab-pane fade" id="rating" role="tabpanel" aria-labelledby="rating-tab">...</div>
    </div>
  </div>
</div>

<!-- Change password modal -->
<div class="modal" tabindex="-1" id="change_password" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-key"></i> Promena lozinke korisnika</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="password_form" method="post">
          <div class="form-group">
            <label for="old_password">Stara lozinka</label>
            <input type="password" name="old_password" id="old_password" value="" class="form-control">
            <small id="check_old_pwd" class=""></small>
          </div>
          <div class="form-group">
            <label for="new_password">Nova lozinka</label>
            <input type="password" name="new_password" id="new_password" value="" class="form-control">
          </div>
          <div class="form-group">
            <label for="confirm_password">Potvrdi lozinku</label>
            <input type="password" name="confirm_password" id="confirm_password" value="" class="form-control">
            <small id="check_new_pwd" class=""></small>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Sacuvaj</button>
        </form>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="clear_form">Nazad</button>
      </div>
    </div>
  </div>
</div>
<script src="assets/js/profile.js"></script>
<?php
  include('parts/footer.php');
?>
