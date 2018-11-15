<?php
  require_once('db/db.php');
  require_once('db/baseurl.php');
  include_once('parts/admin_header.php');
  if(!isset($_SESSION['admin']['admin_id'])) {
    header('Location: admin.php');
  }
?>
<h5 class="" style="color:gold"><i class="fas fa-industry"></i></i> Upravljaj brendovima</h5>
<br>
<div id="brand_message"></div>
<div id="brand-manage">
  <table id="brand_table" class="table table-striped" style="color:white;">
    <thead style="color:white; background-color:rgba(0,0,0,0.2)">
      <tr>
        <th style="width:5%">#</th>
        <th style="width:20%">Kategorija</th>
        <th style="width:30%">Naziv</th>
        <th style="width:10%; text-align:center">Status</th>
        <th style="width:10%; text-align:center">Izmeni</th>
        <th style="width:10%; text-align:center">Izbrisi</th>
      </tr>
    </thead>
  </table>
</div>
<!--brand edit modal -->
<div id="brandEditModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <form id="edit_brand" onsubmit="return false" enctype="multipart/form-data">
        <div class="modal-header">
          <h4 class="modal-title"><i class="fas fa-edit"></i> Izmeni brend</h4>
          <button type="button" name="close" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="brand_new_name">Naziv brenda</label>
              <input type="text" class="form-control" name="brand_new_name" id="brand_new_name" placeholder="Unesi nov naziv brenda" required>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="brand_logo">Logo brenda</label>
                  <input type="file" class="form-control" name="brand_logo" id="brand_logo">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <div class="form-group">
                    <label for="new_category">Kategorija kojoj brend pripada</label>
                    <select class="form-control" name="new_category" id="new_category" required>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                Pogledaj logo: <span id="uploaded_image"></span>
                <div class="form-group" id="logo_preview"></div>
              </div>
              <div class="col-md-8">
                <div class="form-group">
                  <label for="brand_new_description">Opis brenda</label>
                  <textarea name="brand_new_description" id="brand_new_description" rows="8" cols="80" class="form-control" required></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <div class="modal-footer">
          <div class="form-group">
            <button type="submit" id="submit_edited_brand" class="btn btn-primary"><i class="fas fa-save"></i> Izmeni Brend</button>
            <input type="hidden" name="brand_id" id="brand_id" value="">
            <button type="button" id="dismiss_brand" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Nazad</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<br>

<script src="js/brands.js"></script>
<?php
  include_once('parts/admin_footer.php');
?>
