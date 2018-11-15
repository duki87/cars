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
});
