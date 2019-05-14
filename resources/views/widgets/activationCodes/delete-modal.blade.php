<style>.modal-backdrop{position: unset;}</style>
<div id="delete_modal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Reason</h4>
      </div>
      {{ Form::open(['id'=>'delete_form']) }}
      <div class="modal-body">
          <input type="hidden" name="activation_id" id="activation_id" value="">
          <h4 class="text-danger hidden" id="error_message"></h4>
         <textarea class="form-control" rows="5" name="delete_reason" id="reason"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="delete_submit">Submit</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
      {{ Form::close() }}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->