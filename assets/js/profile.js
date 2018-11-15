$(document).ready(function() {
  var domain = 'http://localhost/cars/';
  load_user_data();

  function load_user_data() {
    var load_user_data = 1;
    $.ajax({
      url: "process/profile_process.php",
      method: 'post',
      dataType: 'json',
      data: {load_user_data:load_user_data},
      success: function(data) {
        $('#name').val(data.name);
        $('#last_name').val(data.last_name);
        $('#email').val(data.email);
        $('#address').val(data.address);
        $('#city').val(data.city);
        $('#phone').val(data.phone);
        $('#photo_button').html(data.button);
        $('#date_joined').html(data.date_joined);

        var user_img = '';
        var photo = data.photo;
        if(photo.search("google") == -1) {
          user_img = 'images/user_images/'+data.photo;
        } else {
          user_img = data.photo;
        }

        $('#photo').attr('src', user_img);
        if(data.button == 'Izmeni fotografiju') {
          var remove_button = '<button class="btn btn-danger btn-xs delete" id="delete_photo" data-img="'+data.photo+'" style="position:absolute;top:4px;right:35px">&times;</button>';
          $('#photo_box').append(remove_button);
        } else {
          var remove_button = '<button class="btn btn-danger btn-xs delete d-none" id="delete_photo" data-img="default" style="position:absolute;top:4px;right:35px">&times;</button>';
          $('#photo_box').append(remove_button);
        }
      }
    });
  }

  $(document).on('change', '#add_edit_photo', function(event) {
    event.preventDefault();
    var delete_photo = $('#delete_photo').attr('data-img');
    var property = document.getElementById('add_edit_photo').files[0];
    var image_name = property.name;
    var image_extension = image_name.split('.').pop().toLowerCase();
    if(jQuery.inArray(image_extension, ["jpg","jpeg","png","gif"]) == -1) {
      error_images += 'Uneli ste fajl koji ima nedozvoljenu ekstenziju!';
    }
    var image_size = property.size;
    if(image_size > 5000000) {
      error_images += 'Velicina fotografije veca od 5 MB!';
    } else {
      var form_data = new FormData();
      form_data.append('file', property);
      form_data.append('delete_photo', delete_photo);
      $.ajax({
        url: "process/user_img_preview.php",
        method: 'post',
        data: form_data,
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
          $('#error_images').html('<span class="text-primary">Ucitavanje fotografije...</span>');
        },
        success: function(data) {
          $('#delete_photo').removeClass('d-none');
          $('#photo').attr('src', 'images/user_images/'+data.file_name);
          $('#delete_photo').attr('data-img', data.file_name);
          $('#error_images').html('<span class="text-success">Fotografija je ucitana!</span>');
          document.getElementById('add_edit_photo').value = "";
        }
      });
    }
  });

  $(document).on('click', '#delete_photo', function(event) {
    event.preventDefault();
    var delete_img = true;
    var photo = $(this).attr('data-img');
    $.ajax({
      url: "process/user_img_delete.php",
      method: 'post',
      data: {photo:photo, delete_img:delete_img},
      beforeSend: function() {
        $('#error_images').html('<span class="text-danger">Brisanje...</span>');
      },
      success: function(data) {
        if(data == 'IMG_DELETED') {
          $('#photo').attr('src', 'images/user_images/default.jpg');
          $('#delete_photo').addClass('d-none');
          $('#delete_photo').attr('data-img', 'default');
          $('#error_images').html('<span class="text-success">Fotografija je obrisana!</span>');
          $('#add_edit_photo').val('');
          $('#photo_button').html('Dodaj fotografiju');
        }
      }
    });
  });

  $(document).on('submit', '#edit_user_data', function(event) {
    event.preventDefault();
    var edit_user_data = true;
    var name = $('#name').val();
    var last_name = $('#last_name').val();
    var email = $('#email').val();
    var address = $('#address').val();
    var city = $('#city').val();
    var phone = $('#phone').val();
    var edit_data_obj = {
      "name" : name,
      "last_name" : last_name,
      "email" : email,
      "address" : address,
      "city" : city,
      "phone" : phone,
    };
    var edit_data = JSON.stringify(edit_data_obj);
    $.ajax({
      url: "process/user_process.php",
      method: 'post',
      data: {edit_data:edit_data, edit_user_data:edit_user_data},
      success: function(data) {
        if(data == 'USER_EDIT') {
          $('#profile_message').removeClass('d-none');
          $('#profile_message').append('<strong id="pm_text">Podaci su uspesno izmenjeni!</strong>');
        }
      }
    });
  });

  $(document).on('click', '.close_message', function(event) {
    event.preventDefault();
    $('#pm_text').remove();
    $('#profile_message').addClass('d-none');
  });

  $(document).on('blur', '#old_password', function(event) {
    event.preventDefault();
    var old_password = $(this).val();
    var check_old_password = true;

    var password_data_obj = {
      "old_password" : old_password
    };
    var password_data = JSON.stringify(password_data_obj);
    $.ajax({
      url: "process/user_process.php",
      method: 'post',
      data: {password_data:password_data, check_old_password:check_old_password},
      success: function(data) {
        if(data == 'NOT_MATCH') {
          $('#check_old_pwd').addClass('text-danger');
          $('#check_old_pwd').html('Neispravana stara lozinka. Pokusajte ponovo.');
        } else {
          $('#check_old_pwd').removeClass();
          $('#check_old_pwd').addClass('text-success');
          $('#check_old_pwd').html('Uspesna provera stare lozinke.');
        }
      }
    });
  });

  $(document).on('click', '#clear_form', function(event) {
    event.preventDefault();
    $('#password_form')[0].reset();
    $('#check_old_pwd').removeClass();
    $('#check_old_pwd').html('');
    $('#check_new_pwd').removeClass();
    $('#check_new_pwd').html('');
  });

  $(document).on('submit', '#password_form', function(event) {
    event.preventDefault();
    var old_password = $('#old_password').val();
    var new_password = $('#new_password').val();
    var confirm_password = $('#confirm_password').val();
    var change_password = true;
    if(new_password !== confirm_password) {
      $('#check_new_pwd').addClass('text-danger');
      $('#check_new_pwd').html('Lozinke se ne poklapaju!');
    } else {
      $.ajax({
        url: "process/user_process.php",
        method: 'post',
        data: {new_password:new_password, change_password:change_password},
        success: function(data) {
          if(data == 'NOT_CHANGED') {
            $('#check_new_pwd').addClass('text-danger');
            $('#check_new_pwd').html('Nesto se iskundacilo!');
          } else {
            $('#change_password').modal('toggle');
            $('#password_form')[0].reset();
            $('#profile_message').removeClass('d-none');
            $('#profile_message').append('<strong id="pm_text">Lozinka je uspesno promenjena!</strong>');
          }
        }
      });
    }
  });
});
