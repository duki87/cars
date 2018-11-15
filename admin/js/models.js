$(document).ready(function() {
  get_categories();

  //Get all categories
  function get_categories() {
    var get_categories = true;
    $.ajax({
      url: "process/model_process.php",
      method: 'post',
      data: {get_categories:get_categories},
      dataType: 'json',
      success: function(data) {
        $('#all_categories').html(data);
      }
    });
  }

  $(document).on('change', '#all_categories',function() {
    var category_id = $('#all_categories').val();
    var get_brands = true;
    $.ajax({
      url: "process/model_process.php",
      method: 'post',
      data: {get_brands:get_brands,category_id:category_id},
      dataType: 'json',
      success: function(data) {
        $('#all_brands').html(data);
      }
    });
  });

  //submit model
  $(document).on('submit', '#add_model', function(event) {
    event.preventDefault();
    var model_name = $('#model_name').val();
    var brand_id = $('#all_brands').val();
    var category_id = $('#all_categories').val();
    $('#submit_model').attr('disabled','disabled');
    $.ajax({
      url: "process/model_process.php",
      method: 'post',
      data: {model_name:model_name,brand_id:brand_id, category_id:category_id},
      success: function(data) {
        if(data == 'MODEL_ADDED') {
          $('#add_model')[0].reset();
          $('#submit_model').attr('disabled',false);
          var model_message ='<div class="alert alert-success alert-dismissible fade show" role="alert">'+
          '<strong>Model je uspesno unet!</strong> Mozete dodati sledeci.'+
           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
          '<span aria-hidden="true">&times;</span>'+
            '</button>'+
          '</div>';
          $('#model_message').html('<p>'+model_message+'</p>');
        } else {
          var model_message ='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
          '<strong>Doslo je do greske!</strong> Pokusajte ponovo.'+
           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
          '<span aria-hidden="true">&times;</span>'+
            '</button>'+
          '</div>';
          $('#submit_model').attr('disabled',false);
          $('#model_message').html('<p>'+model_message+'</p>');
        }
      }
    });
  });

  //Clear form event
  $(document).on('click', '#dismiss_model', function(event) {
    event.preventDefault();
    clear_form();
  });

  //Clear form function
  function clear_form() {
    $('#add_model')[0].reset();
  }

  //get models (datatables)
  var load_all_models;
  var modeldataTable = $('#model_table').DataTable({
    "processing"  : true,
    "serverSide"  : true,
    "order" : [],
    "ajax"  : {
      url : "process/model_process.php",
      type :  "POST",
      data: {load_all_models:1}
    },
    "columns": [
        { data: 'number' },
        { data: 'model_name' },
        { data: 'category_name' },
        { data: 'brand_name' },
        { data: 'delete' },
    ],
    "columnDefs"  : [
      {
        "defaultContent": "-",
        "targets": "_all"
      }
    ],
    "pageLength"  : 10
  });

  $(document).on('click', '.delete-model', function(event) {
    event.preventDefault();
    var model_id = $(this).attr('id');
    var delete_model = true;
    if(confirm('Da li ste sigurni da zelite trajno da obrisete ovaj model automobila?')) {
      $.ajax({
        url:  "process/model_process.php",
        method: "POST",
        data: {model_id:model_id,delete_model:delete_model},
        success: function(data) {
          if(data == 'MODEL_DELETED') {
            var model_message ='<div class="alert alert-success alert-dismissible fade show" role="alert">'+
            '<strong>Model je trajno obrisan!</strong> Mozete ga ponovo dodati.'+
             '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
            '<span aria-hidden="true">&times;</span>'+
              '</button>'+
            '</div>';
            $('#model_message').html(model_message);
            modeldataTable.ajax.reload();
          } else {
            var model_message ='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
            '<strong>Doslo je do greske!</strong> Pokusajte ponovo.'+
             '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
            '<span aria-hidden="true">&times;</span>'+
              '</button>'+
            '</div>';
            $('#model_message').html(model_message);
          }
        }
      });
    }
  })

});
