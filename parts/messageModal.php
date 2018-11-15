<!-- Modal -->
<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="messageModalTitle">Posalji poruku korisniku </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="" method="post" id="send_message">
        <div class="modal-body">
          <div class="form-group">
            <textarea id="message_text" name="message_text" class="form-control" rows="8" cols="80"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="vehicle_id" id="vehicle_id" value="">
          <input type="hidden" name="receiver_id" id="receiver_id" value="">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Nazad</button>
          <button type="submit" class="btn btn-primary">Posalji</button>
        </div>
      </form>
    </div>
  </div>
</div>
