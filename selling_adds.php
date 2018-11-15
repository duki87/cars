<?php
require_once('db/db.php');
include('parts/header.php');
?>
<br>
<div class="row row-custom" id="adds_area">
  <div class="col-md-12">
    <h2 class="" style="color:gold; border-bottom: 1px solid gold"><i class="fas fa-car"></i> Pregled oglasa</h2>
  </div>
</div>
<div class="row row-custom" id="sponsored_adds" style="background-color:white">
  <div class="col-md-12">
    <h4 class="" style="color:black; border-bottom: 1px solid black">Sponzorisano</h4>
  </div>

</div>
<br>
<div class="" id="openSearchForm">
  <form class="row">
    <div class="col-md-8 mb-2" style="position:relative">
      <input type="text" name="searchByText" id="searchByText" class="form-control" value="" placeholder="Unesite kljucne reci">
      <div class="d-none suggestion-menu" id="dresults">
      </div>
    </div>
    <div class="col-md-2 mb-2">
      <button type="submit" name="searchByTextSubmit" id="searchByTextSubmit" style="width:100%" id="searchByTextSubmit" class="btn btn-warning"><i class="fas fa-search"></i> Pretrazi</button>
    </div>
    <div class="col-md-2 mb-2">
      <button class="btn btn-primary" style="width:100%" type="button" data-toggle="collapse" data-target="#searchVehicles" aria-expanded="false" aria-controls="collapseExample">
        Detaljna pretraga
      </button>
    </div>
  </form>
</div>
<br>
<div class="collapse" id="searchVehicles">
  <div class="card card-body" style="background-color:rgba(0,0,0,0.3)">
    <?php include_once 'parts/searchForm.php'; ?>
    <br>
  </div><br>
</div>
<div class="row row-custom" id="other_adds">

</div>
<script type="text/javascript">
  get_selling_adds();

  //get selling_adds
  function get_selling_adds() {
    var get_selling_adds = 1;
    $.ajax({
      url: "process/sadds_process.php",
      method: 'post',
      data: {get_selling_adds:get_selling_adds},
      dataType: 'json',
      success: function(data) {
        $('#sponsored_adds').append(data.sponsored);
        $('#other_adds').append(data.other);
      }
    });
  }

  $(document).on('change', '#price', function(e) {
    //e.preventDefault();
    var price_value = $('#price').val();
    $('#price_val').val(price_value);
  });

  $(document).on('change', '#monet', function() {
    var monet_val = $(this).val();
    if(monet_val == 'dinar') {
      $('#price').attr('data-monet', monet_val);
      $('#price').attr('max', '1000000');
      $('#price').attr('step', '10000');
      $('#price').val('100000');
      $('#price_val').val('');
    } else {
      $('#price').attr('data-monet', monet_val);
      $('#price').attr('max', '50000');
      $('#price').attr('step', '200');
      $('#price').val('1000');
      $('#price_val').val('');
    }
  });
  
</script>
<script src="assets/js/selling_adds.js"></script>
<?php
  include('parts/footer.php');
?>