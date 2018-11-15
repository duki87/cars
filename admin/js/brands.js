$(document).ready(function() {
  var domain = 'http://localhost/cars/';
  $('#collapsibleNavbar').collapse();

  get_categories();

  //Get all categories
  function get_categories() {
    var get_categories = true;
    $.ajax({
      url: "process/brand_process.php",
      method: 'post',
      data: {get_categories:get_categories},
      dataType: 'json',
      success: function(data) {
        $('#all_categories').html(data);
        $('#new_category').html(data);
      }
    });
  }

  //Logo preview
  $(document).on('change', '#brand_logo', function() {
    var property = document.getElementById('brand_logo').files[0];
    var image_name = property.name;
    var image_extension = image_name.split('.').pop().toLowerCase();
    if(jQuery.inArray(image_extension, ["jpg","jpeg","png","gif"]) == -1) {
      alert('Ovaj tip datoteke nije dozvoljen! Probajte sa drugom.');
    }
    var image_size = property.size;
    if(image_size > 5000000) {
      alert('Velicina fotografije veca od 5 MB!');
    } else {
      var form_data = new FormData();
      form_data.append('brand_logo', property);
      $.ajax({
        url:  'process/brand_process.php',
        method: 'POST',
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
          $('#uploaded_image').text('Fotografija se ucitava...');
        },
        success: function(data) {
          $('#logo_preview').html(data);
          $('#uploaded_image').text('Logo ucitan!');
          var image_location = $('#remove_button').data('location');
          $('#image_location').val(image_location);
        }
      });
    }
  });

  //Logo preview delete
  $(document).on('click', '#remove_button', function() {
    if(confirm("Da li ste sigurni da zelite da izbrisete ovu fotografiju?")) {
      var location = $('#remove_button').data('location');
      var delete_logo = true;
      $.ajax({
        url:  "process/brand_process.php",
        method: "POST",
        data: {location:location,delete_logo:delete_logo},
        success: function(data) {
          if(data == 'IMG_DELETED') {
            $('#logo_preview').html('');
            $('#uploaded_image').text('Logo obrisan! Ucitajte drugi.');
          }
        }
      });
    } else {
      return false;
    }
  });

  //Brand submit
  $(document).on('submit', '#add_brand', function(event) {
    event.preventDefault();
    var logo = $('#brand_img').data('imgname');
    if($('#brand_img').length < 1 || logo == '') {
      alert('Logo je obavezno uneti!');
    }
    // var form_data = $(this).serialize();
    var brand_name = $('#brand_name').val();
    var brand_description = $('#brand_description').val();
    var category_id = $('#all_categories').val();
    $('#submit_brand').attr('disabled','disabled');
    $.ajax({
      url:  "process/brand_process.php",
      method: "POST",
      data: {logo:logo,brand_description:brand_description,brand_name:brand_name,category_id:category_id},
      success: function(data) {
        if(data == 'BRAND_ADDED') {
          $('#add_brand')[0].reset();
          $('#logo_preview').html('');
          $('#uploaded_image').text('');
          $('#submit_brand').attr('disabled',false);
          var brand_message ='<div class="alert alert-success alert-dismissible fade show" role="alert">'+
          '<strong>Brend uspesno unesen!</strong> Mozete uneti sledeci.'+
           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
          '<span aria-hidden="true">&times;</span>'+
            '</button>'+
          '</div>';
          $('#brand_message').html('<p>'+brand_message+'</p>');
        } else {
          var brand_message ='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
          '<strong>Neuspelo unosenje!</strong> Pokusajte ponovo.'+
           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
          '<span aria-hidden="true">&times;</span>'+
            '</button>'+
          '</div>';
          $('#brand_message').html('<p>'+brand_message+'</p>');
          $('#submit_brand').attr('disabled',false);
        }
      }
    });
  });

  //get all brands (datatables)
  var branddataTable = $('#brand_table').DataTable({
    "processing"  : true,
    "serverSide"  : true,
    "order" : [],
    "ajax"  : {
      url : "process/brand_process.php",
      type :  "POST",
      data: {get_brands:1}
    },
    "columns": [
        { data: 'number' },
        { data: 'category_name' },
        { data: 'brand_name' },
        { data: 'brand_status' },
        { data: 'edit' },
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

  //change brand status
  $(document).on('click', '.change-status', function(event) {
    event.preventDefault();
    var brand_status = $(this).data('brand_status');
    var brand_id = $(this).attr('id');
    var brand_status1 = '';
    var brand_status2 = '';
    if(brand_status == 'active') {
      brand_status1 = 'aktivan';
      brand_status2 = 'neaktivan';
    } else {
      brand_status1 = 'neaktivan';
      brand_status2 = 'aktivan';
    }
    if(confirm('Da li ste sigurni da zelite da promenite status ovog brenda iz '+brand_status1+' u '+ brand_status2 + '?')) {
      $.ajax({
        url:  "process/brand_process.php",
        method: "POST",
        data: {brand_id:brand_id,brand_status:brand_status},
        success: function(data) {
          if(data == 'STATUS_CHANGED') {
            var brand_message ='<div class="alert alert-success alert-dismissible fade show" role="alert">'+
            '<strong>Status brenda izmenjen!</strong> Sada je '+brand_status2+'.'+
             '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
            '<span aria-hidden="true">&times;</span>'+
              '</button>'+
            '</div>';
            $('#brand_message').html(brand_message);
            branddataTable.ajax.reload();
          } else {
            var brand_message ='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
            '<strong>Doslo je do greske!</strong> Pokusajte ponovo.'+
             '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
            '<span aria-hidden="true">&times;</span>'+
              '</button>'+
            '</div>';
            $('#brand_message').html(brand_message);
          }
        }
      })
    }
  });

  //delete brand
  $(document).on('click', '.delete-brand', function(event) {
    event.preventDefault();
    var brand_id = $(this).attr('id');
    var brand_delete = true;
    if(confirm('Da li ste sigurni da zelite trajno da obrisete ovaj brend?')) {
      $.ajax({
        url:  "process/brand_process.php",
        method: "POST",
        data: {brand_id:brand_id,brand_delete:brand_delete},
        success: function(data) {
          if(data == 'BRAND_DELETED') {
            var brand_message ='<div class="alert alert-success alert-dismissible fade show" role="alert">'+
            '<strong>Brend je trajno obrisan!</strong> Mozete ga ponovo dodati.'+
             '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
            '<span aria-hidden="true">&times;</span>'+
              '</button>'+
            '</div>';
            $('#brand_message').html(brand_message);
            branddataTable.ajax.reload();
          } else {
            var brand_message ='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
            '<strong>Doslo je do greske!</strong> Pokusajte ponovo.'+
             '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
            '<span aria-hidden="true">&times;</span>'+
              '</button>'+
            '</div>';
            $('#brand_message').html(brand_message);
          }
        }
      });
    }
  });

  //get brand data for editing
  $(document).on('click', '.edit-brand', function(event) {
    event.preventDefault();
    var brand_id = $(this).attr('id');
    var brand_edit = true;
    $.ajax({
      url:  "process/brand_process.php",
      method: "POST",
      dataType: 'json',
      data: {brand_id:brand_id,brand_edit:brand_edit},
      success: function(data) {
        var image_logo = '<div class="image-content"><img src="../images/brand_logos/'+data.brand_logo+'" class="form-control img-responsive" id="brand_img" alt="" width="100px" height="auto" data-imgname="'+data.brand_logo+'">'+
        '<button type="button" name="location" data-location="../../images/brand_logos/'+data.brand_logo+'" class="btn btn-danger " style="position:absolute; top:5px; right:5px" id="remove_button" name="button"><i class="fas fa-times"></i></button>'+
        '</div>';
        $('#brand_new_description').val(data.brand_description);
        $('#new_category').val(data.category_id);
        $('#logo_preview').html(image_logo);
        $('#brand_new_name').val(data.brand_name);
        $('#brand_id').val(brand_id);
      }
    });
  });


    //Brand update
    $(document).on('submit', '#edit_brand', function(event) {
      event.preventDefault();
      var logo = $('#brand_img').data('imgname');
      if($('#brand_img').length < 1 || logo == '') {
        alert('Logo je obavezno uneti!');
      }
      // var form_data = $(this).serialize();
      var brand_new_name = $('#brand_new_name').val();
      var brand_new_description = $('#brand_new_description').val();
      var brand_id = $('#brand_id').val();
      var new_category = $('#new_category').val();
      var brand_update = true;
      $('#submit_edited_brand').attr('disabled','disabled');
      $.ajax({
        url:  "process/brand_process.php",
        method: "POST",
        data: {brand_update:brand_update,logo:logo,brand_new_description:brand_new_description,brand_new_name:brand_new_name,brand_id:brand_id, new_category:new_category},
        success: function(data) {
          if(data == 'BRAND_UPDATED') {
            branddataTable.ajax.reload();
            $('#brandEditModal').modal('hide');
            $('#logo_preview').html('');
            $('#uploaded_image').text('');
            $('#submit_edited_brand').attr('disabled',false);
            var brand_message ='<div class="alert alert-success alert-dismissible fade show" role="alert">'+
            '<strong>Brend je uspesno izmenjen!</strong>'+
             '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
            '<span aria-hidden="true">&times;</span>'+
              '</button>'+
            '</div>';
            $('#brand_message').html('<p>'+brand_message+'</p>');
          } else {
            var brand_message ='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
            '<strong>Neuspelo unosenje!</strong> Pokusajte ponovo.'+
             '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
            '<span aria-hidden="true">&times;</span>'+
              '</button>'+
            '</div>';
            $('#brand_message').html('<p>'+brand_message+'</p>');
            $('#submit_brand').attr('disabled',false);
          }
        }
      });
    });

  //Clear form event
  $(document).on('click', '#dismiss_brand', function(event) {
    event.preventDefault();
    clear_form();
  });

  //Clear form function
  function clear_form() {
    var location = $('#remove_button').data('location');
    $.ajax({
      url:  "process/brand_process.php",
      method: "POST",
      data: {location:location},
      success: function(data) {
        if(data == 'IMG_DELETED') {
          $('#add_brand')[0].reset();
          $('#logo_preview').html('');
          $('#uploaded_image').text('');
        }
      }
    });
  }
});
