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


{{-- message modal --}}
{{-- old message modal--}}
<div id="message_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <h4 class="message"></h4>
            </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-success" id="confirm">
                    Confirm
                </button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>{{-- //message modal --}}


{{-- message modal --}}
{{-- new message modal --}}
<div id="new_message_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                {{-- the alert info's of the modal --}}
                <div id="new-message-modal-alert" class="hide alert alert-dismissible show" role="alert">
                </div>
                {{-- close button for modal --}}
                <button type="button" class="close" data-dismiss="modal">×</button>
                {{-- title of the modal --}}
                <h4 class="modal-title">Reason</h4>
            </div>
            <div class="modal-body">
                <h4 class="message"></h4>
                {{-- textarea for the reason inputs --}}
                <textarea rows="4" cols="54" id="reason-message" name="id_message" style="resize:none" class="form-control"></textarea>
            </div>
            <div class="modal-footer">
                {{-- close button --}}
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    Close
                </button>
                {{-- confirm button --}}
                    <button type="button" class="btn btn-success" id="modal-btn-confirm">
                    Confirm
                </button>
            </div>
        </div>
    </div>
</div>
{{-- //message modal --}}