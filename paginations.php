<?php
  // require_once('db/db.php');
  require_once('db/db.php');
  include('parts/header.php');

  ?>
<div class="col-md-10 col-md-offset-1">
  <h1>PHP Pagination</h1>
  <div class="float-right">
    <select class="form-control" name="per_page" id="per_page">
      <option value="5">5</option>
      <option value="10">10</option>
    </select>
  </div>
  <table class="table table-striped table-condensed table-bordered table-rounded" id="paginationTable" data-sqltable="brands">
    <thead>
      <tr>
        <th width="20%">brand_name</th>
        <th width="20%">brand_logo</th>
        <th width="25%">brand_description</th>
      </tr>
    </thead>
    <tbody id="pagination_data">

    </tbody>
  </table>

<nav aria-label="Page navigation example">
  <ul class="pagination" id="pagination_area">

  </ul>
</nav>
</div>

<script type="text/javascript">
  get_pagination_data();

  function get_pagination_data() {
    var per_page = 5;
    var get_pagination_data = true;
    var chunk_to_display = 0;
    var sqlTable = JSON.stringify($('#paginationTable').attr('data-sqltable'));
    $.ajax({
      url: "process/pagination_process.php",
      method: 'post',
      data: {
        per_page:per_page,
        get_pagination_data:get_pagination_data,
        sqlTable:sqlTable,
        chunk_to_display:chunk_to_display
      },
      dataType: 'json',
      success: function(data) {
        $('#pagination_area').html(data.paginations);
        $('#pagination_data').html(data.pagination_data);
      }
    });
  }

  $(document).on('click', '.pagination-page', function(event) {
    event.preventDefault();
    var per_page = parseInt($('#per_page').val());
    var sqlTable = JSON.stringify($('#paginationTable').attr('data-sqltable'));
    var chunkid = parseInt($(this).attr('data-chunkid'));
    var get_pagination_page = true;
    $.ajax({
      url: "process/pagination_process.php",
      method: 'post',
      data: {
        per_page:per_page,
        get_pagination_page:get_pagination_page,
        chunkid:chunkid,
        sqlTable:sqlTable
      },
      dataType: 'json',
      success: function(data) {
        $('#pagination_area').html('');
        $('#pagination_area').html(data.paginations);
        $('#pagination_data').html('');
        $('#pagination_data').html(data.pagination_data);
      }
    });
  });

  $(document).on('click', '.pagination-next', function(event) {
    event.preventDefault();
    var per_page = $('#per_page').val();
    var chunkid = parseInt($(this).attr('data-chunkid')) + 1;
    var sqlTable = JSON.stringify($('#paginationTable').attr('data-sqltable'));
    var get_pagination_next = true;
    $.ajax({
      url: "process/pagination_process.php",
      method: 'post',
      data: {per_page:per_page,get_pagination_next:get_pagination_next, chunkid:chunkid, sqlTable:sqlTable},
      dataType: 'json',
      success: function(data) {
        $('#pagination_area').html('');
        $('#pagination_area').html(data.paginations);
        $('#pagination_data').html('');
        $('#pagination_data').html(data.pagination_data);
      }
    });
  });
  //
  $(document).on('click', '.pagination-prev', function(event) {
    event.preventDefault();
    var per_page = $('#per_page').val();
    var chunkid = parseInt($(this).attr('data-chunkid')) - 1;
    var sqlTable = JSON.stringify($('#paginationTable').attr('data-sqltable'));
    var get_pagination_prev = true;
    $.ajax({
      url: "process/pagination_process.php",
      method: 'post',
      data: {per_page:per_page,get_pagination_prev:get_pagination_prev, chunkid:chunkid, sqlTable:sqlTable},
      dataType: 'json',
      success: function(data) {
        $('#pagination_area').html('');
        $('#pagination_area').html(data.paginations);
        $('#pagination_data').html('');
        $('#pagination_data').html(data.pagination_data);
      }
    });
  });
  //
  $(document).on('change', '#per_page', function(event) {
    event.preventDefault();
    var per_page = $('#per_page').val();
    var change_records_num = true;
    var chunkid = 0;
    var sqlTable = JSON.stringify($('#paginationTable').attr('data-sqltable'));
    $.ajax({
      url: "process/pagination_process.php",
      method: 'post',
      data: {per_page:per_page,change_records_num:change_records_num, chunkid:chunkid, sqlTable:sqlTable},
      dataType: 'json',
      success: function(data) {
        $('#pagination_area').html('');
        $('#pagination_area').html(data.paginations);
        $('#pagination_data').html('');
        $('#pagination_data').html(data.pagination_data);
      }
    });
  });
</script>
