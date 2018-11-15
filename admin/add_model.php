<?php
require_once('db/db.php');
require_once('db/baseurl.php');
include_once('parts/admin_header.php');

  if(!isset($_SESSION['admin']['admin_id'])) {
    header('Location: admin.php');
  }
?>
<br>
<div id="model_message"></div>
<div class="card" style="background-color:#00264d; color:white">
  <h5 class="card-header" style="color:gold"><i class="fas fa-plus-square"></i> <i class="fas fa-car"></i></i> Dodaj nov model</h5>
  <div class="card-body">
    <form id="add_model" onsubmit="return false">
      <div class="form-group">
        <label for="">Prvo izaberite kategoriju vozila:</label>
        <select id="all_categories" class="form-control" name="all_categories">

        </select>
      </div>

      <div class="form-group">
        <label for="">Izaberite brend (proizvodjaca):</label>
        <select id="all_brands" class="form-control" name="all_brands">

        </select>
      </div>
      <div class="form-group">
        <label for="model_name">Naziv modela</label>
        <input type="text" class="form-control" name="model_name" id="model_name" placeholder="Unesi naziv modela" required>
      </div>
      <hr>
      <div class="form-group">
        <button type="submit" id="submit_model" class="btn btn-primary"><i class="fas fa-plus-square"></i> Dodaj model</button>
        <button type="button" id="dismiss_model" class="btn btn-danger"><i class="fas fa-times"></i> Ponisti</button>
      </div>
    </form>
  </div>
</div>

<script src="js/models.js"></script>
<?php
  include_once('parts/admin_footer.php');
?>
