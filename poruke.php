<?php
  require_once('db/db.php');
  include('parts/header.php');
  if(!isset($_SESSION['user']['user_id'])) {
    header("Location: http://localhost/cars/signin.php");
    $_SESSION['message']['error'] = 'Morate se prijaviti da biste postavili oglas! Ukoliko nemate nalog, registrujte se.';
  }
?>
  <div class="row row-custom">
    <div class="col-md-12" id="inbox">
      <br>
      <h2 class="" id="title" style="color:gold; border-bottom: 1px solid gold">Vase poruke</h2>
    </div>
  </div>

<script type="text/javascript">
  $(document).ready(function() {
    var domain = 'http://localhost/cars/';
    get_inbox_content();

    function get_inbox_content() {
      var get_inbox_content = true;
      $.ajax({
        url: "process/message_process.php",
        method: 'post',
        data: {get_inbox_content:get_inbox_content},
        success: function(data) {
          $('#inbox').append(data);
        }
      });
    }

  $(document).on('click', '.clickable-row', function(event) {
    event.preventDefault();
    var message_url = $(this).data("href");
    $(location).attr('href', domain + 'razgovor.php?id=' + message_url);
  });
});
</script>
<?php
  include('parts/footer.php');
?>
