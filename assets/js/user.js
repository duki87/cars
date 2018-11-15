$(document).ready(function() {
  session_message();

  function session_message() {
    var get_session_message = 1;
    $.ajax({
      url: "process/user_process.php",
      method: 'post',
      data: {get_session_message:get_session_message},
      success: function(data) {
        if(data !== '') {
          var session_message ='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
          data+
           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
          '<span aria-hidden="true">&times;</span>'+
            '</button>'+
          '</div>';
          $('#login_message').html('<p>'+session_message+'</p>');
        } else {
          $('#login_message').html('');
        }
      }
    });
  }

  var domain = 'http://localhost/cars/';
  $(document).on('submit', '#user_registration', function(event) {
    event.preventDefault();
    var reg_email = $('#reg_email').val();
    var reg_password = $('#reg_password').val();
    var check_password = $('#check_password').val();
    var reg_name = $('#reg_name').val();
    var reg_last_name = $('#reg_last_name').val();
    var street = $('#street').val();
    var street_num = $('#street_num').val();
    var city = $('#city').val();
    var phone = $('#phone').val();
    var error = false;

    //check email
    var filter = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(reg_email == '') {
      $('#email_err').html('Ovo polje je obavezno!');
      error = true;
    } else if(!filter.test(reg_email)) {
      reg_email.focus;
      $('#email_err').html('Unesite ispravan format email-a!');
      error = true;
    } else {
      $('#email_err').html('');
    }

    //check password
    if(reg_password == '') {
      $('#pass_err').html('Ovo polje je obavezno!');
      error = true;
    }
    if(reg_password !== check_password) {
      reg_password.focus;
      $('#pass_err').html('Lozinke se ne poklapaju!');
      error = true;
    }

    if(reg_name == '') {
      reg_name.focus;
      $('#name_err').html('Ovo polje je obavezno!');
      error = true;
    }

    if(reg_last_name == '') {
      reg_name.focus;
      $('#reg_last_name_err').html('Ovo polje je obavezno!');
      error = true;
    }

    if(street == '') {
      reg_name.focus;
      $('#street_err').html('Ovo polje je obavezno!');
      error = true;
    }

    if(street_num == '') {
      reg_name.focus;
      $('#street_num_err').html('Ovo polje je obavezno!');
      error = true;
    }

    if(city == '') {
      reg_name.focus;
      $('#city_err').html('Ovo polje je obavezno!');
      error = true;
    }

    if(phone == '') {
      reg_name.focus;
      $('#phone_err').html('Ovo polje je obavezno!');
      error = true;
    } else if(!phone.match(/^\d+$/)) {
      $('#phone_err').html('Unesite ispravan broj telefona!');
      error = true;
    } else {
      $('#phone_err').html('');
    }
console.log(error);
    if(error) {
      return false;
    } else {
      var address = street + ' ' + street_num;
      var user_details = {
        "email" : reg_email,
        "password" : reg_password,
        "name" : reg_name,
        "last_name" : reg_last_name,
        "address" : address,
        "city" : city,
        "phone" : phone
      };
      var user = JSON.stringify(user_details);
      var new_user = 1;
      $.ajax({
        url: "process/user_process.php",
        method: 'post',
        data: {new_user:new_user,user:user},
        success: function(data) {
          if(data == 'USER_ADDED') {
            var message_success = '<div class="alert alert-success alert-dismissible fade show" role="alert">'+
            '<strong>Uspesno ste se registrovali! </strong> Poslat vam je email za verifikaciju. Nakon toga mozete pristupiti sajtu!'+
             '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
            '<span aria-hidden="true">&times;</span>'+
              '</button>'+
            '</div>';
            $('#user_registration')[0].reset();
            $('#user_success').html('<p>'+message_success+'</p>');
            $('.form-errors').html('');
          } else if(data == 'EMAIL_ALREADY_EXISTS') {
            var message_error = '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
            '<strong>Email vec postoji u bazi! </strong> Pokusajte sa drugim email-om.'+
             '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
            '<span aria-hidden="true">&times;</span>'+
              '</button>'+
            '</div>';
            $('#user_success').html('<p>'+message_error+'</p>');
          } else {
            var message_error = '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
            '<strong>Doslo je do greske! </strong> Pokusajte ponovo.'+
             '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
            '<span aria-hidden="true">&times;</span>'+
              '</button>'+
            '</div>';
            $('#user_success').html('<p>'+message_error+'</p>');
          }
        }
      });
    }
  });

  $(document).on('submit', '#user_signin', function(event) {
    event.preventDefault();
    var error_login = false;
    var sign_email = $('#sign_email').val();
    var sign_password = $('#sign_password').val();

    //check email
    var filter = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(sign_email == '') {
      $('#sign_email_err').html('Ovo polje je obavezno!');
      error_login = true;
    } else if(!filter.test(sign_email)) {
      sign_email_err.focus;
      $('#sign_email_err').html('Unesite ispravan format email-a!');
      error_login = true;
    } else {
      $('#sign_email_err').html('');
    }

    if(sign_password == '') {
      $('#sign_password_err').html('Ovo polje je obavezno!');
      error_login = true;
    }

    if(error_login) {
      return false;
    } else {
      var login_details = {
        "email" : sign_email,
        "password" : sign_password
      };
      var login = JSON.stringify(login_details);
      var login_user = 1;
      $.ajax({
        url: "process/user_process.php",
        method: 'post',
        data: {login_user:login_user,login:login},
        success: function(data) {
          if(data == 'NOT_REGISTERED') {
            var login_message ='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
            '<strong>Niste registrovani!</strong> Najpre se morate registrovati.'+
             '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
            '<span aria-hidden="true">&times;</span>'+
              '</button>'+
            '</div>';
            $('#login_message').html('<p>'+login_message+'</p>');
          } else if(data == 'NOT_ACTIVE') {
            var login_message ='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
            '<strong>Vas nalog jos uvek nije aktivan!</strong> Potvrdite nalog putem verifikacionog email-a. Ukoliko vam nije stigao, kliknite ovde da posaljemo ponovo.'+
             '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
            '<span aria-hidden="true">&times;</span>'+
              '</button>'+
            '</div>';
            $('#login_message').html('<p>'+login_message+'</p>');
          } else if(data == 'PASSWORD_NOT_MATCHED') {
            var login_message ='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
            '<strong>Uneli ste neispravnu lozinku!</strong> Pokusajte ponovo.'+
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
            window.location.href = domain+'user_profile.php';
          }
        }
      });
    }
  });

  // $(document).on('click', '#logout_user', function(event) {
  //   event.preventDefault();
  //   var logout_user = 1;
  //   $.ajax({
  //     url: "process/user_process.php",
  //     method: 'post',
  //     data: {logout_user:logout_user},
  //     success: function(data) {
  //       window.location.href = domain+'index.php';
  //     }
  //   });
  // });
});
