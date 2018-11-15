<?php
require_once('db/db.php');
require_once('db/baseurl.php');
include_once('parts/admin_header.php');

  if(!isset($_SESSION['admin']['admin_id'])) {
    header('Location: admin.php');
  }
?>
<br>
<div id="brand_message"></div>
<div class="card" style="background-color:#00264d; color:white">
  <h5 class="card-header" style="color:gold"><i class="fas fa-plus-square"></i> <i class="fas fa-industry"></i> Dodaj nov brend</h5>
  <div class="card-body">
    <h5 class="card-title">Unesite sledece podatke:</h5>
    <form id="add_brand" onsubmit="return false" enctype="multipart/form-data">
      <div class="form-group">
        <label for="brand_name">Naziv brenda</label>
        <input type="text" class="form-control" name="brand_name" id="brand_name" placeholder="Unesi naziv brenda" required>
      </div>
      <div class="form-group">
        <label for="all_categories">Kategorija kojoj brend pripada</label>
        <select class="form-control" name="all_categories" id="all_categories" required>

        </select>
      </div>
      <div class="form-group">
        <label for="brand_logo">Logo brenda</label>
        <input type="file" class="form-control" name="brand_logo" id="brand_logo">
      </div>
      <div class="row">
        <div class="col-md-4">
          Pogledaj logo: <span id="uploaded_image"></span>
          <div class="form-group" id="logo_preview"></div>
        </div>
        <div class="col-md-8">
          <div class="form-group">
            <label for="brand_description">Opis brenda</label>
            <textarea name="brand_description" id="brand_description" rows="8" cols="80" class="form-control" required></textarea>
          </div>
        </div>
      </div>
      <hr>
      <div class="form-group">
        <button type="submit" id="submit_brand" class="btn btn-primary"><i class="fas fa-plus-square"></i> Dodaj Brend</button>
        <button type="button" id="dismiss_brand" class="btn btn-danger"><i class="fas fa-times"></i> Ponisti</button>
      </div>
    </form>
  </div>
</div>

<script src="js/brands.js"></script>
<?php
  include_once('parts/admin_footer.php');
?>
