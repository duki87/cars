<?php
  require_once('db/db.php');
  require_once('db/baseurl.php');
  include_once('parts/admin_header.php');
  if(!isset($_SESSION['admin']['admin_id'])) {
    header('Location: admin.php');
  }
?>
<h5 class="" style="color:gold"><i class="fas fa-car"></i></i> Upravljaj modelima</h5>
<br>
<div id="model_message"></div>
<br>
<div id="model-manage">
  <table id="model_table" class="table table-striped" style="color:white;">
    <thead style="color:white; background-color:rgba(0,0,0,0.2)">
      <tr>
        <th style="width:10%">#</th>
        <th style="width:25%; text-align:center">Model</th>
        <th style="width:25%">Kategorija</th>
        <th style="width:25%">Brend</th>
        <th style="width:15%">Obrisi</th>
      </tr>
    </thead>
  </table>
</div>

<script src="js/models.js"></script>
<br>
<?php
  include_once('parts/admin_footer.php');
?>
