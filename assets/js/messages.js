$(document).ready(function() {
  check_messages();

  $(document).on('submit', '#messageModal', function(event) {
    event.preventDefault();
    var receiver_id = $('#receiver_id').val();
    var vehicle_id = $('#vehicle_id').val();
    var message_text = $('#message_text').val();
    var message_data = {
      "receiver_id" : receiver_id,
      "vehicle_id" : vehicle_id,
      "message_text" : message_text,
    };

    var message_details = JSON.stringify(message_data);
    var new_message = true;
    $.ajax({
      url: "process/message_process.php",
      method: 'post',
      data: {new_message:new_message,message_details:message_details},
      success: function(data) {
        console.log('sent');
        if(data == 'MESSAGE_ADD') {
          // var add_message ='<div class="alert alert-success alert-dismissible fade show" role="alert">'+
          // '<strong>Poruka je uspesno poslata!</strong>'+
          //  '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
          // '<span aria-hidden="true">&times;</span>'+
          //   '</button>'+
          // '</div>';
          alert('Poruka je uspesno poslata!');
          $('#send_message')[0].reset();
          $('#messageModal').modal('hide');
        } else {
          var vehicle_message ='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
          '<strong>Nesto se iskundacilo!</strong>'+
           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
          '<span aria-hidden="true">&times;</span>'+
            '</button>'+
          '</div>';
          alert('<p>'+add_message+'</p>');
        }
      }
    });
  });

  function check_messages() {
    setInterval(function() {
      var check_messages = true;
      $.ajax({
        url: "process/message_process.php",
        method: 'post',
        data: {check_messages:check_messages},
        success: function(data) {
          $('#countMessages').remove();
          $('#user_messages').append('<span id="countMessages" class="badge badge-danger">'+data+'</span>');
        }
      });
    }, 2000);
  }
});
