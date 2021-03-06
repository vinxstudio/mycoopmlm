<style>.modal-backdrop{position: unset;}</style>
<div id="validate_modal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      {{ Form::open(['id'=>'validate_form']) }}
      <div class="modal-body">
          <input type="hidden" name="gc_id" id="gc_id" value="">
          <input type="hidden" name="validator_id" id="validator_id" value="{{$theUser->details->id}}">
          <input type="hidden" name="status" id="status" value="">
          <label id="label_reason">Reason:</label>
         <textarea class="form-control" rows="5" name="validate_reason" id="reason"></textarea>
         <span class="text-danger hidden" id="error_message"></span>
         <h5 id="validated_by"></h5>
         <h5 id="validated_date"></h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="validate_submit">Submit</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
      {{ Form::close() }}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->