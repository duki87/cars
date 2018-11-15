<?php
require_once('db/db.php');
require_once('db/baseurl.php');
include_once('parts/admin_header.php');

  if(!isset($_SESSION['admin']['admin_id'])) {
    header('Location: admin.php');
  }
?>
<div id="category_message"></div>
<div class="card" style="background-color:#00264d; color:white">
  <h5 class="card-header" style="color:gold"><i class="fas fa-plus-square"></i>  <i class="fas fa-list-ul"></i></i> Dodaj novu kategoriju</h5>
  <div class="card-body">
    <h5 class="card-title">Unesite sledece podatke:</h5>
    <form id="add_category" onsubmit="return false">
      <div class="form-group">
        <label for="brand_name">Naziv kategorije</label>
        <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Unesi naziv brenda" required>
      </div>
      <hr>
      <div class="form-group">
        <button type="submit" id="submit_category" class="btn btn-primary"><i class="fas fa-plus-square"></i> Dodaj Kategoriju</button>
        <button type="button" id="dismiss_category" class="btn btn-danger"><i class="fas fa-times"></i> Ponisti</button>
      </div>
    </form>
  </div>
</div>

<script src="js/categories.js"></script>
<?php
  include_once('parts/admin_footer.php');
?>
