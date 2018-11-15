$(document).ready(function() {
  var domain = 'http://localhost/cars/';
  $('#collapsibleNavbar').collapse();

  //auth_code
  $(document).on('submit', '#auth_confirm', function(event) {
    event.preventDefault();
    var auth_confirm = $(this).serialize();
    $.ajax({
      url: domain+'admin/process/admin_process.php',
      method: 'post',
      data: auth_confirm,
      success: function(data) {
        if(data == 'VALID_CODE') {
          var message_success = '<div class="alert alert-success alert-dismissible fade show" role="alert">'+
          '<strong>Kod ispravan!</strong> Sada mozete uneti vase podatke.'+
           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
          '<span aria-hidden="true">&times;</span>'+
            '</button>'+
          '</div>';
          $('#auth_confirm')[0].reset();
          $('#auth_message').html('<p>'+message_success+'</p>');
          $('#admin_registration').removeClass('admin_registration_hide');
          $('#admin_registration').addClass('admin_registration_show');
        } else {
          var message_fail = '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
          '<strong>Kod neispravan!</strong> Pokusajte ponovo.'+
           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
          '<span aria-hidden="true">&times;</span>'+
            '</button>'+
          '</div>';
          $('#auth_message').html('<p>'+message_fail+'</p>');
        }
      }
    });
  });

  //admin registration
  $(document).on('submit', '#admin_registration', function(event) {
    event.preventDefault();
    var admin_registration = $(this).serialize();
    $.ajax({
      url: domain+'admin/process/admin_process.php',
      method: 'post',
      data: admin_registration,
      success: function(data) {
        if(data == 'SOME_ERROR') {
          var message_reg_alert ='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
          '<strong>Registracija neuspesna!</strong> Kontaktirajte administratora.'+
           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
          '<span aria-hidden="true">&times;</span>'+
            '</button>'+
          '</div>';
          $('#reg_message').html('<p>'+message_reg_alert+'</p>');
        } else if (data == 'EMAIL_ALREADY_EXISTS') {
          var message_reg_alert ='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
          '<strong>Registracija neuspesna!</strong> Ovaj email vec postoji u bazi! Probajte sa drugim.'+
           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
          '<span aria-hidden="true">&times;</span>'+
            '</button>'+
          '</div>';
          $('#reg_message').html('<p>'+message_reg_alert+'</p>');
        } else {
          $('#admin_registration')[0].reset();
          $('#auth_confirm_div').addClass('admin_registration_hide');
          $('#admin_registration').addClass('admin_registration_hide');
          var message_reg_success ='<div class="alert alert-success alert-dismissible fade show" role="alert">'+
          '<strong>Registracija uspesna!</strong> Vas id: '+data+'. Kada primite aktivacioni email, bicete u mogucnosti da pristupite administrativnom delu sajta.'+
           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
          '<span aria-hidden="true">&times;</span>'+
            '</button>'+
          '</div>';
          $('#reg_message').html('<p>'+message_reg_success+'</p>');
        }
      }
    });
  });

  //admin login
  $(document).on('submit', '#admin_login', function(event) {
    event.preventDefault();
    var admin_login = $(this).serialize();
    $.ajax({
      url: domain+'admin/process/admin_process.php',
      method: 'post',
      data: admin_login,
      success: function(data) {
        if(data == 'NOT_REGISTERED') {
          var login_message ='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
          '<strong>Prijavljivanje neuspesno!</strong> Niste registrovani kao administrator.'+
           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
          '<span aria-hidden="true">&times;</span>'+
            '</button>'+
          '</div>';
          $('#login_message').html('<p>'+login_message+'</p>');
        } else if(data == 'NOT_ACTIVE') {
          var login_message ='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
          '<strong>Prijavljivanje neuspesno!</strong> Vas nalog jos uvek nije aktivan. Bicete obavesteni putem maila kada bude aktivan.'+
           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
          '<span aria-hidden="true">&times;</span>'+
            '</button>'+
          '</div>';
          $('#login_message').html('<p>'+login_message+'</p>');
        } else if(data == 'PASSWORD_NOT_MATCHED') {
          var login_message ='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
          '<strong>Prijavljivanje neuspesno!</strong> Niste uneli ispravnu lozinku. Pokusajte ponovo.'+
           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
          '<span aria-hidden="true">&times;</span>'+
            '</button>'+
          '</div>';
          $('#login_message').html('<p>'+login_message+'</p>');
        } else if(data == 'LOGIN_FAIL'){
          var login_message ='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
          '<strong>Prijavljivanje neuspesno!</strong> Nesto se iskundacilo. Pokusajte ponovo.'+
           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
          '<span aria-hidden="true">&times;</span>'+
            '</button>'+
          '</div>';
          $('#login_message').html('<p>'+login_message+'</p>');
        } else {
          window.location.href = domain+'admin/dashboard.php';
        }
      }
    });
  });

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
    $('#submit_brand').attr('disabled','disabled');
    $.ajax({
      url:  "process/brand_process.php",
      method: "POST",
      data: {logo:logo,brand_description:brand_description,brand_name:brand_name},
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
        { data: 'brand_id' },
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
    "pageLength"  : 5
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
      var brand_update = true;
      $('#submit_edited_brand').attr('disabled','disabled');
      $.ajax({
        url:  "process/brand_process.php",
        method: "POST",
        data: {brand_update:brand_update,logo:logo,brand_new_description:brand_new_description,brand_new_name:brand_new_name,brand_id:brand_id},
        success: function(data) {
          if(data == 'BRAND_UPDATED') {
            $('#edit_brand')[0].reset();
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
