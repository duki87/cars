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
  <div class="row">
    <div class="col-md-2">
      <span class="text-info">Broj oglasa po strani:</span>
    </div>
    <div class="col-md-1">
      <select class="form-control" name="per_page" id="per_page">
        <option value="4">4</option>
        <option value="8">8</option>
        <option value="12">12</option>
      </select>
    </div>
    <div class="col-md-2">
      <span class="text-info float-right">Sortiranje:</span>
    </div>
    <div class="col-md-2">
      <select class="form-control" name="sorting" id="sorting">
        <option value="price_asc">Prvo jeftinije</option>
        <option value="price_desc">Prvo skuplje</option>
      </select>
    </div>
  </div>
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

<nav aria-label="Page navigation example">
  <ul class="pagination" id="pagination_area">

  </ul><br>
</nav>
<script type="text/javascript">
  get_selling_adds_sponsored();
  get_selling_adds();

  //get get_selling_adds_sponsored
  function get_selling_adds_sponsored() {
    var get_selling_adds_sponsored = 1;
    $.ajax({
      url: "process/sadds_process.php",
      method: 'post',
      data: {get_selling_adds_sponsored:get_selling_adds_sponsored},
      dataType: 'json',
      success: function(data) {
        $('#sponsored_adds').append(data);
      }
    });
  }

  //get selling_adds_with_pagination
  function get_selling_adds() {
    var get_selling_adds = true;
    var per_page = 4;
    var chunk_to_display = 0;
    var sqlTable = 'vehicle';
    var pagination = {
      "per_page" : per_page,
      "chunk_to_display" : chunk_to_display,
      "sqlTable" : sqlTable
    };
    var pagination_data = JSON.stringify(pagination);
    $.ajax({
      url: "process/sadds_process.php",
      method: 'post',
      data: {get_selling_adds:get_selling_adds,pagination_data:pagination_data},
      dataType: 'json',
      success: function(data) {
        $('#other_adds').append(data.data);
        $('#pagination_area').append(data.paginations);
      }
    });
  }

  $(document).on('click', '.pagination-page', function(event) {
    event.preventDefault();
    var per_page = parseInt($('#per_page').val());
    var sqlTable = 'vehicle';
    var chunkid = parseInt($(this).attr('data-chunkid'));
    var get_selling_adds = true;
    var pagination = {
      "per_page" : per_page,
      "chunk_to_display" : chunkid,
      "sqlTable" : sqlTable
    };
    var pagination_data = JSON.stringify(pagination);
    $.ajax({
      url: "process/sadds_process.php",
      method: 'post',
      data: {
        get_selling_adds:get_selling_adds,
        pagination_data:pagination_data
      },
      dataType: 'json',
      success: function(data) {
        $('#other_adds').html('');
        $('#other_adds').append(data.data);
        $('#pagination_area').html('');
        $('#pagination_area').append(data.paginations);
      }
    });
  });

  $(document).on('click', '.pagination-next', function(event) {
    event.preventDefault();
    var per_page = parseInt($('#per_page').val());
    var sqlTable = 'vehicle';
    var chunkid = parseInt($(this).attr('data-chunkid')) + 1;
    var get_selling_adds = true;
    var pagination = {
      "per_page" : per_page,
      "chunk_to_display" : chunkid,
      "sqlTable" : sqlTable
    };
    var pagination_data = JSON.stringify(pagination);
    $.ajax({
      url: "process/sadds_process.php",
      method: 'post',
      data: {pagination_data:pagination_data,get_selling_adds:get_selling_adds},
      dataType: 'json',
      success: function(data) {
        $('#other_adds').html('');
        $('#other_adds').append(data.data);
        $('#pagination_area').html('');
        $('#pagination_area').append(data.paginations);
      }
    });
  });

  $(document).on('click', '.pagination-prev', function(event) {
    event.preventDefault();
    var per_page = parseInt($('#per_page').val());
    var sqlTable = 'vehicle';
    var chunkid = parseInt($(this).attr('data-chunkid')) - 1;
    var get_selling_adds = true;
    var pagination = {
      "per_page" : per_page,
      "chunk_to_display" : chunkid,
      "sqlTable" : sqlTable
    };
    var pagination_data = JSON.stringify(pagination);
    $.ajax({
      url: "process/sadds_process.php",
      method: 'post',
      data: {pagination_data:pagination_data,get_selling_adds:get_selling_adds},
      dataType: 'json',
      success: function(data) {
        $('#other_adds').html('');
        $('#other_adds').append(data.data);
        $('#pagination_area').html('');
        $('#pagination_area').append(data.paginations);
      }
    });
  });

  $(document).on('change', '#per_page', function(event) {
    event.preventDefault();
    var per_page = parseInt($('#per_page').val());
    var sqlTable = 'vehicle';
    var chunkid = 0;
    var get_selling_adds = true;
    var pagination = {
      "per_page" : per_page,
      "chunk_to_display" : chunkid,
      "sqlTable" : sqlTable
    };
    var pagination_data = JSON.stringify(pagination);
    $.ajax({
      url: "process/sadds_process.php",
      method: 'post',
      data: {pagination_data:pagination_data,get_selling_adds:get_selling_adds},
      dataType: 'json',
      success: function(data) {
        $('#other_adds').html('');
        $('#other_adds').append(data.data);
        $('#pagination_area').html('');
        $('#pagination_area').append(data.paginations);
      }
    });
  });

  $(document).on('change', '#price_min', function(e) {
    e.preventDefault();
    var price_value = $('#price_min').val();
    $('#price_min_val').html(price_value);
    $('#price_from').val(price_value);
    $('#price_max').attr('min', price_value);
    $('#price_max').attr('max', '100000');
  });

  $(document).on('change', '#price_max', function(e) {
    e.preventDefault();
    var price_value_max = $('#price_max').val();
    $('#price_to').val(price_value_max);
    $('#price_max').attr('data-price', price_value_max);
    $('#price_max_val').html(price_value_max);
  });

  // $(document).on('change', '#price', function(e) {
  //   //e.preventDefault();
  //   var price_value = $('#price').val();
  //   $('#price_val').val(price_value);
  // });

  // $(document).on('change', '#monet', function() {
  //   var monet_val = $(this).val();
  //   if(monet_val == 'dinar') {
  //     $('#price').attr('data-monet', monet_val);
  //     $('#price').attr('max', '1000000');
  //     $('#price').attr('step', '10000');
  //     $('#price').val('100000');
  //     $('#price_val').val('');
  //   } else {
  //     $('#price').attr('data-monet', monet_val);
  //     $('#price').attr('max', '50000');
  //     $('#price').attr('step', '200');
  //     $('#price').val('1000');
  //     $('#price_val').val('');
  //   }
  // });

</script>
<script src="assets/js/selling_adds.js"></script>
<?php
  include('parts/footer.php');
?>
