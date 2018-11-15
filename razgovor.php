<?php
  require_once('db/db.php');
  include('parts/header.php');
  if(!isset($_SESSION['user']['user_id'])) {
    header("Location: http://localhost/cars/signin.php");
    $_SESSION['message']['error'] = 'Morate se prijaviti da biste postavili oglas! Ukoliko nemate nalog, registrujte se.';
  }
?>

  <div class="container">
    <div class="col-md-12" id="inbox">
      <br>
      <h2 class="" id="title" style="color:gold; border-bottom: 1px solid gold">Razgovor sa korisnikom: <span class="text-info" id="sender_name"></span> </h2>
      <div class="row chat-area" id="chat" style="overflow-y: scroll; height:16em">

      </div>
    </div>
    <div class="mt-4 pb-2 mx-auto">
      <form class="form-row" method="post" id="send_message">
        <div class="form-group col-md-11">
          <input type="text" name="message_content" id="message_content" class="form-control" value="">
        </div>
        <div class="form-group col-md-1">
          <input type="hidden" id="receiver_id" name="receiver_id" value="">
          <input type="submit" name="submit" id="submit" class="btn btn-success" value="Posalji">
        </div>
      </form>
    </div>
  </div>

<script type="text/javascript">

  $(document).ready(function() {
    $("#chat").scrollTop($("#chat")[0].scrollHeight);
    var id = getUrlParameter('id');
    get_chat_content(id);
    uncheck_read_messages(id);
    check_income_messages(id);
    is_unread();

    function get_chat_content(id) {
      var get_chat_content = true;
      $.ajax({
        url: "process/message_process.php",
        method: 'get',
        data: {get_chat_content:get_chat_content,id:id},
        dataType: 'json',
        success: function(data) {
          $('#chat').html(data.messageArray);
          $('#receiver_id').val(data.receiver_id);
          $('#sender_name').html(data.sender_name);
        }
      });
    }

  $('input').keypress(function(event) {
    if(event.which == 13) {
      event.preventDefault();
      $('#send_message').submit();
    }
  });

  $(document).on('submit', '#send_message', function(event) {
    event.preventDefault();
    var chat_id = id;
    var message_content = $('#message_content').val();
    var receiver_id = $('#receiver_id').val();
    var send_message = true;
    var message_data = {
      "message_content" : message_content,
      "receiver_id" : receiver_id,
      "chat_id" : chat_id
    };
    var message_details = JSON.stringify(message_data);
    $.ajax({
      url: "process/message_process.php",
      method: 'post',
      data: {message_details:message_details,send_message:send_message},
      dataType: 'json',
      success: function(data) {
        $('#send_message')[0].reset();
        load_new_message(data);
      }
    });
  });

  function load_new_message(message_id) {
    var load_new_message = true;
    $.ajax({
      url: "process/message_process.php",
      method: 'post',
      data: {message_id:message_id,load_new_message:load_new_message},
      success: function(data) {
        $('#chat').append(data);
        $("#chat").scrollTop($("#chat")[0].scrollHeight);
      }
    });
  }

  function check_income_messages(chat_id) {
    setInterval(function() {
      var check_income_messages = true;
      $.ajax({
        url: "process/message_process.php",
        method: 'post',
        data: {check_income_messages:check_income_messages, chat_id:chat_id},
        success: function(data) {
          $('#chat').append(data);
        }
      });
    }, 1000);
  }

  function is_unread() {
    setInterval(function() {
      var is_unread = true;
      var message_ids = $('.unread');
      var id_obj = {};
      for(let i=0; i<message_ids.length; i++) {
        id_obj['id' + i] = message_ids[i].getAttribute('data-messageid');
      }
      var check_ids = JSON.stringify(id_obj);
      $.ajax({
        url: "process/message_process.php",
        method: 'post',
        data: {is_unread:is_unread, check_ids:check_ids},
        dataType: 'json',
        success: function(data) {
          for(let j=0; j<data.length; j++) {
            $('#mid'+data[j]).append('<span class="float-right"><i class="far fa-eye"></i></span>');
            $('#mid'+data[j]).removeClass('unread');
          }
        }
      });
    }, 1000);
  }

  function uncheck_read_messages(chat_id) {
    var uncheck_read_messages = true;
    $.ajax({
      url: "process/message_process.php",
      method: 'post',
      data: {uncheck_read_messages:uncheck_read_messages, chat_id:chat_id},
      success: function(data) {
        if(data == 'UNREAD') {
          $('.unread').removeClass('unread');
        }
      }
    });
  }

  function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
            // console.log(sParameterName[1] === undefined ? true : sParameterName[1]);
        }
      }
    };
});

</script>
<?php
  include('parts/footer.php');
?>
